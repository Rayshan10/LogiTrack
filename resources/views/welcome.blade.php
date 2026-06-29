<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Sistem Monitoring Distribusi Barang</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body{
            background:linear-gradient(135deg,#0d6efd,#4f9cff);
            min-height:100vh;
            display:flex;
            align-items:center;
            color:white;
        }

        .hero-card{
            background:white;
            color:#222;
            border-radius:20px;
            padding:50px;
            box-shadow:0 20px 40px rgba(0,0,0,.2);
        }

        .feature{
            margin-top:18px;
            font-size:17px;
        }

        .feature i{
            color:#0d6efd;
            margin-right:10px;
        }

        .title{
            font-weight:700;
            font-size:42px;
        }

        .subtitle{
            color:#666;
            font-size:18px;
        }

        .hero-image{
            font-size:180px;
            color:#0d6efd;
        }
    </style>
    </head>
    
    <body>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-card">
                        <h1 class="title">📦 Sistem Monitoring Distribusi Barang</h1>
                        <p class="subtitle mt-3">
                            Menggunakan QR Code dan Metode
                            <b>Simple Additive Weighting (SAW)</b>
                            untuk menentukan prioritas distribusi barang.
                        </p>
                        
                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Monitoring Distribusi Barang
                        </div>
                        
                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Tracking Barang Secara Real-Time
                        </div>

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Scan QR Code
                        </div>

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Perhitungan Prioritas SAW
                        </div>

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Laporan PDF Distribusi
                        </div>
                        
                        <div class="mt-5">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Login
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 text-center">
                    <div class="hero-image">
                        <i class="bi bi-truck"></i>
                    </div>
                    
                    <h3 class="fw-bold">
                        Distribusi Barang
                    </h3>
                    
                    <p>Monitoring berbasis QR Code untuk mempercepat proses distribusi.</p>
                </div>
            </div>
        </div>
    </body>
</html>