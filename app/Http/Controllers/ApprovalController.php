<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovalExport;

class ApprovalController extends Controller
{
    /**
     * 1. รายการทั้งหมด (แสดงเฉพาะเวอร์ชันล่าสุดของแต่ละกลุ่ม)
     */
    public function index(Request $request)
        {
            $sort = $request->input('sort', 'newest');
            $salesFilter = $request->input('sales_user_id');
            $statusFilter = $request->input('status');

            $query = Approval::select('approvals.*', 'users.name as sales_name')
            ->join(
                DB::raw('(SELECT group_id, MAX(version) as max_version FROM approvals GROUP BY group_id) latest'),
                function ($join) {
                    $join->on('approvals.group_id', '=', 'latest.group_id')
                        ->on('approvals.version', '=', 'latest.max_version');
                }
            )
            ->leftJoin('users', 'users.id', '=', 'approvals.sales_user_id');

        // 1) ฟิลเตอร์ชื่อ Sale และสถานะ
        if (!empty($salesFilter)) {
            $query->where('approvals.sales_user_id', $salesFilter);
        }
        if (!empty($statusFilter)) {
            $query->where('approvals.status', $statusFilter);
        }

            $approvals = $query->orderBy('approvals.updated_at', ($sort === 'oldest' ? 'ASC' : 'DESC'))->get();

            $salesList = User::where('role', 'sale')->orderBy('name')->pluck('name', 'id');
            $statusList = Approval::select('status')->distinct()->pluck('status');

        return view('approvals.index', compact('approvals', 'salesList', 'statusList'));
    }

    /**
     * 2. กระบวนการสร้าง (SALE)
     */
    public function create()
        {
            return view('approvals.create');
        }

    public function store(Request $request)
        {
        $user = auth()->user();

            // 1. เพิ่มส่วนนี้เข้าไปเพื่อประกาศตัวแปร $data
            $data = $request->validate([
            // 1. ข้อมูลลูกค้า (Customer Info)
            'customer_name'         => 'required|string|max:255',
            'customer_district'     => 'nullable|string|max:255',
            'customer_province'     => 'nullable|string|max:255',
            'customer_phone'        => 'nullable|string|max:50',
            'customer_email'        => 'required|string|max:255',

            // 2. ข้อมูลรถ (Car Info)
            'car_model'             => 'required|string|max:255',
            'car_color'             => 'nullable|string|max:255',
            'car_options'           => 'nullable|string',
            'car_price'             => 'required|numeric',

            // 3. ข้อมูลการเงิน (Finance & Installment)
            'plus_head'             => 'nullable|numeric',
            'fn'                    => 'nullable|string|max:255',
            'down_percent'          => 'nullable|numeric|between:0,100',
            'down_amount'           => 'nullable|numeric',
            'finance_amount'        => 'nullable|numeric',
            'installment_per_month' => 'nullable|numeric',
            'installment_months'    => 'nullable|integer',
            'interest_rate'         => 'nullable|numeric',

            // 4. แคมเปญและส่วนลด (Campaign & Discounts)
            'sale_type_amount'      => 'nullable|numeric',
            'fleet_amount'          => 'nullable|numeric',
            'kickback_amount'       => 'nullable|numeric',
            'campaigns_available'   => 'nullable|string',
            'campaigns_used'        => 'nullable|string',
            'Flight'                => 'nullable|numeric',

            // 5. รายการของแถมและอุปกรณ์ตกแต่ง (Free Items & Decoration)
            'free_items'            => 'nullable|string',
            'free_items_over'       => 'nullable|string',
            'extra_purchase_items'  => 'nullable|string',
            'decoration_amount'     => 'nullable|numeric',
            'over_campaign_amount'  => 'nullable|numeric',
            'over_decoration_amount' => 'nullable|numeric',

            // 6. ข้อมูลอื่นๆ และสาเหตุ (Others)
            'over_reason'           => 'nullable|string',
            'remark'                => 'nullable|string',

        ]);

            // 2. จัดการลายเซ็นและข้อมูลเพิ่มเติม (ถ้ามี)
            $data['is_commercial_30000'] = $request->has('is_commercial_30000');

            // 3. บรรทัดที่ 66 (ที่เคย Error) จะใช้งานได้แล้วเพราะมี $data แล้ว
            $approval = Approval::create(array_merge($data, [
            'group_id'      => 0, 
            'version'       => 1,
            'status'        => 'Pending_Admin',
            'created_by'    => strtoupper($user->role),
            'sales_name'    => $user->name,
            'sales_user_id' => $user->id,
        ]));

    // 4. อัปเดต group_id ให้เท่ากับ id ของตัวเอง
            $approval->update(['group_id' => $approval->id]);

            return redirect()->route('approvals.index')->with('success', 'บันทึกสำเร็จ');
        }

    // Admin/Manager Action (ฟังก์ชันรวมเพื่อลดความซ้ำซ้อน)
    public function updateStatus(Request $request, $group_id)
        {
            // 1. ตรวจสอบว่ามีสถานะส่งมาไหม
            $request->validate([
                'status' => 'required|in:Approved,Reject,Pending_Manager'
            ]);

            // 2. อัปเดตทุกใบใน Group เดียวกันให้เป็นสถานะใหม่
            $affected = \App\Models\Approval::where('group_id', $group_id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

            if ($affected === 0) {
                abort(404, 'ไม่พบข้อมูลใบอนุมัติกลุ่มนี้');
            }

            // 3. สำคัญมาก: ต้องเด้งหน้ากลับไปที่เดิมพร้อมข้อความแจ้งเตือน
            return redirect()->route('approvals.index')
                            ->with('success', 'เปลี่ยนสถานะเป็น ' . $request->status . ' เรียบร้อยแล้ว');
        }

    // กรณีถูก Reject: Sale สร้างเวอร์ชันใหม่เพื่อแก้ไข
    public function createNewVersion($groupId)
        {
            $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

            $newVersion = $latest->replicate(); 
            $newVersion->version = $latest->version + 1;
            $newVersion->status = 'Draft';
            $newVersion->save();

            return redirect()->route('approvals.edit', $groupId);
        
        }

    // ส่วนของฟังก์ชัน edit
    public function edit($id)
        {
            $approval = Approval::findOrFail($id);
            $user = auth()->user();

            // แก้ไขเงื่อนไข 403: 
            // อนุญาตถ้า: เป็นเจ้าของงาน (Sale) หรือ เป็น Admin หรือ เป็น Manager
            if ($user->role === 'sale' && $approval->sales_user_id !== $user->id) {
                abort(403, 'คุณไม่มีสิทธิ์แก้ไขเอกสารนี้');
            }

            return view('approvals.edit', compact('approval'));
        }

    // ส่วนของฟังก์ชัน update (เพื่อให้เก็บประวัติฉบับเก่าไว้)
    public function update(Request $request, $id)
        {
            $oldVersion = Approval::findOrFail($id);
            
            // สร้าง Version ใหม่จากของเดิม
            $newVersion = $oldVersion->replicate(); 
            
            // รับข้อมูลใหม่จากฟอร์ม
            $newVersion->fill($request->all());
            
            // รักษา group_id เดิม และเพิ่มเลขเวอร์ชัน
            $newVersion->group_id = $oldVersion->group_id; 
            $newVersion->version = $oldVersion->version + 1;
            $newVersion->status = 'Pending_Admin'; 
            $newVersion->save();

            return redirect()->route('approvals.index')->with('success', 'ส่งเวอร์ชันใหม่เพื่อตรวจสอบแล้ว');
        }

    public function destroy($groupId)
        {
            $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

            if (Auth::user()->role === 'sale' && $latest->sales_user_id !== Auth::id()) {
                abort(403);
            }

            if ($latest->status === 'Approved') {
                return back()->with('error', 'เอกสารอนุมัติแล้ว ไม่อนุญาตให้ลบ');
            }

            Approval::where('group_id', $groupId)->delete();
            return redirect()->route('approvals.index')->with('success', 'ลบเอกสารเรียบร้อย');
        }
        // ฟังก์ชันสำหรับ Export Pdf
    public function exportPdf($id)
        { 
            $approval = Approval::findOrFail($id);

            $pdf = Pdf::loadView('approvals.pdf', compact('approval'))
                    ->setPaper('A4', 'portrait');

            return $pdf->stream('approval_' . $approval->id . '.pdf');
        }

        // ฟังก์ชันสำหรับ Export Excel
    public function exportExcel() 
        {
            // ตั้งชื่อไฟล์เป็น All_Approvals.xlsx
            return Excel::download(new ApprovalExport, 'All_Approvals.xlsx');
        }

        // ฟังก์ชันสำหรับ Export CSV
    public function exportCsv()
        {
            return Excel::download(new ApprovalExport, 'GoogleSheets_Approvals.csv', \Maatwebsite\Excel\Excel::CSV);
        }

    public function show($id)
        {
            // ดึงข้อมูลฉบับปัจจุบัน
            $current = Approval::findOrFail($id);

            // ดึงประวัติทั้งหมดในกลุ่มเดียวกัน เรียงตาม Version ล่าสุด
            $history = Approval::where('group_id', $current->group_id)
                ->orderBy('version', 'desc')
                ->get();

            return view('approvals.show', compact('current', 'history'));
        }

        // 4. การแสดงผลและจัดการข้อมูล
    // public function showGroup($groupId)
    //    {
    //        $approvals = Approval::where('group_id', $groupId)->orderBy('version', 'asc')->get();
    //        $current = $approvals->last(); // แสดงข้อมูลเวอร์ชันล่าสุดเป็นหลัก
    //        return view('approvals.show', compact('approvals', 'current'));
    //    }
    
    public function getVersionDetail($id)
        {
            $approval = Approval::findOrFail($id);
            
            // คืนค่าเป็น View เล็กๆ (Partial) ที่มีเฉพาะตารางข้อมูล
            return view('approvals.partials.version_detail', compact('approval'))->render();
        }
        
   public function fetchVersion($id)
        {
            $approval = \App\Models\Approval::findOrFail($id);
            return view('approvals.partials.preview', compact('approval'))->render();
        }

    public function previewVersion($approvalId, $version)
    {
        $approval = Approval::where('id', $approvalId)
            ->where('version', $version)
            ->firstOrFail();

        return view('approvals.partials.preview', compact('approval'));
    }
}
