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
                <li class="breadcrumb-item"><a data-toggle="tooltip" title="View Order Details" href="/">Unit:
                        {{$unit->unit_name}}</a>
                </li>
                <li class="breadcrumb-item">
                    Order is done!
                </li>
            </ol>
        </nav>
    </div>
    <div class="chooseCityContainer" style="min-height: 0; padding: 5px; margin: 5px 20px">
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                aria-valuemax="100" style="width: 100%">100%</div>
        </div>
    </div>
    <div class="chooseCityContainer" style="align-items: center">
        <center>
            <h1>Congratulations</h1>
        </center>
        <div class="row" style="align-items: center">
            <div class="col-md-6">
                <div style="display: flex; flex-direction: column; gap: 20px; justify-content: center; m">
                    <h2>Your Unit: {{$unit->unit_name}}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div style="display: flex; flex-direction: column; gap: 20px; justify-content: center;margin-top: 5pc">
                    <div
                        style="display: flex; flex-direction: column; padding: 10px; border-radius: 10px; background: #faefd3">
                        <div class="row">
                            <label class="col-sm-3" for=" from"><strong>From:</strong></label>
                            <p class="m-0 col-sm-9"> {{$order->startsFrom}}</p>
                        </div>
                        <div class="row">
                            <label class="col-sm-3" for="until"><strong>Until:</strong></label>
                            <p class="m-0 col-sm-9"> {{$order->endsAt}}</p>
                        </div>
                        <div class="row">
                            @if ($order->order_deliveries > 0)
                            <label class="col-sm-3" for="delivery"><strong>Delivery:</strong></label>
                            <p class="m-0 col-sm-9">Yes</p>
                        </div class="row">
                        <div class="row">
                            @else
                            <label class="col-sm-3" for="delivery"><strong>Delivery:</strong></label>
                            <p class="m-0 col-sm-9">No</p>
                        </div>
                        <div class="row">
                            @endif
                            <label class="col-sm-3" for="payment"><strong>Total Price:</strong></label>
                            <p class="m-0 col-sm-9">Rp.{{$order->order_totalPrice}}</p>
                        </div>
                        <div class="row">
                            <label class="col-sm-3" for="branch"><strong>Location:</strong></label>
                            <p class="m-0 col-sm-9">Branch Name: {{$branch->branch_name}} - Branch Address:
                                {{$branch->branch_address}}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('user.orderDetails', ['order'=>$order->ID_Order]) }}" data-toggle="tooltip"
                        title="View Order Details" class="btn btn-dark">Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection