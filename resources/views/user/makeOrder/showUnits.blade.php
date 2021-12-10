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
                    City: {{$branch->city}}
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('chooseLocation', ['unit'=> $unit->ID_Category, 'city' => $branch->city] ) }}">Choose
                        Location</a>
                </li>
                <li class="breadcrumb-item">
                    Location: Branch Name: {{$branch->branch_name}} - Branch Address: {{$branch->branch_address}}
                </li>
            </ol>
        </nav>
    </div>
    <div class="chooseCityContainer" style="min-height: 0; padding: 5px; margin: 5px 20px">
        <div class="progress">
            <div class="progress-bar color-progress" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                aria-valuemax="100" style="width: 50%">50%</div>
        </div>
    </div>
    <div class="chooseCityContainer row">
        @if (count($unitsAvaliable)>0)
        <div class="col-md-5" style="display: flex; justify-content: center; height: 350px; width: 350;">
            <img class="img-fluid" src="{{ asset('storage/' . $unit->category_img) }}" alt="">
        </div>
        <div class="col-md-5">
            <p class="m-0">You choosed unit {{$unit->category_name}} unit.</p>
            <small>
                @if ($availableInBranch)
                Great! There are {{$unit->category_name}} units in this branch<br>
                Check the Unit that you choosed to confirm.
                @else
                Hmmm, There are no {{$unit->category_name}} units in this branch <br>
                Try another branch or choose a different unit in this branch.
                @endif
            </small>
            <form action="{{ route('makeOrderDetails') }}" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="form-check mt-2">
                    @foreach ($categories as $category)
                    @php
                    $ind = 0;
                    $idUnit = 0;
                    @endphp
                    <div>
                        @foreach ($unitsAvaliable as $unit)
                        @if ($unit->ID_Category == $category->ID_Category)
                        @php
                        $ind++;
                        $idUnit = $unit->ID_Unit;
                        @endphp
                        @endif
                        @endforeach
                        @if ($ind <= 0) <input disabled name="Idunit" class="check form-check-input" type="checkbox"
                            value="{{$idUnit}}">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{$category->category_name}}
                                (There are {{$ind}} available units)
                                <br>
                                <small>This branch has no units of {{$category->category_name}} Category that are
                                    available</small>
                            </label>
                            @else
                            <input id="unitPrice" name="Idunit" class="check form-check-input" type="checkbox"
                                value="{{$idUnit}}">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{$category->category_name}}
                                (There are {{$ind}} available units)
                                <br>
                                <small>Dimensions: {{ $category->dimensions }} <br>
                                    Price/Day: {{$category->pricePerDay}}
                                </small>
                            </label>
                            @endif
                    </div>
                    @endforeach
                </div>
                <div>
                    <button type="submit" class="btn btn-outline-primary float-right">Next</button>
                </div>
            </form>
        </div>
        @else
        <div class="headerS" style="width: 100%;"">
            <h3>
                So sorry, This Branch has no units to Rent<br>
                <small>Maybe you can choose another Branch</small>
            </h3>
        </div>
        @endif
    </div>

</div>
<script>
    $(document).ready(function(){
        $('.check').click(function() {
            $('.check').not(this).prop('checked', false);
        });
    });
</script>
@endsection