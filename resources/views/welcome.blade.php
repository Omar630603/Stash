@extends('layouts.welcome')

@section('content')
<div class="container">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 10px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style=" text-align: center; border-radius: 10px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @endif
    </div>
</div>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px">
        <strong>Whoops!</strong> There were some problems with your input.<br>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="container-fluid">
    <div class="row welcomeHeader">
        <div class="col-sm-8 headerParagraph">
            <div class="row" style="align-items: center">
                <h1 class="col-sm-4" style="font-size: 60px">STASH</h1>
                <h2 class="col-sm-8" style="font-size: 18px">
                    The place where your junk or treasures could be stored. <br>
                    You have the items, we have the place.
                </h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 container-fluid">
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/images/welcome1.jpg') }}"
                                    alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('storage/images/welcome2.jpg') }}"
                                    alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('storage/images/welcome3.jpg') }}"
                                    alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 headerImage m-0">
            <div class="welcomingGreetings">
                @auth
                <h1>Hi, {{Auth::user()->username}}!</h1>
                @else
                <h1>Hi, There!</h1>
                @endauth
                <h1 id="greetings"></h1>
            </div>
            <img class="img-fluid shake" width="200px" src="{{ asset('storage/images/Logo.png') }}">
            <img class="img-fluid" width="400px" src="{{ asset('storage/images/Logo with Name H.png') }}">
        </div>
    </div>
    <div class="services">
        <h1>Services</h1>
        <h2>We offer the following services</h2>
        <div class="servicesCategories">
            @foreach ($categories as $category)
            <div class="card"
                style="width: 20rem; border-radius: 20px; color: #fff; background-color: #E53D71; padding: 10px 10px">
                <img src=" {{ asset('storage/'. $category->category_img) }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column">
                    <h5 class="mt-auto card-title" style="text-align: center;">{{ $category->category_name }}</h5>
                    <h6 class="mt-auto card-title" style="text-align: center;">{{ $category->category_description }}
                    </h6>
                    <div>
                        <p class="m-0 card-text" style="margin-bottom: 10px"><strong>Dimensions:
                            </strong>{{ $category->dimensions }}</p>
                        <p class="mb-2 card-text" style="margin-bottom: 10px"><strong>Price:
                            </strong>Rp.{{ $category->pricePerDay }} / Day</p>
                    </div>
                    @auth
                    <a href="{{ route('chooseCity', ['unit'=> $category->ID_Category] ) }}"
                        class="mt-auto btn btn-rent">Rent</a>
                    @else
                    <a href="{{ route('loginFirst', ['unit'=> $category->ID_Category]) }}"
                        class="mt-auto btn btn-rent">Rent</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    var myDate = new Date();
    var hrs = myDate.getHours();
    var greet;
    if (hrs < 12)
        greet = 'Good Morning';
    else if (hrs >= 12 && hrs <= 17)
        greet = 'Good Afternoon';
    else if (hrs >= 17 && hrs <= 24)
        greet = 'Good Evening';
    document.getElementById('greetings').innerHTML +=
        '<b>' + greet + '!</b> Welcome to';
</script>
@endsection