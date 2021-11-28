@extends('layouts.welcome')

@section('content')
<div class="container" style="margin-top: 2rem">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border: 0; border-radius: 10px">
                <div class="card-header text-lg-center mb-0" style="border-top-left-radius: 10px;
                    border-top-right-radius: 10px;font-size: 20px; background: #3f1652; color: #f89f5b">
                    {{ __('Register') }}
                </div>

                <div class="card-body pt-0">
                    <div style="text-align: center; margin:20px 0 30px 0">
                        <img class="img-fluid" width="200px" src="{{ asset('storage/images/Logo with Name H.png') }}">
                    </div>
                    <div class="container">
                        <div>
                            @if ($message = Session::get('fail'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                                style="border-radius: 10px">
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
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-radius: 10px">
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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text " id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-user-plus m-0" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="text" class="form-control" @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autocomplete="name"
                                            autofocus>
                                        <label for="name">Full Name</label>
                                    </div>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-user-circle-o" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="text" class="form-control" @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}" required
                                            autocomplete="username">
                                        <label for="username">Username</label>
                                    </div>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 10%; justify-content: center">
                                        <i class="icons fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 90%">
                                        <input type="email" class="form-control" @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email">
                                        <label for="email">Email</label>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-phone-square" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="text" class="form-control" name="phone" @error('phone') is-invalid
                                            @enderror" value="{{ old('phone') }}" required autocomplete="phone">
                                        <label for="phone">Phone</label>
                                    </div>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-location-arrow" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="text" class="form-control" name="address" @error('address')
                                            is-invalid @enderror" value="{{ old('address') }}" required
                                            autocomplete="address">
                                        <label for="address">Address</label>
                                    </div>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-key" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="password" class="form-control" @error('password') is-invalid
                                            @enderror" name="password" required autocomplete="new-password">
                                        <label for="password">Password</label>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-key" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            required autocomplete="new-password">
                                        <label for="password">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button id="register-btn" type="submit" class="btn btn-outline-primary float-right">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                You have an accont? <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Sign In') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection