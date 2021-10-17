@extends('layouts.appUser')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">User : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.delivery') }}">Delivery</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delivery Vehicles & Schedules</li>
        </ol>
    </nav>

    <div class="container-fluid" id="deliveryContainer">
        <div class="containerV container" style="padding: 0">
            <div class="container headerVehiclesSchedules">
                <h1>Vehicles</h1>
                <a data-toggle="modal" data-target="#addVehicle" class="btn btn-sm btn-success float-right"
                    style="border-radius: 10px; text-align: center; margin-top: -30px">Add
                </a>
            </div>

            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <form action="{{route('user.delivery')}}" enctype="multipart/form-data">
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
                        <a href="{{route('user.delivery', ['driver' => $vehicle->ID_DeliveryVehicle])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%" src="{{ asset('storage/' . $vehicle->img) }}"
                                        alt="{{$vehicle->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$vehicle->name}} <span class="chat_date">Phone: {{$vehicle->phone}}</span>
                                    </h5>
                                    <p>Delivered : {{$vehicle->deliver}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="chat_list ">
                        <a href="{{route('user.delivery', ['driver' => $vehicle->ID_DeliveryVehicle])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img style="border-radius: 50%" src="{{ asset('storage/' . $vehicle->img) }}"
                                        alt="{{$vehicle->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$vehicle->name}} <span class="chat_date">Phone: {{$vehicle->phone}}</span>
                                    </h5>
                                    <p>Delivered : {{$vehicle->deliver}}</p>
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
        <div class="line">||</div>
        <div class="container containerS" style="padding-right: 0">
            <div class="container headerVehiclesSchedules">
                <h1>Schedules</h1>
                <a onclick="$('#addSchedule').toggle('slow')" class="btn btn-sm btn-success float-right"
                    style="border-radius: 10px; text-align: center; margin-top: -30px">Add
                </a>
            </div>
            <div style="display: none" id="addSchedule">
                <div class="container" style="display: flex; justify-content: center">
                    <div class="headerAddS">
                        <form method="POST" id="addScheduleForm" class="row g-3"
                            action="{{ route('user.addSchedule')}}">
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
                                        <option value="{{$order->ID_Order}}">{{$orderNo++}}- ( {{$order->IdName}} )
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
                                            @ {{$vehicle->name}}
                                            - {{$vehicle->model}}
                                            - Price {{$vehicle->pricePerK}}
                                        </option>
                                        @else
                                        <option value="{{$vehicle->ID_DeliveryVehicle}}">{{$vehicleNo++}}- (
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
                                <label for="pickedUpFrom" class="form-label">Pick Up From</label>
                                <input type="text" class="form-control" id="pickedUpFrom" name="pickedUpFrom">
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
                                            onchange="$('#statusDone').toggle('slow');" name="status"
                                            class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="pickedUp" class="form-label">Pick Up Date</label>
                                <input type="datetime-local" class="form-control" id="pickedUp" name="pickedUp">
                            </div>
                            <div class="col-md-4">
                                <label for="delivered" class="form-label">Deliver Date</label>
                                <input type="datetime-local" class="form-control" id="delivered" name="delivered">
                            </div>
                            <div class="col-md-2">
                                <label for="totalPrice" class="form-label">Total Price</label>
                                <input type="text" class="form-control" id="totalPrice" name="totalPrice">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-dark">Schedule</button>
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
                            <div class="card" style="border-radius:20px; padding: 5px">
                                <div class="card-body" style="background: #9D3488;border-radius:20px;">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img width="100px" src="{{ asset('storage/' . $vehicleDriver->img) }}"
                                            alt="user{{ $vehicleDriver->name }}" class="img-fluid rounded-circle"
                                            style="border: white 5px solid;">
                                        <div style="margin-top: 5px">
                                            <h4 style="color: white;text-transform: uppercase">
                                                <strong>{{ $vehicleDriver->name }}</strong>
                                            </h4>
                                            <p style="color: white"><strong>Driver</strong></p>
                                            <p style="color: white"><strong>Driver for {{$branch->branch}}
                                                    Branch</strong></p>
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
                                            {{ $vehicleDriver->name }}
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
                                            {{ $vehicleDriver->phone }}
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

                <div class="container">
                    <div class="headerS">
                        <h3>
                            This Is All Delivery Schedules by {{ $vehicleDriver->name}} Driver<br>
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

                <table>
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
                                    <small>{{$interval->d}} Days</small>

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
                                <a href="{{route('user.delivery', ['driver' => $schedule->ID_DeliveryVehicle])}}">
                                    <p>{{$schedule->name}}</p>
                                </a>

                            </td>
                            <td data-label="Total Price" class="column">
                                <p>{{$schedule->totalPrice}}</p>
                            </td>
                            <td data-label="Unit" class="column">
                                <p>{{$schedule->IdName}}</p>
                            </td>
                            <td data-label="Customer" class="column">
                                <a href="{{route('user.orders', ['user' => $schedule->ID_User])}}">
                                    <p>{{$schedule->username}}</p>
                                </a>
                            </td>
                            <td data-label="Action" class="column">
                                <div style="display: flex; justify-content:space-around">
                                    <a href="{{ route('user.orderDetails', ['order'=>$schedule->ID_Order]) }}"
                                        data-toggle="tooltip" title="Detials"
                                        style="text-decoration: none;cursor: pointer">
                                        <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="$('#changeScheduleStatus{{$schedule->ID_DeliverySchedule}}').submit();"
                                        data-toggle="tooltip" title="Change Status"
                                        style="text-decoration: none;cursor: pointer">
                                        <i class="refresh-hover fa fa-magic icons"></i>
                                    </a>
                                    <form hidden action="{{ route('user.changeScheduleStatus', $schedule) }}"
                                        id="changeScheduleStatus{{$schedule->ID_DeliverySchedule}}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf
                                    </form>
                                    <a onclick="$('#deleteSchedule{{$schedule->ID_DeliverySchedule}}').submit();"
                                        data-toggle="tooltip" title="Delete Record"
                                        style="text-decoration: none;cursor: pointer">
                                        <i class="delete-hover far fa-trash-alt icons"></i>
                                    </a>
                                    <form hidden action="{{ route('user.deleteSchedule', $schedule) }}"
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
</script>
@endsection