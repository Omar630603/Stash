@extends('layouts.appUser')

@section('content')
<div class="container">
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
<div class="container">
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
    <div style="margin: 0px 20px">
        <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
            <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
                <li class="breadcrumb-item"><a href="/">Unit: {{$category->category_name}}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('chooseCity', ['unit'=> $unit->ID_Category] ) }}">Choose
                        City</a>
                </li>
                <li class="breadcrumb-item">
                    City: {{$branch->city}}
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('chooseLocation', ['unit'=> $unit->ID_Category, 'city' => $branch->city] ) }}">Choose
                        Location</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('showUnits', ['branch'=> $branch->ID_Branch, 'unit'=> $unit->ID_Category] ) }}">
                        Location: Branch Name: {{$branch->branch_name}} - Branch Address: {{$branch->branch_address}}
                    </a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="chooseCityContainer">
        <form method="POST" id="addOrderForm" class="" action="{{ route('customer.addOrder')}}"
            enctype="multipart/form-data">
            @csrf
            <input hidden type="number" name="ID_User" value="{{Auth::user()->ID_User}}">
            <input hidden type="number" name="Idunit" value="{{$unit->ID_Unit}}">
            <input hidden type="number" name="ID_Branch" value="{{$branch->ID_Branch}}">
            <input hidden type="number" id="unitPricePerDay" value="{{$category->pricePerDay}}">
            <div class="row p-2 mb-4 alert-info" style="text-align: center">
                <div class="col-sm-4">
                    <label><strong>Description: {{ $category->category_description }}</strong>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label><strong>Dimensions:
                            {{ $category->dimensions }}</strong>
                    </label>
                </div>
                <div class="col-sm-4">
                    <label><strong>Price Per Day: {{$category->pricePerDay}}</strong>
                    </label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div style="display: flex; gap: 4px">
                        <label style="white-space: nowrap" for="Period"><strong>Period</strong>
                        </label>
                        <p style="margin: 0" id="orderPeriodDiff"></p>
                    </div>
                    <div class="form-group">
                        <label for="startsFrom">From</label>
                        <input id="orderStartDate" onchange="showPrice()" class="form-control" type="datetime-local"
                            name="startsFrom">
                        <label for="endsAt">Until</label>
                        <input id="orderEndDate" onchange="showPrice()" class="form-control" type="datetime-local"
                            name="endsAt">
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-end">
                        <label for="status" style="width: 30%"><strong>Total Payment</strong></label>
                        <input style="width: 70%" readonly type="text" class="form-control" id="orderTotalPayment"
                            value="0">
                    </div>
                </div>
                <div class="col-sm-6">
                    <input hidden name="order_status" checked class="checkStatus form-check-input" type="checkbox"
                        value="0">
                    <div>
                        <label for="capacity"><strong>Unit Capacity </strong></label>
                    </div>
                    <div>
                        <small> (est.) The items that wil be stored are filling the unit by the following percent
                        </small>
                        <input class="form-control" name="capacity" type="number" min="0" max="100"
                            style="margin-bottom: 20px">
                    </div>
                    <div>
                        <label for="order_description"><strong>Order Description
                                <small>(optional)</small> </strong></label>
                    </div>
                    <div>
                        <textarea class="form-control" name="order_description" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div>
                        @if (count($vehicles)<0) <label for="status"><strong>Delivery</strong>
                            <p class="m-0">
                                This branch don't have integrated delivery services yet
                            </p>
                            <small>
                                (You can try another branch)
                            </small>
                            </label>
                            @else
                            <label for="status"><strong>Delivery</strong>
                                <p class="m-0">
                                    Do you want to deliver your items using our delivery system?
                                </p>
                                <small>
                                    (You can add this later if you wish)
                                </small>
                            </label>
                            @endif
                    </div>
                    <div class="form-check" style="margin-bottom: 10px">
                        @if (count($vehicles)<0) <div>
                            <input readonly onclick="$('#addDeliverySchedule').show('fast');" name="delivery"
                                class="checkDeleivery form-check-input" type="checkbox" value="1">
                            <label class="form-check-label" for="flexCheckDefault"> Yes
                            </label>
                    </div>
                    <div>
                        <input readonly onclick="$('#addDeliverySchedule').hide('fast');" checked name="delivery"
                            class="checkDeleivery form-check-input" type="checkbox" value="0">
                        <label class="form-check-label" for="flexCheckDefault"> No
                        </label>
                    </div>
                    @else
                    <div>
                        <input onclick="$('#addDeliverySchedule').show('fast');" name="delivery"
                            class="checkDeleivery form-check-input" type="checkbox" value="1">
                        <label class="form-check-label" for="flexCheckDefault"> Yes
                        </label>
                    </div>
                    <div>
                        <input onclick="$('#addDeliverySchedule').hide('fast');" checked name="delivery"
                            class="checkDeleivery form-check-input" type="checkbox" value="0">
                        <label class="form-check-label" for="flexCheckDefault"> No
                        </label>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div>
                    <label for="capacity"><strong>Order Payment</strong>
                        <p class="m-0">
                            (Do you want to include the payment?
                        </p>
                        <small>(You can pay for the total
                            price later)</small>
                    </label>
                </div>
                <div>
                    <div class="form-check" style="margin-bottom: 10px">
                        <div>
                            <input onclick="$('#addPayment').show('fast');" name="transaction"
                                class="checkPayment form-check-input" type="checkbox" value="1">
                            <label class="form-check-label" for="flexCheckDefault"> Include
                                Payment <small>(Payment details for the entry transaction with price: <small
                                        id="finallPrice"></small>)
                                </small>
                            </label>
                        </div>
                        <div>
                            <input onclick="$('#addPayment').hide('fast');" checked name="transaction"
                                class="checkPayment form-check-input" type="checkbox" value="2">
                            <label class="form-check-label" for="flexCheckDefault"> Exclude
                                Payment
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="container-fluid" style="display: none" id="addDeliverySchedule">
                        <div class="headerOrder" style="display: flex; justify-content: space-evenly; flex-wrap: wrap">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Vehicle <br><small>(Choose a vehicle that works in
                                        {{$branch->branch_name}} branch)</small></label>
                                <div class="form-group">
                                    <select onchange="sendprice($(this).val())" style="width: 100%" class="select2">
                                        <option value=" 0">Select Vehicle</option>
                                        @php
                                        $vehicleNo = 1;
                                        @endphp
                                        @foreach ($vehicles as $vehicle)
                                        <option value="{{$vehicle->ID_DeliveryVehicle}}|{{$vehicle->pricePerK}}">
                                            {{$vehicleNo++}}-
                                            @ Name: {{$vehicle->vehicle_name}}
                                            - Modal: {{$vehicle->model}}
                                            - Price: {{$vehicle->pricePerK}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input hidden type="number" name="ID_DeliveryVehicle" id="vehicleSelected">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label style="width: 100%" for="pickedUpFrom" class="form-label">Pick Up From
                                    <div class="float-right">
                                        <input id="userLocation"
                                            onclick="$('#pickedUpFrom').val('{{Auth::user()->address}}')"
                                            class="form-check-input" type="checkbox">
                                        <label class="form-check-label" for="flexCheckDefault"> <small>Use your
                                                location</small>
                                        </label>
                                    </div>
                                    <br><small>(Where do you want us to
                                        pick
                                        up your stuff?)</small>
                                </label>
                                <input onchange="$('#userLocation').prop('checked', false);" type="text"
                                    class="form-control" id="pickedUpFrom" name="pickedUpFrom">
                            </div>
                            <div class="col-md-4">
                                <label for="deliveredTo" class="form-label">Deliver To <br><small>(This is the branch
                                        address)</small></label>
                                <input readonly type="text" class="form-control" id="deliveredTo" name="deliveredTo"
                                    value="{{$branch->branch_address}}">
                            </div>
                            <div class="col-md-4">
                                <label for="pickedUp" class="form-label">Pick Up Date <small>(Choose a date to pickup
                                        your
                                        items)</small></label>
                                <input onchange="chackDeliveryDates()" type="datetime-local" class="form-control"
                                    id="pickedUp" name="pickedUp">
                                <small id="deliveryCheck"></small>
                            </div>
                            <div class="col-md-4">
                                <label for="delivered" class="form-label">(est.) Delivered Date</label>
                                <input readonly type="datetime-local" class="form-control" id="delivered"
                                    name="delivered">
                            </div>
                            <div class="col-md-4">
                                <label for="totalPrice" class="form-label">Deliver Price</label>
                                <input readonly type="number" class="form-control" id="totalPriceInput"
                                    name="totalPrice" min="0">
                            </div>
                            <input hidden name="description_type" checked class="form-check-input" type="checkbox"
                                value="First Delivery">
                            <div class="col-md-12 mt-1">
                                <label for="description_note" class="form-label">Delivery Description Note</label>
                                <textarea type="text" class="form-control" id="description_note" name="description_note"
                                    rows="5"></textarea>
                            </div>
                            <input hidden name="status" checked class="form-check-input" type="checkbox" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="container-fluid" style="display: none" id="addPayment">
                        <div class="headerOrder" style="display: flex;justify-content: space-between">
                            <div class="form-group" style="margin: 5px 0; width: 45%;">
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
                            <div style="margin: 5px 0; width: 45%;">
                                <a style="width: 100%;" onclick="$('#proofInputImage').click(); return false;"
                                    class="btn btn-sm btn-outline-dark">Add Payment Proof</a>
                                <input id="proofInputImage" style="display: none;" type="file" name="proof">
                                <input style="display: none; margin-top: 5px; text-align: center; width: 100%" readonly
                                    style="display: none" id="proofPhoto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" style="width: 100%" class="btn btn-sm btn-outline-dark">Order
                        {{$unit->unit_name}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });
    $(document).ready(function(){
        $('.checkDeleivery').click(function() {
            $('.checkDeleivery').not(this).prop('checked', false);
        });
        $('.checkPayment').click(function() {
            $('.checkPayment').not(this).prop('checked', false);
        });
    });
</script>
<script>
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
            $('#delivered').val(formatDate(pickedUp));
        }
    }
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var strTime = hours + ':' + minutes;
        return date.getFullYear() + "-" + (date.getMonth()+1) + "-" + (date.getDate()+1) + "T" + strTime;
    }
    function sendprice(price) {
        var vehicleArr = price.split("|");
        $('#vehicleSelected').val(vehicleArr[0]);
        $('#totalPriceInput').val(vehicleArr[1]);
        showPrice();
    }
    function showPrice() {
        var orderStartDate = new Date($('#orderStartDate').val()); 
        var orderEndDate = new Date($('#orderEndDate').val()); 
        var today = new Date();

        if (orderStartDate < today || orderStartDate > orderEndDate) {
            alert('Order Dates Are Invalid')
            $('#orderStartDate').val(null)
            $('#orderEndDate').val(null)
        } else {
            if(today < orderEndDate )
            {
            dateDif = Math.round((orderEndDate-orderStartDate)/(1000*60*60*24));
                if (dateDif == 0) {
                    alert('Order Dates Are Invalid')
                    $('#orderStartDate').val(null)
                    $('#orderEndDate').val(null)
                } else {
                $('#orderPeriodDiff').text(': '+dateDif + ' Days');
                pricePerDay = document.getElementById('unitPricePerDay')
                $('#orderTotalPayment').val(pricePerDay.value * dateDif)
                orderTotalPayment = $('#orderTotalPayment').val();
                totalPriceInput = $('#totalPriceInput').val();
                    if (totalPriceInput != '') {
                        $('#orderTotalPayment').val(parseInt(orderTotalPayment) + parseInt(totalPriceInput));
                    }
                finallPrice = document.getElementById('finallPrice');
                finallPrice.textContent = $('#orderTotalPayment').val();
                }
            }else{
                if (orderEndDate != 'Invalid Date') {
                    alert('Date is already passed')
                    $('#orderEndDate').val(null)
                }
            }
        }
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