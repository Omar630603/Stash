@extends('layouts.appDriver')

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
<div class="container">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px; justify-content: flex-start">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Profile</a></li>
            <li class="breadcrumb-item">Your Profile : {{ Auth::user()->username }}</li>
            <li class="breadcrumb-item active" aria-current="page">Profile Information</li>
            <i onclick="$('#profile').toggle('fast');" style="margin-left: auto;"
                class="fas fa-chevron-circle-down icons" aria-hidden="true"></i></a></li>
        </ol>
    </nav>
    <div id="profile">
        <div class="row gutters-sm" id="info">
            <div class="col-md-4 mb-3">
                <div class="card" style="border-radius: 10px; padding: 5px">
                    <div class="card-body" style="background: #9D3488;border-radius: 10px;">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img width="100px" src="{{ asset('storage/' . $vehicleDriver->vehicle_img) }}"
                                alt="user{{ $vehicleDriver->vehicle_name }}" class="img-fluid rounded-circle"
                                style="border: white 5px solid;">
                            <div style="margin-top: 22px">
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
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Email</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $vehicleDriver->email }}
                            </div>
                        </div>
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
                                <h6 class="mb-2"><strong>Price / K</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $vehicleDriver->pricePerK }}
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Phone</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $vehicleDriver->vehicle_phone }}
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Address</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $vehicleDriver->address }}
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
                            <div class="mt-3">
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <a href="" onclick="$('#imageInput').click(); return false;"
                                        class="btn btn-outline-dark">Change Picture</a>
                                    <form method="post" style="display: none;"
                                        action="{{ route('driver.editImageDriver', ['driver'=>$vehicleDriver]) }}"
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
                                        action="{{ route('driver.defaultImageDriver', ['driver'=>$vehicleDriver]) }}"
                                        id="restore">
                                        @csrf
                                    </form>
                                    <a onclick="$('#delete').submit(); return false;"
                                        class="btn btn-outline-danger">Delete
                                        Driver</a>
                                    <form style="display: none" method="POST"
                                        action="{{ route('driver.deleteDriver', ['driver'=>$vehicleDriver]) }}"
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
                    <form method="post" action="{{ route('driver.editBioDataDriver', ['driver'=>$vehicleDriver]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="float-right" style="cursor: pointer;">
                                <a style="text-decoration: none ;cursor: pointer"
                                    onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                    <i class="fa fa-times icons" aria-hidden="true"></i></a>
                            </div>
                            <div class="row" style="margin-top: 30px">
                                <div class="col-sm-6">
                                    <label for="name"><strong>Name</strong></label>
                                    <input name="name" type="text" class="form-control"
                                        value="{{ $vehicleDriver->vehicle_name }}" placeholder="Enter The Driver Name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email"><strong>Email</strong></label>
                                    <input name="email" type="email" class="form-control"
                                        value="{{ $vehicleDriver->email }}" placeholder="Enter The Driver Email">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-6">
                                    <label for="phone"><strong>Phone</strong></label>
                                    <input name="phone" type="text" class="form-control"
                                        value="{{ $vehicleDriver->vehicle_phone }}"
                                        placeholder="Enter The Driver Phone">
                                </div>
                                <div class="col-sm-6">
                                    <label for="address"><strong>Address</strong></label>
                                    <input name="address" type="text" class="form-control"
                                        value="{{ $vehicleDriver->address }}" placeholder="Enter The Driver Address">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-4">
                                    <label for="model"><strong>Model</strong></label>
                                    <input name="model" type="text" class="form-control"
                                        value="{{ $vehicleDriver->model }}"
                                        placeholder="Enter The Driver Vehicle Model">
                                </div>
                                <div class="col-sm-4">
                                    <label for="plateNumber"><strong>Plate Number</strong></label>
                                    <input name="plateNumber" type="text" class="form-control"
                                        value="{{ $vehicleDriver->plateNumber }}"
                                        placeholder="Enter The Driver Plate Number">
                                </div>
                                <div class="col-sm-4">
                                    <label for="pricePerK"><strong>Price / K</strong></label>
                                    <input name="pricePerK" type="number" class="form-control"
                                        value="{{ $vehicleDriver->pricePerK }}"
                                        placeholder="Enter Price Per Kilometer For The Driver">
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
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item" onclick="$('#profile').toggle('fast');"><a href="#">Deliveries</a></li>
            <li class="breadcrumb-item">{{$type}}</li>
            <li class="breadcrumb-item active" aria-current="page">{{count($schedules)}}: Deliveries</li>
            <div class="btn-group" style="margin-left: auto;">
                <a href="{{ route('branch.transactions') }}" class="btn btn-sm btn-primary">Deliveries</a>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('driver.home', ['status' => 0]) }}">Waiting</a>
                    <a class="dropdown-item" href="{{ route('driver.home', ['status' => 1]) }}">On-Going</a>
                    <a class="dropdown-item" href="{{ route('driver.home', ['status' => 2]) }}">Done</a>
                    <a class="dropdown-item" href="{{ route('driver.home', ['status' => 3]) }}">Picked Up Today</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('driver.home') }}">All
                        Deliveries</a>
                </div>
            </div>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card" style="border-radius: 10px; padding: 5px">
                <p class="m-0" style="font-size: 20px; text-align: center">List of Deliveries</p>
                <div class="color-progress" style="width: 100%; height: 3px; border-radius: 10px"></div>
                @if (count($schedules)>0)
                <div class="row pl-3 pr-3 pb-3 pt-2" style="align-items: center;">
                    @foreach ($schedules as $schedule)
                    <div class="col-md-8 mt-1">
                        <div class="card p-3 mt-2"
                            style="background-color: #ffffff; box-shadow: 0 0 5px 1px rgba(41, 41, 41, 0.507);">
                            <div class="justify-content-between">
                                <div class="p-2" style="border-radius: 10px;">
                                    <div class="float-right d-flex"
                                        style="flex-direction: column; gap: 10px; align-items: center">
                                        @if ($schedule->schedule_status == 0 || $schedule->schedule_status == 1)
                                        <a data-toggle="modal" style="cursor: pointer"
                                            data-target="#changeStatus{{$schedule->ID_DeliverySchedule }}"><i
                                                data-toggle="tooltip" title="Change the status"
                                                class="icons fas fa-magic"></i></a>
                                        <div class="modal fade" id="changeStatus{{$schedule->ID_DeliverySchedule }}"
                                            tabindex="-1" role="dialog" aria-labelledby="makeDelivery"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="justify-content: center">
                                                        <h5 class="modal-title"
                                                            id="changeStatus{{$schedule->ID_DeliverySchedule }}Title"
                                                            style="color: #000">
                                                            Change the Delivery Status for {{$schedule->name}}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body" style="color: #000">
                                                        <form method="POST"
                                                            id="changeStatus{{$schedule->ID_DeliverySchedule }}Form"
                                                            class="row g-3"
                                                            action="{{ route('driver.changeStatus', $schedule)}}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @if ($schedule->schedule_status == 0)
                                                            <div class="alret alert-warning">
                                                                <strong>
                                                                    <p style="text-align: center">
                                                                        Current Status is Waiting<br>
                                                                        Change to On-Going Status
                                                                    </p>
                                                                </strong>
                                                                <p class="p-2">{{$schedule->schedule_description}}</p>
                                                            </div>
                                                            <input hidden name="status" id="" value="1">
                                                            @elseif ($schedule->schedule_status == 1)
                                                            <div class="alret alert-success">
                                                                <strong>
                                                                    <p style="text-align: center">
                                                                        Current Status is On-Going<br>
                                                                        Change to Done Status
                                                                    </p>
                                                                </strong>
                                                                <p class="p-2">{{$schedule->schedule_description}}</p>
                                                            </div>
                                                            <input hidden name="status" id="" value="2">
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button
                                                            onclick="$('#changeStatus{{$schedule->ID_DeliverySchedule }}Form').submit();"
                                                            type="button"
                                                            class="btn btn-sm btn-outline-primary">Change</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @endif
                                        <i data-toggle="tooltip" title="Rp.{{$schedule->schedule_totalPrice}}"
                                            class=" fas fa-money-bill-wave" style="color: #3aa537"></i>
                                    </div>
                                    <i class="fas fa-truck-pickup" style="color: #66377F"></i> Pick-Up :
                                    {{$schedule->pickedUpFrom}}
                                    <br><i class="fas fa-map-marked-alt" style="color: #E53D71"></i>
                                    Destination:
                                    {{$schedule->deliveredTo}}
                                    <br><i class="fas fa-box" style="color: #e6b000"></i>
                                    {{$schedule->unit_name}}
                                </div>
                                <div class="btn btn-sm btn-light mb-1" style="width: 100%">
                                    {{$schedule->schedule_description}}
                                </div>
                                @if ($schedule->schedule_status == 0)
                                <div class="p-1 m-0"
                                    style="background-color: #2b79b9; color: #f0f0f0; border-radius: 10px; text-align: center">
                                    Waiting
                                    <p class="dotsS m-0"></p>
                                </div>
                                @elseif ($schedule->schedule_status == 1)
                                <div class="p-1 m-0"
                                    style="background-color: #ffd92d; color: #2c2c2c; border-radius: 10px; text-align: center">
                                    On-Going
                                    <p class="dots m-0"></p>
                                </div>
                                @elseif ($schedule->schedule_status == 2)
                                <div class="p-1 m-0"
                                    style="background-color: #5bf870; color: #2c2c2c; border-radius: 10px; text-align: center">
                                    Done
                                </div>
                                @endif
                                <div class=" mt-1">
                                    @php
                                    $startsFrom = new DateTime($schedule->pickedUp);
                                    $endsAt = new DateTime($schedule->delivered);
                                    $today = new DateTime(date("Y-m-d H:i:s"));
                                    $interval = $startsFrom->diff($endsAt);
                                    $scheduleCheck = $endsAt->diff($today);
                                    @endphp
                                    @if ($scheduleCheck->invert)
                                    <div class="p-2" style="background: #0077e7; color: #f0f0f0; border-radius: 10px">
                                        <h6 class="mb-0">@if ($schedule->schedule_status == 2) Done @else Active
                                            @endif:
                                            Deliver in @if ($scheduleCheck->days == 0) Today
                                            @elseif($scheduleCheck->days == 1) 1 Day @else{{
                                            $scheduleCheck->days }}
                                            Days @endif @if ($scheduleCheck->days == 0) @else Left @endif
                                            <i data-toggle="tooltip" title="Delivery Trip Details"
                                                onclick="$('#orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}').toggle('fast')"
                                                class="fas fa-arrow-down float-right"></i>
                                        </h6>
                                        <p class="mb-0" style="display: none; width: max-content"
                                            id="orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}">
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
                                                    <small>({{$interval->m}} months, {{$interval->d}}
                                                        days)</small>
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
                                        </p>
                                    </div>
                                    @else
                                    <div class="p-2" style="background: #d42b2b; color: #f0f0f0; border-radius: 10px">
                                        <h6 class="mb-0">@if ($schedule->schedule_status == 2) Done @else
                                            Expaired
                                            @endif: Exceeded
                                            {{ $scheduleCheck->days+1 }} @if ($scheduleCheck->days <= 1) Day @else Days
                                                @endif <i data-toggle="tooltip" title="Delivery Trip Details"
                                                onclick="$('#orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}').toggle('fast')"
                                                class="fas fa-arrow-down float-right"></i>
                                        </h6>
                                        <p class="mb-0" style="display: none; width: max-content"
                                            id="orderDateDetailsPositive{{$schedule->ID_DeliverySchedule}}">
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
                                                    <small>({{$interval->m}} months, {{$interval->d}}
                                                        days)</small>
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
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-1">
                        <div class="card p-3 mt-2"
                            style="background-color: #9D3488; box-shadow: 0 0 5px 1px rgba(41, 41, 41, 0.507);">
                            <div class="d-flex align-items-center text-center" style="gap: 10px">
                                <img width="100px" src="{{ asset('storage/' . $schedule->user_img) }}"
                                    alt="user{{ $schedule->name }}" class="img-fluid rounded-circle"
                                    style="border: white 5px solid;">
                                <div style="margin-top: 30px">
                                    <h4 style="color: white;text-transform: uppercase">
                                        <strong>{{ $schedule->username }}</strong>
                                    </h4>
                                    <p style="color: white; margin: 0">Phone: {{ $schedule->phone }}
                                    </p>
                                    <p style="color: white;">Email: {{ $schedule->email }}
                                    </p>
                                    <p class="mt-auto" style="color: white;"><strong>Customr in STASH</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-3 color-progress" style="width: 100%; height: 3px; border-radius: 10px"></div>
                    @endforeach
                </div>
                @else
                <div class="col-md-12 mb-3 mt-3">
                    <div class="card" style="border-radius: 10px; padding: 15px; text-align: center">
                        <h6>You don't have @if ($type == 'All')
                            any
                            @else
                            {{$type}}
                            @endif deliveries yet! Stay tuned
                        </h6>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection