<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SMaK KLK Dumai</title>
    <link href="{{ asset('img/logo.png') }}" rel="icon" />
    {{-- Custom fonts for this template --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- Custom styles for this template --}}
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    {{-- Custom CSS --}}
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />
</head>

<body class="loading authentication-bg"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <div style="position: absolute; top: 20px; right: 20px; z-index: 1000;">
        <a href="#" class="btn btn-outline-dark">Booking Surat</a>
    </div>

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <div class="card-header pt-4 pb-4 text-center bg-gradient-gray">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" height="140">
                        </div>
                        <div class="card-body shadow-lg p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="fw-bold text-dark">PT. KLK Dumai</h4>
                                <p class="text-muted small">Aplikasi Surat Masuk Keluar</p>
                            </div>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email"
                                        placeholder="Masukkan email anda" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="fs-6 mt-2 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Masukkan password">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye-slash" id="toggle-password"
                                                style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="fs-6 mt-2 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-dark w-100" type="submit">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
