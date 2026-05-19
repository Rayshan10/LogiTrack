@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3 class="mb-4">
            Scan QR Barang
        </h3>

        <div class="row">

            <div class="col-md-6">

                <div id="reader"></div>

            </div>

            <div class="col-md-6">

                <h5>Hasil Scan:</h5>

                <div class="alert alert-primary"
                     id="result">
                    Belum ada QR Code terdeteksi
                </div>

            </div>

        </div>

    </div>

</div>

<!-- HTML5 QR Code -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>

function onScanSuccess(decodedText, decodedResult) {

    document.getElementById('result').innerHTML =
        "QR Code: " + decodedText;

    window.location.href =
        "/barang?search=" + decodedText;
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