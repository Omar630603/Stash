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
            <li class="breadcrumb-item"><a href="javascript:void(0)">Branch Employee: {{ Auth::user()->username }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('branch.orders') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order Details in {{$branch->branch}} Branch</li>
        </ol>
    </nav>
    <div class="container-fluid" id="deliveryContainer" style="flex-wrap: wrap; flex-direction: column">
        <div class="headerO">
            <div class="headerS widthHeader" style="width: 70%">
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
                                <div class="btn-sm btn-primary">Active: {{$orderCheck->days}}
                                    @if($orderCheck->days <= 1) Day @else Days @endif Left<h6 class="mb-0">
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
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-info">With Customer</p>
                                @elseif($order->order_status == 1)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-light">Waiting for
                                    Payment</p>
                                @elseif($order->order_status == 2)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-warning">Delivery</p>
                                @elseif($order->order_status == 3)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-success">In Stash</p>
                                @elseif($order->order_status == 4)
                                <p id="staticStatusOrder" style="width: 70%" class="btn-sm btn-secondary">Canceled</p>
                                @endif
                                <form action="{{ route('branch.changeOrderStatus', $order) }}"
                                    id="changeOrderStatusForm" enctype="multipart/form-data" method="POST"
                                    style="display: none; width: 70%">
                                    @csrf
                                    <p style="margin: 0">
                                    <div style="display: flex; gap: 5px">
                                        <select class="form-select form-select-sm" name="status" id="editStatusOrder">
                                            <option class="btn-info" value="0">With Customer</option>
                                            <option class="btn-light" value="1">Waiting for Payment</option>
                                            <option class="btn-warning" value="2">Delivery</option>
                                            <option class="btn-success" value="3">In Stash</option>
                                            <option class="btn-secondary" value="4">Canceled</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Change</button>
                                        <small>Current Status:
                                            @if ($order->order_status == 0)
                                            With Customer
                                            @elseif($order->order_status == 1)
                                            Waiting for Payment
                                            @elseif($order->order_status == 2)
                                            Delivery
                                            @elseif($order->order_status == 3)
                                            In Stash
                                            @elseif($order->order_status == 4)
                                            Canceled
                                            @endif
                                        </small>
                                    </div>
                                    </p>
                                </form>
                                <a onclick="$('#staticStatusOrder').toggle('fast'); $('#changeOrderStatusForm').toggle('fast');"
                                    style="text-decoration: none;cursor: pointer">
                                    <i data-toggle="tooltip" title="Change Status"
                                        class="refresh-hover fa fa-magic icons"></i>
                                </a>
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
                                                    Waiting: {{$status_waiting}}
                                                    <br>On-Going: {{$status_On_Going}}
                                                    <br>Done: {{$status_Done}}
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
                                    <div style="text-align: right; width: 28%">
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
                                                            style="padding: 10px; border-radius: 10px">
                                                            <form action="{{ route('branch.extendOrder', $order) }}"
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
                                                                            value="{{$category->pricePerDay}}">
                                                                        <small>Current End
                                                                            Date:{{$order->endsAt}}</small>
                                                                        <br>
                                                                        Click Extend to Continue the Process
                                                                    </center>
                                                                </p>

                                                                <div class="container headerOrder"
                                                                    style="text-align: left">
                                                                    <div class="container">
                                                                        <input name="expandPrice" style="margin: 5px"
                                                                            readonly type="text" class="form-control"
                                                                            id="orderExtendPayment" value="0">
                                                                        <div>
                                                                            <label for="capacity"><strong>Extend Order
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
                                                                            <a style="width: 100%;"
                                                                                onclick="$('#proofInputImage').click(); return false;"
                                                                                class="btn btn-sm btn-outline-light">Add
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
                                                            Delete Order for Customer {{$customer->name}}
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert-danger"
                                                            style="padding: 10px; border-radius: 10px">
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
                                                        <form hidden action="{{ route('branch.deleteOrder', $order) }}"
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
                                <form action="{{ route('branch.changeOrderDescription', $order) }}"
                                    id="order_description_form" enctype="multipart/form-data" method="POST"
                                    style="display: none; width: 70%">
                                    @csrf
                                    <div class="input-group">
                                        <textarea name="order_description" class="form-control"
                                            rows="3">{{$order->order_description}}</textarea>
                                        <div class="input-group-prepend">
                                            <button type="submit"
                                                class=" btn btn-sm btn-outline-primary">Change</button>
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

            <div class="line" style="margin: -10px 10px;">||</div>
            <div class="headerVehiclesSchedules widthHeader mb-auto" style="text-align: center; width: 30%">
                <h1 style="">USER</h1>
                <div class="card-body" style="background: #9D3488;border-radius:10px">
                    <a href="{{route('branch.orders', ['user' => $customer->ID_User])}}"
                        style="text-decoration: none;cursor: pointer" data-toggle="tooltip" title="View Profile">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img width="100px" src="{{ asset('storage/' . $customer->user_img) }}"
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
            <div class="headerVehiclesSchedules widthHeader mb-auto" style="text-align: center; width: 30%;">
                <div>
                    <h5 style="margin: 5px 0 5px 0">
                        {{$category->category_name}} Category
                    </h5>
                    <div>
                        <img class="img-fluid" style="border-radius: 50%;" width="200px"
                            src="{{ asset('storage/'. $category->category_img) }}" alt="{{$category->name}}">
                    </div>
                </div>
            </div>
            <div class="line" style="margin: -10px 10px; transform: rotate(180deg);">||</div>
            <div class="headerS widthHeader" style="width: 70%">
                <div class="card" style="border-radius:10px;">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <a href=" {{ route('branch.orderDetailsU', ['unit'=>$unit]) }}">
                            <p class="btn-sm btn-warning mb-0" style="height: 35px">Occupied</p>
                        </a>
                        <h6 class="mb-0"><strong>Unit Details</strong></h6>
                        <div class="btn-sm btn-dark" style="background-color: #66377f; text-align: left">
                            (@if ($unit->capacity == 100)
                            Full: Capacity {{$unit->capacity}}%)
                            @elseif($unit->capacity >= 95)
                            Almost: Full Capacity {{$unit->capacity}}%)
                            @elseif($unit->capacity >= 80)
                            Moderately Full: Capacity {{$unit->capacity}}%)
                            @else
                            Normal: Capacity {{$unit->capacity}}%)
                            @endif
                            <div class="progress mb-1" style="height: 5px" data-placement='left' data-toggle="tooltip"
                                title="Capacity {{$unit->capacity}}%">
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
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Unit Name</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $unit->unit_name }}
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
                                {{ $category->category_description }}
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
                            <div class="col-sm-9 text-secondary"
                                style="display: flex; gap: 5px; justify-content: space-between; align-content: stretch">
                                <div style="display: flex;gap: 10px">
                                    <input disabled style="width: 50%" type="password" value="{{$unit->privateKey}}"
                                        class="form-control" id="privateKey{{$unit->ID_Unit}}">
                                    <div style="display: flex;gap: 5px; margin-top: 5px">
                                        <input class="form-check-input" style="margin-top: 5px" type="checkbox"
                                            onclick="showPrivateKey({{$unit->ID_Unit}})">
                                        <p class="form-check-label">Show Key</p>

                                    </div>
                                </div>
                                <a data-toggle="modal" data-target="#changePrivateKeyUnit{{$unit->ID_Unit}}"
                                    data-placement="top" style="text-decoration: none;cursor: pointer;"><i
                                        data-toggle="tooltip" title="Change Private Key"
                                        class="refresh-hover fas fa-sync icons"></i></a>
                                <div class="modal fade" id="changePrivateKeyUnit{{$unit->ID_Unit}}" tabindex="-1"
                                    role="dialog" aria-labelledby="changePrivateKeyUnit{{$unit->ID_Unit}}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="justify-content: center">
                                                <h5 class="modal-title"
                                                    id="changePrivateKeyUnit{{$unit->ID_Unit}}Title">
                                                    Change Private Key
                                                    {{$unit->unit_name}} Unit
                                                </h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert-danger" style="padding: 10px; border-radius: 10px">
                                                    <p>
                                                        <center><strong>!! This Unit is Occupied !!</strong>
                                                        </center><br>
                                                        Click Change to Continue the Process
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button
                                                    onclick="$('#changePrivateKeyUnitUnitForm{{$unit->ID_Unit}}').submit();"
                                                    type="button" class="btn btn-sm btn-outline-primary">Change</button>
                                                <form method="post"
                                                    action="{{route('branch.changePrivateKeyUnit', $unit)}}"
                                                    enctype="multipart/form-data"
                                                    id="changePrivateKeyUnitUnitForm{{$unit->ID_Unit}}">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row" style="gap: 10px; justify-content: space-between;text-transform: capitalize;">
                            <div id="CapacityChangeBigDiv" class="col-sm-5 text-secondary">
                                <a onclick="$('#unitCapacityDiv').toggle('fast');"
                                    style="background-color: #66377f;width: 100%" class="btn btn-sm btn-dark">
                                    Change Unit Capacity</a>
                                <div id="unitCapacityDiv" class="headerS mt-1" id="changeUnitCapacity"
                                    style="display: none; color: #fff">
                                    <form action="{{ route('branch.changeUnitCapacity', $unit) }}"
                                        id="changeUnitCapacityForm" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div>
                                            <label for="capacity">Capacity: (<small>Changing the capacity of the
                                                    unit is
                                                    a very serious
                                                    action, make sure
                                                    you're making the right option.</small>)</label>
                                            <input class="form-control mb-0" name="capacity" type="number"
                                                value="{{$unit->capacity}}" min="0" max="100" id="unitCapacityNewInput"
                                                style="margin-bottom: 20px">
                                            <small style="display: none" id="unitCapacityStatus">Current Capacity:
                                                {{$unit->capacity}}% ->
                                                <small id="unitCapacityNumber"></small>
                                            </small>
                                            <button class="btn btn-sm btn-light mt-2"
                                                style="width: 100%">Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-5 text-secondary" id="UnitChangeBigDiv">
                                <form action="{{ route('branch.changeOrderUnit',[$unit, $order]) }}"
                                    enctype="multipart/form-data" method="POST">
                                    <a onclick="$('#changeOrderUnitMovingDiv').toggle('fast');"
                                        style="background-color: #66377f;width: 100%" class="btn btn-sm btn-dark">Change
                                        Order Unit</a>
                                    <div id="changeOrderUnitMovingDiv" style="display: none">
                                        <div class="headerS mt-1" style="color: #fff">
                                            <div style="display: flex; justify-content: space-between;">
                                                <label for="capacity">Unit: (<small>Changing the unit of the
                                                        order is
                                                        a very serious
                                                        action, make sure
                                                        you're making the right option.</small>)

                                                </label>
                                                <a data-toggle="tooltip" title="View Change Log"
                                                    onclick="$('.changeDetails').toggle('fast')"
                                                    style="height: max-content" class="btn btn-sm btn-light mb-1">
                                                    <i class="refresh-hover fas fa-info"
                                                        style="color: #000 !important;"></i>
                                                </a>
                                            </div>
                                            <div class="headerVehiclesSchedules" id="mainChangeUnitDiv"
                                                style="display: none; color: #000;text-align: left">
                                                <small id="newOrderTotalPrice"></small>
                                                <br>
                                                <small id="changeUnitPayment"></small>
                                                <br>
                                                <small id="changeUnitMoveable"></small>

                                            </div>
                                            <div class="container-fluid p-2 mb-1 changeDetails"
                                                style="background-color: #E53D71; display: none; border-radius: 10px; color: #fff;">
                                                @php
                                                $startsFrom = new DateTime($order->startsFrom);
                                                $endsAt = new DateTime($order->endsAt);
                                                $today = new DateTime(date("Y-m-d H:i:s"));
                                                $interval = $endsAt->diff($today);
                                                $oldPrice = $interval->days * $category->pricePerDay;
                                                @endphp
                                                <div class="changeUnitLog" style="display: none">
                                                    <small>Current Unit: {{$category->category_name}}</small><br>
                                                    <small>Current Unit Renting Price = {{$oldPrice}}<br>
                                                        (Order Period = {{$interval->days}} Days) * (Unit/Day =
                                                        {{$category->pricePerDay}})
                                                    </small>
                                                    <br><small id="compositionPriceDaysLeft"></small>
                                                    <br><small id="compositionPriceOld"></small>
                                                    <br><small id="compositionPriceNew"></small>
                                                    <br><small id="compositionPrice"></small>
                                                    <br><small id="compositionDesc"></small>
                                                    <br><small id="compositionMoveable"></small>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                @foreach ($categories as $categoryAvaliable)
                                                @php
                                                $ind = 0;
                                                $unitName= '';
                                                $idUnit = 0;
                                                @endphp
                                                <div class="container-fluid">
                                                    @foreach ($units as $unitAvaliable)
                                                    @if ($unitAvaliable->ID_Category == $categoryAvaliable->ID_Category)
                                                    @php
                                                    $ind++;
                                                    $unitName = $unitAvaliable->unit_name;
                                                    $idUnit = $unitAvaliable->ID_Unit;
                                                    @endphp
                                                    @endif
                                                    @endforeach
                                                    @if ($ind <= 0) <input disabled name="Idunit"
                                                        class="checkCategory form-check-input" type="checkbox"
                                                        value="{{$idUnit}}">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{$categoryAvaliable->category_name}}
                                                            (There is {{$ind}} available units)
                                                            <br>
                                                            <small>This Category is has no units </small>
                                                        </label>
                                                        @else
                                                        <input
                                                            onchange="showCompositionPrice({{$category->pricePerDay}}, {{$order->order_totalPrice}}, {{$unit->capacity}})"
                                                            id="unitPrice" name="Idunit"
                                                            class="checkCategory form-check-input" type="checkbox"
                                                            value="{{$idUnit}}">
                                                        <input hidden id="changeUnitPricePerDay{{$idUnit}}"
                                                            value="{{$categoryAvaliable->pricePerDay}}">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            {{$categoryAvaliable->category_name}}
                                                            (There is {{$ind}} available units)
                                                            <br>
                                                            <small>Unit {{$unitName}} is ready to use <br>
                                                                Price/Day: {{$categoryAvaliable->pricePerDay}}
                                                            </small>
                                                        </label>

                                                        @endif
                                                </div>
                                                @endforeach
                                            </div>

                                            @csrf
                                            <div class="container" style="text-align: left">
                                                <input hidden name="changePrice" style="margin: 5px" readonly
                                                    type="text" class="form-control" id="unitChangePayment" value="0">
                                                <input hidden type="number" value="0" id="change_status"
                                                    name="change_status">
                                                <input hidden type="number" value="0" id="new_ID_Unit"
                                                    name="new_ID_Unit">
                                                <div class="mt-3">
                                                    <label for="changeUnit"><strong>Change Unit for This Order
                                                            <small>(This will add the
                                                                payment details for
                                                                the
                                                                new change and add a transaction with
                                                                price: <small id="finallChangePrice"></small>)</small>
                                                        </strong></label>
                                                </div>
                                                <div>
                                                    <div class="form-check" style="margin-bottom: 10px">
                                                        <div>
                                                            <input onclick="$('#addPaymentChange').show('fast');"
                                                                name="transaction"
                                                                class="checkPaymentChange form-check-input"
                                                                type="checkbox" value="1">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Include
                                                                Payment
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <input onclick="$('#addPaymentChange').hide('fast');"
                                                                checked name="transaction"
                                                                class="checkPaymentChange form-check-input"
                                                                type="checkbox" value="0">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Exclude
                                                                Payment
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="display: none;padding: 10px 15px"
                                            id="addPaymentChange">
                                            <div class="headerOrder row">
                                                <div class="form-group" style="margin: 10px 0">
                                                    <select name="ID_Bank" style="width: 100%" class="select2">
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
                                                    <a style="width: 100%;"
                                                        onclick="$('#proofInputImageChangeUnit').click(); return false;"
                                                        class="btn btn-sm btn-outline-light">Add
                                                        Payment Proof</a>
                                                    <input id="proofInputImageChangeUnit" style="display: none;"
                                                        type="file" name="proof">
                                                    <input
                                                        style="display: none; margin-top: 5px; text-align: center; width: 100%"
                                                        disabled style="display: none" id="proofPhotoChangeUnit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="headerS">
                                            <button class="btn btn-sm btn-light" style="width: 100%">Change</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="deliveryContainer" style="margin-top: 20px">
        <div style="text-align: center">
            <h4>Transactions History</h4>
        </div>
        <div class="container-fluid">
            @if(count($transactions)>0)
            <div class="tableWrapper">
                <table id="transactionTable">
                    <thead>
                        <tr>
                            <th class="column">Bank</th>
                            <th class="column">Description</th>
                            <th class="column">Amount</th>
                            <th class="column">Status</th>
                            <th class="column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td data-label="Bank" class="column">
                                @if ($transaction->ID_Bank == Null)
                                <p class="btn-sm btn-light">No bank (not paid yet)</p>
                                @else
                                @foreach ($banks as $bank)
                                @if ($transaction->ID_Bank == $bank->ID_Bank)
                                <p class="btn-sm btn-light">{{$bank->bank_name}} - {{$bank->accountNo}}</p>
                                @endif
                                @endforeach
                                @endif
                            </td>
                            <td data-label="Description" class="column">
                                <p class="btn-sm btn-light">{{$transaction->transactions_description}}</p>
                            </td>
                            <td data-label="Amount" class="column">
                                <p class="btn-sm btn-light">{{$transaction->transactions_totalPrice}}</p>
                            </td>
                            <td data-label="Status" class="column">
                                @if ($transaction->transactions_status == 0 )
                                <p class="btn-sm btn-warning">Unpaid</p>
                                @elseif ($transaction->transactions_status == 1 )
                                <p class="btn-sm btn-success">Paid</p>
                                @elseif ($transaction->transactions_status == 2 )
                                <p class="btn-sm btn-danger">Disapproved</p>
                                @elseif ($transaction->transactions_status == 3 )
                                <p class="btn-sm btn-success">Approved</p>
                                @endif
                            </td>
                            <td style="text-align: right" data-label="Action" class="column">
                                @if ($transaction->transactions_status == 0)
                                <a data-toggle="tooltip" title="Pay" style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-receipt icons" aria-hidden="true"></i>
                                </a>
                                @elseif ($transaction->transactions_status == 1)
                                <a target="_blank" rel="noopener noreferrer"
                                    href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                    title="View Proof" style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                </a>
                                <a data-toggle="tooltip" title="Approve Transaction"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-check-circle icons"></i>
                                </a>
                                <a data-toggle="tooltip" title="Disapprove Transaction"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="delete-hover fas fa-ban icons"></i>
                                </a>
                                @elseif ($transaction->transactions_status == 2)
                                <a target="_blank" rel="noopener noreferrer"
                                    href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                    title="View Proof" style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                </a>
                                <a data-toggle="tooltip" title="Approve Transaction"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-check-circle icons"></i>
                                </a>
                                @elseif ($transaction->transactions_status == 3)
                                <a target="_blank" rel="noopener noreferrer"
                                    href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                    title="View Proof" style="text-decoration: none;cursor: pointer">
                                    <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                </a>
                                <a data-toggle="tooltip" title="Disapprove Transaction"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="delete-hover fas fa-ban icons"></i>
                                </a>
                                @endif
                                <a data-toggle="tooltip" title="Delete Transaction"
                                    style="text-decoration: none;cursor: pointer">
                                    <i class="delete-hover far fa-trash-alt icons"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="headerS">
                <h3>
                    No Transactions Found<br>
                    <small>This order has no transactions</small>
                </h3>
            </div>

            @endif
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
                            <div class="alert-success" style="padding: 10px; border-radius: 10px">
                                <p>
                                    Here you can change the trip and time of the delivery as well as
                                    the Vehicle and the total price of the delivery.
                                </p>
                                <form method="POST" id="addDeliveryForm" class="row g-3"
                                    action="{{ route('branch.addSchedule')}}">
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
            <div class="tableWrapper">
                <table id="schedulesTable">
                    <thead>
                        <tr>
                            <th class="column">Trip & Period</th>
                            <th class="column">Status</th>
                            <th class="column">Vehicle</th>
                            <th class="column">Total Price</th>
                            <th class="column">Description</th>
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
                            <td data-label="Description" class="column">
                                <p class="btn-sm btn-light">{{$schedule->schedule_description}}</p>
                            </td>
                            <td style="text-align: right" data-label="Action" class="column">
                                <div style="display: flex; justify-content:space-around">
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
                                                    <div class="alert-success"
                                                        style="padding: 10px; border-radius: 10px">
                                                        <p>
                                                            Here you can change the trip and time of the delivery as
                                                            well as
                                                            the Vehicle and the total price of the delivery.
                                                        </p>
                                                        <form method="POST"
                                                            id="editDelivery{{$schedule->ID_DeliverySchedule}}Form"
                                                            class="row g-3"
                                                            action="{{ route('branch.editSchedule', ['schedule'=>$schedule])}}">
                                                            @csrf
                                                            <div class="col-md-12">
                                                                <label for="phone" class="form-label">Vehicle</label>
                                                                <div class="form-group">
                                                                    <select name="ID_DeliveryVehicle"
                                                                        style="width: 100%" class="select2">
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
                                                                        <option
                                                                            value="{{$vehicle->ID_DeliveryVehicle}}">
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
                                                                <input type="text" class="form-control"
                                                                    id="pickedUpFrom" name="pickedUpFrom"
                                                                    value="{{$schedule->pickedUpFrom}}"
                                                                    placeholder="{{$schedule->pickedUpFrom}}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="deliveredTo" class="form-label">Deliver
                                                                    To</label>
                                                                <input type="text" class="form-control" id="deliveredTo"
                                                                    name="deliveredTo"
                                                                    value="{{$schedule->deliveredTo}}"
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
                                                        type="button"
                                                        class="btn btn-sm btn-outline-primary">Change</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<script>
    function showPrivateKey(id) {
      var x = document.getElementById("privateKey"+id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
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
    function showCompositionPrice(oldUnitPrice, orderTotalPrice, unitCapacity) {
        unitVal = $("input:checkbox[id=unitPrice]:checked");
        pricePerDay = document.getElementById('changeUnitPricePerDay'+unitVal.val()).value;
        var orderEndDate = new Date($('#extendOrderTimeOld').val()); 
        var today = new Date();
        if (orderEndDate < today) {
            unitVal.prop('checked', false);
            alert('Extend the period first, the order is expired')
        }else{
            dateDif = Math.round((orderEndDate-today)/(1000*60*60*24));
            if (dateDif == 0) {
                dateDif = 1;
            }
            var compositionPriceDaysLeft = document.getElementById('compositionPriceDaysLeft');
            var compositionPriceOld = document.getElementById('compositionPriceOld');
            var compositionPriceNew = document.getElementById('compositionPriceNew');
            var compositionPrice = document.getElementById('compositionPrice');
            var compositionDesc = document.getElementById('compositionDesc');
            var compositionMoveable = document.getElementById('compositionMoveable');
            var newOrderTotalPrice = document.getElementById('newOrderTotalPrice');
            var changeUnitPayment = document.getElementById('changeUnitPayment');
            var changeUnitMoveable = document.getElementById('changeUnitMoveable');
            finallNewPrice = parseInt(pricePerDay) * dateDif;
            finallOldPrice = oldUnitPrice * dateDif;
            offTotal = orderTotalPrice - finallOldPrice;
            onTotal = offTotal + finallNewPrice;
            $('#mainChangeUnitDiv').show('fast');
            $('.changeUnitLog').show('fast');
            $('#CapacityChangeBigDiv').attr('class', 'col-sm-12 text-secondary');
            $('#UnitChangeBigDiv').attr('class', 'col-sm-12 text-secondary');
            compositionPriceDaysLeft.textContent =  "There Are "+ dateDif +" Remaining Days.";
            compositionPriceOld.textContent =  "Current Unit Price = Unit/Day Price->"+oldUnitPrice+" * Remaining Days->"+dateDif+ " = ("+finallOldPrice+")";
            compositionPriceNew.textContent =  "New Unit Price = Unit/Day Price->"+pricePerDay+" * Remaining Days->"+dateDif+ " = ("+finallNewPrice+")";
            compositionPrice.textContent = "Order Total Price = ("+orderTotalPrice+") - Current Unit Price ("+finallOldPrice+") = Order Total Price ("+offTotal+") + New Unit Price = ("+finallNewPrice+") = "+onTotal;
            finallChangePrice = document.getElementById('finallChangePrice');
            
            if (orderTotalPrice == onTotal) {
                $('#unitChangePayment').val(0);
                $('#change_status').val(0);
                $('#new_ID_Unit').val(0);
                newOrderTotalPrice.textContent =  "No Change In the order price ("+ onTotal +")";
                compositionDesc.textContent =  "Meaning there are no changes will be made becasue it is the same category.";
                changeUnitPayment.textContent =  "No Need To Change The Unit";
                compositionMoveable.textContent = "Unit Is Not Changeable, Try Another Unit: Same Unit";
                changeUnitMoveable.textContent = "Unit Is Not Changeable: Same Unit";
                finallChangePrice.textContent = '0: No Changes'; 
            }else{
            payment = finallNewPrice - finallOldPrice;
                if (payment<0) {
                    $('#unitChangePayment').val(0);
                    $('#change_status').val(1);
                    $('#new_ID_Unit').val(unitVal.val());
                    newOrderTotalPrice.textContent = "Order total price change negatively (New:"+ onTotal +"/Old:"+orderTotalPrice+")";
                    compositionDesc.textContent =  "Meaning the customer can change to a chaper Unit but the customer should not pay because it is a step down.";
                    changeUnitPayment.textContent =  "Unit Is Not Refundable";
                    compositionMoveable.textContent = "Unit Is Changeable: Unit Is Not Refundable";
                    changeUnitMoveable.textContent = "Unit Is Changeable: no composition";
                    finallChangePrice.textContent = "-"+payment+": Change Expanse Down"; 
                }else{
                    $('#unitChangePayment').val(payment);
                    $('#change_status').val(2);
                    $('#new_ID_Unit').val(unitVal.val());
                    newOrderTotalPrice.textContent =  "New Order Total Price ("+ onTotal +")";
                    compositionDesc.textContent =  "Meaning The Current Unit Price Will Be Deleted From The Order Total Price And Add The New Price to it. The Payment Will Be the Difference Between the old Price and the new price.";
                    changeUnitPayment.textContent =  "The Customer Has To Pay: ("+payment+")";
                    compositionMoveable.textContent = "Unit Is Changeable, Click Next To Proceed";
                    changeUnitMoveable.textContent = "Unit Is Changeable";
                    finallChangePrice.textContent = ""+payment+": Change Expanse Up"; 
                }
            }
        }
    }
    $(document).ready(function(){
        $('.checkPayment').click(function() {
            $('.checkPayment').not(this).prop('checked', false);
        });
        $('.checkPaymentChange').click(function() {
            $('.checkPaymentChange').not(this).prop('checked', false);
        });
        $('.checkCategory').click(function() {
            $('.checkCategory').not(this).prop('checked', false);
        });
        $('#transactionTable').DataTable( {
            "pagingType": "full_numbers"
        });
        $('#schedulesTable').DataTable( {
            "pagingType": "full_numbers"
        });
        var unitCapacityNewInput = document.getElementById('unitCapacityNewInput');
        var unitCapacityNumber = document.getElementById('unitCapacityNumber');
        var color = '';
        var text = '';
        unitCapacityNewInput.onchange = function() {
            var left = 100 - unitCapacityNewInput.value;
            $('#unitCapacityStatus').show('fast');
            if (unitCapacityNewInput.value >= 95) {
                color = "#ff4242";
                text = "New Capacity: " + unitCapacityNewInput.value + "% (Almost Full : Left Capacity = "+left+"%)";
                if (unitCapacityNewInput.value == 100) {
                    color = "#ff2424";
                    text = "New Capacity: " + unitCapacityNewInput.value + " (Full : Left Capacity = "+left+"%)";
                }
            } else if(unitCapacityNewInput.value >= 80) {
                color = "#e0d238";
                text = "New Capacity: " + unitCapacityNewInput.value + " (Moderately Full : Left Capacity = "+left+"%)";
            }else{
                color = "#38b9e0";
                text = "New Capacity: " + unitCapacityNewInput.value + " (Left Capacity = "+left+"%)";
            }
            unitCapacityNumber.textContent =  text;
            unitCapacityNumber.style.color = color;

        }
        
        
    });
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });
    + function($) {
    'use strict';
    var proofInputImage = document.getElementById('proofInputImage');
    var proofPhoto = document.getElementById('proofPhoto');
    proofInputImage.onchange = function() {
        proofPhoto.style.display = '';
        proofPhoto.value = 'File Name:' + proofInputImage.files[0].name;
    }
    var proofInputImageChangeUnit = document.getElementById('proofInputImageChangeUnit');
    var proofPhotoChangeUnit = document.getElementById('proofPhotoChangeUnit');
    proofInputImageChangeUnit.onchange = function() {
        proofPhotoChangeUnit.style.display = '';
        proofPhotoChangeUnit.value = 'File Name:' + proofInputImageChangeUnit.files[0].name;
    }
    }(jQuery);
    
</script>
@endsection