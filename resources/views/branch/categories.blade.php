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
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 10px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Branch Employee : {{ Auth::user()->username }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('branch.category') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories & Units in {{$branch->branch_name}}
                Branch:
                Total of {{count($units)}} Units</li>
        </ol>
    </nav>
    @if (count($categories)>0)
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
                <div class="float-right" style="cursor: pointer;">
                    <form method="POST" action="{{route('branch.addUnit')}}" enctype="multipart/form-data"
                        id="addCategoryForm{{$category->ID_Category}}">
                        @csrf
                        <input hidden type="text" value="{{$branch->ID_Branch}}" name="ID_Branch">
                        <input hidden type="text" value="{{$category->ID_Category}}" name="ID_Category">
                        <input hidden type="text" value="{{$category->category_name}}" name="categoryName">
                        <input hidden type="text" value="{{$ind+1}}" name="ind">
                    </form>
                    <button type="submit" data-toggle="modal" data-target="#addCategory{{$category->ID_Category}}"
                        class="btn btn-sm btn-outline-success" style="border-radius: 10px; text-align: center;">Add
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="addCategory{{$category->ID_Category}}" tabindex="-1" role="dialog"
                        aria-labelledby="addCategory{{$category->ID_Category}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="justify-content: center">
                                    <h5 class="modal-title" id="addCategory{{$category->ID_Category}}Title">Add a
                                        {{$category->category_name}} Unit
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert-success" style="padding: 10px; border-radius: 10px">
                                        <p>
                                            This will add a new unit with the name
                                            <strong>0{{$branch->ID_Branch}}-0{{$category->ID_Category}}-{{$category->category_name}}/{{$ind+1}}</strong><br>
                                            Click Add to Proceed<br>
                                            The Private key will be generated automatically
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button onclick="$('#addCategoryForm{{$category->ID_Category}}').submit();"
                                        type="button" class="btn btn-sm btn-outline-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2" style="padding: 10px; margin: 0; ">
            <div class="alert-success mb-2"
                style="display: flex; justify-content: space-between; border-radius: 10px; padding: 10px; width: 100%">
                <div>
                    <p style="margin: 0"><strong>Description : </strong>{{$category->description}}</p>
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
            <div class="categories" style="display: flex; justify-content: flex-end; gap: 20px">
                <div style="text-align: center">
                    <img width="200px" class="img-fluid" style="border-radius: 10px;"
                        src="{{ asset('storage/' . $category->category_img) }}" alt="">
                </div>
                <div style="flex: 1">
                    <div class="table100">
                        @if ( $ind > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th class="column">Status</th>
                                    <th class="column">Code Name</th>
                                    <th class="column">Private Key</th>
                                    <th class="column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                @if ($unit->ID_Category == $category->ID_Category)
                                <tr>
                                    <td data-label="Status" class="column">
                                        <div style="display: flex; justify-content: space-between">
                                            @if ($unit->unit_status)
                                            <p class="btn-sm btn-warning mb-0" style="width:40%">
                                                <a data-toggle="tooltip" title="Order Details" class="mb-0"
                                                    style="color: #000000;"
                                                    href="{{ route('branch.orderDetailsU', ['unit'=>$unit]) }}">
                                                    Occupied
                                                </a>
                                            </p>

                                            @else
                                            <p class="btn-sm btn-secondary mb-0" style="width:40%">Unoccupied
                                            </p>
                                            @endif
                                            <div class="btn-sm btn-dark"
                                                style="background-color: #66377f; text-align: left; width: 50%">(
                                                <small>@if ($unit->capacity == 100)
                                                    Full: Capacity {{$unit->capacity}}%)
                                                    @elseif($unit->capacity >= 95)
                                                    Almost: Full Capacity {{$unit->capacity}}%)
                                                    @elseif($unit->capacity >= 80)
                                                    Moderately Full: Capacity {{$unit->capacity}}%)
                                                    @elseif($unit->capacity == 0)
                                                    Empty)
                                                    @else
                                                    Capacity {{$unit->capacity}}%)
                                                    @endif
                                                </small>
                                                <div class="progress mb-1" style="height: 5px" data-placement='left'
                                                    data-toggle="tooltip" title="Capacity {{$unit->capacity}}%">
                                                    @if ($unit->capacity >= 95)
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{$unit->capacity}}%"
                                                        aria-valuenow="{{$unit->capacity}}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                    @elseif($unit->capacity >= 80)
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{$unit->capacity}}%"
                                                        aria-valuenow="{{$unit->capacity}}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                    @else
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                        style="width: {{$unit->capacity}}%"
                                                        aria-valuenow="{{$unit->capacity}}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Code Name" class="column">
                                        <p class="btn-sm btn-light mb-0" style="padding-bottom: 13px">
                                            {{$unit->unit_name}}
                                        </p>
                                    </td>
                                    <td data-label="Private Key" class="column">
                                        <div style="display: flex;gap: 10px">
                                            <input disabled style="width: 50%" type="password"
                                                value="{{$unit->privateKey}}" class="form-control"
                                                id="privateKey{{$unit->ID_Unit}}">
                                            <div style="display: flex;gap: 5px; margin-top: 5px">
                                                <input class="form-check-input" style="margin-top: 5px" type="checkbox"
                                                    onclick="showPrivateKey({{$unit->ID_Unit}})">
                                                <p class="form-check-label">Show Key</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right" data-label="Action" class="column">
                                        <div style="display: flex;gap: 10px">
                                            <a data-toggle="modal" data-target="#changePrivateKeyUnit{{$unit->ID_Unit}}"
                                                data-placement="top" style="text-decoration: none;cursor: pointer"><i
                                                    data-toggle="tooltip" title="Change Private Key"
                                                    class="refresh-hover fas fa-sync icons"></i></a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="changePrivateKeyUnit{{$unit->ID_Unit}}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="changePrivateKeyUnit{{$unit->ID_Unit}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="justify-content: center">
                                                            <h5 class="modal-title"
                                                                id="changePrivateKeyUnit{{$unit->ID_Unit}}Title">
                                                                Change Private Key
                                                                {{$unit->unit_name}} Unit
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($unit->unit_status)
                                                            <div class="alert-danger"
                                                                style="padding: 10px; border-radius: 10px">
                                                                <p>
                                                                    <center><strong>!! This Unit is Occupied !!</strong>
                                                                    </center><br>
                                                                    <a
                                                                        href="{{ route('branch.orderDetailsU', ['unit'=>$unit]) }}">Click
                                                                        Here</a> to See Order Details<br>
                                                                    Click Change to Continue the Process
                                                                </p>
                                                            </div>
                                                            @else
                                                            <div class="alert-warning"
                                                                style="padding: 10px; border-radius: 10px">
                                                                <p>
                                                                    <center><strong>This Unit is Unoccupied</strong>
                                                                    </center><br>
                                                                    Click Change to Continue the Process
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button
                                                                onclick="$('#changePrivateKeyUnitUnitForm{{$unit->ID_Unit}}').submit();"
                                                                type="button"
                                                                class="btn btn-sm btn-outline-primary">Change</button>
                                                            <form method="post"
                                                                action="{{route('branch.changePrivateKeyUnit', $unit)}}"
                                                                enctype="multipart/form-data"
                                                                id="changePrivateKeyUnitUnitForm{{$unit->ID_Unit}}">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($unit->unit_status)

                                            <a href="{{ route('branch.orderDetailsU', ['unit'=>$unit]) }}"
                                                style="text-decoration: none;cursor: pointer"><i data-placement="top"
                                                    title="Cancel Subscription" data-toggle="tooltip"
                                                    class="noUse-hover fas fa-user-slash icons"></i></a>
                                            @else
                                            <a href="{{ route('branch.orders') }}" data-placement="top"
                                                title="Make Rent" style="text-decoration: none;cursor: pointer"><i
                                                    data-toggle="tooltip" data-placement="top" title="Make Rent"
                                                    class="use-hover fas fa-user-plus icons"></i></a>
                                            @endif
                                            <a data-toggle="modal" data-target="#deleteUnit{{$unit->ID_Unit}}"
                                                style="text-decoration: none;cursor: pointer">
                                                <i data-placement="top" title="Delete Unit" data-toggle="tooltip"
                                                    class="delete-hover far fa-trash-alt icons"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteUnit{{$unit->ID_Unit}}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteUnit{{$unit->ID_Unit}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="justify-content: center">
                                                            <h5 class="modal-title"
                                                                id="deleteUnit{{$unit->ID_Unit}}Title">
                                                                Delete
                                                                {{$unit->unit_name}} Unit
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($unit->unit_status)
                                                            <div class="alert-danger"
                                                                style="padding: 10px; border-radius: 10px">
                                                                <p>
                                                                    <center><strong>!! This Unit is Occupied !!</strong>
                                                                    </center><br>
                                                                    <a
                                                                        href="{{ route('branch.orderDetailsU', ['unit'=>$unit]) }}">Click
                                                                        Here</a> to See Order Details<br>
                                                                    Click Delete to Continue the Process
                                                                </p>
                                                            </div>
                                                            @else
                                                            <div class="alert-warning"
                                                                style="padding: 10px; border-radius: 10px">
                                                                <p>
                                                                    <center><strong>This Unit is Unoccupied</strong>
                                                                    </center><br>
                                                                    Click Delete to Continue the Process
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button
                                                                onclick="$('#deleteUnitForm{{$unit->ID_Unit}}').submit();"
                                                                type="button"
                                                                class="btn btn-sm btn-outline-danger">Delete</button>
                                                            <form method="Post"
                                                                action="{{route('branch.deleteUnit', $unit)}}"
                                                                enctype="multipart/form-data"
                                                                id="deleteUnitForm{{$unit->ID_Unit}}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <center>
                            <p>No Units</p>
                        </center>
                        @endif
                    </div>
                </div>

            </div>
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
<script>
    function showPrivateKey(id) {
      var x = document.getElementById("privateKey"+id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
</script>
@endsection