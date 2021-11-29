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
                <li class="breadcrumb-item">Your Orders :
                    {{ count($orders) }} Orders
                </li>
            </ol>
        </nav>
    </div>
    <div class="container mt-3 mb-3">
        <div class="row">
            @if (count($orders)>0)
            @foreach ($orders as $order) @php $date1=new DateTime($order->startsFrom);
            $date2 = new DateTime($order->endsAt);
            $today = new DateTime(date("Y-m-d H:i:s"));
            $interval = $date1->diff($date2);
            $orderCheck = $date2->diff($today);
            @endphp
            <div class="col-md-4">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between"
                        onclick="$('#orderDetails{{$order->ID_Order}}').toggle('fast')" style="cursor: pointer"
                        data-toggle="tooltip" title="{{$order->category_name}} Unit Order Details">
                        <div class="d-flex flex-row align-items-center" style="flex-wrap: wrap">
                            @if ($orderCheck->invert)
                            @if ($orderCheck->days>$interval->days )
                            <div class="led-blue"></div>
                            @else
                            <div class="led-green"></div>
                            @endif
                            @else
                            <div class="led-red"></div>
                            @endif
                            <div class="icon"> <img class="img-fluid" width="50px"
                                    src="{{ asset('storage/' . $order->category_img) }}"
                                    alt="{{$order->category_name}}"> </div>
                            <div class="ms-2 c-details">
                                <h6 class="mb-0">{{$order->category_name}}</h6> <span>{{$order->unit_name}}</span>
                            </div>
                        </div>

                        <div class="badge"> @if ($order->order_status == 0)
                            <span class="badge-info">With Customer</span>
                            @elseif($order->order_status == 1)
                            <span class="badge-light">Waiting for Payment</span>
                            @elseif($order->order_status == 2)
                            <span class="badge-warning">Delivery</span>
                            @elseif($order->order_status == 3)
                            <span class="badge-success">In Stash</span>
                            @elseif($order->order_status == 4)
                            <span class="badge-secondary">Canceled</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3" style="display: none" id="orderDetails{{$order->ID_Order}}">
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
                            <div class="btn-sm btn-danger" style="border-radius: 5px">Expaired: Exceeded
                                {{$orderCheck->days+1}}
                                @if($orderCheck->days <= 1) Day @else Days @endif <h6 class="mb-0">
                                    <strong>Period: {{ $interval->days }} @if ($interval->days <= 1) Day @else Days
                                            @endif </strong>
                                            </h6>
                            </div>
                            @endif
                            <div class="mt-3">
                                @if ($order->madeBy)
                                <i data-toggle="tooltip" title="Order Made By Branch"
                                    class="noUse-hover float-right far fa-building"></i>
                                @else
                                <i data-toggle="tooltip" title="Order Made By You"
                                    class="refresh-hover float-right fas fa-user-tag"></i>
                                @endif
                                <h6 class="mb-0">
                                    <strong>Branch: {{$order->city}}, {{$order->branch_name}}</strong>
                                </h6>

                            </div>
                            <div class="mt-3">
                                <div class="progress">
                                    @if ($order->capacity >= 95)
                                    <div data-toggle="tooltip" title="(Full: Capacity {{$order->capacity}}%)"
                                        class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{$order->capacity}}%;" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                    @elseif($order->capacity >= 80)
                                    <div data-toggle="tooltip" title="(Moderately Full: Capacity {{$order->capacity}}%)"
                                        class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{$order->capacity}}%;" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                    @else
                                    <div data-toggle="tooltip" title="(Capacity: {{$order->capacity}}%)"
                                        class="progress-bar" role="progressbar" style="width: {{$order->capacity}}%;"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    @endif
                                </div>
                                <div class="mt-1"> <span class="text1">
                                        {{$order->capacity}}% Used <span class="text2">of 100%
                                            capacity</span></span>
                                </div>
                                <div class="mt-3">
                                    <button class="btn-gradient">Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="container">
                    <div class="headerS" style="width: 100%;">
                        <h3>
                            You haven't made any orders yet<br>
                            <small>You can add new ones from the main page</small>
                        </h3>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endsection