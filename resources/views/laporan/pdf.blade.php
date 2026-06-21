<!DOCTYPE html>
<html>
<head>

<style>

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}

table th {
    background-color: #f2f2f2;
}

</style>
</style>

</head>
<body>

<h2 align="center">

LAPORAN DISTRIBUSI BARANG

</h2>

<p>
<b>Periode :</b>
{{ \Carbon\Carbon::parse($awal)->format('d-m-Y') }}
s/d
{{ \Carbon\Carbon::parse($akhir)->format('d-m-Y') }}
</p>

<table>

    <thead>

        <tr>
            <th>No</th>

            <th>Kode</th>

            <th>Barang</th>

            <th>Status</th>

            <th>Kurir</th>

            <th>Lokasi</th>

            <th>Tanggal</th>

        </tr>

    </thead>

    <tbody>

        @foreach($tracking as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->barang->kode_barang }}</td>

    <td>{{ $item->barang->nama_barang }}</td>

    <td>{{ $item->status }}</td>

    <td>{{ $item->user->name ?? '-' }}</td>

    <td>{{ $item->lokasi }}</td>

    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

</tr>

@endforeach

    </tbody>

</table>

</body>
</html>