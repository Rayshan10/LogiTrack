<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Login | Sistem Monitoring Distribusi Barang</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            body{
                margin:0;
                background:linear-gradient(135deg,#0d6efd,#4f9cff);
                min-height:100vh;
                display:flex;
                justify-content:center;
                align-items:center;
                font-family:'Segoe UI',sans-serif;
            }

            .login-card{
                width:1000px;
                border-radius:25px;
                overflow:hidden;
                box-shadow:0 25px 60px rgba(0,0,0,.25);
                background:white;
            }

            .left-panel{
                background:#0d6efd;
                color:white;
                padding:60px;
                height:100%;
            }

            .left-panel h2{
                font-weight:bold;
            }

            .left-panel p{
                opacity:.9;
            }

            .feature{
                margin-top:18px;
                font-size:17px;
            }

            .feature i{
                margin-right:10px;
            }

            .right-panel{
                padding:60px;
            }

            .right-panel h3{
                font-weight:bold;
            }

            .logo{
                font-size:70px;
            }

            .form-control{
                border-radius:12px;
                height:48px;
            }

            .btn-login{
                border-radius:12px;
                padding:12px;
                font-weight:bold;
            }

            .footer{
                margin-top:30px;
                text-align:center;
                color:#777;
                font-size:14px;
            }
        </style>
    </head>

    <body>
        <div class="login-card">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="left-panel">
                        <div class="logo">
                            📦
                        </div>
                        
                        <h2 class="mt-3">
                            LOGISTIK DISTRIBUSI
                        </h2>
                        
                        <p>
                            Sistem Monitoring Distribusi Barang menggunakan QR Code dan Metode SAW.
                        </p>
                        
                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Monitoring Distribusi Barang
                        </div>
                        
                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            Tracking Barang
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
                            Laporan Distribusi
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="right-panel">
                        <h3 class="mb-4">
                            Login Admin / Kurir
                        </h3>
                        
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label>Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>

                                    @error('email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label>Password</label>
                                <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                                
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-check mb-4">
                                <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember">
                                
                                <label
                                    class="form-check-label" for="remember">Remember Me
                                </label>
                            </div>
                            
                            <button class="btn btn-primary w-100 btn-login">
                                <i class="bi bi-box-arrow-in-right"></i>
                                LOGIN
                            </button>
                        </form>
                        
                        <div class="footer">
                            © {{ date('Y') }}
                            Sistem Monitoring Distribusi Barang
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>