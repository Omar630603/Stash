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
                <li class="breadcrumb-item">Your Order : {{ $unit->category_name }} Unit</li>
                <li class="breadcrumb-item">Unit Name : {{ $unit->unit_name }}</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div>
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

                                                                <div class="container headerOrder"
                                                                    style="text-align: left">
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
                                                        <button
                                                            onclick="$('#deleteOrder{{$order->ID_Order}}').submit();"
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
        </div>
    </div>
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
    $(document).ready(function(){
        $('.checkPayment').click(function() {
            $('.checkPayment').not(this).prop('checked', false);
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
    </script>
    @endsection