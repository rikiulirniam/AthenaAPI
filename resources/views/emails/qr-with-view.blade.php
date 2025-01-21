<!DOCTYPE html>
<html>
<head>
    <title>QR Code Anda</title>
</head>
<body>
    <h1>QR Code Anda</h1>
    <p>Nomor: {{ $number }}</p>
    <p><img src="{{ $qrCodeUrl }}" alt="QR Code" style="max-width: 100%; height: auto;"></p>
</body>
</html>
