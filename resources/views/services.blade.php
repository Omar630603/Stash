@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
    <div class="about-services">
        <div class="header-about-services">
            <h2>Safety, Security & Privacy</h2>
        </div>
        <div class="units">
            <h3>Units</h3>
            <h4>In Stash, we offer our customers with different range of unit sizes to suit their needs.</h4>
            <div class="units-inside">
                <div class="div-info">
                    <p class="m-0">You can store your items in one of our units.</p>
                    <p class="m-0">The units are located in various branches around the country.</p>
                    <p class="m-0">You can simply choose a city and then a branch located in that city and then fill in
                        the
                        details required
                        for the unit that you want and voilà you got yourself a storage unit.</p>
                    <p class="m-0">Click on Rent below to start using our services.</p>
                </div>
                <div class="images">
                    <img class="large-image" src="{{ asset('storage/images/largeUnit.png') }}" alt="" class="img-fluid">
                    <img class="medium-image" src="{{ asset('storage/images/mediumUnit.png') }}" alt=""
                        class="img-fluid">
                    <img class="small-image" src="{{ asset('storage/images/smallUnit.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="delivery">
            <div style="text-align: right">
                <h3>Delivery System</h3>
                <h4>We offer you a fast and reliable delivery system for your unit order.</h4>
            </div>
            <div class="delivery-inside">
                <div class="delivery-div-info">
                    <p class="m-0">When making an order you can also ask for delivery of your items.</p>
                    <p class="m-0">The branch that you chose has staff dedicated to delivering your items.</p>
                    <p class="m-0">The Items delivery can be done from and to the branch of your unit.</p>
                    <p class="m-0">Go to your order details to make new deliveries.</p>
                </div>
                <div class="deliveryImages">
                    <img class="deliveryImageUser" src="{{ asset('storage/images/user.png') }}" alt=""
                        class="img-fluid">
                    <img class="deliveryImage" src="{{ asset('storage/images/van.png') }}" alt="" class="img-fluid">
                    <img class="deliveryImageF" src="{{ asset('storage/images/vanf.png') }}" alt="" class="img-fluid">
                    <img class="deliveryImageUnit" src="{{ asset('storage/images/unit.png') }}" alt=""
                        class="img-fluid">
                </div>
            </div>
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
@endsection