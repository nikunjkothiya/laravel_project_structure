<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Pages / 403 </title>

    <!-- Favicons -->
    <link href="{{ asset('public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4tfo9YKnGSOdIOFCML7BPA/jF4ilQwZmF6vA2T+fSyyFSxHedFvVvDDJbh+HHW9Z" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" integrity="sha384-mQ93eFGH7pOUb0/7T/XpTQO8V1+NwYcUt2P0soA6Z+5LCFLFlMIGsM7zq28CS8Q8" crossorigin="anonymous">

</head>

<body>
    <main>
        <div class="container">
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>403</h1>
                <h2>User does not have the right permissions.</h2>
                <a class="btn" href="{{ route('dashboard') }}">Back to home</a>
                <img src="{{ asset('public/assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found" />
            </section>
        </div>
    </main>
    <!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-DfXdz2htPH0lsSSs5nCTpuj/4ey2XlC7R+qFJ7m8VnQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha384-1d4iqR1vjJ3xW3e6k2bF6ovZZbSB4P0Mg8rxFLVGhFhCxP8jftogzz/Z0vnD3HzN" crossorigin="anonymous"></script>
</body>

</html>