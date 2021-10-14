<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', '')">
        <meta name="keywords" content="@yield('meta_keywords', '')">

    @stack('before-styles')

        <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/fontawesome-all.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/meanmenu.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/video.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/lightbox.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/progess.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
        {{--<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">--}}
        <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">

        <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">

        <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
        <link href="{{asset('assets/css/colors/color-2.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-2">
        <link href="{{asset('assets/css/colors/color-3.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-3">
        <link href="{{asset('assets/css/colors/color-4.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-4">
        <link href="{{asset('assets/css/colors/color-5.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-5">
        <link href="{{asset('assets/css/colors/color-6.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-6">
        <link href="{{asset('assets/css/colors/color-7.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-7">
        <link href="{{asset('assets/css/colors/color-8.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-8">
        <link href="{{asset('assets/css/colors/color-9.css')}}" rel="alternate stylesheet" type="text/css"
              title="color-9">

              
        <link rel="stylesheet" href="{{asset('assets/sweetalert/sweetalert2.min.css')}}"/>

        @stack('after-styles')
        @yield('css')
        @if(config('onesignal_status') == 1)
            {!! config('onesignal_data') !!}
        @endif
    @if(config('google_analytics_id') != "")

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{config('google_analytics_id')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config','{{config('google_analytics_id')}}');
        </script>
     @endif
    </head>
    <body class="{{config('layout_type')}}" onload="onload()">

    <div id="app">
    {{--<div id="preloader"></div>--}}
    @include('frontend.layouts.modals.loginModal')


    <!-- Start of Header section
    ============================================= -->
        <header>
            <div id="main-menu" class="main-menu-container">
                <div class="main-menu">
                    <div class="container">
                        <div class="navbar-default">
                            <div class="navbar-header float-left">
                                <a class="navbar-brand text-uppercase" href="{{url('/')}}"><img
                                            src={{asset("storage/logos/".config('logo_w_image'))}} alt="logo"></a>
                            </div><!-- /.navbar-header -->


                            <div class="navbar-menu float-right">
                                <div class="nav-menu ul-li">
                                    <ul>
                                        @if(auth()->check())
                                            <li class="menu-item-has-children ul-li-block">
                                                <a href="#!">{{ $logged_in_user->first_name }}</a>
                                                <ul class="sub-menu">
                                                    @can('view backend')
                                                        <li>
                                                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                                        </li>
                                                    @endcan


                                                    <li>
                                                        <a href="{{ route('frontend.auth.logout') }}">Logout</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @else
                                            <li class="log-in mt-0">
                                                @if(!auth()->check())
                                                    <a id="openLoginModal" data-target="#myModal"
                                                    href="#">Login</a>
                                                    <!-- The Modal -->
                                                @endif
                                            </li>
                                        @endif


                                    </ul>
                                </div>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <nav class="navbar-menu float-left">
                                <div class="nav-menu ul-li">
                                    <ul>
                                        <li class="nav-item">
                                            <a href="{{asset('courses')}}"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="1">Courses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{asset('contact')}}"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="2">Contact</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{asset('about-us')}}"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="3">About Us</a>
                                        </li>

                                        <li class="menu-item-has-children ul-li-block">
                                            <a href="#!">Online Resources</a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a class="" id="menu-4" href="{{url('/faqs')}}">FAQs</a>
                                                </li>
                                                <li>
                                                    <a class="" id="menu-5" href="{{url('/blog')}}">Reference Materials</a>
                                                </li>
                                                <li>
                                                    <a class="" id="menu-6" href="#">Directory of Expertise</a>
                                                    <ul class="depth-2">
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/teachers')}}">Subject Matter Expert Or Instructional Designer</a>
                                                        </li>
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/expertise?type=0')}}">Core Group of Specialist (CGS)</a>
                                                        </li>
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/expertise?type=1')}}">Social Welfare and Development Learning Network (SWDLNet)</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{asset('events')}}"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="21">Events</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>

                            <div class="mobile-menu">
                                <div class="logo"><a href="{{url('/')}}"><img src={{asset("storage/logos/".config('logo_w_image'))}} alt="Logo"></a></div>
                                <nav>
                                    <ul>
                                        <li class="">
                                            <a href="courses"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="menu-1">Courses</a>
                                        </li>
                                        <li class="">
                                            <a href="contact"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="menu-2">Contact</a>
                                        </li>
                                        <li class="">
                                            <a href="about-us"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="menu-3">About Us</a>
                                        </li>

                                        <li class="">
                                            <a href="#!">Online Resources</a>
                                            <ul class="">
                                                <li>
                                                    <a class="" id="menu-4" href="{{url('/faqs')}}">FAQs</a>
                                                </li>
                                                <li>
                                                    <a class="" id="menu-5" href="{{url('/blog')}}">Reference Materials</a>
                                                </li>
                                                <li>
                                                    <a class="" id="menu-6" href="#">Directory of Expertise</a>
                                                    <ul class="depth-2">
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/teachers')}}">Subject Matter Expert Or Instructional Designer</a>
                                                        </li>
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/expertise?type=0')}}">Core Group of Specialist (CGS)</a>
                                                        </li>
                                                        <li>
                                                            <a class="" id="menu-7" href="{{url('/expertise?type=1')}}">Social Welfare and Development Learning Network (SWDLNet)</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="">
                                            <a href="events"
                                                class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                                                id="menu-21">Events</a>
                                        </li>

                                        @if(auth()->check())
                                            <li class="">
                                                <a href="#!">{{ $logged_in_user->name }}</a>
                                                <ul class="">

                                                    @can('view backend')
                                                        <li>
                                                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                                        </li>
                                                    @endcan


                                                    <li>
                                                        <a href="{{ route('frontend.auth.logout') }}">Logout</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @else
                                            <li class="">
                                                <a id="openLoginModal" data-target="#myModal"
                                                   href="#">Login</a>
                                                <!-- The Modal -->
                                                {{--@include('frontend.layouts.modals.loginModal')--}}

                                            </li>
                                        @endif
                                    </ul>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <!-- Start of Header section
        ============================================= -->


        @yield('content')
        @include('cookieConsent::index')
        @if(!isset($no_footer))
            @include('frontend.layouts.partials.footer')
        @endif

    </div><!-- #app -->

    <!-- Scripts -->
    @stack('before-scripts')
    <!-- For Js Library -->
    <script src="{{asset('assets/js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/jarallax.js')}}"></script>
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/js/lightbox.js')}}"></script>
    <script src="{{asset('assets/js/jquery.meanmenu.js')}}"></script>
    <script src="{{asset('assets/js/scrollreveal.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/js/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/gmap3.min.js')}}"></script>
    <script src="{{asset('assets/js/switch.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    <script src="{{asset('assets/sweetalert/sweetalert2.min.js')}}"></script>
    <script>
        function showLoading(){
            Swal.fire({
                title: 'Please Wait !',
                html: 'Loading...',// add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton:false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
        }
        function closeLoading() {
            Swal.close();
        }
        
        $(document).ready(function() {
            showLoading();
        });

        function onload(){
            closeLoading();
        }
    </script>

    <script>
        @if(request()->has('user')  && (request('user') == 'admin'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('admin@lms.com')
        $('#loginForm').find('#password').val('secret')

        @elseif(request()->has('user')  && (request('user') == 'student'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('student@lms.com')
        $('#loginForm').find('#password').val('secret')

        @elseif(request()->has('user')  && (request('user') == 'teacher'))

        $('#myModal').modal('show');
        $('#loginForm').find('#email').val('teacher@lms.com')
        $('#loginForm').find('#password').val('secret')

        @endif
    </script>
    <script>
        @if((session()->has('show_login')) && (session('show_login') == true))
        $('#myModal').modal('show');
                @endif
        var font_color = "{{config('font_color')}}"
        setActiveStyleSheet(font_color);
    </script>
    @yield('js')

    @stack('after-scripts')

    @include('includes.partials.ga')
    @include('includes.partials.check-login')
    </body>
    </html>
