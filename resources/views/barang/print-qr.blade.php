<!DOCTYPE html>
<html>
<head>

<title>Label Pengiriman</title>

<style>

body{
    font-family: Arial, sans-serif;
}

.label{
    width: 420px;
    border: 2px solid #000;
    padding: 15px;
    margin: auto;
}

.header{
    text-align:center;
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
}

table{
    width:100%;
}

table td{
    padding:5px;
}

.qr{
    text-align:center;
    margin-top:15px;
}

.footer{
    margin-top:15px;
    text-align:center;
    font-size:12px;
}

.qr svg{
    max-width: 180px;
}
</style>

</head>

<body onload="window.print()">

<div class="label">

    <div class="header">

        LOGISTIK DISTRIBUSI

    </div>

    <table>

        <tr>
            <td width="130"><b>Kode Barang</b></td>
            <td width="10">:</td>
            <td>{{ $barang->kode_barang }}</td>
        </tr>

        <tr>
            <td><b>Nama Barang</b></td>
            <td>:</td>
            <td>{{ $barang->nama_barang }}</td>
        </tr>

        <tr>
            <td><b>Kategori</b></td>
            <td>:</td>
            <td>{{ $barang->kategori }}</td>
        </tr>

        <tr>
            <td><b>Status</b></td>
            <td>:</td>
            <td>{{ $barang->status }}</td>
        </tr>

    </table>

    <div class="qr">

        {!! base64_decode($barang->qr_code) !!}

    </div>

    <div class="footer">

        Scan QR untuk proses distribusi barang

    </div>

</div>

</body>
</html>