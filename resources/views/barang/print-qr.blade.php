<!DOCTYPE html>
<html>
<head>

    <title>Cetak QR Barang</title>

    <style>

        body{
            font-family: Arial;
            text-align:center;
            margin-top:50px;
        }

        .qr-box{
            border:1px solid #000;
            padding:20px;
            display:inline-block;
        }

    </style>

</head>
<body>

<div class="qr-box">

    <h3>
        {{ $barang->nama_barang }}
    </h3>

    <p>
        {{ $barang->kode_barang }}
    </p>

    <img src="data:image/svg+xml;base64,{{ $barang->qr_code }}"
        width="300">

</div>

<script>

window.print();

</script>

</body>
</html>