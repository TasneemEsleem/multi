<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="favicon.png" rel="icon">
    <meta name="author" content="Nghia Minh Luong">
    <meta name="keywords" content="Default Description">
    <meta name="description" content="Default keyword">
    <title>Sky - Homepage</title>
    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:300,400,700%7CMontserrat:300,400,500,600,700,800,900"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/ps-icon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/Magnific-Popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/revolution/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/revolution/css/layers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/revolution/css/navigation.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"  rel="stylesheet">
    <!-- Custom-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('style')
</head>

<body class="ps-loading">
    <div class="header--sidebar"></div>
    <header class="header">
        <div class="header__top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                        <p>460 West 34th Street, 15th floor, New York - Hotline: 804-377-3580 - 804-399-3580</p>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                        <div class="header__actions"><a href="{{ route('loginCustomer') }}">Login & Regiser</a>
                            <div class="btn-group ps-dropdown"><a class="dropdown-toggle" href="#"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD<i
                                        class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><img src="images/flag/usa.svg" alt=""> USD</a></li>
                                    <li><a href="#"><img src="images/flag/singapore.svg" alt=""> SGD</a>
                                    </li>
                                    <li><a href="#"><img src="images/flag/japan.svg" alt=""> JPN</a></li>
                                </ul>
                            </div>
                            <div class="btn-group ps-dropdown"><a class="dropdown-toggle" href="#"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language<i
                                        class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Japanese</a></li>
                                    <li><a href="#">Chinese</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navigation">
            <div class="container-fluid">
                <div class="navigation__column left">
                    <div class="header__logo"><a class="ps-logo" href="index.html"><img src="images/logo.png"
                     alt=""></a></div>
                </div>
                <div class="navigation__column right">
                    @yield('cart-content')
                    <div class="menu-toggle"><span></span></div>
                </div>
                <div class="navigation__column center">
                    <ul class="main-menu menu">
                        <li class="menu-item menu-item-has-children dropdown"><a href="{{ route('dashboard-customer') }}">Home</a>
                        </li>
                        <li class="menu-item"><a href="{{ route('ViewRestaurant') }}">All Restaurant</a></li>
                        <li class="menu-item"><a href="{{ route('OrderItem') }}">Search Restaurants</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="header-services">
        <div class="ps-services owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="7000"
            data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1"
            data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
            data-owl-mousedrag="on">
            <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>: Get free standard
                delivery on every order with Sky Store</p>
            <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>: Get free standard
                delivery on every order with Sky Store</p>
            <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>: Get free standard
                delivery on every order with Sky Store</p>
        </div>
    </div>
    <main class="ps-main">
        @yield('contents')
        <div class="ps-footer bg--cover" data-background="{{asset('assets/images/background/restaurant-interior.jpg')}}">
            <div class="ps-footer__content">
                <div class="ps-container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                            <aside class="ps-widget--footer ps-widget--info">
                                <header><a class="ps-logo" href="index.html"><img src="images/logo-white.png"
                                            alt=""></a>
                                    <h3 class="ps-widget__title">Address Office 1</h3>
                                </header>
                                <footer>
                                    <p><strong>460 West 34th Street, 15th floor, New York</strong></p>
                                    <p>Email: <a href='mailto:support@store.com'>support@store.com</a></p>
                                    <p>Phone: +323 32434 5334</p>
                                    <p>Fax: ++323 32434 5333</p>
                                </footer>
                            </aside>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                            <aside class="ps-widget--footer ps-widget--info second">
                                <header>
                                    <h3 class="ps-widget__title">Address Office 2</h3>
                                </header>
                                <footer>
                                    <p><strong>PO Box 16122 Collins Victoria 3000 Australia</strong></p>
                                    <p>Email: <a href='mailto:support@store.com'>support@store.com</a></p>
                                    <p>Phone: +323 32434 5334</p>
                                    <p>Fax: ++323 32434 5333</p>
                                </footer>
                            </aside>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">
                            <aside class="ps-widget--footer ps-widget--link">
                                <header>
                                    <h3 class="ps-widget__title">Find Our store</h3>
                                </header>
                                <footer>
                                    <ul class="ps-list--link">
                                        <li><a href="#">Coupon Code</a></li>
                                        <li><a href="#">SignUp For Email</a></li>
                                        <li><a href="#">Site Feedback</a></li>
                                        <li><a href="#">Careers</a></li>
                                    </ul>
                                </footer>
                            </aside>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">
                            <aside class="ps-widget--footer ps-widget--link">
                                <header>
                                    <h3 class="ps-widget__title">Get Help</h3>
                                </header>
                                <footer>
                                    <ul class="ps-list--line">
                                        <li><a href="#">Order Status</a></li>
                                        <li><a href="#">Shipping and Delivery</a></li>
                                        <li><a href="#">Returns</a></li>
                                        <li><a href="#">Payment Options</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                    </ul>
                                </footer>
                            </aside>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 ">
                            <aside class="ps-widget--footer ps-widget--link">
                                <header>
                                    <h3 class="ps-widget__title">Products</h3>
                                </header>
                                <footer>
                                    <ul class="ps-list--line">
                                        <li><a href="#">Shoes</a></li>
                                        <li><a href="#">Clothing</a></li>
                                        <li><a href="#">Accessries</a></li>
                                        <li><a href="#">Football Boots</a></li>
                                    </ul>
                                </footer>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-footer__copyright">
                <div class="ps-container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <p>&copy; <a href="#">SKYTHEMES</a>, Inc. All rights Resevered. Design by <a
                                    href="#"> Alena Studio</a></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <ul class="ps-social">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script type="text/javascript" src="{{ asset('assets/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/gmap3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/imagesloaded.pkgd.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/isotope.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery.matchHeight-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/slick/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/elevatezoom/jquery.elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/Magnific-Popup/dist/jquery.magnific-popup.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAx39JFH5nhxze1ZydH-Kl8xXM3OK4fvcg&amp;region=GB"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/revolution/js/jquery.themepunch.tools.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <!-- Custom scripts-->
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
</body>

</html>
