@extends('layouts.master') {{-- Assuming master.blade.php is in layouts folder --}}

@section('title', 'Service') {{-- For the page title --}}

@section('content')
<style>
.dot {
    width: 10px;
    height: 10px;
    background-color: #ccc;
    border-radius: 50%;
    display: inline-block;
    margin: 0 5px;
}

</style>
    <!-- Page Header Start -->
    <div class="container-fluid page-header-1 py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-uppercase mb-3 animated slideInDown" style="color:red">{{__('messages.purchase')}}</h1>
        </div>
    </div>
    <!-- Page Header End -->
    
     <!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{__('messages.purchase')}}</p>
            <h1 class="text-uppercase">{{__('messages.purchase_choose_version')}}</h1>
        </div>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item">
                    <div class="team-img position-relative overflow-hidden">
                        <img class="img-fluid" src="img/web_2.jpg" alt="">
                        <div class="team-social">
                        <a class="btn btn-square" href="https://t.me/HAXSupport"><i class="fab fa-telegram"></i></a>
                            <a class="btn btn-square" href="https://x.com/HAXSUPPOR"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square" href="https://www.facebook.com/HAXSUPPOR/"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="bg-secondary text-center p-4" style="min-height: 200px; overflow-y: auto;">
                    <h5 class="text-uppercase">{{__('messages.purchase_personal_license')}}</h5>
                    <span class="text-primary">{{__('messages.purchase_personal_price')}}</span>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item">
                    <div class="team-img position-relative overflow-hidden">
                        <img class="img-fluid" src="img/web_3.jpg" alt="">
                        <div class="team-social">
                        <a class="btn btn-square" href="https://t.me/HAXSupport"><i class="fab fa-telegram"></i></a>
                            <a class="btn btn-square" href="https://x.com/HAXSUPPOR"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square" href="https://www.facebook.com/HAXSUPPOR/"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="bg-secondary text-start p-4" style="max-height: 200px; overflow-y: auto;">
                        <h5 class="text-uppercase">{{__('messages.purchase_custom_license')}}</h5>
                        <span class="text-primary">{{__('messages.purchase_custom_price')}}</span>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item">
                    <div class="team-img position-relative overflow-hidden">
                        <img class="img-fluid" src="img/web_1.jpg" alt="">
                        <div class="team-social">
                            <a class="btn btn-square" href="https://t.me/HAXSupport"><i class="fab fa-telegram"></i></a>
                            <a class="btn btn-square" href="https://x.com/HAXSUPPOR"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square" href="https://www.facebook.com/HAXSUPPOR/"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                    <div class="bg-secondary text-center p-4" style="min-height: 200px; overflow-y: auto;">
                    <h5 class="text-uppercase">{{__('messages.purchase_full_source_code')}}</h5>
                    <span class="text-primary">{{__('messages.purchase_full_source_code_price')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="text-uppercase">{{__('messages.services_title')}}</h1>
            </div>
            <div class="row g-4">
                <!-- Service Items -->
                 <center>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fab fa-twitter img-fluid"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">{{__('messages.twitter')}}</h3>
                            <p>{{__('messages.twitter_support')}}</p>
                        </div>
                    </div>
                </div>
                </center>
                <!-- Repeat similar blocks for other services -->
            </div>
        </div>
    </div>
    <!-- Service End -->

    
    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{__('messages.testimonial_title')}}</p>
                <h1 class="text-uppercase">{{__('messages.testimonial_clients_say')}}</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_1')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_2')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_3')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_4')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_5')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_6')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_7')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_8')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_9')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_10')}}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{__('messages.recommend_11')}}</span>
                </div>
            </div>  
            <center>
                <div class="d-flex pt-1 m-n1 justify-content-center">
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="https://t.me/craxsosp"><i class="fab fa-telegram"></i></a>
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="#"><i class="fab fa-facebook"></i></a>
                </div>
            </center>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection
