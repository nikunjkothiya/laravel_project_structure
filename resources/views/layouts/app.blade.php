<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sample Code') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,700&display=swap" rel="stylesheet">

    <!-- Css -->
    @include('layouts.includes.css')
    @stack('page_css')
</head>

<body>
    <!-- BEGIN: Header -->
    @include('shared.header')
    <!-- END: Header -->

    <main id="main" class="main">
        @yield('content')
    </main>

    <!-- BEGIN: Footer -->
    @include('shared.footer')
    <!-- END: Footer -->

    <!-- BEGIN: Page JS -->
    @include('layouts.includes.js')
    <!-- END: Page JS-->

    @stack('page_js')
    @stack('scripts')

    @if(session()->has('successMsg'))
    <script>
        toastr.success(`{{ session('successMsg') }}`);
    </script>
    @endif
    @if(session()->has('errorMsg'))
    <script>
        toastr.error(`{{ session('errorMsg') }}`);
    </script>
    @endif
</body>

</html>