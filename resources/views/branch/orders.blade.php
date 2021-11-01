@extends('layouts.appBranch')

@section('content')
<div class="container-fluid">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-danger" style="text-align: center; border-radius: 20px">
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success" style="text-align: center; border-radius: 20px">
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @endif
    </div>
</div>
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Branch Employee : {{ Auth::user()->username }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('branch.orders') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders for {{$branch->branch_name}} Branch :Total of
                {{count($orders)}} Orders
            </li>
        </ol>
    </nav>

    <div class="container-fluid" id="deliveryContainer">
        <div class="containerV container" style="padding: 0">
            <div class="container headerVehiclesSchedules">
                <h1>Users</h1>
                <a data-toggle="modal" data-target="#addUser" class="btn btn-sm btn-success float-right"
                    style="border-radius: 10px; text-align: center; margin-top: -30px">Add
                </a>
            </div>

            <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="justify-content: center">
                            <h5 class="modal-title" id="addUserTitle">
                                Add New User
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div>
                                <form method="POST" id="addUserForm" class="row g-3"
                                    action="{{ route('branch.addUser')}}">
                                    @csrf
                                    <div style="display: flex; flex-wrap: wrap; justify-content: space-evenly"
                                        class="container">
                                        <label for="name"><strong>Fill this data only for a new
                                                customer</strong></label>
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
                                        </div>
                                        <div class="row">
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
                                        </div>
                                        <div class="row">
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
                                                        <label for="password">Customer's Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-dismiss="modal">Close</button>
                            <button type="submit" onclick="$('#addUserForm').submit();"
                                class="btn btn-sm btn-outline-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <form action="{{route('branch.orders')}}" enctype="multipart/form-data">
                                <input name="search" type="text" class="search-bar" placeholder="Search User">
                                <span class="input-group-addon">
                                    <button type="submit"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    @if (count($users)>0)

                    @foreach ($users as $user)
                    @if ($noUser)
                    <div class="chat_list ">
                        <a href="{{route('branch.orders', ['user' => $user->ID_User])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%" src="{{ asset('storage/' . $user->user_img) }}"
                                        alt="{{$user->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$user->name}} <span class="chat_date">Phone: {{$user->phone}}</span>
                                    </h5>
                                    <p>Ordered : {{$user->ordered}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @else
                    @if ($active && $activeU == $user->ID_User)
                    <div class="chat_list active_chat">
                        <a href="{{route('branch.orders', ['user' => $user->ID_User])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%" src="{{ asset('storage/' . $user->user_img) }}"
                                        alt="{{$user->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$user->name}} <span class="chat_date">Phone: {{$user->phone}}</span>
                                    </h5>
                                    <p>Ordered : {{$user->order}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="chat_list ">
                        <a href="{{route('branch.orders', ['user' => $user->ID_User])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%" src="{{ asset('storage/' . $user->user_img) }}"
                                        alt="{{$user->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$user->name}} <span class="chat_date">Phone: {{$user->phone}}</span>
                                    </h5>
                                    <p>Ordered : {{$user->ordered}}</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    @endif

                    @endif
                    @endforeach

                    @else
                    <div class="chat_list ">
                        <div class="chat_people">
                            <div class="chat_ib">
                                <h5>No Users</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="line">||</div>
        <div class="container containerS" style="padding-right: 0">
            <div class="container headerVehiclesSchedules">
                <h1>Orders</h1>
                <a onclick="$('#addOrder').toggle('slow')" class="btn btn-sm btn-success float-right"
                    style="border-radius: 10px; text-align: center; margin-top: -30px">Add
                </a>
            </div>
            <div style="display: none" id="addOrder">
                <div class="container" style="display: flex; justify-content: center">
                    <div class="headerAddS">
                        <form method="POST" id="addOrderForm" class="row g-3" action="{{ route('branch.addOrder')}}">
                            @csrf
                            <div class="container" id="userOption">
                                <div class="container">
                                    <div class="container headerOrder">
                                        <div style="display: flex; gap: 60px;">
                                            <label for="name"><strong>User </strong></label>
                                            <div class="form-check form-switch">
                                                <input
                                                    onchange="$('#newCustomerData').toggle('slow'); $('#oldCustomerData').toggle('fast');"
                                                    name="userNew" class="form-check-input" type="checkbox">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">New
                                                    User</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none; margin-left: 20px" id="newCustomerData"
                                        class="container">
                                        <label for="name"><strong>Fill this data only for a new
                                                customer</strong></label>
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
                                                @if($noUser)
                                                <option value="{{$user->ID_User}}">{{$userNo++}}- {{$user->username}} /
                                                    {{$user->name}}
                                                </option>
                                                @else
                                                @if ($activeU == $user->ID_User)
                                                <option selected value="{{$user->ID_User}}">{{$userNo++}}-
                                                    {{$user->username}} /
                                                    {{$user->name}}
                                                </option>
                                                @else
                                                <option value="{{$user->ID_User}}">{{$userNo++}}- {{$user->username}} /
                                                    {{$user->name}}
                                                </option>
                                                @endif
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container" id="orderOptionAndStatusOption" style="display: flex">
                                <div class="container">
                                    <div class="container headerOrder">
                                        <div class="container">
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
                                                    @if ($ind <= 0) <input disabled name="Idunit"
                                                        class="check form-check-input" type="checkbox"
                                                        value="{{$idUnit}}">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{$category->name}}
                                                            (There is {{$ind}} available units)
                                                            <br>
                                                            <small>This Category is has no units </small>
                                                        </label>
                                                        @else
                                                        <input name="Idunit" class="check form-check-input"
                                                            type="checkbox" value="{{$idUnit}}">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{$category->name}}
                                                            (There is {{$ind}} available units)
                                                            <br>
                                                            <small>Unit {{$unitName}} is ready to use </small>
                                                        </label>
                                                        @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container headerOrder">
                                        <div class="container">
                                            <div>
                                                <label for="order_status"><strong>Status </strong></label>
                                            </div>
                                            <div class="form-check">
                                                <div>
                                                    <input name="order_status" checked
                                                        class="checkStatus form-check-input" type="checkbox" value="0">
                                                    <p class="btn-sm btn-info">With Customer</p>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input name="order_status" class="checkStatus form-check-input"
                                                        type="checkbox" value="1">
                                                    <p class="btn-sm btn-light">Waiting for Payment</p>
                                                </div>
                                                <div>
                                                    <input name="order_status" class="checkStatus form-check-input"
                                                        type="checkbox" value="2">
                                                    <p class="btn-sm btn-warning">Delivery</p>
                                                </div>
                                                <div>
                                                    <input name="order_status" class="checkStatus form-check-input"
                                                        type="checkbox" value="2">
                                                    <p class="btn-sm btn-success">In Stash</p>
                                                </div>
                                                <div>
                                                    <input name="order_status" class="checkStatus form-check-input"
                                                        type="checkbox" value="2">
                                                    <p class="btn-sm btn-secondary">Canceled</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="container headerOrder">
                                        <div class="container">
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
                                    </div>
                                    <div class="container headerOrder">
                                        <div class="container">
                                            <div>
                                                <label for="capacity"><strong>Unit Capacity </strong></label>
                                            </div>
                                            <div>
                                                <small> The items stored is filling the unit by the following percent
                                                </small>
                                                <input class="form-control" name="capacity" type="number" min="0"
                                                    max="100" style="margin-bottom: 20px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container headerOrder">
                                        <div class="container">
                                            <div>
                                                <label for="status"><strong>Delivery </strong></label>
                                            </div>
                                            <div class="form-check" style="margin-bottom: 10px">
                                                <div>
                                                    <input onclick="$('#addDeliverySchedule').toggle('slow');"
                                                        name="delivery" class="checkDeleivery form-check-input"
                                                        type="checkbox" value="1">
                                                    <label class="form-check-label" for="flexCheckDefault"> Yes
                                                    </label>
                                                </div>
                                                <div>
                                                    <input checked name="delivery"
                                                        class="checkDeleivery form-check-input" type="checkbox"
                                                        value="0">
                                                    <label class="form-check-label" for="flexCheckDefault"> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="container">
                                    <div class="container headerOrder">
                                        <div class="container">
                                            <div>
                                                <label for="capacity"><strong>Order description
                                                        <small>(optional)</small> </strong></label>
                                            </div>
                                            <div>
                                                <small> The items stored is filling the unit by the following percent
                                                </small>
                                                <textarea class="form-control" name="order_description"
                                                    style="margin-bottom: 20px"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none" id="addDeliverySchedule">
                                <div class="container" style="padding: 0 20px">
                                    <div class="headerOrder"
                                        style="display: flex; justify-content: space-evenly; flex-wrap: wrap">
                                        <div class="col-md-12">
                                            <label for="phone" class="form-label">Vehicle</label>
                                            <div class="form-group">
                                                <select name="ID_DeliveryVehicle" style="width: 100%" class="select2">
                                                    <option value="0">Select Vehicle</option>
                                                    @php
                                                    $vehicleNo = 1;
                                                    @endphp
                                                    @foreach ($vehicles as $vehicle)
                                                    <option value="{{$vehicle->ID_DeliveryVehicle}}">
                                                        {{$vehicleNo++}}- (
                                                        {{$vehicle->plateNumber}} )
                                                        -
                                                        @ {{$vehicle->name}}
                                                        - {{$vehicle->model}}
                                                        - Price {{$vehicle->pricePerK}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pickedUpFrom" class="form-label">Pick Up From</label>
                                            <input type="text" class="form-control" id="pickedUpFrom"
                                                name="pickedUpFrom">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="deliveredTo" class="form-label">Deliver To</label>
                                            <input type="text" class="form-control" id="deliveredTo" name="deliveredTo">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="model" class="form-label">Status</label>
                                            <div class="form-group">
                                                <div style="background: #fff; padding: 3px; border-radius: 5px;display: flex; justify-content: space-between;"
                                                    class="form-check form-switch">
                                                    <div>
                                                        <label style="color: #000;" for="status">Status:
                                                            <small style="display: none" id="statusDone">Done</small>
                                                        </label>
                                                    </div>
                                                    <input style="margin-left: 0; margin-right: 5px; position: inherit"
                                                        onchange="$('#statusDone').toggle('slow');"
                                                        name="statusDelivery" class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckDefault">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pickedUp" class="form-label">Pick Up Date</label>
                                            <input type="datetime-local" class="form-control" id="pickedUp"
                                                name="pickedUp">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="delivered" class="form-label">Deliver Date</label>
                                            <input type="datetime-local" class="form-control" id="delivered"
                                                name="delivered">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="totalPrice" class="form-label">Delivery Price
                                            </label>
                                            <input type="text" class="form-control" id="schedule_totalPrice"
                                                name="schedule_totalPrice">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="schedule_description"><strong>Schedule description
                                                    <small>(optional)</small> </strong></label>
                                            <textarea class="form-control" name="schedule_description"
                                                style="margin-bottom: 20px"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container" style="padding: 0 30px">
                                <button style="width: 100%" type="submit" class="btn btn-outline-dark">Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table100">
                @if (!$active)
                <div class="headerS">
                    <h3>
                        This Is All Orders in {{$branch->branch}} Branch<br>
                        <small>Here you can see all the orders and their information.</small>
                    </h3>
                </div>
                @else
                @if (!$noUser)

                <div class="container">
                    <div class="row gutters-sm" id="info">
                        <div class="col-md-4 mb-3">
                            <div class="card" style="border-radius:20px; padding: 5px">
                                <div class="card-body" style="background: #9D3488;border-radius:20px;">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img width="100px" src="{{ asset('storage/' . $userProfile->user_img) }}"
                                            alt="user{{ $userProfile->name }}" class="img-fluid rounded-circle"
                                            style="border: white 5px solid;">
                                        <div style="margin-top: 5px">
                                            <h4 style="color: white;text-transform: uppercase">
                                                <strong>{{ $userProfile->username }}</strong>
                                            </h4>
                                            <p style="color: white"><strong>Customer</strong></p>
                                            <p style="color: white"><strong>Customr in STASH</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="float-right" style="cursor: pointer;">
                                        <a style="text-decoration: none;cursor: pointer"
                                            onclick="$('#edit').toggle('fast'); $('#info').toggle('fast'); return false;"><i
                                                class="fa fa-pencil-square-o icons " aria-hidden="true"></i></a>
                                    </div>
                                    <div class="row" style="margin-top: 35px">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"><strong>Name</strong></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $userProfile->name }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-2"><strong>UserName</strong></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $userProfile->username }}
                                        </div>
                                        <div class="col-sm-3">
                                            <h6 class="mb-2"><strong>Email</strong></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $userProfile->email }}
                                        </div>
                                        <div class="col-sm-3">
                                            <h6 class="mb-2"><strong>Phone</strong></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $userProfile->phone }}
                                        </div>
                                        <div class="col-sm-3">
                                            <h6 class="mb-2"><strong>Address</strong></h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $userProfile->address }}
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters-sm" id="edit" style="display: none">
                        <div class="col-md-4 mb-3">
                            <div class="card" style="border-radius:20px;">
                                <div class="card-body" style="background: #fff;border-radius:20px;">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ asset('storage/' . $userProfile->user_img) }}"
                                            alt="user{{ $userProfile->name }}" class="rounded-circle" width="150"
                                            style="border: white 2px solid;">
                                        <div class="mt-2">
                                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                                <a href="" onclick="$('#imageInput').click(); return false;"
                                                    class="btn btn-outline-dark">Change Picture</a>
                                                <form method="post" style="display: none;"
                                                    action="{{ route('branch.editImageUser', ['user'=>$userProfile]) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input id="imageInput" style="border: none"
                                                        onchange="document.getElementById('upload').click();"
                                                        type="file" name="image">
                                                    <input type="submit" name="upload" id="upload">
                                                </form>
                                                <a onclick="$('#restore').submit(); return false;"
                                                    class="btn btn-outline-dark">Restore
                                                    Default</a>
                                                <form style="display: none" method="POST"
                                                    action="{{ route('branch.defaultImageUser', ['user'=>$userProfile]) }}"
                                                    id="restore">
                                                    @csrf
                                                </form>
                                                <a onclick="$('#delete').submit(); return false;"
                                                    class="btn btn-outline-danger">Delete
                                                    User</a>
                                                <form style="display: none" method="POST"
                                                    action="{{ route('branch.deleteUser', ['user'=>$userProfile]) }}"
                                                    id="delete">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3" style="border-radius:20px;">
                                <form method="post"
                                    action="{{ route('branch.editBioDataUser', ['user'=>$userProfile]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="float-right" style="cursor: pointer;">
                                            <a style="text-decoration: none ;cursor: pointer"
                                                onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                                <i class="fa fa-times icons" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="row" style="margin-top: 30px">
                                            <div class="col-sm-12">
                                                <label for="name"><strong>Name</strong></label>
                                                <input name="name" type="text" class="form-control"
                                                    value="{{ $userProfile->name }}" placeholder="Enter Your Full Name">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-sm-12">
                                                <label for="username"><strong>Username</strong></label>
                                                <input name="username" type="text" class="form-control"
                                                    value="{{ $userProfile->username }}" placeholder="Enter Model">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-sm-12">
                                                <label for="email"><strong>Email</strong></label>
                                                <input name="email" type="text" class="form-control"
                                                    value="{{ $userProfile->email }}" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-sm-12">
                                                <label for="phone"><strong>Phone</strong></label>
                                                <input name="phone" type="text" class="form-control"
                                                    value="{{ $userProfile->phone }}" placeholder="Enter Your Phone">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-sm-12">
                                                <label for="address"><strong>address</strong></label>
                                                <input name="address" type="text" class="form-control"
                                                    value="{{ $userProfile->address }}"
                                                    placeholder="Enter Your Address">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-sm-12" style="margin-top: 10px">
                                                <button class="btn btn-outline-dark"
                                                    style="float: right">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="headerS">
                        <h3>
                            This Is All Orders for {{ $userProfile->name}} Customer
                            <a href="{{route('branch.orders', ['user' => $userProfile->ID_User])}}"
                                style="text-decoration: none;cursor: pointer"><i data-toggle="tooltip"
                                    title="Refresh Orders" class="refresh-hover fas fa-sync icons"></i></a>
                            <br>
                            <small>Here you can see all the schedules and their information.</small>
                        </h3>
                    </div>
                </div>

                @else
                <div class="headerS">
                    <h3>
                        No User Found Using This Word ({{$searchName}})<br>
                        <small>Try again or add new</small>
                    </h3>
                </div>

                @endif
                @endif
                @if(count($orders)>0)

                <div class="table100">
                    <table>
                        <thead>
                            <tr>
                                <th class="column">Status</th>
                                <th class="column">Period</th>
                                <th class="column">Has Delivery</th>
                                <th class="column">Total Price</th>
                                <th class="column">Unit</th>
                                <th class="column">Customer</th>
                                <th class="column">Made By</th>
                                <th class="column">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td data-label="Status" class="column">
                                    @if ($order->order_status == 0)
                                    <p class="btn-sm btn-info">With Customer</p>
                                    @elseif($order->order_status == 1)
                                    <p class="btn-sm btn-light">Waiting for Payment</p>
                                    @elseif($order->order_status == 2)
                                    <p class="btn-sm btn-warning">Delivery</p>
                                    @elseif($order->order_status == 3)
                                    <p class="btn-sm btn-success">In Stash</p>
                                    @elseif($order->order_status == 4)
                                    <p class="btn-sm btn-secondary">Canceled</p>
                                    @endif
                                </td>

                                <td data-label="Period" class="column">
                                    @php
                                    $date1 = new DateTime($order->startsFrom);
                                    $date2 = new DateTime($order->endsAt);
                                    $interval = $date1->diff($date2);
                                    @endphp
                                    <p>@if($interval->d == 0 && $interval->m == 0 && $interval->y == 0)
                                        <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                            <small id="fromIcon{{$order->ID_Order}}" style="display: none">From:</small>
                                        </i>
                                        {{$order->startsFrom}}
                                        <br>
                                        <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                            <small id="untilIcon{{$order->ID_Order}}"
                                                style="display: none">Until:</small>
                                        </i>
                                        {{$order->endsAt}}
                                        <small>The same day</small>
                                        @elseif($interval->m == 0 && $interval->y == 0)
                                        <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                            <small id="fromIcon{{$order->ID_Order}}" style="display: none">From:</small>
                                        </i>
                                        {{$date1->format('Y-m-d')}}
                                        <br>
                                        <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                            <small id="untilIcon{{$order->ID_Order}}"
                                                style="display: none">Until:</small>
                                        </i>
                                        {{$date2->format('Y-m-d')}}
                                        <small>{{$interval->d}} Days</small>
                                        @elseif($interval->y == 0 && $interval->m > 0)
                                        <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                            <small id="fromIcon{{$order->ID_Order}}" style="display: none">From:</small>
                                        </i>
                                        {{$date1->format('Y-m-d')}}
                                        <br>
                                        <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                            <small id="untilIcon{{$order->ID_Order}}"
                                                style="display: none">Until:</small>
                                        </i>
                                        {{$date2->format('Y-m-d')}}
                                        <small>{{$interval->m}} months, {{$interval->d}} days</small>
                                        @elseif($interval->y > 0)
                                        <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                            <small id="fromIcon{{$order->ID_Order}}" style="display: none">From:</small>
                                        </i>
                                        {{$date1->format('Y-m-d')}}
                                        <br>
                                        <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                            class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                            <small id="untilIcon{{$order->ID_Order}}"
                                                style="display: none">Until:</small>
                                        </i>
                                        {{$date2->format('Y-m-d')}}
                                        <small>{{$interval->y}} years, {{$interval->m}} months, {{$interval->d}}
                                            days</small>
                                        @endif
                                    </p>
                                </td>
                                <td data-label="Has Delivery" class="column">
                                    @if ($order->order_deliveries <= 0) <p class="btn-sm btn-secondary">No Deliveries
                                        </p>
                                        @else
                                        <p class="btn-sm btn-success">{{$order_deliveries}}</p>
                                        @endif
                                </td>
                                <td data-label="Total Price" class="column">
                                    <p>{{$order->order_totalPrice}}</p>
                                </td>
                                <td data-label="Unit" class="column">
                                    <p>{{$order->unit_name}}</p>
                                </td>
                                <td data-label="Customer" class="column">
                                    <a href="{{route('branch.orders', ['user' => $order->ID_User])}}">
                                        <p>{{$order->username}}</p>
                                    </a>
                                </td>
                                <td data-label="Status" class="column">
                                    @if ($order->madeBy)
                                    <p class="btn-sm btn-success">Branch</p>
                                    @else
                                    <p class="btn-sm btn-secondary">Customer</p>
                                    @endif

                                </td>
                                <td data-label="Action" class="column">
                                    <div style="display: flex; justify-content:space-around">
                                        <a href="{{ route('branch.orderDetails', ['order'=>$order]) }}" data-toggle="
                                            tooltip" title="Detials" style="text-decoration: none;cursor: pointer">
                                            <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                        </a>
                                        <a onclick="$('#deleteOrder{{$order->ID_Order}}').submit();"
                                            data-toggle="tooltip" title="Delete Record"
                                            style="text-decoration: none;cursor: pointer">
                                            <i class="delete-hover far fa-trash-alt icons"></i>
                                        </a>
                                        <form hidden action="{{ route('branch.deleteOrder', $order) }}"
                                            id="deleteOrder{{$order->ID_Order}}" enctype="multipart/form-data"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="headerS">
                    <h3>
                        No Orders Found<br>
                        <small>Try again or add new</small>
                    </h3>
                </div>
                @endif
            </div>
        </div>
    </div>
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
@endsection