<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SMaK KLK Dumai - @yield('title')</title>
    <link href="{{ asset('img/logo.png') }}" rel="icon" />
    {{-- Custom fonts for this template --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    {{-- Custom styles for this template --}}
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-dark" href="#">SMaK KLK Dumai</a>
            <div class="ml-auto">
                <a href="{{ route('bookings.step.one') }}" class="btn btn-outline-dark rounded-0 mr-2">Booking Surat</a>
                <a href="{{ route('login') }}" class="btn btn-dark rounded-0">Masuk</a>
            </div>
        </div>
    </nav>

    <div class="d-flex align-items-start justify-content-center py-5 bg-light" style="min-height: 100vh;">
        <div class="container" style="max-width: 700px;">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap core JavaScript --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- Core plugin JavaScript --}}
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    {{-- Custom scripts for all pages --}}
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    {{-- Page level plugins --}}
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    {{-- Page level custom scripts --}}
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    {{-- Page level plugins --}}
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    {{-- Page level custom scripts --}}
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
