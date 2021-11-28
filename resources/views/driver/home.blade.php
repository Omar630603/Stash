@extends('layouts.appDriver')

@section('content')
<div class="container">
    <div class="row gutters-sm" id="info">
        <div class="col-md-4 mb-3">
            <div class="card" style="border-radius: 10px; padding: 5px">
                <div class="card-body" style="background: #9D3488;border-radius: 10px;">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img width="100px" src="{{ asset('storage/' . $vehicleDriver->vehicle_img) }}"
                            alt="user{{ $vehicleDriver->vehicle_name }}" class="img-fluid rounded-circle"
                            style="border: white 5px solid;">
                        <div style="margin-top: 22px">
                            <h4 style="color: white;text-transform: uppercase">
                                <strong>{{ $vehicleDriver->vehicle_name }}</strong>
                            </h4>
                            <p style="color: white"><strong>Driver</strong></p>
                            <p style="color: white"><strong>Driver for {{$branch->branch_name}}
                                    Branch</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3" style="border-radius: 10px;">
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
                            {{ $vehicleDriver->vehicle_name }}
                        </div>
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Email</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $vehicleDriver->email }}
                        </div>
                    </div>
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
                            <h6 class="mb-2"><strong>Price / K</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $vehicleDriver->pricePerK }}
                        </div>
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Phone</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $vehicleDriver->vehicle_phone }}
                        </div>
                        <div class="col-sm-3">
                            <h6 class="mb-2"><strong>Address</strong></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $vehicleDriver->address }}
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters-sm" id="edit" style="display: none">
        <div class="col-md-4 mb-3">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body" style="background: #fff;border-radius: 10px;">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ asset('storage/' . $vehicleDriver->vehicle_img) }}"
                            alt="user{{ $vehicleDriver->vehicle_name }}" class="rounded-circle" width="150"
                            style="border: white 2px solid;">
                        <div class="mt-3">
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <a href="" onclick="$('#imageInput').click(); return false;"
                                    class="btn btn-outline-dark">Change Picture</a>
                                <form method="post" style="display: none;"
                                    action="{{ route('driver.editImageDriver', ['driver'=>$vehicleDriver]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input id="imageInput" style="border: none"
                                        onchange="document.getElementById('upload').click();" type="file" name="image">
                                    <input type="submit" name="upload" id="upload">
                                </form>
                                <a onclick="$('#restore').submit(); return false;" class="btn btn-outline-dark">Restore
                                    Default</a>
                                <form style="display: none" method="POST"
                                    action="{{ route('driver.defaultImageDriver', ['driver'=>$vehicleDriver]) }}"
                                    id="restore">
                                    @csrf
                                </form>
                                <a onclick="$('#delete').submit(); return false;" class="btn btn-outline-danger">Delete
                                    Driver</a>
                                <form style="display: none" method="POST"
                                    action="{{ route('driver.deleteDriver', ['driver'=>$vehicleDriver]) }}" id="delete">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3" style="border-radius: 10px;">
                <form method="post" action="{{ route('driver.editBioDataDriver', ['driver'=>$vehicleDriver]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="float-right" style="cursor: pointer;">
                            <a style="text-decoration: none ;cursor: pointer"
                                onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                <i class="fa fa-times icons" aria-hidden="true"></i></a>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col-sm-6">
                                <label for="name"><strong>Name</strong></label>
                                <input name="name" type="text" class="form-control"
                                    value="{{ $vehicleDriver->vehicle_name }}" placeholder="Enter The Driver Name">
                            </div>
                            <div class="col-sm-6">
                                <label for="email"><strong>Email</strong></label>
                                <input name="email" type="email" class="form-control"
                                    value="{{ $vehicleDriver->email }}" placeholder="Enter The Driver Email">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-sm-6">
                                <label for="phone"><strong>Phone</strong></label>
                                <input name="phone" type="text" class="form-control"
                                    value="{{ $vehicleDriver->vehicle_phone }}" placeholder="Enter The Driver Phone">
                            </div>
                            <div class="col-sm-6">
                                <label for="address"><strong>Address</strong></label>
                                <input name="address" type="text" class="form-control"
                                    value="{{ $vehicleDriver->address }}" placeholder="Enter The Driver Address">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-sm-4">
                                <label for="model"><strong>Model</strong></label>
                                <input name="model" type="text" class="form-control" value="{{ $vehicleDriver->model }}"
                                    placeholder="Enter The Driver Vehicle Model">
                            </div>
                            <div class="col-sm-4">
                                <label for="plateNumber"><strong>Plate Number</strong></label>
                                <input name="plateNumber" type="text" class="form-control"
                                    value="{{ $vehicleDriver->plateNumber }}"
                                    placeholder="Enter The Driver Plate Number">
                            </div>
                            <div class="col-sm-4">
                                <label for="pricePerK"><strong>Price / K</strong></label>
                                <input name="pricePerK" type="number" class="form-control"
                                    value="{{ $vehicleDriver->pricePerK }}"
                                    placeholder="Enter Price Per Kilometer For The Driver">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-sm-12" style="margin-top: 10px">
                                <button class="btn btn-outline-dark" style="float: right">Change</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection