@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="main-breadcrumb" style="border-radius: 20px">
        <ol class="breadcrumb" style="background-color: #fff8e6; border-radius: 10px">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin : {{ Auth::user()->username }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories & Units in {{$branch->branch}} Branch
                :Total of {{count($units)}} Units</li>
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
    if (!$unit->status) {
    $unoccupied++;
    }else {
    $occupied++;
    }
    }
    }
    @endphp
    <div class="card mb-3" style="border-radius:20px;">
        <div class="card-header"
            style="padding: 10px; background-image: url({{ asset('storage/' . $category->img) }}); border-radius:20px; background-repeat: no-repeat, repeat; background-position: left; background-size: contain;">
            <div style="display: flex; justify-content: flex-end; ">
                <div style="flex: 1; text-align: center; margin-left: 20px">
                    <p style="margin: 0"><strong>{{$category->name}}</strong></p>
                </div>
                <div class="float-right" style="cursor: pointer;">
                    <form method="POST" action="{{route('admin.addUnit')}}" enctype="multipart/form-data"
                        id="addCategoryForm{{$category->ID_Category}}">
                        @csrf
                        <input hidden type="text" value="{{$branch->ID_Admin}}" name="ID_Admin">
                        <input hidden type="text" value="{{$category->ID_Category}}" name="ID_Category">
                        <input hidden type="text" value="{{$category->name}}" name="categoryName">
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
                                        {{$category->name}} Unit
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert-success" style="padding: 10px; border-radius: 20px">
                                        <p>
                                            This will add a new unit with the name
                                            <strong>0{{$branch->ID_Admin}}-0{{$category->ID_Category}}-{{$category->name}}/{{$ind+1}}</strong><br>
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
            <div class="mb-2" style="display: flex; justify-content: space-between;">
                <div>
                    <p style="margin: 0"><strong>Description : </strong>{{$category->description}}</p>
                    <p style="margin: 0"><strong>Dimensions : </strong>{{$category->dimensions}}</p>
                    <p style="margin: 0"><strong>Occupied : </strong><a href=""></a>{{$occupied}}</a> |
                        <strong>Unoccupied :
                        </strong>{{$unoccupied}}</p>
                </div>
                <div>
                    <p style="margin: 0"><strong>Price / Day : </strong>{{$category->pricePerDay}}</p>
                    <p style="margin: 0"><strong>{{$category->name}} Units : </strong>{{$ind}}</p>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 10px;">
            <div style="display: flex; justify-content: flex-end; gap: 20px">
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
                                        @if ($unit->status)
                                        <p class="btn-sm btn-warning">Occupied</p>
                                        @else
                                        <p class="btn-sm btn-secondary">Unoccupied</p>
                                        @endif
                                    </td>
                                    <td data-label="Code Name" class="column">
                                        <p>{{$unit->IdName}}</p>
                                    </td>
                                    <td data-label="Private Key" class="column">
                                        <div style="display: flex;gap: 10px">
                                            <input disabled style="width: 50%" type="password"
                                                value="{{$unit->privateKey}}" class="form-control"
                                                id="privateKey{{$unit->ID_Unit}}">
                                            <div style="display: flex;gap: 5px; margin-top: 10px">
                                                <input style="margin-top: 5px" type="checkbox"
                                                    onclick="showPrivateKey({{$unit->ID_Unit}})">
                                                <p>Show Key</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Action" class="column">
                                        <div style="display: flex;gap: 10px">
                                            <a data-toggle="modal" data-target="#changePrivateKeyUnit{{$unit->ID_Unit}}"
                                                data-placement="top" title="Change Private Key"
                                                style="text-decoration: none;cursor: pointer"><i
                                                    class="refresh-hover fas fa-sync"></i></a>

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
                                                                {{$unit->IdName}} Unit
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($unit->status)
                                                            <div class="alert-danger"
                                                                style="padding: 10px; border-radius: 20px">
                                                                <p>
                                                                    <center><strong>!! This Unit is Occupied !!</strong>
                                                                    </center><br>
                                                                    <a href="">Click Here</a> to See Order Details<br>
                                                                    Click Change to Continue the Process
                                                                </p>
                                                            </div>
                                                            @else
                                                            <div class="alert-warning"
                                                                style="padding: 10px; border-radius: 20px">
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
                                                                action="{{route('admin.changePrivateKeyUnit', $unit)}}"
                                                                enctype="multipart/form-data"
                                                                id="changePrivateKeyUnitUnitForm{{$unit->ID_Unit}}">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($unit->status)
                                            <a data-placement="top" title="Cancel Subscription"
                                                style="text-decoration: none;cursor: pointer"><i
                                                    class="noUse-hover fas fa-user-slash"></i></a>
                                            @else
                                            <a data-placement="top" title="Make Rent"
                                                style="text-decoration: none;cursor: pointer"><i
                                                    class="use-hover fas fa-user-plus"></i></a>
                                            @endif
                                            <a data-placement="top" title="Delete Unit" data-toggle="modal"
                                                data-target="#deleteUnit{{$unit->ID_Unit}}"
                                                style="text-decoration: none;cursor: pointer">
                                                <i class="delete-hover far fa-trash-alt"></i></a>
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
                                                                {{$unit->IdName}} Unit
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($unit->status)
                                                            <div class="alert-danger"
                                                                style="padding: 10px; border-radius: 20px">
                                                                <p>
                                                                    <center><strong>!! This Unit is Occupied !!</strong>
                                                                    </center><br>
                                                                    <a href="">Click Here</a> to See Order Details<br>
                                                                    Click Delete to Continue the Process
                                                                </p>
                                                            </div>
                                                            @else
                                                            <div class="alert-warning"
                                                                style="padding: 10px; border-radius: 20px">
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
                                                                action="{{route('admin.deleteUnit', $unit)}}"
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
                <div>
                    <img style="border-radius: 10px;" src="{{ asset('storage/' . $category->img) }}" alt="">
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