@extends('layouts.appUser')

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
    <div class="container">
        <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
            <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Profile</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.orders') }}">Orders</a></li>
                <li class="breadcrumb-item">Your Order : {{ $unit->category_name }} Unit</li>
                <li class="breadcrumb-item">Unit Name : {{ $unit->unit_name }}</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="card" style="border-radius:10px;">
            <div class="card-body">
                <h6 class="mb-0"><strong>Order Details</strong></h6>
                <div class="row" style="margin-top: 5px">
                    <div class="col-sm-3">
                        @php
                        $date1 = new DateTime($order->startsFrom);
                        $date2 = new DateTime($order->endsAt);
                        $today = new DateTime(date("Y-m-d H:i:s"));
                        $interval = $date1->diff($date2);
                        $orderCheck = $date2->diff($today);
                        @endphp
                        @if ($orderCheck->invert)
                        @if ($orderCheck->days>$interval->days )
                        <div class="btn-sm btn-primary" style="border-radius: 5px">
                            @else <div class="btn-sm btn-success" style="border-radius: 5px"> @endif
                                @if ($orderCheck->days>$interval->days )
                                Will start in {{$orderCheck->days - $interval->days }} @if($orderCheck->days -
                                $interval->days <= 1) Day @else Days @endif @else Active: {{$orderCheck->days}}
                                    @if($orderCheck->days <= 1) Day @else Days @endif Left @endif<h6 class="mb-0">
                                        <strong>Period:
                                            {{ $interval->days }} @if ($interval->days <= 1) Day @else Days @endif
                                                </strong>
                                                </h6>
                            </div>
                            @else
                            <div class="btn-sm btn-danger">Expaired: Exceeded {{$orderCheck->days+1}}
                                @if($orderCheck->days <= 1) Day @else Days @endif <h6 class="mb-0">
                                    <strong>Period: {{ $interval->days }} @if ($interval->days <= 1) Day @else Days
                                            @endif </strong>
                                            </h6>
                            </div>
                            @endif

                        </div>
                        <div class="col-sm-9 text-secondary" style="display: flex; gap: 70px;">
                            <div class="mt-1">
                                <h6 style="color: #000" class="mb-0"><strong>From: </strong></h6>
                                <h6 class="mb-0">({{ $order->startsFrom }})</h6>
                            </div>
                            <div class="mt-1">
                                <h6 style="color: #000" class="mb-0"><strong>Until: </strong></h6>
                                <h6 class="mb-0">({{ $order->endsAt }})</h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Status</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary"
                            style="display: flex; gap: 5px; justify-content: space-between">
                            @if ($order->order_status == 0)
                            <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-info">With Customer
                            </p>
                            @elseif($order->order_status == 1)
                            <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-light">Waiting for
                                Payment</p>
                            @elseif($order->order_status == 2)
                            <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-warning">Delivery</p>
                            @elseif($order->order_status == 3)
                            <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-success">In Stash</p>
                            @elseif($order->order_status == 4)
                            <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-secondary">Canceled
                            </p>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Delivery</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            @if ($order->order_deliveries <= 0) <p style="width: 70%" class="btn-sm btn-secondary">
                                No Deliveries
                                </p>
                                @else
                                @php
                                $status_waiting = 0;
                                $status_On_Going = 0;
                                $status_Done = 0;
                                @endphp
                                @foreach ($schedules as $schedule)
                                @if ($schedule->ID_Order == $order->ID_Order && $schedule->schedule_status==0)
                                @php
                                $status_waiting++;
                                @endphp
                                @elseif ($schedule->ID_Order == $order->ID_Order &&
                                $schedule->schedule_status==1)
                                @php
                                $status_On_Going++;
                                @endphp
                                @elseif ($schedule->ID_Order == $order->ID_Order &&
                                $schedule->schedule_status==2)
                                @php
                                $status_Done++;
                                @endphp
                                @endif
                                @endforeach
                                <div style="width: 70%; margin-bottom: 1rem;" class="btn-sm btn-success">
                                    <h6 class="mb-0">
                                        Deliveries: {{$order->order_deliveries}}
                                        <i data-toggle="tooltip" title="Order Deliveries Details"
                                            onclick="$('#orderDeliveriesDetail{{$order->ID_Order}}').toggle('fast')"
                                            class="fas fa-arrow-down float-right"></i>
                                        <p class="mb-0" style="display: none; width: max-content"
                                            id="orderDeliveriesDetail{{$order->ID_Order}}">
                                            <small>
                                                You have {{$status_waiting}} waiting,
                                                {{$status_On_Going}} on-going, and {{$status_Done}} done deliveries.
                                            </small>
                                        </p>
                                    </h6>
                                </div>
                                @endif
                        </div>
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Order Price</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <p style="width: 70%" class="btn-sm btn-success">{{ $order->order_totalPrice }}</p>
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
                                                        Extend Order Time for Unit {{$unit->unit_name}}
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert-success"
                                                        style="padding: 10px; border-radius: 10px">
                                                        <form action="{{ route('user.extendOrder', $order) }}"
                                                            id="extendOrderForm" enctype="multipart/form-data"
                                                            method="POST">
                                                            @csrf
                                                            <p id="orderPeriodExtendDiff"></p>
                                                            <p>
                                                                <center><strong>!! This Will Extend The Order
                                                                        Time!!</strong>
                                                                    <label for="endsAt">Extend Until</label>
                                                                    <input onchange="checkExtendOrder()"
                                                                        id="extendOrderTimeNew" class="form-control"
                                                                        type="datetime-local" name="extendEndsAt">
                                                                    <input id="extendOrderTimeOld" hidden
                                                                        value="{{$order->endsAt}}">
                                                                    <input id="unitPricePerDay" hidden
                                                                        value="{{$unit->pricePerDay}}">
                                                                    <small>Current End
                                                                        Date:{{$order->endsAt}}</small>
                                                                    <br>
                                                                    Click Extend to Continue the Process
                                                                </center>
                                                            </p>

                                                            <div class="container headerOrder" style="text-align: left">
                                                                <div class="container">
                                                                    <input name="expandPrice" style="margin: 5px"
                                                                        readonly type="text" class="form-control"
                                                                        id="orderExtendPayment" value="0">
                                                                    <div>
                                                                        <label for="capacity"><strong>Extend
                                                                                Order
                                                                                Time Payment
                                                                                <small>(This will add the
                                                                                    payment details for
                                                                                    the
                                                                                    extension transaction with
                                                                                    price: <small
                                                                                        id="finallExtendPrice"></small>)</small>
                                                                            </strong></label>
                                                                    </div>
                                                                    <div>
                                                                        <div class="form-check"
                                                                            style="margin-bottom: 10px">
                                                                            <div>
                                                                                <input
                                                                                    onclick="$('#addPayment').show('fast');"
                                                                                    name="transaction"
                                                                                    class="checkPayment form-check-input"
                                                                                    type="checkbox" value="1">
                                                                                <label class="form-check-label"
                                                                                    for="flexCheckDefault">
                                                                                    Include
                                                                                    Payment
                                                                                </label>
                                                                            </div>
                                                                            <div>
                                                                                <input
                                                                                    onclick="$('#addPayment').hide('fast');"
                                                                                    checked name="transaction"
                                                                                    class="checkPayment form-check-input"
                                                                                    type="checkbox" value="0">
                                                                                <label class="form-check-label"
                                                                                    for="flexCheckDefault">
                                                                                    Exclude
                                                                                    Payment
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="container"
                                                                style="display: none;padding: 10px 15px"
                                                                id="addPayment">
                                                                <div class="headerOrder row">
                                                                    <div class="form-group" style="margin: 10px 0">
                                                                        <label>Choose a bank account then send the
                                                                            total
                                                                            amount shown above</label>

                                                                        <select name="ID_Bank" style="width: 100%"
                                                                            class="select2">
                                                                            <option value="0">Select Bank
                                                                            </option>
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
                                                                        <label>Upload the proof of the trasaction
                                                                            here</label>

                                                                        <a style="width: 100%;"
                                                                            onclick="$('#proofInputImage').click(); return false;"
                                                                            class="btn btn-sm btn-outline-dark">Add
                                                                            Payment Proof</a>
                                                                        <input id="proofInputImage"
                                                                            style="display: none;" type="file"
                                                                            name="proof">
                                                                        <input
                                                                            style="display: none; margin-top: 5px; text-align: center; width: 100%"
                                                                            disabled style="display: none"
                                                                            id="proofPhoto">
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                        <i data-toggle="tooltip" title="Delete Order"
                                            class="delete-hover far fa-trash-alt icons"></i>
                                    </a>
                                    <div class="modal fade" id="deleteOrder" tabindex="-1" role="dialog"
                                        aria-labelledby="deleteOrder" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="justify-content: center">
                                                    <h5 class="modal-title" id="deleteOrderTitle">
                                                        Delete Order for Unit {{$unit->unit_name}}
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert-danger"
                                                        style="padding: 10px; border-radius: 10px">
                                                        <p>
                                                            <center><strong>!! This Will Delete The
                                                                    Order!!</strong>
                                                                <br>
                                                                Click Delete to Continue the Process
                                                            </center>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button onclick="$('#deleteOrder{{$order->ID_Order}}').submit();"
                                                        type="button"
                                                        class="btn btn-sm btn-outline-danger">Delete</button>
                                                    <form hidden action="{{ route('user.deleteOrder', $order) }}"
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
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Order Description</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary"
                            style="display: flex; gap: 5px; justify-content: space-between">
                            <p id="orderDescriptionText" style="width: 70%" class="btn-sm btn-light">
                                {{$order->order_description}}
                            </p>
                            <form action="{{ route('user.changeOrderDescription', $order) }}"
                                id="order_description_form" enctype="multipart/form-data" method="POST"
                                style="display: none; width: 70%">
                                @csrf
                                <div class="input-group">
                                    <textarea name="order_description" class="form-control"
                                        rows="3">{{$order->order_description}}</textarea>
                                    <div class="input-group-prepend">
                                        <button type="submit" class=" btn btn-sm btn-outline-primary">Change</button>
                                    </div>
                                </div>
                            </form>
                            <a style="text-decoration: none ;cursor: pointer"
                                onclick="$('#order_description_form').toggle('fast'); $('#orderDescriptionText').toggle('fast');">
                                <i data-toggle="tooltip" title="Edit Order Description"
                                    class="use-hover fa fa-pencil-square-o icons" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3 mb-2" style="min-height:340px">
                    <h6 class="mb-0"><strong> Branch and Unit Information
                        </strong></h6>
                    {{$unit->unit_name}}
                    <div class="d-flex" style="justify-content: flex-start">
                        <div class="d-flex" style="gap: 10px; align-items: center; justify-content: space-between">
                            <img width="150px" style="border-radius: 100%" class="img-fluid"
                                src="{{ asset('storage/' . $branch->branch_img) }}" alt="">
                            <strong>
                                <p class="m-0" style="">{{$branch->branch_name}}
                                    <br>{{$branch->branch_address}}
                                </p>
                            </strong>
                        </div>
                        <div style="position: absolute; top: 160px; right: 20px; left: 50px; text-align: center;">
                            <div style="display: flex; gap: 10px; align-items: center">
                                <div style="display: flex; flex-direction: column;">
                                    <div
                                        style="background: #e53d72; padding: 10px; border-radius: 50%;box-shadow: 0 0 10px 1px rgba(41, 41, 41, 0.507);">
                                        <img width="100px" class="img-fluid"
                                            src="{{ asset('storage/' . $unit->category_img) }}" alt=""
                                            style="border-radius: 50%">
                                    </div>
                                    <h6 class="m-0 pt-1" style="box-shadow: 0 0 10px 1px rgba(41, 41, 41, 0.507);">
                                        {{$unit->category_name}}
                                    </h6>
                                </div>
                                <div style="width: 100%;background-color: #242424;padding: 5px; border-radius:10px;
                                    color: #fff">
                                    <small>@if ($unit->capacity == 100)
                                        Full: Capacity {{$unit->capacity}}%
                                        @elseif($unit->capacity >= 95)
                                        Almost: Full Capacity {{$unit->capacity}}%
                                        @elseif($unit->capacity >= 80)
                                        Moderately Full: Capacity {{$unit->capacity}}%
                                        @elseif($unit->capacity == 0)
                                        Empty
                                        @else
                                        Capacity {{$unit->capacity}}%
                                        @endif
                                    </small>
                                    <div class="progress mb-1" style="height: 5px" data-placement='left'
                                        data-toggle="tooltip" title="Capacity {{$unit->capacity}}%">
                                        @if ($unit->capacity >= 95)
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{$unit->capacity}}%" aria-valuenow="{{$unit->capacity}}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @elseif($unit->capacity >= 80)
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{$unit->capacity}}%" aria-valuenow="{{$unit->capacity}}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @else
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{$unit->capacity}}%" aria-valuenow="{{$unit->capacity}}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container"
                        style="background-color: #ffffff; box-shadow: 0 0 10px 1px rgba(41, 41, 41, 0.507); border-top-left-radius: 10px;border-top-right-radius: 10px;">
                        <div class="row" style="margin-top: 90px">
                            <div class="col-sm-3" style="margin-bottom: 5px" data-placement="left" data-toggle="tooltip"
                                title="Dimensions">
                                <h6 class="m-0"><i class="icons fas fa-boxes"></i></h6>
                            </div>
                            <div class="col-sm-9 text-secondary" style="margin-bottom: 5px">
                                {{ $unit->dimensions }}
                            </div>
                            <div class="col-sm-3" style="margin-bottom: 5px" data-placement="left" data-toggle="tooltip"
                                title="Description">
                                <h6 class="m-0"><i class="icons fas fa-info-circle"></i></h6>
                            </div>
                            <div class="col-sm-9 text-secondary" style="margin-bottom: 5px">
                                {{ $unit->category_description }}
                            </div>
                            <div class="col-sm-3" style="margin-bottom: 5px" data-placement="left" data-toggle="tooltip"
                                title="PricePerDay">
                                <h6 class="m-0"><i class="icons fas fa-tags"></i></h6>
                            </div>
                            <div class="col-sm-9 text-secondary" style="margin-bottom: 5px">
                                Rp.{{ $unit->pricePerDay }}/day
                            </div>
                            <div class="col-sm-3" style="margin-bottom: 15px" data-placement="left"
                                data-toggle="tooltip" title="Private Key">
                                <h6 class="m-0"><i class="icons fas fa-key"></i></h6>
                            </div>
                            <div class="col-sm-9 text-secondary" style="margin-bottom: 15px">
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
                    </div>
                    <div
                        style="box-shadow: 0 4px 10px 1px rgba(41, 41, 41, 0.507); padding: 5px; background: #FFBE8D; border-bottom-left-radius: 10px;border-bottom-right-radius: 10px">
                        <small>Contact the branch for changing the unit size or any other operations for this unit:
                            {{$branch->phone}}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3 mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3 mb-2" style="background-color: #F89F5B; color: #3F1652">
                                <div data-toggle="modal" data-target="#makeDelivery"
                                    class="d-flex justify-content-center" style="cursor: pointer;">
                                    <h6 class="m-0" data-toggle="tooltip"
                                        title="Click me! to add deliveries for your unit">
                                        Deliveries</h6>
                                </div>
                                <div class="modal fade" id="makeDelivery" tabindex="-1" role="dialog"
                                    aria-labelledby="makeDelivery" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="justify-content: center">
                                                <h5 class="modal-title" id="makeDeliveryTitle" style="color: #000">
                                                    Make Delivery
                                                </h5>
                                            </div>
                                            <div class="modal-body" style="color: #000">
                                                <form method="POST" id="addScheduleForm" class="row g-3"
                                                    action="{{ route('user.addSchedule')}}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="container-fluid">
                                                        <div class="headerOrder"
                                                            style="display: flex; justify-content: space-between; flex-wrap: wrap">
                                                            <div class="col-md-4">
                                                                <label for="phone" class="form-label">Vehicle
                                                                    <br><small>(Choose a vehicle that
                                                                        works in
                                                                        {{$branch->branch_name}} branch)</small></label>
                                                                <div class="form-group">
                                                                    <select onchange="sendprice($(this).val())"
                                                                        style="width: 100%" class="select2">
                                                                        <option value=" 0">Select Vehicle</option>
                                                                        @php
                                                                        $vehicleNo = 1;
                                                                        @endphp
                                                                        @foreach ($vehicles as $vehicle)
                                                                        <option
                                                                            value="{{$vehicle->ID_DeliveryVehicle}}|{{$vehicle->pricePerK}}">
                                                                            {{$vehicleNo++}}-
                                                                            @ Name: {{$vehicle->vehicle_name}}
                                                                            - Model: {{$vehicle->model}}
                                                                            - Price: {{$vehicle->pricePerK}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input hidden type="number"
                                                                        name="ID_DeliveryVehicle" id="vehicleSelected">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label style="width: 100%" for="pickedUpFrom"
                                                                    class="form-label">Pick Up From
                                                                    <div class="float-right">
                                                                        <input id="userLocation"
                                                                            onclick="$('#pickedUpFrom').val('{{Auth::user()->address}}')"
                                                                            class="form-check-input" type="checkbox">
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault"> <small>Use your
                                                                                location</small>
                                                                        </label>
                                                                    </div>
                                                                    <br><small>(Where do you want us to
                                                                        pick
                                                                        up your stuff?)</small>
                                                                </label>
                                                                <input
                                                                    onchange="$('#userLocation').prop('checked', false);"
                                                                    type="text" class="form-control" id="pickedUpFrom"
                                                                    name="pickedUpFrom">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="deliveredTo" class="form-label">Deliver To
                                                                    <br><small>(Address for the destination, This is the
                                                                        branch
                                                                        address
                                                                        ({{$branch->branch_address}}))</small></label>
                                                                <input type="text" class="form-control" id="deliveredTo"
                                                                    name="deliveredTo" value="">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="pickedUp" class="form-label">Pick Up Date
                                                                    <small>(Choose a date to
                                                                        pickup
                                                                        your
                                                                        items)</small></label>
                                                                <input onchange="chackDeliveryDates()"
                                                                    type="datetime-local" class="form-control"
                                                                    id="pickedUp" name="pickedUp">
                                                                <small id="deliveryCheck"></small>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="delivered" class="form-label">(est.)
                                                                    Delivered
                                                                    Date</label>
                                                                <input readonly type="datetime-local"
                                                                    class="form-control" id="delivered" name="delivered"
                                                                    value="2021-11-31T09:06">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="totalPrice" class="form-label">Deliver
                                                                    Price</label>
                                                                <input readonly type="number" class="form-control"
                                                                    id="totalPriceInput" name="totalPrice" min="0">
                                                            </div>
                                                            <div class="col-md-4 mt-1">
                                                                <label for="description_type"
                                                                    class="form-label">Delivery
                                                                    Type</label>
                                                                @if (!count($schedules)>0) <div>
                                                                    <input name="description_type" checked
                                                                        class="checkDescription_type form-check-input"
                                                                        type="checkbox" value="First Delivery">
                                                                    <p style="width: 100%" class="btn-sm btn-info">First
                                                                        Delivery</p>
                                                                    </label>
                                                                </div>
                                                                @else
                                                                <div>
                                                                    <input
                                                                        onclick="checkDeliveryAva({{$unit->capacity}})"
                                                                        name="description_type"
                                                                        class="checkDescription_type form-check-input"
                                                                        type="checkbox" value="Add to Unit"
                                                                        id="addToUnitOption">
                                                                    <p class="btn-sm btn-info">Add to Unit
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <input name="description_type"
                                                                        class="checkDescription_type form-check-input"
                                                                        type="checkbox" value="Transform from Unit">
                                                                    <p class="btn-sm btn-info">Transform from Unit</p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-8 mt-1">
                                                                <label for="description_note"
                                                                    class="form-label">Delivery
                                                                    Description Note</label>
                                                                <textarea type="text" class="form-control"
                                                                    id="description_note" name="description_note"
                                                                    rows="5"></textarea>
                                                            </div>
                                                            <input hidden name="status" checked class="form-check-input"
                                                                type="checkbox" value="0">
                                                            <input hidden name="ID_Order" checked
                                                                class="form-check-input" type="checkbox"
                                                                value="{{$order->ID_Order}}">
                                                            <div class="col-md-12">
                                                                <div>
                                                                    <label for="capacity"><strong>Delivery Payment
                                                                            <small>(This will add the payment details
                                                                                for
                                                                                the transaction with price: <small
                                                                                    id="price"></small>)</small>
                                                                        </strong></label>
                                                                </div>
                                                                <div>
                                                                    <div class="form-check" style="margin-bottom: 10px">
                                                                        <div>
                                                                            <input
                                                                                onclick="$('#addPaymentDelivey').show('fast');"
                                                                                name="transaction"
                                                                                class="checkPaymentDelivey form-check-input"
                                                                                type="checkbox" value="1">
                                                                            <label class="form-check-label"
                                                                                for="flexCheckDefault">
                                                                                Include
                                                                                Payment
                                                                            </label>
                                                                        </div>
                                                                        <div>
                                                                            <input
                                                                                onclick="$('#addPaymentDelivey').hide('fast');"
                                                                                checked name="transaction"
                                                                                class="checkPaymentDelivey form-check-input"
                                                                                type="checkbox" value="0">
                                                                            <label class="form-check-label"
                                                                                for="flexCheckDefault">
                                                                                Exclude
                                                                                Payment
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="addPaymentDelivey" style="display: none"
                                                                class="col-md-12">
                                                                <div class="form-group" style="margin: 10px 0">
                                                                    <select name="ID_Bank" style="width: 100%"
                                                                        class="select2">
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
                                                                    <a style="width: 100%;"
                                                                        onclick="$('#proofInputImageDelivery').click(); return false;"
                                                                        class="btn btn-sm btn-outline-dark">Add Payment
                                                                        Proof</a>
                                                                    <input id="proofInputImageDelivery"
                                                                        style="display: none;" type="file" name="proof">
                                                                    <input
                                                                        style="display: none; margin-top: 5px; text-align: center; width: 100%"
                                                                        disabled style="display: none"
                                                                        id="proofPhotoDelivery">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button onclick="$('#addScheduleForm').submit();" type="button"
                                                    class="btn btn-sm btn-outline-primary">Make</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (count($schedules)>0)
                            <div class="pl-2 pr-2" style="overflow-y:scroll; height:420px;">
                                @foreach ($schedules as $schedule)
                                <div class="card p-3 mt-2"
                                    style="background-color: #ffffff; box-shadow: 0 0 10px 1px rgba(41, 41, 41, 0.507);">
                                    <div class="justify-content-between">
                                        <div class="p-2" style="border-radius: 10px;">
                                            <div class="float-right d-flex"
                                                style="flex-direction: column; gap: 10px; align-items: center">
                                                <i data-toggle="tooltip" title="{{$schedule->schedule_description}}"
                                                    class="fas fa-comments" style="color: #F89F5B"></i>
                                                <i data-toggle="tooltip" title="Rp.{{$schedule->schedule_totalPrice}}"
                                                    class=" fas fa-money-bill-wave" style="color: #3aa537"></i>
                                                @if ($schedule->schedule_status == 0 || $schedule->schedule_status == 2)
                                                <i onclick="confirm('You can only delete waiting or done schedules. When delete, it will not be recovered. You will have to pay again in case you want to make a schedule again.')"
                                                    data-toggle="tooltip" title="Delete Delivery" class="fas fa-trash"
                                                    style="color: #a53737"
                                                    onclick="$('#deleteSchedule{{$schedule->ID_DeliverySchedule}}form').submit();"></i>
                                                <form hidden action="{{ route('user.deleteSchedule', $schedule) }}"
                                                    id="deleteSchedule{{$schedule->ID_DeliverySchedule}}form"
                                                    enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endif

                                            </div>
                                            <i class="fas fa-truck-pickup" style="color: #66377F"></i> Pick-Up :
                                            {{$schedule->pickedUpFrom}}
                                            <br><i class="fas fa-map-marked-alt" style="color: #E53D71"></i>
                                            Destination:
                                            {{$schedule->deliveredTo}}
                                            <br><i class="fas fa-truck" style="color: #3F1652"></i>
                                            {{$schedule->model}}-{{$schedule->plateNumber}}
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
                                            <div class="p-2"
                                                style="background: #0077e7; color: #f0f0f0; border-radius: 10px">
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
                                                    <small>({{$interval->d}}@if ($interval->days <= 1) Day @else Days
                                                            @endif) </small>
                                                            @elseif($interval->y == 0 && $interval->m > 0)
                                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                                class="fa fa-long-arrow-down fromIcon"
                                                                aria-hidden="true">
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
                                                                class="fa fa-long-arrow-down fromIcon"
                                                                aria-hidden="true">
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
                                            <div class="p-2"
                                                style="background: #d42b2b; color: #f0f0f0; border-radius: 10px">
                                                <h6 class="mb-0">@if ($schedule->schedule_status == 2) Done @else
                                                    Expaired
                                                    @endif: Exceeded
                                                    {{ $scheduleCheck->days+1 }} @if ($scheduleCheck->days <= 1) Day
                                                        @else Days @endif <i data-toggle="tooltip"
                                                        title="Delivery Trip Details"
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
                                                    <small>({{$interval->d}}@if ($interval->days <= 1) Day @else Days
                                                            @endif) </small>
                                                            @elseif($interval->y == 0 && $interval->m > 0)
                                                            <i onmouseover="$('#fromIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                                                class="fa fa-long-arrow-down fromIcon"
                                                                aria-hidden="true">
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
                                                                class="fa fa-long-arrow-down fromIcon"
                                                                aria-hidden="true">
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
                                @endforeach
                            </div>
                            @else
                            <div class="card p-3 mt-1" style="background-color: #f0f0f0">
                                <div class="d-flex justify-content-between" style="flex-direction: column">
                                    <h6 class="m-0">You don't have deliveries on this order yet</h6>
                                    <small>You can add new one by clicking on deliveries header</small>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3 mb-2" style="background-color: #3F1652; color: #F89F5B">
                                <div data-toggle="modal" data-target="#makeDelivery"
                                    class="d-flex justify-content-center" style="cursor: pointer;">
                                    <h6 class="m-0" data-toggle="tooltip"
                                        title="Click me! to add deliveries for your unit">
                                        Transaction</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <script>
        + function($) {
    'use strict';
    var proofInputImage = document.getElementById('proofInputImage');
    var proofPhoto = document.getElementById('proofPhoto');
    proofInputImage.onchange = function() {
        proofPhoto.style.display = '';
        proofPhoto.value = 'File Name:' + proofInputImage.files[0].name;
    }
    }(jQuery);
    + function($) {
    'use strict';
    var proofInputImageDelivery = document.getElementById('proofInputImageDelivery');
    var pDelivery = document.getElementById('proofPhotoDelivery');
    proofInputImageDelivery.onchange = function() {
        pDelivery.style.display = '';
        pDelivery.value = 'File Name:' + proofInputImageDelivery.files[0].name;
    }
    }(jQuery);
    $(document).ready(function(){
        $('.checkPayment').click(function() {
            $('.checkPayment').not(this).prop('checked', false);
        });  
        $('.checkDescription_type').click(function() {
            $('.checkDescription_type').not(this).prop('checked', false);
        });
        $('.checkPaymentDelivey').click(function() {
            $('.checkPaymentDelivey').not(this).prop('checked', false);
        });
    });
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });
    function checkExtendOrder() {
        var orderEndDate = new Date($('#extendOrderTimeOld').val()); 
        var orderNewDate = new Date($('#extendOrderTimeNew').val());
        var today = new Date();
        if (orderNewDate < orderEndDate || orderNewDate == today) {
            alert('Dates are Invalid')
            $('#extendOrderTimeNew').val(null)
        } else {
            dateDif = Math.round((orderNewDate-orderEndDate)/(1000*60*60*24));
            if (dateDif == 0) {
                alert('Dates are Invalid')
                $('#extendOrderTimeNew').val(null)
            } else {
                $('#orderPeriodExtendDiff').text('Extend Period: '+dateDif + ' Days');
                pricePerDay = document.getElementById('unitPricePerDay')
                $('#orderExtendPayment').val(pricePerDay.value * dateDif)
                finallPrice = document.getElementById('finallExtendPrice');
                finallPrice.textContent = $('#orderExtendPayment').val(); 
            }
        }
    }
    function chackDeliveryDates() {
        var pickedUp = new Date($('#pickedUp').val()); 
        var delivered = new Date($('#delivered').val());
        var today = new Date();
        var deliveryCheck = document.getElementById('deliveryCheck');
        if (pickedUp < today) {
            alert('Delivery Dates Are Invalid')
            $('#pickedUp').val(null)
            $('#delivered').val(null)
        } else {
            dateDif = 1;
            deliveryCheck.textContent =  'Delivery Period: '+dateDif+' day.';
            console.log(formatDate(pickedUp));
            console.log($('#pickedUp').val())
            $('#delivered').val(formatDate(pickedUp));
        }
    }
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        if (date.getDate()==31) {
            var days = 1
        } else {
            var days = date.getDate()+1;
        }
        var months = date.getMonth()+1;
        var year = date.getFullYear();
        daysInMonth = new Date(year, months, 0).getDate();
        if (hours < 10) {
            hours = '0'+ hours
        }
        if (minutes < 10) {
            minutes = '0'+ minutes
        }
        if (daysInMonth == 30) {
                days = 1;
                months++;
        }
        if (days < 10) {
            days = '0'+ days 
        }
        if (months < 10) {
            months = '0'+ months
        }
        if (months == 13) {
            months = 12;
        }
        if (date.getDate()==31 && months == 12) {
            months ='01';
            year++;
        }
        var strTime = hours + ':' + minutes;
        return year + "-" + months + "-" + days + "T" + strTime;
    }
    function sendprice(price) {
        var vehicleArr = price.split("|");
        $('#vehicleSelected').val(vehicleArr[0]);
        $('#totalPriceInput').val(vehicleArr[1]);
        showPrice();
    }
    function checkDeliveryAva(capacity) {
        if (capacity >= 95) {
            alert('Unit is Full, You Cannot Add To It');
            $('#addToUnitOption').prop('checked', false);
        }
    }
    function showPrivateKey(id) {
      var x = document.getElementById("privateKey"+id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    </script>
    @endsection