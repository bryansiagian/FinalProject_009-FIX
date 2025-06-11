<!DOCTYPE html>
<html>

<head>
    <title>Testimoni Baru</title>
</head>

<body>
    <h1>Testimoni Baru Menunggu Persetujuan</h1>
    <p>Testimoni baru telah dikirimkan dan menunggu persetujuan Anda.</p>

    <p><strong>Pengguna:</strong> {{ $testimonial->user->name }}</p>
    <p><strong>Produk:</strong> {{ $testimonial->product->name }}</p>
    <p><strong>Testimoni:</strong> {{ $testimonial->content }}</p>

    <p>Silakan login ke dashboard admin untuk menyetujui atau menolak testimoni.</p>
</body>

</html>