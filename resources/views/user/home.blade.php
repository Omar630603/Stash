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
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
            <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Your Profile :
                        {{ Auth::user()->username }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile Information</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm" id="info">
            <div class="col-md-4 mb-3">
                <div class="card" style="border-radius: 10px; padding: 15px">
                    <div class="card-body" style="background: #9D3488;border-radius: 10px;">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset('storage/' . Auth::user()->user_img) }}"
                                alt="user{{ Auth::user()->username }}" class="rounded-circle" width="160"
                                style="border: white 5px solid;">
                            <div style="margin-top: 40px">
                                <h4 style="color: white;text-transform: uppercase">
                                    <strong>{{ Auth::user()->username }}</strong>
                                </h4>
                                <p style="color: white"><strong>Customer</strong></p>
                                <p style="color: white"><strong>Email: {{ Auth::user()->email }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="float-right" style="cursor: pointer;">
                            <a id="edit-profile-btn" style="text-decoration: none;cursor: pointer"
                                onclick="$('#edit').toggle('fast'); $('#info').toggle('fast'); return false;"><i
                                    class="fa fa-pencil-square-o icons" data-toggle="tooltip" title="Edit Profile"
                                    aria-hidden="true"></i></a>
                        </div>
                        <div>
                            <p>Your Profile</p>
                        </div>
                        <div class="row" style="margin-top: 35px">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Full Name</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>User Name</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->username }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Email</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Phone</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->phone }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"><strong>Address</strong></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ Auth::user()->address }}
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div>

            <div class="row gutters-sm" id="edit" style="display: none">
                <div class="col-md-4 mb-3">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body" style="background: #fff;border-radius: 10px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/' . Auth::user()->user_img) }}"
                                    alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                    style="border: white 2px solid;">
                                <div class="mt-5">
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        <a href="" onclick="$('#imageInput').click(); return false;"
                                            class="btn btn-outline-dark">Change Picture</a>
                                        <form method="post" style="display: none;"
                                            action="{{ route('customer.editImage', $customer) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input id="imageInput" style="border: none"
                                                onchange="document.getElementById('upload').click();" type="file"
                                                name="image">
                                            <input type="submit" name="upload" id="upload">
                                        </form>
                                        <a href="" onclick="$('#restore').submit(); return false;"
                                            class="btn btn-outline-dark">Restore Default</a>
                                        <form style="display: none" method="POST"
                                            action="{{ route('customer.defaultImage', $customer) }}" id="restore">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-3" style="border-radius: 10px;">
                        <form method="post" action="{{ route('customer.editBioData', $customer) }}"
                            enctype="multipart/form-data" class="mb-0">
                            @csrf
                            <div class="card-body">
                                <div class="float-right" style="cursor: pointer;">
                                    <a style="text-decoration: none ;cursor: pointer"
                                        onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                        <i class="fa fa-times icons" data-toggle="tooltip" title="Close"
                                            aria-hidden="true"></i></a>
                                </div>
                                <div class="row" style="margin-top: 30px">
                                    <div class="col-sm-6">
                                        <label for="name"><strong>Full Name</strong></label>
                                        <input name="name" type="text" class="form-control"
                                            value="{{ Auth::user()->name }}" placeholder="Enter Your Full Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="username"><strong>User Name</strong></label>
                                        <input name="username" type="text" class="form-control"
                                            value="{{ Auth::user()->username }}" placeholder="Enter Your UserName">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="email"><strong>Email</strong></label>
                                        <input name="email" type="text" class="form-control"
                                            value="{{ Auth::user()->email }}" placeholder="Enter Your Email">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="phone"><strong>Phone</strong></label>
                                        <input name="phone" type="text" class="form-control"
                                            value="{{ Auth::user()->phone }}" placeholder="Enter Your Phone">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="address"><strong>Address</strong></label>
                                        <input name="address" type="text" class="form-control"
                                            value="{{ Auth::user()->address }}" placeholder="Enter Your Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="margin-top: 10px">
                                        <button id="changecustomerProfile-btn" class="btn btn-outline-dark"
                                            style="float: right">Change</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection