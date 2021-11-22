@extends('layouts.appUser')

@section('content')
<style>
    table tr td {
        vertical-align: top;
    }
</style>
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
        </ol>
    </nav>
    @if (count($categories)>0)
    <input type="number" value="{{count($categories)}}" id="categoriesAmount" hidden>
    @foreach ($categories as $category)
    @php
    $ind = 0;
    $unoccupied = 0;
    $occupied = 0;
    foreach ($units as $unit) {
    if ($unit->ID_Category == $category->ID_Category) {
    $ind++;
    if (!$unit->unit_status) {
    $unoccupied++;
    }else {
    $occupied++;
    }
    }
    }
    @endphp
    <div class="card mb-3" style="border-radius: 10px;">
        <div class="card-header"
            style="padding: 10px; background-image: url({{ asset('storage/' . $category->category_img) }}); border-radius: 10px; background-repeat: no-repeat, repeat; background-position: left; background-size: contain;">
            <div style="display: flex; justify-content: flex-end; ">
                <div style="flex: 1; text-align: center; margin-left: 20px">
                    <h5 style="margin: 0">{{$category->category_name}}</h5>
                </div>
            </div>
        </div>
        <div class="mb-2" style="padding: 10px; margin: 0; ">
            <div class="alert-success mb-2"
                style="display: flex; justify-content: space-between; border-radius: 10px; padding: 10px; width: 100%">
                <div>
                    <p style="margin: 0"><strong>Description : </strong>{{$category->category_description}}</p>
                    <p style="margin: 0"><strong>Dimensions : </strong>{{$category->dimensions}}</p>
                    <p style="margin: 0"><strong>Occupied : </strong><a href=""></a>{{$occupied}}</a> |
                        <strong>Unoccupied :
                        </strong>{{$unoccupied}}
                    </p>
                </div>
                <div>
                    <p style="margin: 0"><strong>Price / Day : </strong>{{$category->pricePerDay}}</p>
                    <p style="margin: 0"><strong>{{$category->category_name}} Units : </strong>{{$ind}}</p>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 10px;">
            @foreach ($branches as $branch)
            <p>{{$branch->branch_name}}</p>
            @endforeach
        </div>
    </div>
    @endforeach
    @else
    <div class="container" style="margin-top: 10px">
        <div class="justify-content-center">
            <center>
                <h5 class="card-title">There are no categories yet!</h5>
            </center>
        </div>
    </div>
    @endif
</div>
@endsection