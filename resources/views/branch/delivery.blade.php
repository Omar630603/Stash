@extends('layouts.appBranch')

@section('content')
<div class="container-fluid">
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
<div class="container-fluid">
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
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Branch Employee : {{ Auth::user()->username }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('branch.delivery') }}">Delivery</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delivery Vehicles & Schedules</li>
        </ol>
    </nav>

    <div class="container-fluid" id="deliveryContainer">
        <div class="containerV container-fluid" style="padding: 0" id="driversPanel">
            <div class="container-fluid headerVehiclesSchedules">
                <h1>Vehicles</h1>
                <a data-toggle="modal" data-target="#addVehicle" class="btn btn-sm btn-success float-right"
                    style="border-radius: 10px; text-align: center; margin-top: -30px">Add
                </a>
            </div>

            <div class="modal fade" id="addVehicle" tabindex="-1" role="dialog" aria-labelledby="addVehicle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="justify-content: center">
                            <h5 class="modal-title" id="addVehicleTitle">
                                Add New Vehicle
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="headerAddS">
                                <form method="POST" id="addDriverForm" class="row g-3"
                                    action="{{ route('branch.addDriver')}}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" class="form-control" id="model" name="model">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="plateNumber" class="form-label">Plate Number</label>
                                        <input type="text" class="form-control" id="plateNumber" name="plateNumber">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pricePerK" class="form-label">Price / K</label>
                                        <input type="text" class="form-control" id="pricePerK" name="pricePerK">
                                    </div>
                                    <input hidden type="text" value="{{$branch->ID_Branch}}" name="ID_Branch">
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-dismiss="modal">Close</button>
                            <button type="submit" onclick="$('#addDriverForm').submit();"
                                class="btn btn-sm btn-outline-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <form action="{{route('branch.delivery')}}" enctype="multipart/form-data">
                                <input name="search" type="text" class="search-bar" placeholder="Search Vehicle">
                                <span class="input-group-addon">
                                    <button type="submit"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    @if (count($vehicles)>0)

                    @foreach ($vehicles as $vehicle)
                    @if ($active && $activeV == $vehicle->ID_DeliveryVehicle)
                    <div class="chat_list active_chat">
                        <a href="{{route('branch.delivery', ['driver' => $vehicle->ID_DeliveryVehicle])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border: 2px solid #9D3488; border-radius: 50%; padding: 2px;"
                                        src="{{ asset('storage/' . $vehicle->vehicle_img) }}"
                                        alt="{{$vehicle->vehicle_name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$vehicle->vehicle_name}} <span class="chat_date">Phone:
                                            {{$vehicle->vehicle_phone}}</span>
                                    </h5>
                                    <p>Delivered : {{$vehicle->vehicle_deliveries}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="chat_list ">
                        <a href="{{route('branch.delivery', ['driver' => $vehicle->ID_DeliveryVehicle])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%"
                                        src="{{ asset('storage/' . $vehicle->vehicle_img) }}"
                                        alt="{{$vehicle->vehicle_name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$vehicle->vehicle_name}} <span class="chat_date">Phone:
                                            {{$vehicle->vehicle_phone}}</span>
                                    </h5>
                                    <p>Delivered : {{$vehicle->vehicle_deliveries}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach

                    @else
                    <div class="chat_list ">
                        <div class="chat_people">
                            <div class="chat_ib">
                                <h5>No Vehicles</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="m-0 bookmark">
            <p class="mr-0">List of Drivers</p>
        </div>
        <div class="line" style="margin: -10px -10px -10px 10px; transform: rotate(180deg);">||
        </div>
        <div class="custom-menu">
            <button onclick="$('#driversPanel').toggle('fast');$('.bookmark').toggle('fast')" type="button"
                id="sidebarCollapse" class="btn btn-primary shadow-none">
                <i data-toggle="tooltip" title="Drivers" class="fa fa-bars"></i>
            </button>
        </div>
        <div class="containerS" style="padding-right: 0; width: 100%;"">
            <div class=" headerVehiclesSchedules">
            <h1>Schedules</h1>
            <a onclick="$('#addSchedule').toggle('slow')" class="btn btn-sm btn-success float-right"
                style="border-radius: 10px; text-align: center; margin-top: -30px">Add
            </a>
        </div>
        <div style="display: none" id="addSchedule">
            <div class="container" style="display: flex; justify-content: center">
                <div class="headerAddS">
                    <form method="POST" id="addScheduleForm" class="row g-3" action="{{ route('branch.addSchedule')}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label">Order</label>
                            <div class="form-group">
                                <select name="ID_Order" style="width: 100%" class="select2">
                                    <option value="0">Select Order</option>
                                    @php
                                    $orderNo = 1;
                                    @endphp
                                    @foreach ($orders as $order)
                                    <option value="{{$order->ID_Order}}">{{$orderNo++}}- ( {{$order->unit_name}} )
                                        -
                                        @ {{$order->username}}
                                        - {{$order->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Vehicle</label>
                            <div class="form-group">
                                <select name="ID_DeliveryVehicle" style="width: 100%" class="select2">
                                    <option value="0">Select Vehicle</option>
                                    @php
                                    $vehicleNo = 1;
                                    @endphp
                                    @foreach ($vehicles as $vehicle)
                                    @if ($active && $activeV == $vehicle->ID_DeliveryVehicle)
                                    <option selected value="{{$vehicle->ID_DeliveryVehicle}}">{{$vehicleNo++}}- (
                                        {{$vehicle->plateNumber}} )
                                        -
                                        @ {{$vehicle->vehicle_name}}
                                        - {{$vehicle->model}}
                                        - Price {{$vehicle->pricePerK}}
                                    </option>
                                    @else
                                    <option value="{{$vehicle->ID_DeliveryVehicle}}">{{$vehicleNo++}}- (
                                        {{$vehicle->plateNumber}} )
                                        -
                                        @ {{$vehicle->vehicle_name}}
                                        - {{$vehicle->model}}
                                        - Price {{$vehicle->pricePerK}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pickedUpFrom" class="form-label">Pick Up From</label>
                            <input type="text" class="form-control" id="pickedUpFrom" name="pickedUpFrom">
                        </div>
                        <div class="col-md-6">
                            <label for="deliveredTo" class="form-label">Deliver To</label>
                            <input type="text" class="form-control" id="deliveredTo" name="deliveredTo">
                        </div>
                        <div class="col-md-3">
                            <label for="description_type" class="form-label">Description Type</label>
                            <div class="form-check">
                                <div>
                                    <input name="description_type" checked
                                        class="checkDescription_type form-check-input" type="checkbox"
                                        value="First Delivery">
                                    <p style="width: 100%" class="btn-sm btn-info">First Delivery</p>
                                    </label>
                                </div>
                                <div>
                                    <input name="description_type" class="checkDescription_type form-check-input"
                                        type="checkbox" value="Add to Unit">
                                    <p class="btn-sm btn-info">Add to Unit</p>
                                </div>
                                <div>
                                    <input name="description_type" class="checkDescription_type form-check-input"
                                        type="checkbox" value="Transform from Unit">
                                    <p class="btn-sm btn-info">Transform from Unit</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="description_note" class="form-label">Description Note</label>
                            <textarea type="text" class="form-control" id="description_note" name="description_note"
                                rows="5"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="model" class="form-label">Status</label>
                            <div class="form-check">
                                <div>
                                    <input name="status" checked class="checkStatus form-check-input" type="checkbox"
                                        value="0">
                                    <p style="width: 100%" class="btn-sm btn-info">Waiting</p>
                                    </label>
                                </div>
                                <div>
                                    <input name="status" class="checkStatus form-check-input" type="checkbox" value="1">
                                    <p class="btn-sm btn-warning">On-going</p>
                                </div>
                                <div>
                                    <input name="status" class="checkStatus form-check-input" type="checkbox" value="2">
                                    <p class="btn-sm btn-success">Done</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="pickedUp" class="form-label">Pick Up Date</label>
                            <input onchange="chackDeliveryDates()" type="datetime-local" class="form-control"
                                id="pickedUp" name="pickedUp">
                            <small id="deliveryCheck"></small>
                        </div>
                        <div class="col-md-4">
                            <label for="delivered" class="form-label">Deliver Date</label>
                            <input onchange="chackDeliveryDates()" type="datetime-local" class="form-control"
                                id="delivered" name="delivered">
                        </div>
                        <div class="col-md-4">
                            <label for="totalPrice" class="form-label">Total Price</label>
                            <input onchange="showPrice()" type="number" class="form-control" id="totalPriceInput"
                                name="totalPrice">
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label for="capacity"><strong>Delivery Payment
                                        <small>(This will add the payment details for
                                            the transaction with price: <small id="price"></small>)</small>
                                    </strong></label>
                            </div>
                            <div>
                                <div class="form-check" style="margin-bottom: 10px">
                                    <div>
                                        <input onclick="$('#addPayment').show('fast');" name="transaction"
                                            class="checkPayment form-check-input" type="checkbox" value="1">
                                        <label class="form-check-label" for="flexCheckDefault"> Include
                                            Payment
                                        </label>
                                    </div>
                                    <div>
                                        <input onclick="$('#addPayment').hide('fast');" checked name="transaction"
                                            class="checkPayment form-check-input" type="checkbox" value="0">
                                        <label class="form-check-label" for="flexCheckDefault"> Exclude
                                            Payment
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="addPayment" style="display: none" class="col-md-12">
                            <div class="form-group" style="margin: 10px 0">
                                <select name="ID_Bank" style="width: 100%" class="select2">
                                    <option value="0">Select Bank</option>
                                    @php
                                    $bankNo = 1;
                                    @endphp
                                    @foreach ($banks as $bank)
                                    <option value="{{$bank->ID_Bank}}">
                                        {{$bankNo++}}- (
                                        {{$bank->bank_name}} )
                                        -
                                        @ {{$bank->accountNo}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="margin: 10px 0">
                                <a style="width: 100%;" onclick="$('#proofInputImage').click(); return false;"
                                    class="btn btn-sm btn-outline-dark">Add Payment Proof</a>
                                <input id="proofInputImage" style="display: none;" type="file" name="proof">
                                <input style="display: none; margin-top: 5px; text-align: center; width: 100%" disabled
                                    style="display: none" id="proofPhoto">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn btn-outline-dark">Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table100">
            @if (!$active)
            <div class="headerS">
                <h3>
                    This Is All Delivery Schedules in {{$branch->branch}} Branch<br>
                    <small>Here you can see all the schedules and their information.</small>
                </h3>
            </div>
            @else
            @if (!$noDriver)

            <div class="container">
                <div class="row gutters-sm" id="info">
                    <div class="col-md-4 mb-3">
                        <div class="card" style="border-radius: 10px; padding: 5px">
                            <div class="card-body" style="background: #9D3488;border-radius: 10px;">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img width="100px" src="{{ asset('storage/' . $vehicleDriver->vehicle_img) }}"
                                        alt="user{{ $vehicleDriver->vehicle_name }}" class="img-fluid rounded-circle"
                                        style="border: white 5px solid;">
                                    <div style="margin-top: 5px">
                                        <h4 style="color: white;text-transform: uppercase">
                                            <strong>{{ $vehicleDriver->vehicle_name }}</strong>
                                        </h4>
                                        <p style="color: white"><strong>Driver</strong></p>
                                        <p style="color: white"><strong>Driver for {{$branch->branch_name}}
                                                Branch</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3" style="border-radius: 10px;">
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
                                        {{ $vehicleDriver->vehicle_name }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-2"><strong>Model</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $vehicleDriver->model }}
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-2"><strong>Plate Number</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $vehicleDriver->plateNumber }}
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-2"><strong>Phone</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $vehicleDriver->vehicle_phone }}
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-2"><strong>Price / K</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $vehicleDriver->pricePerK }}
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutters-sm" id="edit" style="display: none">
                    <div class="col-md-4 mb-3">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-body" style="background: #fff;border-radius: 10px;">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset('storage/' . $vehicleDriver->vehicle_img) }}"
                                        alt="user{{ $vehicleDriver->vehicle_name }}" class="rounded-circle" width="150"
                                        style="border: white 2px solid;">
                                    <div class="mt-2">
                                        <div style="display: flex; flex-direction: column; gap: 10px;">
                                            <a href="" onclick="$('#imageInput').click(); return false;"
                                                class="btn btn-outline-dark">Change Picture</a>
                                            <form method="post" style="display: none;"
                                                action="{{ route('branch.editImageDriver', ['driver'=>$vehicleDriver]) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input id="imageInput" style="border: none"
                                                    onchange="document.getElementById('upload').click();" type="file"
                                                    name="image">
                                                <input type="submit" name="upload" id="upload">
                                            </form>
                                            <a onclick="$('#restore').submit(); return false;"
                                                class="btn btn-outline-dark">Restore
                                                Default</a>
                                            <form style="display: none" method="POST"
                                                action="{{ route('branch.defaultImageDriver', ['driver'=>$vehicleDriver]) }}"
                                                id="restore">
                                                @csrf
                                            </form>
                                            <a onclick="$('#delete').submit(); return false;"
                                                class="btn btn-outline-danger">Delete
                                                Driver</a>
                                            <form style="display: none" method="POST"
                                                action="{{ route('branch.deleteDriver', ['driver'=>$vehicleDriver]) }}"
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
                        <div class="card mb-3" style="border-radius: 10px;">
                            <form method="post"
                                action="{{ route('branch.editBioDataDriver', ['driver'=>$vehicleDriver]) }}"
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
                                                value="{{ $vehicleDriver->vehicle_name }}"
                                                placeholder="Enter Your Full Name">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-sm-12">
                                            <label for="model"><strong>Model</strong></label>
                                            <input name="model" type="text" class="form-control"
                                                value="{{ $vehicleDriver->model }}" placeholder="Enter Model">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-sm-12">
                                            <label for="plateNumber"><strong>Plate Number</strong></label>
                                            <input name="plateNumber" type="text" class="form-control"
                                                value="{{ $vehicleDriver->plateNumber }}"
                                                placeholder="Enter Plate Number">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-sm-12">
                                            <label for="phone"><strong>Phone</strong></label>
                                            <input name="phone" type="text" class="form-control"
                                                value="{{ $vehicleDriver->vehicle_phone }}"
                                                placeholder="Enter Your Phone">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-sm-12">
                                            <label for="pricePerK"><strong>Price / K</strong></label>
                                            <input name="pricePerK" type="text" class="form-control"
                                                value="{{ $vehicleDriver->pricePerK }}"
                                                placeholder="Enter Your Address">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-sm-12" style="margin-top: 10px">
                                            <button class="btn btn-outline-dark" style="float: right">Change</button>
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
                        This Is All Delivery Schedules by {{ $vehicleDriver->vehicle_name}} Driver<br>
                        <small>Here you can see all the schedules and their information.</small>
                    </h3>
                </div>
            </div>

            @else
            <div class="headerS">
                <h3>
                    No Driver Found Using This Word ({{$searchName}})<br>
                    <small>Try again or add new</small>
                </h3>
            </div>

            @endif
            @endif
            @if(count($schedules)>0)
            <div class="tableWrapper">
                <table id="driversTable">
                    <thead>
                        <tr>
                            <th class="column">Trip & Period</th>
                            <th class="column">Status</th>
                            <th class="column">Vehicle</th>
                            <th class="column">Total Price</th>
                            <th class="column">Unit</th>
                            <th class="column">Customer</th>
                            <th class="column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                        <tr>
                            <td data-label="Trip" class="column">
                                <div>
                                    @php
                                    $startsFrom = new DateTime($schedule->pickedUp);
                                    $endsAt = new DateTime($schedule->delivered);
                                    $today = new DateTime(date("Y-m-d H:i:s"));
                                    $interval = $startsFrom->diff($endsAt);
                                    $scheduleCheck = $endsAt->diff($today);
                                    @endphp
                                    @if ($scheduleCheck->invert)
                                    <div class="btn-sm btn-primary">
                                        <h6 class="mb-0">@if ($schedule->schedule_status == 2) Done @else Active @endif:
                                            {{ $scheduleCheck->days }} @if ($scheduleCheck->days <= 1) Day @else Days
                                                @endif Left <i data-toggle="tooltip" title="Delivery Trip Details"
                                                onclick="$('#orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}').toggle('fast')"
                                                class="fas fa-arrow-down float-right"></i>
                                        </h6>
                                        <p class="mb-0" style="display: none; width: max-content"
                                            id="orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}">
                                            Pick-Up : {{$schedule->pickedUpFrom}}
                                            <br>Destination: {{$schedule->deliveredTo}}
                                            <br>
                                            @if($interval->days == 0)

                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$schedule->pickedUp}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$schedule->delivered}}
                                            <small>(The same day)</small>
                                            @elseif($interval->m == 0 && $interval->y == 0)
                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$startsFrom->format('Y-m-d')}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$endsAt->format('Y-m-d')}}
                                            <small>({{$interval->d}}@if ($interval->days <= 1) Day @else Days @endif)
                                                    </small>
                                                    @elseif($interval->y == 0 && $interval->m > 0)
                                                    <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                        <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">From:</small>
                                                    </i>
                                                    {{$startsFrom->format('Y-m-d')}}
                                                    <br>
                                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">Until:</small>
                                                    </i>
                                                    {{$endsAt->format('Y-m-d')}}
                                                    <small>({{$interval->m}} months, {{$interval->d}} days)</small>
                                                    @elseif($interval->y > 0)
                                                    <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                        <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">From:</small>
                                                    </i>
                                                    {{$startsFrom->format('Y-m-d')}}
                                                    <br>
                                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">Until:</small>
                                                    </i>
                                                    {{$endsAt->format('Y-m-d')}}
                                                    <small>({{$interval->y}} years, {{$interval->m}} months,
                                                        {{$interval->d}}
                                                        days)</small>
                                                    @endif
                                                    <br>Description: {{$schedule->schedule_description}}
                                        </p>
                                    </div>
                                    @else
                                    <div class="btn-sm btn-danger">
                                        <h6 class="mb-0">@if ($schedule->schedule_status == 2) Done @else Expaired
                                            @endif: Exceeded
                                            {{ $scheduleCheck->days+1 }} @if ($scheduleCheck->days <= 1) Day @else Days
                                                @endif <i data-toggle="tooltip" title="Delivery Trip Details"
                                                onclick="$('#orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}').toggle('fast')"
                                                class="fas fa-arrow-down float-right"></i>
                                        </h6>
                                        <p class="mb-0" style="display: none; width: max-content"
                                            id="orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}">
                                            Pick-Up : {{$schedule->pickedUpFrom}}
                                            <br>Destination: {{$schedule->deliveredTo}}
                                            <br>
                                            @if($interval->days == 0)
                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$schedule->pickedUp}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$schedule->delivered}}
                                            <small>(The same day)</small>
                                            @elseif($interval->m == 0 && $interval->y == 0)
                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$startsFrom->format('Y-m-d')}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$endsAt->format('Y-m-d')}}
                                            <small>({{$interval->d}}@if ($interval->days <= 1) Day @else Days @endif)
                                                    </small>
                                                    @elseif($interval->y == 0 && $interval->m > 0)
                                                    <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                        <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">From:</small>
                                                    </i>
                                                    {{$startsFrom->format('Y-m-d')}}
                                                    <br>
                                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">Until:</small>
                                                    </i>
                                                    {{$endsAt->format('Y-m-d')}}
                                                    <small>({{$interval->m}} months, {{$interval->d}} days)</small>
                                                    @elseif($interval->y > 0)
                                                    <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                        <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">From:</small>
                                                    </i>
                                                    {{$startsFrom->format('Y-m-d')}}
                                                    <br>
                                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                        class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                                            style="display: none">Until:</small>
                                                    </i>
                                                    {{$endsAt->format('Y-m-d')}}
                                                    <small>({{$interval->y}} years, {{$interval->m}} months,
                                                        {{$interval->d}}
                                                        days)</small>
                                                    @endif
                                                    <br>Description: {{$schedule->schedule_description}}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Status" class="column">
                                @if ($schedule->schedule_status == 0)
                                <p class="btn-sm btn-info">Waiting</p>
                                @elseif ($schedule->schedule_status == 1)
                                <p class="btn-sm btn-warning">On-Going</p>
                                @elseif ($schedule->schedule_status == 2)
                                <p class="btn-sm btn-success">Done</p>
                                @endif
                            </td>
                            <td data-label="Vehicle" class="column">
                                <a href="{{route('branch.delivery', ['driver' => $schedule->ID_DeliveryVehicle])}}">
                                    <p class="btn-sm btn-light">{{$schedule->vehicle_name}}</p>
                                </a>

                            </td>
                            <td data-label="Total Price" class="column">
                                <p class="btn-sm btn-light">{{$schedule->schedule_totalPrice}}</p>
                            </td>
                            <td data-label="Unit" class="column">
                                <p class="btn-sm btn-light">{{$schedule->unit_name}}</p>
                            </td>
                            <td data-label="Customer" class="column">
                                <a href="{{route('branch.orders', ['user' => $schedule->ID_User])}}">
                                    <p class="btn-sm btn-light">{{$schedule->username}}</p>
                                </a>
                            </td>
                            <td style="text-align: right" data-label="Action" class="column">
                                <div style="display: flex; justify-content:space-around">
                                    <a href="{{ route('branch.orderDetails', ['order'=>$schedule->ID_Order]) }}"
                                        data-toggle="tooltip" title="Detials"
                                        style="text-decoration: none;cursor: pointer">
                                        <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="$('#deleteSchedule{{$schedule->ID_DeliverySchedule}}').submit();"
                                        data-toggle="tooltip" title="Delete Record"
                                        style="text-decoration: none;cursor: pointer">
                                        <i class="delete-hover far fa-trash-alt icons"></i>
                                    </a>
                                    <form hidden action="{{ route('branch.deleteSchedule', $schedule) }}"
                                        id="deleteSchedule{{$schedule->ID_DeliverySchedule}}"
                                        enctype="multipart/form-data" method="POST">
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
                    No Schedules Found<br>
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
    $(document).ready(function(){
        $('.checkStatus').click(function() {
            $('.checkStatus').not(this).prop('checked', false);
        });
        $('.checkDescription_type').click(function() {
            $('.checkDescription_type').not(this).prop('checked', false);
        });
        $('.checkPayment').click(function() {
            $('.checkPayment').not(this).prop('checked', false);
        });
        $('#driversTable').DataTable( {
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
    });
    function chackDeliveryDates() {
        var pickedUp = new Date($('#pickedUp').val()); 
            var delivered = new Date($('#delivered').val());
            var deliveryCheck = document.getElementById('deliveryCheck');
            if (pickedUp > delivered) {
                alert('Dates are Invalid')
                $('#pickedUp').val(null)
                $('#delivered').val(null)
            } else {
                dateDif = Math.round((delivered-pickedUp)/(1000*60*60*24));
                deliveryCheck.textContent =  'Delivery Period: '+dateDif+' days.';
            }
    }
    function showPrice() {
        price = document.getElementById('price');
        totalPriceInput = document.getElementById('totalPriceInput');
        price.textContent = totalPriceInput.value;
    }
</script>
<script>
    + function($) {
    'use strict';
    var proofInputImage = document.getElementById('proofInputImage');
    var p = document.getElementById('proofPhoto');
    proofInputImage.onchange = function() {
        p.style.display = '';
        p.value = 'File Name:' + proofInputImage.files[0].name;
    }
    }(jQuery);
</script>
@endsection