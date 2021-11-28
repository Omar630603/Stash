@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
<div class="headerParagraph" >
<h1 style="text-align:center">Our Services</h1>

</div>

<style>
   body
   * {
      box-sizing: border-box;
   }
   .card {
      color: white;
      float: left;
      width: calc(50% - 40px);
      padding: 10px;
      border-radius: 10px;
      margin: 10px;
      height: 200px;
   }


   .card p {
      font-size: 18px;
   }
   .cardContainer:after {
      content: "";
      display: table;
      clear: both;
   }
   @media screen and (max-width: 600px) {
      .card {
         width: 100%;
      }
   }

   img:hover {
  /* Start the shake animation and make the animation last for 0.5 seconds */
  animation: shake 0.5s;

  /* When the animation is finished, start again */
  animation-iteration-count: infinite;
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 70%;
}

</style>

<div class="services">
<div class="headerParagraph">
<h2>Locker - Small Size</h2>
<div class="cardContainer" >
<div class="card" >
<img src="/img/locker.png" width="100" height="200" class="center">
</div>

<div class="card" width="400">
    <p style="color:black">
    They are usually intended for use in public places, 
    and intended for the short- or long-term private use 
    of individuals for storing clothing or other personal items. 
    With 3 x 3 space Users may rent a locker for a single use or for 
    a period of time for repeated use. 
    </p>
</div>

</div>

</div><br>
<div class="headerParagraph">
<h2>Garage - Medium Size</h2>
<div class="cardContainer" >
<div class="card" style="color:black">
<img src="/img/garage.png" width="100" height="200" class="center">
</div>

<div class="card">
<p style="color:black">
with 6 x 6 space, it can protects a vehicle from precipitation, and, if it is 
equipped with a locking garage door, it also protects the vehicle(s) from theft and vandalism. 
Most garages also serve multifunction duty as workshops for a variety of projects, 
including painting, woodworking, and assembly. 
    </p>
</div>
</div>
</div><br>

<div class="headerParagraph">
<h2>Warehouse - Large Size</h2>
<div class="cardContainer" >
<div class="card" style="color:black">
<img src="/img/warehouse.png" width="100" height="170" class="center">
</div>

<div class="card">
<p style="color:black">
The functions of warehousing include stocking, maintaining, and controlling your work in 
process inventory. With 9 x 9 space, it Developing a dependable warehouse process for your products is 
crucial for business growth. 
Warehousing actions include: Setting your warehouse up properly and with relevant equipment.
    </p>
</div>
</div>
</div>
</div>
@endsection