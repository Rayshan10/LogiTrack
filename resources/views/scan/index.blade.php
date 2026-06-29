@extends('layouts.app')

@section('title', 'Scan QR')

@section('content')

<div class="card shadow border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-truck"></i>
        Informasi Distribusi
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Status Distribusi
                </label>
                <select
                    id="statusDistribusi"
                    class="form-select">
                    <option value="Barang Dikirim">
                        Barang Dikirim
                    </option>
                    <option value="Barang Diterima">
                        Barang Diterima
                    </option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Lokasi
                </label>
                <input
                    id="lokasiDistribusi"
                    class="form-control"
                    placeholder="Contoh : Gudang Jakarta">
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7">
                <h5 class="mb-3">
                    <i class="bi bi-camera"></i>
                    Kamera Scanner
                </h5>
                <div id="reader"></div>
            </div>
            <div class="col-lg-5">
                <h5 class="mb-3">
                    <i class="bi bi-clipboard-data"></i>
                    Hasil Scan
                </h5>
                <div class="alert alert-secondary" id="result">
                    Belum ada QR Code yang dipindai.
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
        <div class="text-start">
            <h5 class="text-success">
                <i class="bi bi-check-circle-fill"></i>
                QR Berhasil Dibaca
            </h5>
            <hr>
            <p>
                <b>QR :</b>
                ${decodedText}
            </p>
            <p>
                <b>Status :</b>
                ${status}
            </p>
            <p>
                <b>Lokasi :</b>
                ${lokasi}
            </p>
        </div>
    `;

    if(lokasi.trim() == '')
    {
        Swal.fire({
            icon:'warning',
            title:'Lokasi Belum Diisi',
            text:'Silakan isi lokasi distribusi.'
        });

        scanning = false;
        return;
    }

    Swal.fire({
        title:'Memproses QR...',
        allowOutsideClick:false,
        didOpen:()=>{
            Swal.showLoading();
        }
    });

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
            <div class="alert alert-success">
                <h5>
                    <i class="bi bi-check-circle-fill"></i>
                    Berhasil
                </h5>
                QR berhasil diproses.
                <br>
                Status :
                <b>${status}</b>
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