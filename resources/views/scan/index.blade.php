@extends('layouts.app')

@section('title', 'Scan QR')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label>Status Distribusi</label>
                <select id="statusDistribusi" class="form-control">
                    <option value="Barang Dikirim">Barang Dikirim</option>
                    <option value="Barang Diterima">Barang Diterima</option>
                </select>
            </div>

            <div class="col-md-6">
                <label>Lokasi</label>
                <input type="text"
                    id="lokasiDistribusi"
                    class="form-control"
                    placeholder="Contoh: Gudang Jakarta">
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard">
    <div class="card-body">
        <h3 class="mb-4">Scan QR Barang</h3>
        <div class="row">
            <div class="col-md-6">
                <div id="reader"></div>
            </div>

            <div class="col-md-6">
                <h5>Hasil Scan:</h5>
                <div class="alert alert-primary" id="result">
                    Belum ada QR Code terdeteksi
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HTML5 QR Code -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let scanning = false;

function onScanSuccess(decodedText)
{
    if (scanning) return;
    scanning = true;

    let status = document.getElementById('statusDistribusi').value;
    let lokasi = document.getElementById('lokasiDistribusi').value;

    document.getElementById('result').innerHTML = `
        <strong>QR:</strong><br>
        ${decodedText}<br><br>
        <strong>Status:</strong> ${status}<br>
        <strong>Lokasi:</strong> ${lokasi}
    `;

    fetch('/scan/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            kode_barang: decodedText,
            status: status,
            lokasi: lokasi
        })
    })
    .then(response => response.json())
    .then(data => {

        console.log(data);

        if (data.success)
        {
            let pesan =
                'Status distribusi berhasil diperbarui';

            /*
            |--------------------------------------------------------------------------
            | Jika barang diterima
            |--------------------------------------------------------------------------
            */

            if(status == 'Barang Diterima')
            {
                pesan =
                    'Barang berhasil diterima';
            }

            /*
            |--------------------------------------------------------------------------
            | Popup SweetAlert
            |--------------------------------------------------------------------------
            */

        Swal.fire({

            icon: 'success',

            title: 'Berhasil!',

            text: pesan,

            timer: 2000,

            showConfirmButton: false

        });

        /*
        |--------------------------------------------------------------------------
        | Update result box
        |--------------------------------------------------------------------------
        */

        document.getElementById('result').innerHTML = `

            <div class="text-success">

                <strong>
                    QR berhasil diproses
                </strong>

            </div>

        `;

        /*
        |--------------------------------------------------------------------------
        | Stop scanner
        |--------------------------------------------------------------------------
        */

        html5QrcodeScanner.clear();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        setTimeout(() => {

            window.location.href =
                '/riwayat-pengiriman';

        }, 2000);

        } else {
            scanning = false;

            document.getElementById('result').innerHTML = `
                <div class="text-danger">
                    Barang tidak ditemukan
                </div>
            `;
        }
    })
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    {
        fps: 10,
        qrbox: 250
    }
);

html5QrcodeScanner.render(onScanSuccess);
</script>

@endsection