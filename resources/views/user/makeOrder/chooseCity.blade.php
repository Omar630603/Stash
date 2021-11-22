@extends('layouts.appUser')

@section('content')
<div class="container">
    <div class="chooseCityContainer">
        <div style="width: 50%">
            <img class="img-fluid" src="{{ asset('storage/images/chooseCity.png') }}" alt="">
        </div>
        <div style="width: 50%" class="m-0">
            <div class="form-group" style="margin: 10px 0">
                <select name="ID_Bank" style="width: 100%" class="select2">
                    <option value="0">Select City</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->city}}">
                        {{$city->city}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button class="btn btn-outline-primary">Next</button>
            </div>
        </div>
    </div>

</div>


<script>
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });
</script>
@endsection