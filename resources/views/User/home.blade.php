@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as a user!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.appUser')

@section('content')
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
            <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User : {{ Auth::user()->username }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm" id="info">
            <div class="col-md-4 mb-3">
                <div class="card" style="border-radius:20px; padding: 5px">
                    <div class="card-body" style="background: #9D3488;border-radius:20px;">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset('storage/' . Auth::user()->img) }}"
                                alt="user{{ Auth::user()->username }}" class="rounded-circle" width="160"
                                style="border: white 5px solid;">
                            <div style="margin-top: 40px">
                                <h4 style="color: white;text-transform: uppercase">
                                    <strong>{{ Auth::user()->username }}</strong></h4>
                                <p style="color: white"><strong>User</strong></p>
                                <p style="color: white"><strong>User of Stash</strong></p>
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
                    <div class="card" style="border-radius:20px;">
                        <div class="card-body" style="background: #fff;border-radius:20px;">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/' . Auth::user()->img) }}"
                                    alt="user{{ Auth::user()->username }}" class="rounded-circle" width="150"
                                    style="border: white 2px solid;">
                                <div class="mt-3">
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        <a href="" onclick="$('#imageInput').click(); return false;"
                                            class="btn btn-outline-dark">Change Picture</a>
                                        <form method="post" style="display: none;"
                                            action="{{ route('user.editImage') }}"
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
                                            action="{{ route('admin.defaultImage') }}" id="restore">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3" style="border-radius:20px;">
                        <form method="post" action="{{ route('user.editBioData') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="float-right" style="cursor: pointer;">
                                    <a style="text-decoration: none ;cursor: pointer"
                                        onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                        <i class="fa fa-times icons" aria-hidden="true"></i></a>
                                </div>
                                <div class="row" style="margin-top: 30px">
                                    <div class="col-sm-12">
                                        <label for="name"><strong>Full Name</strong></label>
                                        <input name="name" type="text" class="form-control"
                                            value="{{ Auth::user()->name }}" placeholder="Enter Your Full Name">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="username"><strong>User Name</strong></label>
                                        <input name="username" type="text" class="form-control"
                                            value="{{ Auth::user()->username }}" placeholder="Enter Your UserName">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="email"><strong>Email</strong></label>
                                        <input name="email" type="text" class="form-control"
                                            value="{{ Auth::user()->email }}" placeholder="Enter Your Email">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="phone"><strong>Phone</strong></label>
                                        <input name="phone" type="text" class="form-control"
                                            value="{{ Auth::user()->phone }}" placeholder="Enter Your Phone">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="address"><strong>Address</strong></label>
                                        <input name="address" type="text" class="form-control"
                                            value="{{ Auth::user()->address }}" placeholder="Enter Your Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" style="margin-top: 10px">
                                        <button class="btn btn-outline-dark" style="float: right">Change</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row gutters-sm">
                <div class="col-md-8">
                    <div class="card mb-3" style="border-radius:20px;">
                        <div class="card-body">
                            <div class="float-right" style="cursor: pointer;">
                                <a style="text-decoration: none;cursor: pointer" onclick="$('#edit_loction').toggle('fast'); $('#branch-name-text').toggle('fast'); $('#branch-name').toggle('fast');
                                $('#branch-city-text').toggle('fast'); $('#branch-city').toggle('fast');
                                $('#branch-location-text').toggle('fast'); $('#branch-location').toggle('fast');
                                $('#btn-edit-branch').toggle('fast');
                                 return false;"><i class="fa fa-pencil-square-o icons" aria-hidden="true"></i></a>
                            </div>
                            <form method="post" action="{{ route('user.editBranch', $branch) }}"
                                enctype="multipart/form-data">
                                @csrf
            @endsection
            @section('scripts')
            @parent
            @stop
        </div>
    </div>
</div>