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
                <p class="col-sm-8" style="font-size: 15px">
                    The place where your junk or treasures could be stored. </br>
                    You have the item, we have the place.
                </p>
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
                                <div class="carousel-caption">
                                    <h1>Welcome!</h1>
                                    <p>To Stash</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('storage/images/welcome2.jpg') }}"
                                    alt="Second slide">
                                <div class="carousel-caption">
                                    <h1>Safety & Security</h1>
                                    <p>are what we care about</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('storage/images/welcome3.jpg') }}"
                                    alt="Third slide">
                                <div class="carousel-caption">
                                    <h1>Privacy</h1>
                                    <p>is our top priority</p>
                                </div>
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
                    <div>
                        <p class="mt-auto card-text"><strong>Description: </strong>{{ $category->category_description }}
                        </p>
                        <p class="mt-auto card-text" style="margin-bottom: 10px"><strong>Dimensions:
                            </strong>{{ $category->dimensions }}</p>
                    </div>
                    @auth
                    <a href="{{ route('chooseCity', ['unit'=> $category->ID_Category] ) }}"
                        class="mt-auto btn btn-rent">Rent</a>
                    @else
                    <a href="{{ route('loginFirst') }}" class="mt-auto btn btn-rent">Rent</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection