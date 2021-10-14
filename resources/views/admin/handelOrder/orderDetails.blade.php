@extends('layouts.appAdmin')


@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order Details in {{$branch->branch}} Branch</li>
        </ol>
    </nav>
    <div class="container-fluid" id="deliveryContainer" style="flex-wrap: wrap; flex-direction: column">
        <div class="headerO">
            <h1>ORDER</h1>
            <div class="headerS">
                <div class="card" style="border-radius:20px;">
                    <div class="card-body">
                        <h6 class="mb-0"><strong>Order Details</strong></h6>
                        <div class="row" style="margin-top: 35px">
                            <div class="col-sm-3">
                                @php
                                $date1 = new DateTime($order->startsFrom);
                                $date2 = new DateTime($order->endsAt);
                                $interval = $date1->diff($date2);
                                @endphp
                                <h6 class="mb-0"><strong>Period: {{ $interval->days }} Days</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary" style="display: flex">
                                <h6 class="mb-0"><strong>From</strong></h6><br>
                                {{ $order->startsFrom }}
                                <h6 class="mb-0"><strong>Until</strong></h6><br>
                                {{ $order->endsAt }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Status</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary"
                                style="display: flex; gap: 5px; justify-content: space-between">
                                @if ($order->status == 0)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-primary">Waiting</p>
                                @elseif($order->status == 1)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-warning">In Delivery</p>
                                @elseif($order->status == 2)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-secondary">In STASH</p>
                                @endif

                                <form action="{{ route('admin.changeOrderStatus', $order) }}" id="changeOrderStatusForm"
                                    enctype="multipart/form-data" method="POST" style="display: none">
                                    @csrf
                                    <p style="margin: 0">
                                        <small>Old Status:
                                            @if ($order->status == 0)
                                            Waiting
                                            @elseif($order->status == 1)
                                            In Delivery
                                            @elseif($order->status == 2)
                                            In STASH
                                            @endif
                                        </small>
                                    <div style="display: flex; gap: 5px">
                                        <select class="form-select form-select-sm" name="status" id="editStatusOrder">
                                            <option class="btn-sm btn-primary" value="0">Waiting</option>
                                            <option class="btn-sm btn-warning" value="1">In Delivery</option>
                                            <option class="btn-sm btn-secondary" value="2">In STASH</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Change</button>
                                    </div>
                                    <small>When you choose a status, it will change immediately</small>
                                    </p>
                                </form>
                                <a onclick="$('#staticStatusOrder').toggle(''); $('#changeOrderStatusForm').toggle('slow');"
                                    style="text-decoration: none;cursor: pointer">
                                    <i data-toggle="tooltip" title="Change Status"
                                        class="refresh-hover fa fa-magic icons"></i>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Delivery</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                @if ($order->delivery)
                                <p style="width: 70%" class="btn-sm btn-success">Yes</p>
                                @else
                                <p style="width: 70%" class="btn-sm btn-secondary">No</p>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Order Price</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <p style="width: 70%" class="btn-sm btn-success">{{ $order->totalPrice }}</p>
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Extend Time Price</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary"
                                style="display: flex; gap: 5px; justify-content: space-between">
                                @if ($order->expandPrice <= 0) <p style="width: 70%" class="btn-sm btn-secondary">No
                                    extension yet</p>
                                    @else
                                    <p style="width: 70%" class="btn-sm btn-success">{{ $order->expandPrice }}</p>
                                    @endif
                                    <div>
                                        <a data-toggle="modal" data-target="#extendTimeOrder"
                                            style="text-decoration: none;cursor: pointer;">
                                            <i data-toggle="tooltip" title="Extend Time"
                                                class="use-hover far fa-calendar-plus icons" aria-hidden="true"></i>
                                        </a>
                                        <div class="modal fade" id="extendTimeOrder" tabindex="-1" role="dialog"
                                            aria-labelledby="extendTimeOrder" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="justify-content: center">
                                                        <h5 class="modal-title" id="extendTimeOrderTitle">
                                                            Extend Order Time for Customer {{$customer->name}}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert-success"
                                                            style="padding: 10px; border-radius: 20px">
                                                            <form action="{{ route('admin.extendOrder', $order) }}"
                                                                id="extendOrderForm" enctype="multipart/form-data"
                                                                method="POST">
                                                                @csrf
                                                                <p>
                                                                    <center><strong>!! This Will Extend The Order
                                                                            Time!!</strong>
                                                                        <label for="endsAt">Extend Until</label>
                                                                        <input class="form-control"
                                                                            type="datetime-local" name="extendEndsAt">
                                                                        <small>Old:{{$order->endsAt}}</small>
                                                                        <br>
                                                                        Click Extend to Continue the Process
                                                                    </center>
                                                                </p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button onclick="$('#extendOrderForm').submit();" type="button"
                                                            class="btn btn-sm btn-outline-primary">Extend</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a data-toggle="modal" data-target="#deleteOrder"
                                            style="text-decoration: none;cursor: pointer">
                                            <i data-toggle="tooltip" title="Delete Record"
                                                class="delete-hover far fa-trash-alt icons"></i>
                                        </a>
                                        <div class="modal fade" id="deleteOrder" tabindex="-1" role="dialog"
                                            aria-labelledby="deleteOrder" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="justify-content: center">
                                                        <h5 class="modal-title" id="deleteOrderTitle">
                                                            Delete Order for Customer {{$customer->name}}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert-danger"
                                                            style="padding: 10px; border-radius: 20px">
                                                            <p>
                                                                <center><strong>!! This Will Delete The Order!!</strong>
                                                                    <br>
                                                                    Click Delete to Continue the Process
                                                                </center>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button
                                                            onclick="$('#deleteOrder{{$order->ID_Order}}').submit();"
                                                            type="button"
                                                            class="btn btn-sm btn-outline-danger">Delete</button>
                                                        <form hidden action="{{ route('admin.deleteOrder', $order) }}"
                                                            id="deleteOrder{{$order->ID_Order}}"
                                                            enctype="multipart/form-data" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="line" style="margin: 0 10px">||</div>
            <h1>USER</h1>
            <div class="headerVehiclesSchedules widthHeader" style="text-align: center">
                <div class="card-body" style="background: #9D3488;border-radius:20px">
                    <a href="{{route('admin.orders', ['user' => $customer->ID_User])}}"
                        style="text-decoration: none;cursor: pointer" data-toggle="tooltip" title="View Profile">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img width="100px" src="{{ asset('storage/' . $customer->img) }}"
                                alt="user{{ $customer->name }}" class="img-fluid rounded-circle"
                                style="border: white 5px solid;">
                            <div style="margin-top: 30px">
                                <h4 style="color: white;text-transform: uppercase">
                                    <strong>{{ $customer->username }}</strong>
                                </h4>
                                <hr style="height: 10px; color: #57244d">
                                <p style="color: white; margin: 0">Phone: {{ $customer->phone }}
                                </p>
                                <p style="color: white;">Email: {{ $customer->email }}
                                </p>
                                <p class="mt-auto" style="color: white;"><strong>Customr in STASH</strong></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="headerO">

            <div class="headerVehiclesSchedules widthHeader" style="text-align: center;">
                <div>
                    <h5 style="margin: 5px 0 25px 0">
                        {{$category->name}} Category
                    </h5>
                    <div>
                        <img class="img-fluid" style="border-radius: 50%;" width="200px"
                            src="{{ asset('storage/'. $category->img) }}" alt="{{$category->name}}">
                    </div>
                </div>
            </div>
            <div style="text-align: center">
                <h4>CATEGORY</h4>
                <h4>&</h4>
                <h4>UNIT</h4>
            </div>
            <div class="line" style="margin: 0 10px">||</div>
            <div class="headerS">
                <div class="card" style="border-radius:20px;">
                    <div class="card-body">
                        <div class="float-right" style="margin-bottom: 100px">
                            <a href="{{ route('admin.orderDetailsU', ['unit'=>$unit]) }}">
                                <p class="btn-sm btn-warning">Occupied</p>
                            </a>
                        </div>
                        <h6 class="mb-0"><strong>Unit Details</strong></h6>
                        <div class="row" style="margin-top: 35px">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Unit Name</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $unit->IdName }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Dimensions</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $category->dimensions }}
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Description</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $category->description }}
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Price Per Day</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $category->pricePerDay }}
                            </div>
                            <div class="col-sm-3">
                                <h6 class="mb-2"><strong>Private Key</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <div style="display: flex;gap: 10px">
                                    <input disabled style="width: 50%" type="password" value="{{$unit->privateKey}}"
                                        class="form-control" id="privateKey{{$unit->ID_Unit}}">
                                    <div style="display: flex;gap: 5px; margin-top: 5px">
                                        <input class="form-check-input" style="margin-top: 5px" type="checkbox"
                                            onclick="showPrivateKey({{$unit->ID_Unit}})">
                                        <p class="form-check-label">Show Key</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="deliveryContainer" style="margin-top: 20px">
        <div style="text-align: center">
            <h4>Deliver History</h4>
        </div>
        <div>
            <a data-toggle="modal" data-target="#addDelivery" class="btn btn-sm btn-success float-right"
                style="border-radius: 10px; text-align: center; margin-top: 10px">Add
            </a>
            <div class="modal fade" id="addDelivery" tabindex="-1" aria-labelledby="addDelivery" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="justify-content: center">
                            <h5 class="modal-title" id="addDeliveryTitle">Add
                                Delivery Schedule
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="alert-success" style="padding: 10px; border-radius: 20px">
                                <p>
                                    Here you can change the trip and time of the delivery as well as
                                    the Vehicle and the total price of the delivery.
                                </p>
                                <form method="POST" id="addDeliveryForm" class="row g-3"
                                    action="{{ route('admin.addSchedule')}}">
                                    @csrf
                                    <input hidden type="text" value="{{$order->ID_Order}}" name="ID_Order">
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
                                        <label for="pickedUpFrom" class="form-label">Pick Up
                                            From</label>
                                        <input type="text" class="form-control" id="pickedUpFrom" name="pickedUpFrom">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="deliveredTo" class="form-label">Deliver
                                            To</label>
                                        <input type="text" class="form-control" id="deliveredTo" name="deliveredTo">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pickedUp" class="form-label">Pick Up
                                            Date</label>
                                        <input type="datetime-local" class="form-control" id="pickedUp" name="pickedUp">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="delivered" class="form-label">Deliver
                                            Date</label>
                                        <input type="datetime-local" class="form-control" id="delivered"
                                            name="delivered">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="totalPrice" class="form-label">Total
                                            Price</label>
                                        <input type="text" class="form-control" id="totalPrice" name="totalPrice">
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
                                                    onchange="$('#statusDone').toggle('slow');" name="status"
                                                    class="form-check-input" type="checkbox"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-dismiss="modal">Close</button>
                            <button onclick="$('#addDeliveryForm').submit();" type="button"
                                class="btn btn-sm btn-outline-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @if(count($schedules)>0)

            <table>
                <thead>
                    <tr>
                        <th class="column">Trip & Period</th>
                        <th class="column">Status</th>
                        <th class="column">Vehicle</th>
                        <th class="column">Total Price</th>
                        <th class="column">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                    <tr>
                        <td data-label="Trip" class="column">
                            @php
                            $date1 = new DateTime($schedule->pickedUp);
                            $date2 = new DateTime($schedule->delivered);
                            $interval = $date1->diff($date2);
                            @endphp
                            <p>
                                @if($interval->d == 0)
                                <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule }}').toggle('fast');"
                                    class="fa fa-long-arrow-right fromIcon" aria-hidden="true">
                                    <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">From:</small>
                                </i>
                                {{$schedule->pickedUpFrom}}
                                <small>{{$schedule->pickedUp}}</small>
                                <br>
                                <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                    class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                    <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">To:</small>
                                </i>
                                {{$schedule->deliveredTo}}
                                <small>{{$schedule->delivered}}</small>
                                <br>
                                <small>The same day</small>
                                @elseif($interval->m == 0 && $interval->y == 0)
                                <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule }}').toggle('fast');"
                                    class="fa fa-long-arrow-right fromIcon" aria-hidden="true">
                                    <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">From:</small>
                                </i>
                                {{$schedule->pickedUpFrom}}
                                <small>{{$date1->format('Y-m-d')}}</small>
                                <br>
                                <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                    class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                    <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">To:</small>
                                </i>
                                {{$schedule->deliveredTo}}
                                <small>{{$date2->format('Y-m-d')}}</small>
                                <br>
                                <small>{{$interval->days}} Days</small>

                                @elseif($interval->y == 0 && $interval->m > 0)
                                <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule }}').toggle('fast');"
                                    class="fa fa-long-arrow-right fromIcon" aria-hidden="true">
                                    <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">From:</small>
                                </i>
                                {{$schedule->pickedUpFrom}}
                                <small>{{$date1->format('Y-m-d')}}</small>
                                <br>
                                <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                    class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                    <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">To:</small>
                                </i>
                                {{$schedule->deliveredTo}}
                                <small>{{$date2->format('Y-m-d')}}</small>
                                <br>
                                <small>{{$interval->m}} months, {{$interval->d}} days</small>

                                @elseif($interval->y > 0)
                                <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule }}').toggle('fast');"
                                    class="fa fa-long-arrow-right fromIcon" aria-hidden="true">
                                    <small id="fromIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">From:</small>
                                </i>
                                {{$schedule->pickedUpFrom}}
                                <small>{{$date1->format('Y-m-d')}}</small>
                                <br>
                                <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                    class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                    <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                        style="display: none">To:</small>
                                </i>
                                {{$schedule->deliveredTo}}
                                <small>{{$date2->format('Y-m-d')}}</small>
                                <br>
                                <small>{{$interval->y}} years, {{$interval->m}} months, {{$interval->d}}
                                    days</small>
                                @endif
                            </p>
                        </td>
                        <td data-label="Status" class="column">
                            @if ($schedule->status)
                            <p class="btn-sm btn-secondary">Done</p>
                            @else
                            <p class="btn-sm btn-warning">On-Going</p>
                            @endif
                        </td>
                        <td data-label="Vehicle" class="column">
                            <a href="{{route('admin.delivery', ['driver' => $schedule->ID_DeliveryVehicle])}}">
                                <p>{{$schedule->name}}</p>
                            </a>

                        </td>
                        <td data-label="Total Price" class="column">
                            <p>{{$schedule->totalPrice}}</p>
                        </td>
                        <td data-label="Action" class="column">
                            <div style="display: flex; justify-content:space-around">
                                @if (!$schedule->status)
                                <a style="text-decoration: none ;cursor: pointer" data-toggle="modal"
                                    data-target="#editDelivery{{$schedule->ID_DeliverySchedule}}">
                                    <i class="use-hover fa fa-pencil-square-o icons" aria-hidden="true"></i></a>

                                <div class="modal fade" id="editDelivery{{$schedule->ID_DeliverySchedule}}"
                                    tabindex="-1" aria-labelledby="editDelivery{{$schedule->ID_DeliverySchedule}}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="justify-content: center">
                                                <h5 class="modal-title"
                                                    id="editDelivery{{$schedule->ID_DeliverySchedule}}Title">Edit
                                                    Delivery Info
                                                </h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert-success" style="padding: 10px; border-radius: 20px">
                                                    <p>
                                                        Here you can change the trip and time of the delivery as well as
                                                        the Vehicle and the total price of the delivery.
                                                    </p>
                                                    <form method="POST"
                                                        id="editDelivery{{$schedule->ID_DeliverySchedule}}Form"
                                                        class="row g-3"
                                                        action="{{ route('admin.editSchedule', ['schedule'=>$schedule])}}">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <label for="phone" class="form-label">Vehicle</label>
                                                            <div class="form-group">
                                                                <select name="ID_DeliveryVehicle" style="width: 100%"
                                                                    class="select2">
                                                                    <option value="0">Select Vehicle</option>
                                                                    @php
                                                                    $vehicleNo = 1;
                                                                    @endphp
                                                                    @foreach ($vehicles as $vehicle)
                                                                    @if ($schedule->ID_DeliveryVehicle ==
                                                                    $vehicle->ID_DeliveryVehicle)
                                                                    <option selected
                                                                        value="{{$vehicle->ID_DeliveryVehicle}}">
                                                                        {{$vehicleNo++}}- (
                                                                        {{$vehicle->plateNumber}} )
                                                                        -
                                                                        @ {{$vehicle->name}}
                                                                        - {{$vehicle->model}}
                                                                        - Price {{$vehicle->pricePerK}}
                                                                    </option>
                                                                    @else
                                                                    <option value="{{$vehicle->ID_DeliveryVehicle}}">
                                                                        {{$vehicleNo++}}- (
                                                                        {{$vehicle->plateNumber}} )
                                                                        -
                                                                        @ {{$vehicle->name}}
                                                                        - {{$vehicle->model}}
                                                                        - Price {{$vehicle->pricePerK}}
                                                                    </option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pickedUpFrom" class="form-label">Pick Up
                                                                From</label>
                                                            <input type="text" class="form-control" id="pickedUpFrom"
                                                                name="pickedUpFrom" value="{{$schedule->pickedUpFrom}}"
                                                                placeholder="{{$schedule->pickedUpFrom}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="deliveredTo" class="form-label">Deliver
                                                                To</label>
                                                            <input type="text" class="form-control" id="deliveredTo"
                                                                name="deliveredTo" value="{{$schedule->deliveredTo}}"
                                                                placeholder="{{$schedule->deliveredTo}}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="pickedUp" class="form-label">Pick Up
                                                                Date</label>
                                                            <input type="datetime-local" class="form-control"
                                                                id="pickedUp" name="pickedUp">
                                                            <small>Old:{{$schedule->pickedUp}}</small>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="delivered" class="form-label">Deliver
                                                                Date</label>
                                                            <input type="datetime-local" class="form-control"
                                                                id="delivered" name="delivered">
                                                            <small>Old:{{$schedule->delivered}}</small>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalPrice" class="form-label">Total
                                                                Price</label>
                                                            <input type="text" class="form-control" id="totalPrice"
                                                                name="totalPrice" value="{{$schedule->totalPrice}}"
                                                                placeholder="{{$schedule->totalPrice}}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button
                                                    onclick="$('#editDelivery{{$schedule->ID_DeliverySchedule}}Form').submit();"
                                                    type="button" class="btn btn-sm btn-outline-primary">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <a onclick="$('#changeScheduleStatus{{$schedule->ID_DeliverySchedule}}').submit();"
                                    data-toggle="tooltip" title="Change Status"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="refresh-hover fa fa-magic icons"></i>
                                </a>
                                <form hidden action="{{ route('admin.changeScheduleStatus', $schedule) }}"
                                    id="changeScheduleStatus{{$schedule->ID_DeliverySchedule}}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                </form>
                                <a onclick="$('#deleteSchedule{{$schedule->ID_DeliverySchedule}}').submit();"
                                    data-toggle="tooltip" title="Delete Record"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="delete-hover far fa-trash-alt icons"></i>
                                </a>
                                <form hidden action="{{ route('admin.deleteSchedule', $schedule) }}"
                                    id="deleteSchedule{{$schedule->ID_DeliverySchedule}}" enctype="multipart/form-data"
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


<script>
    function showPrivateKey(id) {
      var x = document.getElementById("privateKey"+id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
</script>
<script>
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });
</script>
@endsection