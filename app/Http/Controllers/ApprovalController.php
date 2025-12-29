<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Approval;
use App\Models\User;

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
        $user = Auth::user();
        $data = $request->validate([
            'customer_name'     => 'required|string',
            'customer_district' => 'nullable|string',
            'customer_province' => 'nullable|string',
            'customer_phone'    => 'nullable|string',
            'car_model'         => 'required|string',
            'car_color'         => 'nullable|string',
            'car_options'       => 'nullable|string',
            'car_price'         => 'required|numeric',
            'plus_head'         => 'nullable|numeric',
            'fn'                => 'nullable|string',
            'down_percent'      => 'nullable|numeric',
            'down_amount'       => 'nullable|numeric',
            'finance_amount'    => 'nullable|numeric',
            'installment_per_month' => 'nullable|numeric',
            'installment_months'    => 'nullable|integer',
            'interest_rate'     => 'nullable|numeric',
            'remark'            => 'nullable|string',
            // ... เพิ่ม Validation ฟิลด์อื่นๆ ตามต้องการ ...
        ]);

        // จัดการลายเซ็น
        $saveSignature = function($base64, $prefix) {
            if (!$base64 || !str_contains($base64, ',')) return null;
            $fileData = base64_decode(explode(',', $base64)[1]);
            $fileName = $prefix.'_'.time().'_'.uniqid().'.png';
            $path = 'signatures/'.$fileName;
            Storage::disk('public')->put($path, $fileData);
            return 'storage/'.$path;
        };

        $data['sc_signature'] = $saveSignature($request->input('sc_signature_data'), 'sc');
        $data['sale_com_signature'] = $saveSignature($request->input('sale_com_signature_data'), 'salecom');
        $data['is_commercial_30000'] = $request->has('is_commercial_30000');

        // บันทึก Version 1
        $approval = Approval::create(array_merge($data, [
            'group_id'      => 0, 
            'version'       => 1,
            'status'        => 'Draft',
            'created_by'    => strtoupper($user->role),
            'sales_name'    => $user->name,
            'sales_user_id' => $user->id,
        ]));

        // อัปเดต group_id ให้ตรงกับ id แรก
        $approval->update(['group_id' => $approval->id]);

        return redirect()->route('approvals.index')->with('success', 'บันทึกร่างเรียบร้อยแล้ว');
    }

    /**
     * 3. กระบวนการส่งและอนุมัติ (Workflow)
     */

    // Sale กดส่งไปให้ Admin
    public function submit($groupId)
    {
        $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();
        $latest->update(['status' => 'Pending_Admin']);
        return back()->with('status', 'ส่งคำขอไปที่ Admin แล้ว');
    }

    // Admin/Manager Action (ฟังก์ชันรวมเพื่อลดความซ้ำซ้อน)
    public function updateStatus(Request $request, $groupId)
    {
        $latest = Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();
        $action = $request->input('action'); // approve / reject

        if ($latest->status === 'Pending_Admin') {
            $latest->status = ($action === 'approve') ? 'Pending_Manager' : 'Reject';
        } 
        elseif ($latest->status === 'Pending_Manager') {
            $latest->status = ($action === 'approve') ? 'Approved' : 'Reject';
        }

        $latest->save();
        return back()->with('success', 'ดำเนินการเรียบร้อยแล้ว');
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
}