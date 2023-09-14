<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('public/front')}}/img/favicon.png" rel="icon">
    <link href="{{asset('public/front')}}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('public/front/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="{{asset('public/front/assets/css/style.css')}}" rel="stylesheet">


    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
        @if(isset($settings->logo))
            <img src="{{ $settings->logo }}" height="50" class="img-circle elevation-2 mt-4" >
        @else
            <img src="{{ asset('logo.png') }}" height="50" class="brand-image mt-4" alt="{{ Config::get('app.name') }}"  style="opacity: .8">
        @endif


        <nav id="navbar" class="navbar">
            <ul>
                @foreach($pages as $page)
                    @if($page->status == 1  and $page->top_menu == 1)

                        <li><a class="nav-link {{Request::is($page->slug)?'active':''}}" href="{{ route('home', [$page->slug]) }}">{{$page->title}}</a></li>

                    @endif
                @endforeach
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
@if($currentPage->slug == "home")
    {!! $currentPage->hero !!}
@endif
<main id="main">
    {!! $currentPage->content !!}
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-contact">
                    {{--                    @if($currentPage->logo_type == "0")--}}
                    {{--                        <h3>Somwire</h3>--}}
                    {{--                    @else--}}
                    {{--                        <!-- Uncomment below if you prefer to use an image logo -->--}}
                    {{--                        <a href="{{ route('home') }}" class="logo"><img src="{{asset('storage/app/public/business/'.$logo)}}" alt=""></a>--}}
                    {{--                    @endif--}}

                    <p>
                        <strong>Phone:</strong> @if(isset($settings)) {{ $settings->business_phone }} @endif<br>
                        <strong>Email:</strong> @if(isset($settings)) {{ $settings->business_email }} @endif<<br>
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        @foreach($pages as $page)
                            @if($page->status == 1  and $page->footer_menu == 1)
                                <li><i class="bx bx-chevron-right"></i> <a class="{{Request::is($page->slug)?'active':''}}" href="{{ route('home', [$page->slug]) }}">{{$page->title}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>Our Social Networks</h4>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="copyright">
            &copy; Copyright <strong><span>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</span></strong>.
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset('public/assets/front')}}/vendor/purecounter/purecounter.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/aos/aos.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/glightbox/js/glightbox.min.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/swiper/swiper-bundle.min.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/waypoints/noframework.waypoints.js"></script>
<script src="{{asset('public/assets/front')}}/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="{{asset('public/assets/front')}}/js/main.js"></script>

</body>

</html>
