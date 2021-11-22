@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
    <div class="welcomeHeader">
        <div class="headerParagraph">
            <h1>STASH</h1>
            <div>
                <p>
                    The place where your junk or treasures could be stored. </br>
                    Your have the item, we have a place.
                </p>
            </div>
        </div>
        <div class="headerImage">
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