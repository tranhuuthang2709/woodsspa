<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin đặt lịch mới</title>
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #b45f06;
            text-align: center;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🧖‍♀️ Thông tin đặt lịch mới từ khách hàng</h2>

        <p><strong>👤 Họ tên:</strong> {{ $data['name'] }}</p>
        <p><strong>📧 Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Điện thoại:</strong> {{ $data['full_phone'] }}</p>
        <p><strong>Quốc gia:</strong> {{ $data['country_name'] }}</p>
        <p><strong>📅 Ngày:</strong>{{ \Carbon\Carbon::parse($data['date'])->format('d/m/Y') }}</p>
        <p><strong>⏰ Giờ:</strong> {{ $data['time'] }}</p>
        <p><strong>👥 Số khách:</strong> {{ $data['guestCount'] }}</p>

        @if(!empty($data['guests']))
            <h3 style="margin-top: 25px;">💆‍♀️ Dịch vụ đã chọn</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên khách</th>
                        <th>Dịch vụ</th>
                        <th>Thời lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['guests'] as $index => $guest)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $guest['name'] ?? '---' }}</td>
                            <td>{{ $guest['service_name'] ?? '---' }}</td>
                            <td>{{ $guest['duration'] ?? '?' }}'</td>
                            <td>{{ $guest['price'] ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(!empty($data['notes']))
            <p style="margin-top: 20px;"><strong>📝 Ghi chú:</strong> {{ $data['notes'] }}</p>
        @endif

        <div class="footer">
            Email này được gửi tự động từ website <strong>Woods Spa</strong>.  
        </div>
    </div>
</body>
</html>
