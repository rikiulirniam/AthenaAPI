<!DOCTYPE html>
<html>
<head>
    <title>QR Code Anda</title>
</head>
<body>
    <h1>PENDAFTARAN BERHASIL!!</h1>
    <p>Daftar ulang ke Sekolah dan tunjukkan kode QR dibawah ini kepada petugas.</p>
    <p>No. Pendaftaran : {{ $number }}</p>
    <img class="width: 100%;" src={{ "https://api.qrserver.com/v1/create-qr-code/?data=$number&size=500x500" }} alt="QR Code">
</body>
</html>
