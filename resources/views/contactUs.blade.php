@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
<div class="headerParagraph">
<h1 style="text-align:center">Contact Us</h1>
</div>
<div class="services">
<div class="headerParagraph">

<style>
   body 
   * {
      box-sizing: border-box;
   }
   .card {
      color: white;
      float: left;
      width: calc(25% - 20px);
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
  width: 65%;
}

</style>


<h2>Phone & Fax</h2><br>
<div class="cardContainer" >
    <div class="card" >
    <img src="/img/phone.png" width="130" height="130" class="center">
        <p style="color:black">Phone : 0813-5379-4279</p></div>

    <div class="card">
    <img src="/img/fax.png" width="130" height="130" class="center">
        <p style="color:black">Fax : (480) 539-4289</p></div>

</div>
</div><br>
<div class="headerParagraph">
<br><br>
<h2>Our Social Media</h2>

  <div class="cardContainer">
    <div class="card">
    <img src="/img/instagram.png" width="130" height="130" class="center"><br>
    <p style="color:black">Instagram : @stash.id</p></div>

    <div class="card" class="center">
    <img src="/img/facebook.png" width="130" height="130" class="center"><br>
    <p style="color:black">Facebook : RealStash</p></div>

    <div class="card" >
    <img src="/img/twitter.png" width="130" height="130" class="center"><br>
    <p style="color:black">Twitter : @stash_it</p></div>

    <div class="card" >
    <img src="/img/pinterest.png" width="130" height="130" class="center"><br>
    <p style="color:black">Pinterest : the.stash</p></div>

</div>
</div>
</div>
@endsection