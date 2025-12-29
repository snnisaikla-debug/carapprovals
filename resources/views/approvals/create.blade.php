
@extends('layout')

@section('title', 'สร้างใบอนุมัติ (Mobile UI)')

@section('content')

<style>
    .section-title {
        font-weight: bold;
        font-size: 18px;
        margin-top: 15px;
        padding: 10px 0;
        border-bottom: 2px solid #c10000ff;
    }
    .sub {
        font-size: 14px;
        color: #555555ff;
        margin-bottom: 5px;
    }
</style>

<form method="POST" action="{{ route('approvals.store') }}">
    @csrf
    <div class="d-flex justify-content-between mb-3">
        <button type="button" onclick="history.back()" class="btn btn-secondary">
            ← กลับ
        </button>
    </div>
    
    <ins><h2>ใบขออนุมัติการขายรถยนต์</h2></ins>
    <br>

    {{-- DATE --}}
    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">วันที่ขอแคมเปญ</label>
            <input type="date" class="form-control" name="Request_date">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">วันที่จะส่งมอบรถ</label>
            <input type="date" class="form-control" name=" ">
        </div>
    </div>


    {{-- 1. ข้อมูลลูกค้า --}}
    <div class="section-title">ข้อมูลลูกค้า</div>

    <div class="mb-3">
        <label class="form-label">ชื่อลูกค้า</label>
        <input type="text" class="form-control" name="customer_name" required>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">อำเภอ</label>
            <input type="text" class="form-control" name="customer_district">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จังหวัด</label>
            <input type="text" class="form-control" name="customer_province">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">เบอร์โทร</label>
        <input type="text" class="form-control" name="customer_phone">
    </div>


    {{-- 2. ข้อมูลรถ --}}
    <div class="section-title">ข้อมูลรถ</div>

        <div class="mb-3">
            <label class="form-label">รุ่นรถ</label>
            <input type="text" class="form-control" name="car_model" required>
        </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">สี</label>
            <input type="text" class="form-control" name="car_color">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">ออฟชั่น</label>
            <input type="text" class="form-control" name="car_options">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">ราคา (บาท)</label>
        <input id="car_price" class="form-control" type="number" step="0.01" name="car_price">
    </div>
    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">บวกหัว (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="plus_head">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">F/N</label>
            <input type="text" class="form-control" name="fn">
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">ดาวน์ (%)</label>
            <input id="down_percent" class="form-control" type="number" step="0.01" name="down_percent">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">ดาวน์ (บาท)</label>
            <input id="down_amount" class="form-control" type="number" step="0.01" name="down_amount" placeholder="--- คำนวนอัตโนมัติ ---">
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">จำนวนงวด</label>
            <input id="installment_months" class="form-control" type="number" name="installment_months">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">งวดละ (บาท)</label>
             <input id="installment_per_month" class="form-control" type="number" readonly name="installment_per_month" placeholder="--- คำนวนอัตโนมัติ ---">
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">ดอกเบี้ย (%)</label>
            <input id="interest_rate" class="form-control" type="number" step="0.01" name="interest_rate">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">ยอดจัด (บาท)</label>
            <input id="finance_amount" class="form-control" type="number" readonly name="finance_amount">
        </div>
    </div>

        <div class="section-title"></div></br>

        <div class="mb-3">
            <label class="form-label">คัชซี</label>
            <input type="number" step="0.01" class="form-control" name="Chassis">
        </div>
        <div class="mb-3">
            <label class="form-label">เลขสต๊อก</label>
            <input type="number" step="0.01" class="form-control" name="stock_number">
        </div>

    <div class="section-title"></div></br>

    <div class="row">
        <div class="col-6 mb-3">
                <label class="form-label">รหัสแคมเปญ</label>
                <select class="form-select" name="com_fn_option">
                    <option value="">-- เลือก --</option>
                    <option value="์N">N</option>
                    <option value="L">L</option>
                    <option value="LDP">LDP</option>
                    <option value="90D">90D</option>
                    <option value="SCP">SCP</option>
                    <option value="FCP">FCP</option>
                </select>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">หัก (บาท)</label>
            <input type="number" class="form-control" name="installment_months">
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">ประเภทการขาย</label><br>
            <input type="checkbox" name="sale_type_options[]" value="GE"> GE<br>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จำนวน (บาท)</label><br>
            <input type="number" step="0.01" class="form-control" name="sale_type_amount">
        </div>
        <div class="col-6 mb-3">
            <input type="checkbox" name="options[]" value="RETENEION"> RETENTION
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จำนวน (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="sale_type_amount">
        </div>
        <div class="col-6 mb-3">
            <input type="checkbox" name="options[]" value="เกตรกร"> เกตรกร
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จำนวน (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="sale_type_amount">
        </div>
        <div class="col-6 mb-3">
            <input type="checkbox" name="options[]" value="Welcome"> Welcome
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จำนวน (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="sale_type_amount">
        </div>
    </div>

        <div class="mb-3">
            <input type="checkbox" name="options[]">
            <label class="form-label">Fleet (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="fleet_amount">
        </div>

    <div class="row">    
        <div class="col-6 mb-3">
            <label class="form-label">หักประกัน (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="insurance_deduct">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">ใช้จริง (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="insurance_used">
        </div>
    </div>    

        <div class="mb-3">
            <label class="form-label">Kickback (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="kickback_amount">
        </div>
    
        <div class="mb-3">
            <label class="form-label">Com F/N</label>
            <select class="form-select" name="com_fn_option">
                <option value="">-- เลือก --</option>
                <option value="4">4</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
            </select>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">จำนวน (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="com_fn_amount">
        </div>


    {{-- 13–17 ของแถม --}}
    <div class="section-title">รายการของแถม</div>

    <div class="mb-3">
        <label class="form-label">รายการของแถม</label>
        <textarea rows="2" class="form-control" name="free_items"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">รายการของแถมเกิน</label>
        <textarea rows="2" class="form-control" name="free_items_over"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">รายการซื้อเพิ่ม</label>
        <textarea rows="2" class="form-control" name="extra_purchase_items"></textarea>
    </div>


    {{-- 19–20 แคมเปญ --}}
    <div class="section-title">แคมเปญ</div><br>

    <div class="mb-3">
        <label class="form-label">แคมเปญที่มี</label>
        <textarea rows="2" class="form-control" name="campaigns_available"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">แคมเปญที่ใช้</label>
        <textarea rows="2" class="form-control" name="campaigns_used"></textarea>
    </div>
     <div class="col-6 mb-3">
        <label class="form-label">ส่วนลด (เงินสดดาวน์)</label>
        <input type="number" step="0.01" class="form-control" name="decoration_amount">
    </div>
    <div class="col-6 mb-3">
        <label class="form-label">รับรถจ่ายดาวน์/สด</label>
        <input type="text" step="0.01" class="form-control" name="decoration_amount">
    </div>
     <div class="col-6 mb-3">
        <label class="form-label">จ่ายของแต่ง</label>
        <input type="number" step="0.01" class="form-control" name="decoration_amount">
    </div>
     <div class="col-6 mb-3">
        <label class="form-label">รวมทั้งหมด</label>
        <input type="number" step="0.01" class="form-control" name="decoration_amount">
    </div>

    {{-- 21–22 commercial / การแต่ง --}}
    <div class="section-title">Commercial / การแต่ง</div><br>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_commercial_30000" value="1" id="comm">
        <label for="comm" class="form-check-label">commercial 30,000 บาท</label>
    </div>

    <div class="mb-3">
        <label class="form-label">รายการแต่ง</label>
        <textarea rows="2" class="form-control" name="decoration_amount"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">มูลค่า (บาท)</label>
        <textarea rows="2" class="form-control" name="decoration_amount"></textarea>
    </div>


    {{-- 23–24 เกินแคมเปญ / เกินของแต่ง --}}
    <div class="section-title"></div><br>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">เกินแคมเปญ (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="over_campaign_amount">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">สถานะ</label>
            <select class="form-select" name="over_campaign_status">
                <option value="">-- เลือก --</option>
                <option value="ไม่เกิน">ไม่เกิน</option>
                <option value="เกิน">เกิน</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">เกินของตกแต่ง (บาท)</label>
            <input type="number" step="0.01" class="form-control" name="over_decoration_amount">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">สถานะ</label>
            <select class="form-select" name="over_decoration_status">
                <option value="">-- เลือก --</option>
                <option value="ไม่เกิน">ไม่เกิน</option>
                <option value="เกิน">เกิน</option>
            </select>
        </div>
    </div>

        <div class="mb-3">
            <label class="form-label">สาเหตุขอเกิน</label>
            <textarea rows="2" class="form-control" name="over_reason"></textarea>
        </div>


    {{-- 25–27 --}}
    <div class="section-title"></div><br>

    

    <div class="mb-3">
        <label class="form-label">SC (ชื่อ/ลายเซ็น)</label>
        <input type="text" class="form-control" name="sc_signature">
    </div>

    <div class="mb-3">
        <label class="form-label">Com การขาย (ชื่อ/ลายเซ็น)</label>
        <input type="text" class="form-control" name="sale_com_signature">
    </div>

    <button class="btn btn-primary w-100 mt-3">บันทึกและส่งให้ Admin</button>

</form>
    <div class="section-title">ลายเซ็น</div>

    {{-- Signature SC --}}
    <div class="mb-3">
        <label class="form-label">SC เซ็นที่นี่</label>
        <div class="border" style="width:100%; height:200px;">
            <canvas id="sc-pad" style="width:100%; height:100%;"></canvas>
        </div>
        <button type="button" id="sc-clear" class="btn btn-sm btn-outline-danger mt-2">ล้างลายเซ็น SC</button>
        <input type="hidden" name="sc_signature_data" id="sc_signature_data">
    </div>

    {{-- Signature Com การขาย --}}
    <div class="mb-3">
        <label class="form-label">Com การขาย เซ็นที่นี่</label>
        <div class="border" style="width:100%; height:200px;">
            <canvas id="salecom-pad" style="width:100%; height:100%;"></canvas>
        </div>
        <button type="button" id="salecom-clear" class="btn btn-sm btn-outline-danger mt-2">ล้างลายเซ็น Com</button>
        <input type="hidden" name="sale_com_signature_data" id="sale_com_signature_data">
    </div>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>
    function setupSignaturePad(canvasId, clearBtnId, outputId) {
        const canvas = document.getElementById(canvasId);
        const clearBtn = document.getElementById(clearBtnId);
        const output   = document.getElementById(outputId);

        // ปรับขนาด canvas ให้พอดีกับมือถือ
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;
            const ctx = canvas.getContext("2d");
            ctx.scale(ratio, ratio);
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        const sigPad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'black',
        });

        clearBtn.addEventListener('click', function () {
            sigPad.clear();
            output.value = '';
        });

        return { sigPad, output };
    }

    const scPad = setupSignaturePad('sc-pad', 'sc-clear', 'sc_signature_data');
    const saleComPad = setupSignaturePad('salecom-pad', 'salecom-clear', 'sale_com_signature_data');

    // ก่อน submit ฟอร์ม ให้แปลงลายเซ็นเป็น base64
    document.querySelector('form').addEventListener('submit', function (e) {
        if (!scPad.sigPad.isEmpty()) {
            scPad.output.value = scPad.sigPad.toDataURL('image/png');
        }
        if (!saleComPad.sigPad.isEmpty()) {
            saleComPad.output.value = saleComPad.sigPad.toDataURL('image/png');
        }
    });
</script>
{{-- ================== SCRIPT คำนวณ ================== --}}
<script>
function calculateFinance() {
    const price = parseFloat(car_price.value) || 0;
    const downPercent = parseFloat(down_percent.value) || 0;
    let downAmount = parseFloat(down_amount.value) || 0;
    const months = parseInt(installment_months.value) || 0;
    const interest = parseFloat(interest_rate.value) || 0;

    if (downPercent > 0) {
        downAmount = price * (downPercent / 100);
        down_amount.value = downAmount.toFixed(2);
    }

    const finance = price - downAmount;
    finance_amount.value = finance.toFixed(2);

    const interestTotal = finance * (interest / 100) * (months / 12);
    const total = finance + interestTotal;

    installment_per_month.value = months > 0
        ? (total / months).toFixed(2)
        : '';
}

document.querySelectorAll(
    '#car_price,#down_percent,#down_amount,#installment_months,#interest_rate'
).forEach(el => el.addEventListener('input', calculateFinance));
</script>
@endsection