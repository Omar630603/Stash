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
                <li class="breadcrumb-item"><a href="/">Unit: {{$unit->category_name}}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('chooseCity', ['unit'=> $unit->ID_Category] ) }}">Choose
                        City</a>
                </li>
                <li class="breadcrumb-item">
                    City: {{$city}}
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('chooseLocation', ['unit'=> $unit->ID_Category, 'city' => $city] ) }}">Choose
                        Location</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="chooseCityContainer row">
        @if (count($locations)>0)
        <div class="col-md-5" style="display: flex; justify-content: center; height: 350px; width: 350;">
            <img class="img-fluid" src="{{ asset('storage/images/chooseLocation.png') }}" alt="">
        </div>
        <div class="col-md-5">
            <p>Choose a location where you want to rent {{$unit->category_name}} unit.</p>
            <form action="{{ route('showUnits') }}" method="GET" enctype="multipart/form-data">
                @csrf
                <input hidden name="unit" type="text" value="{{$unit->ID_Category}}">
                <div class="form-group" style="margin: 10px 0">
                    <select name="branch" style="width: 100%" class="select2">
                        <option value="0">Select Location</option>
                        @foreach ($locations as $location)
                        <option value="{{$location->ID_Branch}}">
                            Branch Name: {{$location->branch_name}} - Branch Address: {{$location->branch_address}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-outline-primary float-right">Next</button>
                </div>
            </form>
        </div>
        @else
        <div class="headerS" style="width: 100%;"">
            <h3>
                So sorry, this city has no branches<br>
                <small>Maybe you can try later</small>
            </h3>
        </div>
        @endif
    </div>
</div>
<script>
    $(" .select2").select2({ theme: "bootstrap-5" , selectionCssClass: "select2--small" , // For Select2 v4.1
            dropdownCssClass: "select2--small" , }); </script>
            @endsection