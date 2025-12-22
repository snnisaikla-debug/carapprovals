<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8">

<style>
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }

    .title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: middle;
    }

    .label {
        width: 25%;
        background: #f5f5f5;
    }

    .value {
        width: 25%;
    }

    .required {
        color: red;
        font-weight: bold;
    }

    .no-border td {
        border: none;
    }
</style>
</head>

<body>

<div class="title">
    แบบฟอร์มขออนุมัติการขายรถยนต์
</div>

<table>
    <tr>
        <td class="label">
            ราคารถ <span class="required">*</span>
        </td>
        <td class="value">
            {{ number_format($car_price) }} บาท
        </td>
        <td class="label">
            ดาวน์ (%) <span class="required">*</span>
        </td>
        <td class="value">
            {{ $down_percent }} %
        </td>
    </tr>

    <tr>
        <td class="label">
            จำนวนงวด <span class="required">*</span>
        </td>
        <td class="value">
            {{ $installment }} งวด
        </td>
        <td class="label">
            ค่างวดต่อเดือน
        </td>
        <td class="value">
            {{ number_format(($car_price * (1 - $down_percent/100)) / $installment) }} บาท
        </td>
    </tr>
</table>

<br>

<table class="no-border">
    <tr>
        <td style="width:50%; text-align:center;">
            ลงชื่อ Sales<br><br><br>
            ________________________
        </td>
        <td style="width:50%; text-align:center;">
            ผู้อนุมัติ<br><br><br>
            ________________________
        </td>
    </tr>
</table>

</body>
</html>