@extends('layouts.welcome')

@section('content')
<div class="container-fluid">
    <div class="about-us">
        <div class="about-us-inside">
            <div class="about-us-inside-info p-5">
                <h1 class="display-4">What is Stash?</h1>
                <p class="lead text-black mb-0">Stash is an online application that provides services focused on
                    monitoring storage unit systems. Stash offers a solution to a lifestyle where having more space is
                    now a luxury everyone can afford. We value that home is for living and we want to give customers the
                    freedom to de-clutter while keeping the things that matter. Stash is here to help and facilitate
                    business owners, companies, and the public who want to use self-storage service with a website that
                    is easily accessible only by the internet network and can be used on various gadgets, one of which
                    is a smartphone.</p>
            </div>
            <div class="about-us-inside-image p-5">
                <img width="200px" src="{{ asset('storage/images/logo.png') }}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="about-us flipcolor">
        <div class="about-us-inside" style="flex-direction: row-reverse">
            <div class="about-us-inside-info p-5" style="text-align: right">
                <h1 class="display-4">What do we do in Stash?</h1>
                <p class="lead text-black mb-0">We offer our customers storage units that they can use for storing their
                    items safely. We help our customers with the delivery of their items by providing a built-in
                    delivery system. The main idea is to make the life our customers easier.</p>
            </div>
            <div class="about-us-inside-image p-5">
                <img width="300px" src="{{ asset('storage/images/units.png') }}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="about-us-developers">
        <div class="row mb-3">
            <div class="col-lg-12" style="text-align: center">
                <h2 class="display-4 font-weight-light">Developers</h2>
                <p class="lead text-black mb-4">Stash Development Team</p>
            </div>
        </div>

        <div class="row text-center px-5" style="justify-content: center">
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/omar.jpeg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Omar Al-Maktary</h5><span class="small text-uppercase text-mutedCard">Programer &
                        Engineer</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/profile.php?id=100013517199373"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/omar630603/"
                                class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/alif.jpeg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">M. Alif Ananda</h5><span
                        class="small text-uppercase text-mutedCard">Management</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/groups/3676406335772078"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/baggio.jpeg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">De Roger Baggio B.</h5><span class="small text-uppercase text-mutedCard">Data
                        analyst
                    </span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/baggio.deroger"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/baggioderogerr/"
                                class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/rizki.jpeg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Rizki Irfan Maulana</h5><span
                        class="small text-uppercase text-mutedCard">Designer</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/profile.php?id=100008786583027"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/rzkirfan_/"
                                class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/radit.jpg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Radithya Iqbal Prasaja</h5><span
                        class="small text-uppercase text-mutedCard">Programer
                    </span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/profile.php?id=100010450022316"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="ihttps://www.instagram.com/radithya_iqbal/"
                                class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
            <!-- Team item-->
            <div class="col-xl-4 col-sm-6 mb-5">
                <div class="bg-white rounded shadow-sm py-5 px-4 develover-Card">
                    <img src="{{ asset('storage/images/lely.jpeg') }}" alt="" width="130"
                        class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                    <h5 class="mb-0">Lelyta Salsabila</h5><span class="small text-uppercase text-mutedCard">Data
                        analyst</span>
                    <ul class="social mb-0 list-inline mt-3">
                        <li class="list-inline-item"><a href="https://web.facebook.com/lelyta.salsabila"
                                class="social-link"><i class="fa fa-facebook-f"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/lelyta_salsabila/"
                                class="social-link"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="social-link"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End-->
        </div>
    </div>
</div>

@endsection