@extends('layouts.appAdmin')

@section('content')
@foreach ($vehicles as $vehicle)
@endforeach
{{-- {{$vehicles}}
{{$schedules}} --}}
<div class="container">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delivery Vehicles & Schedules</li>
        </ol>
    </nav>

    <div class="container" id="deliveryContainer">
        <div class="containerV container" style="padding: 0">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar" placeholder="Search">
                            <span class="input-group-addon">
                                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                            </span> </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    @foreach ($vehicles as $vehicle)
                    <div class="chat_list ">
                        {{-- active_chat --}}
                        <a href="{{route('admin.delivery', ['driver' => $vehicle->name])}}">
                            <div class="chat_people">
                                <div class="chat_img">
                                    <img src="{{ asset('storage/' . $vehicle->img) }}" alt="{{$vehicle->name}}">
                                </div>
                                <div class="chat_ib">
                                    <h5>{{$vehicle->name}} <span class="chat_date">Phone: {{$vehicle->phone}}</span>
                                    </h5>
                                    <p>Delivered : {{$vehicle->deliver}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container containerS" style="padding-right: 0">
            <div class="table100">
                @if(count($schedules)>0)
                <table>
                    <thead>
                        <tr>
                            <th class="column">Trip & Period</th>
                            <th class="column">Status</th>
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
                                    <br>
                                    <small>{{$schedule->pickedUp}}</small>
                                    <br>
                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                        class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                            style="display: none">To:</small>
                                    </i>
                                    {{$schedule->deliveredTo}}
                                    <br>
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
                                    <br>
                                    <small>{{$date1->format('Y-m-d')}}</small>
                                    <br>
                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                        class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                            style="display: none">To:</small>
                                    </i>
                                    {{$schedule->deliveredTo}}
                                    <br>
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
                                    <br>
                                    <small>{{$date1->format('Y-m-d')}}</small>
                                    <br>
                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                        class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                            style="display: none">To:</small>
                                    </i>
                                    {{$schedule->deliveredTo}}
                                    <br>
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
                                    <br>
                                    <small>{{$date1->format('Y-m-d')}}</small>
                                    <br>
                                    <i onmouseover="$('#untilIcon{{$schedule->ID_DeliverySchedule}}').toggle('fast');"
                                        class="fa fa-long-arrow-left fromIcon" aria-hidden="true">
                                        <small id="untilIcon{{$schedule->ID_DeliverySchedule}}"
                                            style="display: none">To:</small>
                                    </i>
                                    {{$schedule->deliveredTo}}
                                    <br>
                                    <small>{{$date2->format('Y-m-d')}}</small>
                                    <br>
                                    <small>{{$interval->y}} years, {{$interval->m}} months, {{$interval->d}}
                                        days</small>
                                    @endif
                                </p>
                            </td>
                            <td data-label="Status" class="column">
                                <p>{{$schedule->status}}</p>
                            </td>
                            <td data-label="Total Price" class="column">
                                <p>{{$schedule->totalPrice}}</p>
                            </td>
                            <td data-label="Unit" class="column">
                                <p>{{$schedule->IdName}}</p>
                            </td>
                            <td data-label="Customer" class="column">
                                <p>{{$schedule->username}}</p>
                            </td>
                            <td data-label="Action" class="column">
                                <p>Action</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <center>
                    <p>No Schedules</p>
                </center>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection