@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
    <div class="welcomeHeader">
        <div class="headerParagraph">
            <h1>STASH</h1>
            <p>Self-storage can be broadly defined as a service that allows individuals or businesses to rent secure and
                convenient storage units when they need extra space to store their goods.Self-storage isn’t just for
                individuals and families storing their home contents. Our units can also be used for business needs.
                Stash
                offers your business the ultimate in secure and flexible unit sizes. Whatever the storage needs are, we
                have
                your business covered. At Stash we have a wide range of room sizes from small to large to suit
                customers’
                requirements. Like the unit sizes, we are very flexible and it’s possible can increase and decrease the
                storage as often as liked and we only charge for the size of the occupied unit.
            </p>
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
                <img src=" {{ asset('storage/'. $category->img) }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column">
                    <h5 class="mt-auto card-title" style="text-align: center;">{{ $category->name }}</h5>
                    <div>
                        <p class="mt-auto card-text"><strong>Description: </strong>{{ $category->description }}</p>
                        <p class="mt-auto card-text" style="margin-bottom: 10px"><strong>Dimensions:
                            </strong>{{ $category->dimensions }}</p>
                    </div>
                    <a href="#" class="mt-auto btn btn-rent">Rent</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection