@extends('layouts.appBranch')

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
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
            <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Branch Employee :
                        {{ Auth::user()->username }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Branch Employee Profile & Branch Information</li>
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
                                <p style="color: white"><strong>Branch</strong></p>
                                <p style="color: white"><strong>Branch Employee of {{$branch->branch_name}}
                                        Branch</strong>
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
                            <p>{{ $branch->branch_name }} Branch Employee's Profile</p>
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
                                <div class="mt-3">
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        <a href="" onclick="$('#imageInput').click(); return false;"
                                            class="btn btn-outline-dark">Change Picture</a>
                                        <form method="post" style="display: none;"
                                            action="{{ route('branch.editImage', $branchEmployee) }}"
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
                                            action="{{ route('branch.defaultImage', $branchEmployee) }}" id="restore">
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
                        <form method="post" action="{{ route('branch.editBioData', $branchEmployee) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="float-right" style="cursor: pointer;">
                                    <a style="text-decoration: none ;cursor: pointer"
                                        onclick="$('#info').toggle('fast'); $('#edit').toggle('fast'); return false;">
                                        <i class="fa fa-times icons" data-toggle="tooltip" title="Close"
                                            aria-hidden="true"></i></a>
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
                                        <button id="changeBranchProfile-btn" class="btn btn-outline-dark"
                                            style="float: right">Change</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row gutters-sm">
                <div class="col-md-8">
                    <div class="card mb-3" style="border-radius: 10px;">
                        <div class="card-body">
                            <div class="float-right" style="cursor: pointer;">
                                <a style="text-decoration: none;cursor: pointer" onclick="$('#edit_loction').toggle('fast'); $('#branch-name-text').toggle('fast'); $('#branch-name').toggle('fast');
                                $('#branch-city-text').toggle('fast'); $('#branch-city').toggle('fast');
                                $('#branch-location-text').toggle('fast'); $('#branch-location').toggle('fast');
                                $('#btn-edit-branch').toggle('fast');
                                 return false;"><i class="fa fa-pencil-square-o icons" data-toggle="tooltip"
                                        title="Edit Branch" aria-hidden="true"></i></a>
                            </div>
                            <div>
                                <p>{{ $branch->branch_name }} Branch Information</p>
                            </div>
                            <form method="post" action="{{ route('branch.editBranch', $branch) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row" style="margin-top: 35px">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"><strong>Branch name</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <p id="branch-name-text">{{ $branch->branch_name }}</p>
                                        <input style="display: none" id="branch-name" name="branch_name" type="text"
                                            class="form-control" value="{{ $branch->branch_name }}"
                                            placeholder="Branch Name">
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"><strong>City</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <p id="branch-city-text">{{ $branch->city }}</p>
                                        <input style="display: none" id="branch-city" name="city" type="text"
                                            class="form-control" value="{{ $branch->city }}" placeholder="Branch City">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"><strong>Location</strong></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <p id="branch-location-text">{{ $branch->branch_address }}</p>
                                        <input style="display: none" id="branch-location" name="branch_address"
                                            type="text" class="form-control" value="{{ $branch->branch_address }}"
                                            placeholder="Branch Location">
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="display: none" id="btn-edit-branch">
                                    <div class="col-sm-12" style="margin-top: 10px">
                                        <button class="btn btn-outline-dark" style="float: right">Change</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3" style="border-radius: 10px; padding: 17px;">
                        <div class="form-group" id="edit_loction"
                            style="display: none; text-align: center; padding: 5px">
                            <label for="address_address" style=""><strong>Address</strong></label>
                            <input type="text" id="address-input" name="address_address" class="form-control map-input">
                            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                        </div>
                        <div id="address-map-container" style="width:100%;height:280px;border-radius: 10px;">
                            <div style="width: 100%; height: 100%; border-radius: 10px;" id="address-map"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                    </div>
                </div>
            </div>
            <div class="row gutters-sm">
                <div class="col-md-8">
                    <div class="card mb-3" style="border-radius: 10px;">
                        <div class="card-body">
                            <div class="float-right" style="cursor: pointer;">
                                <a style="text-decoration: none;cursor: pointer"
                                    onclick="$('#AddBank').toggle('slow');"><i class="fas fa-plus icons"
                                        data-toggle="tooltip" title="Add Bank Account" aria-hidden="true"></i></a>

                            </div>
                            <div id="AddBank" style="display: none;" class="container float-right mb-3">
                                <form style="padding: 20px; border-bottom: 2px solid #ccc"
                                    action="{{route('branch.addBank')}}" method="POST">
                                    @csrf
                                    <label for="bank_name">Bank Name</label>
                                    <input style="width: 100%" class="form-control" name="bank_name" type="text">
                                    <label for="accountNo">Account NO.</label>
                                    <input style="width: 100%" class="form-control" name="accountNo" type="text">
                                    <button type="submit" style="width: 100%"
                                        class="btn btn-sm btn-outline-dark mt-5 float-right">Submit</button>
                                </form>
                            </div>
                            <div>
                                <p>{{ $branch->branch_name }} Branch Bank's Information</p>
                            </div>
                            <div>
                                <div class="container-fluid">
                                    @if(count($banks)>0) <table id="bankTable">
                                        <thead>
                                            <tr>
                                                <th class="column">Bank</th>
                                                <th class="column">Account</th>
                                                <th class="column">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($banks as $bank)
                                            <tr>
                                                <form method="post" action="{{ route('branch.editBranchBank', $bank) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <td data-label="Bank" class="column">
                                                        <p class="btn-sm btn-light mb-0"
                                                            id="bank-name-text{{$bank->ID_Bank}}">
                                                            {{$bank->bank_name}}
                                                        </p>
                                                        <input style="display: none; width: 100%"
                                                            id="bank-name{{$bank->ID_Bank}}" name="bank_name"
                                                            type="text" class="form-control"
                                                            value="{{ $bank->bank_name }}"
                                                            placeholder="{{ $bank->bank_name }}">

                                                    </td>
                                                    <td data-label="Account NO." class="column">
                                                        <p class="btn-sm btn-light mb-0"
                                                            id="accountNo-text{{$bank->ID_Bank}}">
                                                            {{$bank->accountNo}}
                                                        </p>
                                                        <div style="display: flex; justify-content: space-between;">
                                                            <input style="display: none; width: max-content"
                                                                id="accountNo{{$bank->ID_Bank}}" name="accountNo"
                                                                type="text" class="form-control"
                                                                value="{{ $bank->accountNo }}"
                                                                placeholder="{{ $bank->accountNo }}">
                                                            <button style="display: none"
                                                                id="btn-edit-bank-{{$bank->ID_Bank}}" type="submit"
                                                                class="btn btn-sm btn-dark">Change</button>
                                                        </div>
                                                    </td>
                                                </form>
                                                <td data-label="Action" class="column" style="text-align: right">
                                                    <a style="text-decoration: none ;cursor: pointer"
                                                        onclick="$('#bank-name-text{{$bank->ID_Bank}}').toggle('fast'); 
                                                        $('#bank-name{{$bank->ID_Bank}}').toggle('fast'); 
                                                        $('#accountNo-text{{$bank->ID_Bank}}').toggle('fast');
                                                        $('#accountNo{{$bank->ID_Bank}}').toggle('fast');
                                                        $('#btn-edit-bank-{{$bank->ID_Bank}}').toggle('fast');return false;">
                                                        <i class="use-hover fa fa-pencil-square-o icons"
                                                            aria-hidden="true" data-toggle="tooltip"
                                                            title="Edit {{$bank->bank_name}}-{{$bank->accountNo}} Bank Account"></i></a>
                                                    <a data-toggle="tooltip" title="Delete Bank"
                                                        style="text-decoration: none;cursor: pointer">
                                                        <i data-toggle="modal"
                                                            data-target="#deleteBankModal{{$bank->ID_Bank}}"
                                                            class="delete-hover far fa-trash-alt icons"></i>
                                                    </a>
                                                    <div class="modal fade" id="deleteBankModal{{$bank->ID_Bank}}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="deleteabnkAria{{$bank->ID_Bank}}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="justify-content: center">
                                                                    <h5 class="modal-title"
                                                                        id="deleteBankModal{{$bank->ID_bank}}Title">
                                                                        Delete
                                                                        {{$bank->bank_name}} Bank - {{$bank->accountNo}}
                                                                    </h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert-danger"
                                                                        style="padding: 10px; border-radius: 10px">
                                                                        <p>
                                                                            <center><strong>!! Are you sure you want to
                                                                                    delete the {{$bank->bank_name}} Bank
                                                                                    !!</strong>
                                                                                <br>
                                                                                This will delete all the transactions
                                                                                related to this bank<br><br>
                                                                                Click Delete to Continue the Process
                                                                            </center>

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button
                                                                        onclick="$('#deleteBank{{$bank->ID_Bank}}').submit();"
                                                                        type="button"
                                                                        class="btn btn-sm btn-outline-danger">Delete</button>
                                                                    <form hidden
                                                                        action="{{ route('branch.deleteBank', $bank) }}"
                                                                        id="deleteBank{{$bank->ID_Bank}}"
                                                                        enctype="multipart/form-data" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="headerS">
                                        <h3>
                                            No Banks Found<br>
                                            <small>This Branch has no bank accoutns, click add button to add a new
                                                one</small>
                                        </h3>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3" style="border-radius: 10px;">
                        <div class="card-body">
                            <div class="btn-group" style="width: 100%">
                                <a href="{{ route('branch.transactions') }}" class="btn btn-info">Transactions</a>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    data-reference="parent">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" style="width: 100%">
                                    <a class="dropdown-item"
                                        href="{{ route('branch.transactions', ['status' => 0]) }}">Unpaid</a>
                                    <a class="dropdown-item"
                                        href="{{ route('branch.transactions', ['status' => 1]) }}">Paid</a>
                                    <a class="dropdown-item"
                                        href="{{ route('branch.transactions', ['status' => 2]) }}">Disapproved</a>
                                    <a class="dropdown-item"
                                        href="{{ route('branch.transactions', ['status' => 3]) }}">Approved</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('branch.transactions') }}">All
                                        Transactions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
            @section('scripts')
            @parent
            <script
                src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
                async defer></script>
            <script src="{{ asset('js/mapInput.js') }}"></script>
            <script>
                $(document).ready(function(){
                    $('#bankTable').DataTable( {
                        "pagingType": "full_numbers"
                    });
                });
            </script>
            @stop
        </div>
    </div>
</div>