<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Stash') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/appDriver.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('storage/images/logo.png') }}">
    </head>

    <body style="background-color: #fff8e6">
        <div id="loading">
            <div id="loader-container">
                <div id="loading-image"></div>
            </div>
        </div>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="padding: 0">
                <div class="container-fluid">
                    <a class="navbar-brand" style="padding-top: 0; font-size: 0" href="{{ url('/') }}">
                        <img align="center" width="90" src="{{ asset('storage/images/Logo with Name H.png') }}" alt="">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse pl-2 pr-2 pb-1" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <!-- Middle Side Of Navbar -->
                        <nav class="shift" style="padding: 0">
                            <ul class="navbar-nav m-auto">
                                <li><a href="{{route('home')}}">Dashboard</a></li>
                            </ul>
                        </nav>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto gap-1">
                            <!-- Authentication Links -->
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-dark signupsingin-btn" href="{{ route('login') }}">
                                    <p>{{ __('Login') }}</p><i class="fas fa-sign-in-alt"></i>
                                </a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-dark signupsingin-btn" href="{{ route('register') }}">
                                    <p>{{ __('Register') }}</p>
                                    <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                </a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <div class="profile-logo" style="display: flex; justify-content: space-between;">
                                    <div style="display: flex; flex-direction: column;">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->username }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a href="{{ route('home') }}" class="dropdown-item">Dashboard <i
                                                    style="margin-top: 4px" class="fa fa-dashboard float-right"
                                                    aria-hidden="true"></i></a>
                                            <a id="logout-btn" class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }} <i style="margin-top: 4px"
                                                    class="fa fa-sign-out float-right" aria-hidden="true"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                    <a href="{{ route('home') }}"><img width="35px" height="35px"
                                            style="border-radius: 50%"
                                            src="{{asset('storage/'.Auth::user()->user_img)}}"></a>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4" style="background: rgb(63,22,82);
        background: linear-gradient(0deg, rgba(63,22,82,1) 10%, rgba(157,52,136,1) 40%, rgba(248,159,91,1) 80%);">
                @yield('content')
                <footer class="footer-16371">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-9 text-center">
                                <div class="footer-site-logo mb-4">
                                    <a href="#"><img align="center" width="200"
                                            src="{{ asset('storage/images/Logo with Name H.png') }}" alt=""></a>
                                </div>
                                <ul class="list-unstyled nav-links mb-4">
                                    <li><a style="color: #fff8e6" href="/">Home</a></li>
                                    <li><a style="color: #fff8e6" href="{{ route('welcome.services') }}">Services</a>
                                    </li>
                                    <li><a style="color: #fff8e6" href="{{ route('welcome.aboutus') }}">About Us</a>
                                    </li>
                                    <li><a style="color: #fff8e6" href="{{ route('welcome.contactus') }}">Contact Us</a>
                                    </li>
                                </ul>
                                <div class="social mb-2">
                                    <h3 style="color: #fff8e6">Stay in touch</h3>
                                    <ul class="list-unstyled nav-links">
                                        <li class="in"><a href="#"><span class="icon-instagram"></span></a></li>
                                        <li class="fb"><a href="#"><span class="icon-facebook"></span></a></li>
                                        <li class="tw"><a href="#"><span class="icon-twitter"></span></a></li>
                                        <li class="pin"><a href="#"><span class="icon-pinterest"></span></a></li>
                                    </ul>
                                </div>
                                <div class="copyright">
                                    <p class="font-italic text-muted mb-0">&copy; Copyrights STASH.com All rights
                                        reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
        @yield('scripts')
    </body>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
    <script>
        $(window).on('load', function () {
        $('#loading').slideToggle('fast');
        }) 
    </script>

</html>