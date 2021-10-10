@extends('layouts.appAdmin')


@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Make New Order</li>
        </ol>
    </nav>
    <div class="card mb-3" style="border-radius:20px;">
        <div class="card-header" style="padding: 10px; border-radius:20px;">
            <div style="display: flex; justify-content: space-around; text-decoration: bold">
                <h5>Make a New Order</h5>
            </div>
        </div>
        <div style="padding: 10px; margin: 0; ">
            <div class="mb-1" style="display: flex; justify-content: space-between;">
                <div class="alert-success" style="border-radius: 20px; padding: 10px; width: 100%">
                    <p style="margin: 0"><strong>Description : </strong>Here you will be able to make orders for renting
                        the units in your branch. Switch the New User option if the customer has never used STASH.</p>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 10px;">
            <form method="POST" action="{{route('admin.makeRent')}}" enctype="multipart/form-data">
                @csrf
                <div class="container" id="userOption">
                    <div class="container">
                        <div class="container headerOrder">
                            <div style="display: flex; gap: 60px;">
                                <label for="name"><strong>User </strong></label>
                                <div class="form-check form-switch">
                                    <input
                                        onchange="$('#newCustomerData').toggle('slow'); $('#oldCustomerData').toggle('fast');"
                                        name="userNew" class="form-check-input" type="checkbox"
                                        id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">New User</label>
                                </div>
                            </div>
                        </div>
                        <div style="display: none; margin-left: 20px" id="newCustomerData" class="container">
                            <label for="name"><strong>Fill this data only for a new customer</strong></label>
                            <div class="row">
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-user-plus" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="name">
                                            <label for="name">Customer's Full Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-user-circle-o" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="username">
                                            <label for="username">Customer's Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="email" class="form-control" name="email">
                                            <label for="email">Customer's Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-phone-square" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="phone">
                                            <label for="phone">Customer's Phone</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-location-arrow" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="address">
                                            <label for="address">Customer's Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="icons fa fa-key" aria-hidden="true"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password">
                                            <label for="address">Customer's Password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="oldCustomerData" class="container">
                            <label for="name"><strong>Find a Customer in Our Database</strong></label>
                            <div class="form-group">
                                <select name="userOld" style="width: 100%" class="select2">
                                    <option value="0">Select User</option>
                                    @php
                                    $userNo = 1;
                                    @endphp
                                    @foreach ($users as $user)
                                    <option value="{{$user->ID_User}}">{{$userNo++}}- {{$user->username}} /
                                        {{$user->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container" id="orderOptionAndStatusOption" style="display: flex">
                    <div class="container">
                        <div class="container headerOrder" style="display: flex; gap: 20px">
                            <div>
                                <label><strong>Category </strong></label>
                            </div>
                            <div class="form-check">
                                @foreach ($categories as $category)
                                @php
                                $ind = 0;
                                $unitName= '';
                                $idUnit = 0;
                                @endphp
                                <div>
                                    @foreach ($units as $unit)
                                    @if ($unit->ID_Category == $category->ID_Category)
                                    @php
                                    $ind++;
                                    $unitName = $unit->IdName;
                                    $idUnit = $unit->ID_Unit;
                                    @endphp
                                    @endif
                                    @endforeach
                                    <input name="Idunit" class="check form-check-input" type="checkbox"
                                        value="{{$idUnit}}">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$category->name}}
                                        (There is {{$ind}} available units)
                                        <br>
                                        <small>Unit {{$unitName}} is ready to use </small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="container headerOrder" style="display: flex; gap: 40px">
                            <div>
                                <label for="status"><strong>Status </strong></label>
                            </div>
                            <div class="form-check">
                                <div>
                                    <input name="status" checked class="checkStatus form-check-input" type="checkbox"
                                        value="0">
                                    <label class="form-check-label" for="flexCheckDefault"> Waiting
                                    </label>
                                </div>
                                <div>
                                    <input name="status" class="checkStatus form-check-input" type="checkbox" value="1">
                                    <label class="form-check-label" for="flexCheckDefault"> Delivery
                                    </label>
                                </div>
                                <div>
                                    <input name="status" class="checkStatus form-check-input" type="checkbox" value="2">
                                    <label class="form-check-label" for="flexCheckDefault"> Done
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="container headerOrder" style="display: flex; gap: 20px">
                            <div>
                                <label for="status"><strong>Period </strong></label>
                            </div>
                            <div class="form-group">
                                <label for="startsFrom">From</label>
                                <input class="form-control" type="datetime-local" name="startsFrom">
                                <label for="endsAt">Until</label>
                                <input class="form-control" type="datetime-local" name="endsAt">
                            </div>
                        </div>
                        <div class="container headerOrder" style="display: flex; gap: 20px">
                            <div>
                                <label for="status"><strong>Delivery </strong></label>
                            </div>
                            <div class="form-check" style="margin-bottom: 10px">
                                <div>
                                    <input name="delivery" class="checkDeleivery form-check-input" type="checkbox"
                                        value="1">
                                    <label class="form-check-label" for="flexCheckDefault"> Yes
                                    </label>
                                </div>
                                <div>
                                    <input checked name="delivery" class="checkDeleivery form-check-input"
                                        type="checkbox" value="0">
                                    <label class="form-check-label" for="flexCheckDefault"> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-dark" type="submit">Rent</button>
            </form>
        </div>
        <script>
            $(".select2").select2({
                theme: "bootstrap-5",
                selectionCssClass: "select2--small", // For Select2 v4.1
                dropdownCssClass: "select2--small",
            });
        </script>
        <script>
            $(document).ready(function(){
                $('.check').click(function() {
                    $('.check').not(this).prop('checked', false);
                });
            });
            $(document).ready(function(){
                $('.checkStatus').click(function() {
                    $('.checkStatus').not(this).prop('checked', false);
                });
            });
            $(document).ready(function(){
                $('.checkDeleivery').click(function() {
                    $('.checkDeleivery').not(this).prop('checked', false);
                });
            });
        </script>
    </div>
</div>
@endsection