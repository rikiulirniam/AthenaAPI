<!DOCTYPE html>
<html>
<head>
    <title>QR Code Anda</title>
</head>
<body>
    <h1>QR Code Anda</h1>
    <p>Nomor: {{ $number }}</p>
    <p><img src={{ "https://api.qrserver.com/v1/create-qr-code/?data=$number&size=200x200" }} alt="QR Code">
    </p>
</body>
</html>
