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


        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/appAdmin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icon.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('storage/images/logo.png') }}">
    </head>

    <body style="background-color: #fff8e6">
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="padding: 0">
                <div class="container">
                    <a class="navbar-brand" style="padding-top: 0; font-size: 0" href="{{ url('/') }}">
                        <img align="center" width="90" src="{{ asset('storage/images/Logo with Name H.png') }}" alt="">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>
                        <!-- Middle Side Of Navbar -->
                        <nav class="shift" style="padding: 0">
                            <ul class="navbar-nav m-auto">
                                <li><a href="{{route('home')}}">Home</a></li>
                                <li><a href="{{route('admin.category')}}">Categories</a></li>
                                <li><a href="{{route('admin.orders')}}">Orders</a></li>
                                <li><a href="{{route('admin.delivery')}}">Delivery</a></li>
                            </ul>
                        </nav>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
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
                                    <li><a style="color: #fff8e6" href="{{route('admin.category')}}">Categories</a></li>
                                    <li><a style="color: #fff8e6" href="{{route('admin.orders')}}">Orders</a></li>
                                    <li><a style="color: #fff8e6" href="{{route('admin.delivery')}}">Delivery</a></li>
                                </ul>
                                <div class="social mb-2">
                                    <h3 style="color: #fff8e6">Stay in touch</h3>
                                    <ul class="list-unstyled nav-links">
                                        <li class="in"><a href="#"><span class="icon-instagram"></span></a></li>
                                        <li class="fb"><a href="#"><span class="icon-facebook"></span></a></li>
                                        <li class="tw"><a href="#"><span class="icon-twitter"></span></a></li>
                                        <li class="pin"><a href="#"><span class="icon-pinterest"></span></a></li>
                                        <li class="dr"><a href="#"><span class="icon-dribbble"></span></a></li>
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

</html>