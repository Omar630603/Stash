@extends('layouts.welcome')

@section('content')
<div class="content">
   <div class="container ">
      @if ($message = Session::get('fail'))
      <div class="alert alert-warning alert-dismissible fade show" style="border-radius: 10px">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <p>{{ $message }}</p>
      </div>
      @elseif ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" style="border-radius: 10px">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <p>{{ $message }}</p>
      </div>
      @endif
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
      <div class="row justify-content-center contactUs" style="color: #fff">
         <div class="col-md-12">
            <div class="row justify-content-center" style="align-items: center">
               <div class="col-md-6">
                  <div class="row">
                     <h3 class="heading mb-4">Send us a message!</h3>
                     <p>We can talk about everything! :)</p>
                     <p><img width="400px" src="{{ asset('storage/images/contact.svg') }}" alt="Image"
                           class="img-fluid"></p>
                  </div>
               </div>
               <div class="col-md-6 mt-5">
                  <form action="{{ route('welcome.sendMessage') }}" class="mb-5" method="post" id="contactForm"
                     name="contactForm">
                     <h3 class="heading mb-4">Fill in your information</h3>
                     @csrf
                     @auth
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <a href="{{ route('home') }}" class="float-right" style="margin-right: 5px"><img width="80px"
                                 height="80px" style="border-radius: 50%; border: 2px solid #f89f5b; padding: 2px"
                                 src="{{asset('storage/'.Auth::user()->user_img)}}">
                           </a>
                           <strong>
                              <p class="card-title">Hello! {{Auth::user()->username}}</p>
                           </strong>
                           <p class="card-text">E-Mail: {{Auth::user()->email}}</p>

                        </div>
                     </div>
                     <input hidden class="form-control" name="email" value="{{Auth::user()->email}}">
                     <input hidden name="name" value="{{Auth::user()->name}}">
                     <input hidden name="isUser" value="1">
                     @else
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <input style="border-radius: 10px !important" type="text" class="form-control" name="name"
                              id="name" placeholder="Your name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <input style="border-radius: 10px !important" type="text" class="form-control" name="email"
                              id="email" placeholder="Email">
                        </div>
                     </div>
                     <input hidden name="isUser" value="0">
                     @endauth
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <input style="border-radius: 10px !important" type="text" class="form-control" name="subject"
                              id="subject" placeholder="Subject">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <textarea style="border-radius: 10px !important;" class="form-control" name="message"
                              id="message" cols="5" rows="5" placeholder="Write your message"></textarea>
                        </div>
                     </div>
                     <div class="row" style="justify-content: flex-end">
                        <div class="col-sm-12">
                           <input type="submit" value="Send Message"
                              class="float-right btn-rent btn btn-primary py-2 px-4">
                           <span class="submitting"></span>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection