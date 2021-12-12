@extends('layouts.welcome')

@section('content')

<div class="container" style="margin-top: 2rem">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border: 0; border-radius: 10px">
                <div class="card-header text-lg-center mb-0" style="border-top-left-radius: 10px;
                    border-top-right-radius: 10px;font-size: 20px; background: #3f1652; color: #f89f5b">
                    {{ __('Login') }}
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
                                    <p style="margin: 0">{{ $show = substr($message, 1); }}</p>
                                </strong>
                            </div>
                            @elseif ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style=" text-align: center; border-radius: 10px">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>
                                    <p style="margin: 0">{{ $show = substr($message, 1); }}</p>
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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if ($message)
                        <input hidden name="unit" value="{{$message[0]}}">
                        @else
                        @endif
                        <div class="form-group row" style="justify-content: center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text " id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-user-plus m-0" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input id="login" type="text"
                                            class="form-control @error('WrongCredentials') is-invalid @enderror"
                                            name=" login" value="{{ old('username') ?: old('email') }}" required
                                            autofocus>
                                        <label for="name">Username or Email</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="justify-content: center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"
                                        style="width: 20%; justify-content: center">
                                        <i class="icons fa fa-key" aria-hidden="true"></i>
                                    </span>
                                    <div class="form-floating" style="width: 80%">
                                        <input id="password" type="password"
                                            class="form-control @error('WrongCredentials') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                @error('WrongCredentials')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button id="login-btn" type="submit" class="btn btn-outline-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                You don't have an accont? <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Sign Up') }}
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