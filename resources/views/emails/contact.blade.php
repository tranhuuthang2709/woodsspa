<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tin nhắn liên hệ mới</title>
</head>
<body>
  <h3>Thông tin liên hệ:</h3>
  <p><strong>Họ tên:</strong> {{ $data['name'] }}</p>
  <p><strong>Phương thức liên lạc:</strong> {{ $data['contact_method'] ?? 'Không chọn' }}</p>
  <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
  <p><strong>Email:</strong> {{ $data['email'] }}</p>
  <p><strong>Nội dung:</strong></p>
  <p>{{ $data['content'] }}</p>
</body>
</html>
