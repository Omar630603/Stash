@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders for {{$branch->branch}} Branch :Total of
                {{count($orders)}} Orders</li>
        </ol>
    </nav>
    <div class="card mb-3" style="border-radius:20px;">
        <div class="card-header" style="padding: 10px; border-radius:20px;">
            <div style="display: flex; justify-content: flex-end; ">
                <div style="flex: 1; text-align: center; margin-left: 20px">
                    <h5 style="margin: 0">Orders</h5>
                </div>
                <div class="float-right" style="cursor: pointer;">
                    <a href="{{route('admin.makeOrder')}}" class="btn btn-sm btn-outline-success"
                        style="border-radius: 10px; text-align: center;">Make
                    </a>
                </div>
            </div>
        </div>
        <div class="mb-2" style="padding: 10px; margin: 0; ">
            <div class="alert-success mb-2"
                style="display: flex; justify-content: space-between; border-radius: 20px; padding: 10px; width: 100%">
                <div>
                    <p style="margin: 0"><strong>Description : </strong></p>
                </div>
                <div>
                    <p style="margin: 0"><strong>Orders : </strong>{{count($orders)}}</p>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 10px;">
            <div style="display: flex; justify-content: flex-end; gap: 20px">
                <div style="flex: 1">
                    <div class="table100">
                        @if(count($orders)>0)
                        <table>
                            <thead>
                                <tr>
                                    <th class="column">Status</th>
                                    <th class="column">Period</th>
                                    <th class="column">Has Delivery</th>
                                    <th class="column">Total Price</th>
                                    <th class="column">Unit</th>
                                    <th class="column">Customer</th>
                                    <th class="column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td data-label="Status" class="column">
                                        <p>{{$order->status}}</p>
                                    </td>
                                    <td data-label="Period" class="column">
                                        @php
                                        $date1 = new DateTime($order->startsFrom);
                                        $date2 = new DateTime($order->endsAt);
                                        $interval = $date1->diff($date2);
                                        @endphp
                                        <p>@if($interval->d == 0)
                                            <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$order->ID_Order}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$order->startsFrom}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$order->ID_Order}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$order->endsAt}}
                                            <small>The same day</small>
                                            @elseif($interval->m == 0 && $interval->y == 0)
                                            <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$order->ID_Order}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$date1->format('Y-m-d')}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$order->ID_Order}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$date2->format('Y-m-d')}}
                                            <small>{{$interval->d}} Days</small>
                                            @elseif($interval->y == 0 && $interval->m > 0)
                                            <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$order->ID_Order}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$date1->format('Y-m-d')}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$order->ID_Order}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$date2->format('Y-m-d')}}
                                            <small>{{$interval->m}} months, {{$interval->d}} days</small>
                                            @elseif($interval->y > 0)
                                            <i onmouseover="$('#fromIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-down fromIcon" aria-hidden="true">
                                                <small id="fromIcon{{$order->ID_Order}}"
                                                    style="display: none">From:</small>
                                            </i>
                                            {{$date1->format('Y-m-d')}}
                                            <br>
                                            <i onmouseover="$('#untilIcon{{$order->ID_Order}}').toggle('fast');"
                                                class="fa fa-long-arrow-up fromIcon" aria-hidden="true">
                                                <small id="untilIcon{{$order->ID_Order}}"
                                                    style="display: none">Until:</small>
                                            </i>
                                            {{$date2->format('Y-m-d')}}
                                            <small>{{$interval->y}} years, {{$interval->m}} months, {{$interval->d}}
                                                days</small>
                                            @endif</p>
                                    </td>
                                    <td data-label="Has Delivery" class="column">
                                        <p>{{$order->delivery}}</p>
                                    </td>
                                    <td data-label="Total Price" class="column">
                                        <p>{{$order->totalPrice}}</p>
                                    </td>
                                    <td data-label="Unit" class="column">
                                        <p>{{$order->IdName}}</p>
                                    </td>
                                    <td data-label="Customer" class="column">
                                        <p>{{$order->username}}</p>
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
                            <p>No Orders</p>
                        </center>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection