<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Approval;

class ApprovalController extends Controller
{
    // แสดงรายการใบล่าสุดของแต่ละ group
    public function index(Request $request)
{
    $sort = $request->input('sort', 'newest'); // default = ล่าสุดก่อน
    if ($sort === 'date') {
        $sort = 'newest'; // รองรับของเดิมที่ใช้ ?sort=date
    }

    $salesFilter = $request->input('sales');
    $statusFilter = $request->input('status');
    $statusList = Approval::select('status')->distinct()->orderBy('status')->pluck('status');
    
    return view('approvals.index', compact('approvals', 'salesList', 'statusList'));

    $query = Approval::select('approvals.*')
        ->join(DB::raw('(SELECT group_id, MAX(version) as max_version FROM approvals GROUP BY group_id) latest'),
            function ($join) {
                $join->on('approvals.group_id', '=', 'latest.group_id');
                $join->on('approvals.version', '=', 'latest.max_version');
            });

    if (!empty($salesFilter)) {
        $query->where('approvals.sales_name', $salesFilter);
    }
    if (!empty($statusFilter)) {                 // ✅ เพิ่ม
        $query->where('approvals.status', $statusFilter);
    }
    if ($sort === 'oldest') {
        $query->orderBy('approvals.updated_at', 'ASC');
    } else {
        $query->orderBy('approvals.updated_at', 'DESC');
    }

    $salesList = Approval::select('sales_name')
        ->distinct()
        ->orderBy('sales_name')
        ->pluck('sales_name');

    return view('approvals.index', [
        'approvals' => $query->get(),
        'sort'      => $sort,
        'salesList' => $salesList,
    ]);
}

    // ฟอร์มสร้างใบอนุมัติ (Sales)
    public function create()
    {
        return view('approvals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 1. ข้อมูลลูกค้า
            'customer_name'     => 'required|string',
            'customer_district' => 'nullable|string',
            'customer_province' => 'nullable|string',
            'customer_phone'    => 'nullable|string',

            // 2. ข้อมูลรถ
            'car_model'         => 'required|string',
            'car_color'         => 'nullable|string',
            'car_options'       => 'nullable|string',
            'car_price'         => 'required|numeric',

            // 3–12 การเงิน
            'plus_head'             => 'nullable|numeric',
            'fn'                    => 'nullable|string',
            'down_percent'          => 'nullable|numeric',
            'down_amount'           => 'nullable|numeric',
            'finance_amount'        => 'nullable|numeric',
            'installment_per_month' => 'nullable|numeric',
            'installment_months'    => 'nullable|integer',
            'interest_rate'         => 'nullable|numeric',
            'campaign_code'         => 'nullable|string',
            'sale_type'             => 'nullable|string',
            'sale_type_amount'      => 'nullable|numeric',
            'fleet_amount'          => 'nullable|numeric',

            // 13–17
            'insurance_deduct'      => 'nullable|numeric',
            'insurance_used'        => 'nullable|numeric',
            'kickback_amount'       => 'nullable|numeric',
            'com_fn_option'         => 'nullable|string',
            'com_fn_amount'         => 'nullable|numeric',
            'free_items'            => 'nullable|string',
            'free_items_over'       => 'nullable|string',
            'extra_purchase_items'  => 'nullable|string',

            // 19–20
            'campaigns_available'   => 'nullable|string',
            'campaigns_used'        => 'nullable|string',

            // 21–24
            'decoration_amount'     => 'nullable|numeric',
            'over_campaign_amount'  => 'nullable|numeric',
            'over_campaign_status'  => 'nullable|string',
            'over_decoration_amount'=> 'nullable|numeric',
            'over_decoration_status'=> 'nullable|string',

            // 25–27
            'over_reason'           => 'nullable|string',
            'sc_signature'          => 'nullable|string',
            'sale_com_signature'    => 'nullable|string',

            // หมายเหตุท้ายฟอร์ม
            'remark'                => 'nullable|string',
            'sc_signature_data'        => 'nullable|string',
            'sale_com_signature_data'  => 'nullable|string',
        ]);
        $scPath = null;
        $saleComPath = null;

        // ฟังก์ชันช่วยเซฟ base64 เป็นไฟล์
        $saveSignature = function($base64, $prefix) {
            if (!$base64) return null;

            @list($type, $fileData) = explode(';', $base64);
            @list(, $fileData) = explode(',', $fileData);

            if (!$fileData) return null;

            $fileData = base64_decode($fileData);
            $fileName = $prefix.'_'.time().'_'.uniqid().'.png';
            $path = 'signatures/'.$fileName;

            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $fileData);


            return 'storage/'.$path; // path สำหรับแสดงรูป
        };

        $scPath = $saveSignature($request->input('sc_signature_data'), 'sc');
        $saleComPath = $saveSignature($request->input('sale_com_signature_data'), 'salecom');

        $data['sc_signature']      = $scPath;
        $data['sale_com_signature'] = $saleComPath;

        // checkbox จะส่งมาเฉพาะตอนติ๊ก
        $data['is_commercial_30000'] = $request->has('is_commercial_30000');

        $user = Auth::user();

        // version แรก
        $approval = Approval::create(array_merge($data, [
            'group_id'   => 0,
            'version'    => 1,
            'status'     => 'WAIT_ADMIN',
            'created_by' => $user->role,    // SALE
            'sales_name' => $user->name,    // ชื่อ Sales (ไว้ sort / ดูรายการ)
        ]));

        // ให้ group_id == id แรกของตัวเอง
        $approval->group_id = $approval->id;
        $approval->save();

        return redirect()->route('approvals.index');
    }

    // ดูประวัติทั้ง group + ปุ่มอนุมัติ
    public function showGroup($groupId)
{
    $approvals = Approval::where('group_id', $groupId)
        ->orderBy('version', 'asc')
        ->get();

    $current = $approvals->first(); // ตัวแทน group

    return view('approvals.show', compact('approvals', 'current'));
}

    // Admin อนุมัติ / ไม่อนุมัติ
    public function adminAction(Request $request, $groupId)
    {
        $action = $request->input('action'); // approve / reject

        $current = Approval::where('group_id', $groupId)
            ->orderByDesc('version')
            ->first();

        $newVersion = $current->version + 1;
        $newStatus = $action === 'approve' ? 'WAIT_HEAD' : 'REJECTED_ADMIN';

        Approval::create([
            'group_id'      => $groupId,
            'version'       => $newVersion,
            'status'        => $newStatus,
            'car_model'     => $current->car_model,
            'car_price'     => $current->car_price,
            'customer_name' => $current->customer_name,
            'remark'        => $current->remark,
            'created_by'    => 'ADMIN',
        ]);

        return redirect()->route('approvals.show', $groupId);
    }

    // หัวหน้า อนุมัติ / ไม่อนุมัติ
    public function headAction(Request $request, $groupId)
    {
        $action = $request->input('action'); // approve / reject

        $current = Approval::where('group_id', $groupId)
            ->orderByDesc('version')
            ->first();

        $newVersion = $current->version + 1;
        $newStatus = $action === 'approve' ? 'APPROVED' : 'REJECTED_HEAD';

        Approval::create([
            'group_id'      => $groupId,
            'version'       => $newVersion,
            'status'        => $newStatus,
            'car_model'     => $current->car_model,
            'car_price'     => $current->car_price,
            'customer_name' => $current->customer_name,
            'remark'        => $current->remark,
            'created_by'    => 'HEAD',
        ]);

        return redirect()->route('approvals.show', $groupId);
        }
    public function exportPdf($id)
    {
        $approval = Approval::findOrFail($id);

        $pdf = Pdf::loadView('approvals.pdf', compact('approval'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('approval_'.$approval->id.'.pdf');
    }
    public function edit($groupId)
    {
        // ดึงเวอร์ชันล่าสุดของ group นี้
        $current = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

        // อนุญาตให้ SALE แก้เฉพาะของตัวเอง (กันแก้ของคนอื่น)
        if (Auth::user()->role === 'sale' && $current->sales_name !== Auth::user()->name) {
        abort(403);
        }

        // เปิดฟอร์มแก้ไข (ใช้ create เดิมก็ได้ หรือทำ edit แยก)
        return view('approvals.edit', compact('current'));
    }

    public function update(Request $request, $groupId)
    {
        $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

        // ✅ SALE แก้เฉพาะของตัวเอง
        if (Auth::user()->role === 'sale' && $latest->sales_name !== Auth::user()->name) {
        abort(403);
    }

        // ✅ validate (ค่อยๆ เพิ่มทีหลังได้)
        $data = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_district' => 'nullable|string|max:255',
                'customer_province' => 'nullable|string|max:255',
                'customer_phone' => 'nullable|string|max:50',

                'car_model' => 'required|string|max:255',
                'car_color' => 'nullable|string|max:255',
                'car_options' => 'nullable|string|max:255',
                'car_price' => 'required|numeric',

                // ใส่ฟิลด์อื่นๆ ที่มีในฟอร์มตามจริงได้เรื่อย ๆ
            ]);

            // ✅ สร้างเวอร์ชันใหม่ (ไม่ทับของเดิม)
            $new = new Approval();
            $new->group_id = $latest->group_id;
            $new->version  = $latest->version + 1;

            // สถานะเมื่อ “แก้ไขแล้วส่งใหม่”
            // โดย workflow ของเปา: ส่งเข้า admin ใหม่เสมอ
            $new->status = 'WAIT_ADMIN';

            // ใครเป็นคนสร้างเวอร์ชันนี้
            $new->created_by = strtoupper(Auth::user()->role); // SALE/ADMIN/HEAD

            // ✅ ต้องเก็บชื่อ sales ในทุกเวอร์ชัน (ถ้ามี field นี้)
            $new->sales_name = $latest->sales_name ?? Auth::user()->name;

            // map ข้อมูลจากฟอร์มลง model
            $new->customer_name = $data['customer_name'];
            $new->customer_district = $data['customer_district'] ?? null;
            $new->customer_province = $data['customer_province'] ?? null;
            $new->customer_phone = $data['customer_phone'] ?? null;

            $new->car_model = $data['car_model'];
            $new->car_color = $data['car_color'] ?? null;
            $new->car_options = $data['car_options'] ?? null;
            $new->car_price = $data['car_price'];

            // ✅ ถ้ามีฟิลด์อื่น ๆ ก็ใส่ต่อ (plus_head, fn, down_percent, …)
            // $new->plus_head = $request->input('plus_head');
            // ...

            $new->save();

            return redirect()->route('approvals.show', $groupId)->with('success', 'สร้างเวอร์ชันใหม่เรียบร้อย');
        }

        public function destroy($groupId)
        {
            // ลบทั้ง group (ทุกเวอร์ชัน)
            $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

            if (Auth::user()->role === 'sale' && $latest->sales_name !== Auth::user()->name) {
                abort(403);
            }

            // แนะนำ: ให้ลบได้เฉพาะยังไม่ APPROVED
            if ($latest->status === 'APPROVED') {
                return back()->with('error', 'เอกสารอนุมัติแล้ว ไม่อนุญาตให้ลบ');
            }

            Approval::where('group_id', $groupId)->delete();

            return redirect()->route('approvals.index')->with('success', 'ลบเอกสารชุดนี้เรียบร้อย');
        }

    }
