@inject('content', 'App\Http\Controllers\FrontController')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | @yield('title')</title>

    <meta name="description" content="{{ $settings->description }}">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $settings->site_name }} - {{ $settings->site_title }}">
    <meta itemprop="description" content="{{ $settings->description }}">

    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/png" />
    @section('styles')

        <link href="{{ asset('themes/purposeTheme/temp/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="{{ asset('themes/purposeTheme/temp/css/materialdesignicons.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!-- Magnific -->
        <link rel="stylesheet" href="{{ asset('themes/purposeTheme/temp/css/line.css') }}">
        <link href="{{ asset('themes/purposeTheme/temp/css/flexslider.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('themes/purposeTheme/temp/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css')}}" />

        <!-- Slider -->
        <link rel="stylesheet" href="{{ asset('themes/purposeTheme/temp/css/owl.carousel.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/purposeTheme/temp/css/owl.theme.default.min.css') }}" />
        @php
            $theme = $settings->website_theme == 'purpose.css' ? 'default.css' : $settings->website_theme;
        @endphp
        <!-- Main Css -->
        <link href="{{ asset('themes/purposeTheme/temp/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('themes/purposeTheme/temp/css/colors/' . $theme) }}" rel="stylesheet">
    @show
</head>

<body>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        {!! $settings->tawk_to !!}
    </script>


    <!-- Navbar STart -->
    <header id="topnav" class="sticky defaultscroll">
        <div class="container">
            <!-- Logo container-->
            <div>
                <a class="logo" href="/">
                    <img src="{{ asset('storage/' . $settings->logo) }}" height="35" alt="" class="mr-2">
                </a>
            </div>
            @guest
                <div class="buy-button">
                    <a href="login" class="mr-3 btn btn-primary login-btn-success">login</a>
                    <a href="register" class="btn btn-primary login-btn-success ">Get Started</a>
                </div>
            @endguest
            @auth
                <div class="btn-group buy-button mt-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        {{ auth()->user()->name }}
                    </a>
                </div>
            @endauth
            <!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li><a href="{{ url('/about') }}">About us</a></li>
                    <li><a href="#pricing">Plans</a></li>
                    <li><a href="{{ url('/faq') }}">Faq</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>

                @guest
                    <!--end navigation menu-->
                    <div class="buy-menu-btn d-none">
                        <a href="{{ url('/login') }}" target="_blank" class="btn btn-success">Login</a>
                        <a href="{{ url('/register') }}" target="_blank" class="btn btn-success">Get Started</a>
                    </div>
                    <!--end login button-->
                @endguest
                @auth
                    <div class="buy-menu-btn d-none">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    </div>
                @endauth
            </div>
            <!--end navigation-->
        </div>
        <!--end container-->
    </header>
    <!--end header-->
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="pb-0 mb-0 col-lg-4 col-12 mb-md-4 pb-md-2">
                    <h5 class="text-light footer-head">{{ $settings->site_name }}</h5>
                    <p class="mt-4">{{ $settings->description }}</p>

                    <ul class="mt-4 mb-0 list-unstyled social-icon social">
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i
                                    data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                    </ul>
                    <!--end icon-->

                </div>
                <!--end col-->

                <div class="pt-2 mt-4 col-lg-4 col-md-4 mt-sm-0 pt-sm-0">
                    <h5 class="text-light footer-head">Useful Links</h5>
                    <ul class="mt-4 list-unstyled footer-list">
                        <li><a href="{{ url('/') }}" class="text-foot"><i
                                    class="mr-1 mdi mdi-chevron-right"></i>
                                Home</a></li>
                        <li><a href="{{ url('/about') }}" class="text-foot"><i
                                    class="mr-1 mdi mdi-chevron-right"></i>
                                About us</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-foot"><i
                                    class="mr-1 mdi mdi-chevron-right"></i>
                                Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}" class="text-foot"><i
                                    class="mr-1 mdi mdi-chevron-right"></i>
                                Faq</a></li>
                    </ul>
                </div>
                <!--end col-->

                <div class="pt-2 mt-4 col-lg-4 col-md-4 mt-sm-0 pt-sm-0">
                    <h5 class="text-light footer-head">Contact Details</h5>
                    <div class="mt-2">
                        <h6 class="text-foot"><i class="mr-1 mdi mdi-home"> </i>
                            Head Office</h6>
                        <p>{{ $content->getContent('52GPRA', 'description') }}</p>
                        <h6><i class="mr-1 mdi mdi-email"> </i>Email Address</h6>
                        <p>{{ $content->getContent('HLgyaQ', 'description') }}</p>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <footer class="footer footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-left">
                        <p class="mb-0">
                            © Copyright {{ date('Y') }} {{ $settings->site_name }} All
                            Rights Reserved.
                        </p>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>
    <!--end footer-->
    <!-- Footer End -->



    @section('scripts')
        <!-- javascript -->
        <script src="{{ asset('themes/purposeTheme/temp/js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('themes/purposeTheme/temp/js/bootstrap.bundle.min.js') }}"></script>

        <!-- SLIDER -->
        <script src="{{ asset('themes/purposeTheme/temp/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('themes/purposeTheme/temp/js/owl.init.js') }}"></script>
        <!-- Icons -->
        <script src="{{ asset('themes/purposeTheme/temp/js/feather.min.js') }}"></script>
        <script src="{{ asset('themes/purposeTheme/temp/js/bundle.js') }}"></script>

        <script src="{{ asset('themes/purposeTheme/temp/js/app.js') }}"></script>
        <script src="{{ asset('themes/purposeTheme/temp/js/widget.js') }}"></script>
    @show
</body>

</html>
