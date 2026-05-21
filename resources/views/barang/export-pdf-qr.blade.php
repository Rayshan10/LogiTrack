<!DOCTYPE html>
<html>
<head>

    <title>QR Barang</title>

    <style>

        body{
            font-family: Arial;
        }

        .qr-container{
            width: 30%;
            border:1px solid #000;
            padding:10px;
            margin:10px;
            text-align:center;
            float:left;
        }

        img{
            width:150px;
        }

    </style>

</head>
<body>

<h2>Daftar QR Barang</h2>

@foreach($barang as $b)

<div class="qr-container">

    <h4>
        {{ $b->nama_barang }}
    </h4>

    <p>
        {{ $b->kode_barang }}
    </p>

    <img src="data:image/svg+xml;base64,{{ $b->qr_code }}">

</div>

@endforeach

</body>
</html>