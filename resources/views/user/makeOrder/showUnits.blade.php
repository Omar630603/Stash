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
    <div class="chooseCityContainer">
        @if (count($unitsAvaliable)>0)
        <div style="width: 50%; display: flex; justify-content: center; height: 350px; width: 350;">
            <h1>{{$unit->category_name}}</h1>
            <img class="img-fluid" src="{{ asset('storage/' . $unit->category_img) }}" alt="">
        </div>
        <div style="width: 50%;" class="m-0">
            <p class="m-0">Your choosed unit {{$unit->category_name}} unit.</p>
            <small>Check the Unit that you choosed to confirm or you can change the unit available</small>
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
                            (There is {{$ind}} available units)
                            <br>
                            <small>This branch has no units of {{$category->category_name}} Category that are
                                available</small>
                        </label>
                        @else
                        <input id="unitPrice" name="Idunit" class="check form-check-input" type="checkbox"
                            value="{{$idUnit}}">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$category->category_name}}
                            (There is {{$ind}} available units)
                            <br>
                            <small>Dimensions: {{ $category->dimensions }} <br>
                                Price/Day: {{$category->pricePerDay}}
                            </small>
                        </label>
                        @endif
                </div>
                @endforeach
            </div>
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