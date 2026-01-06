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

        if (!empty($salesFilter)) {
            $query->where('approvals.sales_user_id', $salesFilter);
        }

        if (!empty($statusFilter)) {
            $query->where('approvals.status', $statusFilter);
        }

        $query->orderBy('approvals.updated_at', ($sort === 'oldest' ? 'ASC' : 'DESC'));
        
        $approvals = $query->get();
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

        // 7. ลายเซ็น (Signature Data - รับค่าเป็น Base64)
        'sc_signature_data'     => 'nullable|string',
        'sale_com_signature_data' => 'nullable|string',
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
    public function updateStatus(Request $request, $groupId)
        {
            $latest = Approval::where('group_id', $groupId)->latest()->firstOrFail();
            $action = $request->input('action'); 
            $role = strtolower(auth()->user()->role);

            if ($action === 'approve') {
                if ($role === 'admin') {
                    $latest->status = 'Pending_Manager'; // Admin ผ่านไปหา Manager
                } elseif ($role === 'manager') {
                    $latest->status = 'Approved'; // Manager อนุมัติจบงาน
                }
            } elseif ($action === 'reject') {
                $latest->status = 'Draft'; // โดน Reject ตีกลับเป็น Draft ให้ Sale แก้ไข
            }

            $latest->save();
            return back()->with('success', 'อัปเดตสถานะเรียบร้อย');
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

    /**
     * 4. การแสดงผลและจัดการข้อมูล
     */

    public function showGroup($groupId)
        {
            $approvals = Approval::where('group_id', $groupId)->orderBy('version', 'asc')->get();
            $current = $approvals->last(); // แสดงข้อมูลเวอร์ชันล่าสุดเป็นหลัก
            return view('approvals.show', compact('approvals', 'current'));
        }

    public function edit($groupId)
        {
            $current = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();
            
            // เช็คสิทธิ์: เฉพาะเจ้าของหรือ Admin
            if (Auth::user()->role === 'sale' && $current->sales_user_id !== Auth::id()) {
                abort(403);
            }

            return view('approvals.edit', compact('current'));
        }

    public function update(Request $request, $groupId)
        {
            $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();

            $data = $request->validate([
                'customer_name' => 'required|string',
                'car_model'     => 'required|string',
                'car_price'     => 'required|numeric',
                // ... ใส่ฟิลด์ที่ต้องการให้อัปเดต ...
            ]);

            // สร้างเวอร์ชันใหม่เสมอเมื่อมีการแก้ไข (Audit Trail)
            $newVersion = $latest->replicate();
            $newVersion->fill($data);
            $newVersion->version = $latest->version + 1;
            $newVersion->status = 'Pending_Admin'; // แก้ไขแล้วส่งกลับไปเริ่ม Workflow ใหม่
            $newVersion->save();

            return redirect()->route('approvals.show', $groupId)->with('success', 'สร้างเวอร์ชันใหม่และส่งตรวจสอบแล้ว');
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

    public function exportPdf($id)
        {
            $approval = Approval::findOrFail($id);
            $pdf = Pdf::loadView('approvals.pdf', compact('approval'))->setPaper('A4', 'portrait');
            return $pdf->stream('approval_'.$approval->id.'.pdf');
        }
    // เพิ่มฟังก์ชันนี้เข้าไปใน Controller
    public function show($id)
        {
            // ค้นหาข้อมูลจาก ID
            $current = Approval::findOrFail($id);
            
            // ดึงประวัติทั้งหมดในกลุ่มเดียวกัน (Group ID) เพื่อแสดงในตารางประวัติ
            $approvals = Approval::where('group_id', $current->group_id)
                                ->orderBy('version', 'asc')
                                ->get();

            return view('approvals.show', compact('current', 'approvals'));
        }
        // ฟังก์ชันสำหรับบันทึกการแก้ไขโปรไฟล์
}