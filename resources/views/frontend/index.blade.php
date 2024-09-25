<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../frontend/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../frontend/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

        @php
            $setting = DB::table('settings')->first();
        @endphp

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{url('/')}}"><img src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" alt=""></a>
        </div>

        <div class="humberger__menu__widget">
            
            <div class="header__top__right__auth">
                <a href="{{url('/login')}}"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> {{$setting->email}}</li>
                <li>{{$setting->address_line_1}}</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> {{$setting->email}}</li>
                                <li>{{$setting->address_line_1}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            
                            <div class="header__top__right__auth">
                                <a href="{{url('/login')}}"><i class="fa fa-user"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="{{url('/')}}"><img src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" alt=""></a>
                    </div>
                </div>
                
                <h3 style=" font-weight: bold; margin-left: 150px;">{{$setting->company_name}}</h3>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->




    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">

            <div class="row featured__filter">

                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{ asset('uploads/product_image/'.$product->product_image) }}" >
                        </div>
                        <div class="featured__item__text">
                            <h6><a>{{$product->product_name}}</a></h6>
                            <h5>{{$product->selling_price}} tk</h5>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Featured Section End -->



    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="img/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="../frontend/js/jquery-3.3.1.min.js"></script>
    <script src="../frontend/js/bootstrap.min.js"></script>
    <script src="../frontend/js/jquery.nice-select.min.js"></script>
    <script src="../frontend/js/jquery-ui.min.js"></script>
    <script src="../frontend/js/jquery.slicknav.js"></script>
    <script src="../frontend/js/mixitup.min.js"></script>
    <script src="../frontend/js/owl.carousel.min.js"></script>
    <script src="../frontend/js/main.js"></script>



</body>

</html>