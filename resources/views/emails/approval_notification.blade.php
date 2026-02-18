<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Sarabun', sans-serif; color: #333; }
        .container { padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        .header { background-color: #0d6efd; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #198754; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .table-changes { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table-changes th, .table-changes td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table-changes th { background-color: #f2f2f2; }
        .highlight { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>
                @if($type === 'new') 📢 ใบขออนุมัติใหม่
                @else ✏️ มีการแก้ไขข้อมูล (V.{{ $approval->version }}, Group ID: {{ $approval->group_id }})
                @endif
            </h2>
        </div>

        <div class="content">
            <p><strong>เรียน ผู้จัดการ,</strong></p>

            @if($type === 'new')
                <p>มีการสร้างใบขออนุมัติใหม่ โดยเซลล์: <strong>{{ $approval->sales_name }}</strong></p>
                <ul>
                    <li><strong>ลูกค้า:</strong> {{ $approval->customer_name }}</li>
                    <li><strong>รุ่นรถ:</strong> {{ $approval->car_model }}</li>
                    <li><strong>ราคารถ:</strong> {{ number_format($approval->car_price, 2) }} บาท</li>
                </ul>
            @else
                {{-- แก้ไขจุดที่ Error: เปลี่ยน $current และ $row เป็น $approval --}}
                <p>มีการแก้ไขข้อมูล Group ID: {{ $approval->group_id }} โดย: <strong>{{ $approval->sales_name }}</strong></p>
                
                <p><strong>รายการที่เปลี่ยนแปลง:</strong></p>
                @if(count($changes) > 0)
                    <table class="table-changes">
                        <thead>
                            <tr>
                                <th>หัวข้อ</th>
                                <th>ข้อมูลเดิม</th>
                                <th>ข้อมูลใหม่</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($changes as $change)
                            <tr>
                                <td>{{ $change['field'] }}</td>
                                <td class="highlight">{{ $change['old'] }}</td>
                                <td style="color: green; font-weight: bold;">{{ $change['new'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif

            <br>
            <div style="text-align: center;">
                <a href="{{ route('approvals.show', $approval->id) }}" class="button">ดูรายละเอียดเพิ่มเติม</a>
            </div>
        </div>
    </div>
</body>
</html>