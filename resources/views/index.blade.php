@extends('layouts.master')

@section('title', 'Home')

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

        /* إضافة تنسيق للنافذة المنبثقة */
        .video-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .video-modal-content {
            margin: 5% auto;
            display: block;
            width: 80%;
            max-width: 800px;
            position: relative;
        }

        .video-close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #f1f1f1;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
        }

        .modal-video {
            width: 100%;
            height: auto;
            max-height: 80vh;
        }
    </style>
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <video id="video1" class="w-100" autoplay loop muted>
                        <source src="{{ asset('videos/video_1.mp4') }}" type="video/mp4">
                        {{ __('messages.carousel_browser_support') }}
                    </video>
                    <div class="carousel-caption d-flex align-items-start justify-content-center text-start">
                        <div class="mx-sm-5 px-5" style="max-width: 900px;">
                            <h1 class="display-2 text-red text-uppercase mb-4 animated slideInDown" style="color:red">
                                {{ __('messages.carousel_hello') }}</h1>
                            <!-- زر تشغيل الفيديو المُعدّل -->
                            <center>
                                <button class="btn btn-primary" style="margin-top:200px"
                                    onclick="openVideoModal('{{ asset('videos/video_1.mp4') }}')">{{ __('messages.carousel_play_video') }}</button>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <video id="video2" class="w-100" autoplay loop muted>
                        <source src="{{ asset('videos/slider_2/slider_2.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="carousel-caption d-flex align-items-start justify-content-center text-start">
                        <div class="mx-sm-5 px-5" style="max-width: 900px;">
                            <h1 class="display-2 text-red text-uppercase mb-4 animated slideInDown" style="color:red">
                                {{ __('messages.carousel_windows_version') }}</h1>
                            <!-- زر تشغيل الفيديو المُعدّل -->
                            <center>
                                <button class="btn btn-primary" style="margin-top:150px"
                                    onclick="openVideoModal('{{ asset('videos/slider_2/slider_2.mp4') }}')">{{ __('messages.carousel_play_video') }}</button>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <video id="video2" class="w-100" autoplay loop muted>
                        <source src="{{ asset('videos/slider_3/slider_3.mp4') }}" type="video/mp4">
                        {{ __('messages.carousel_browser_support') }}
                    </video>
                    <div class="carousel-caption d-flex align-items-start justify-content-center text-start">
                        <div class="mx-sm-5 px-5" style="max-width: 900px;">
                            <h1 class="display-2 text-red text-uppercase mb-4 animated slideInDown" style="color:red">
                                {{ __('messages.carousel_windows_version') }}</h1>
                            <!-- زر تشغيل الفيديو المُعدّل -->
                            <center>
                                <button class="btn btn-primary" style="margin-top:150px"
                                    onclick="openVideoModal('{{ asset('videos/slider_3/slider_3.mp4') }}')">{{ __('messages.carousel_play_video') }}</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- نافذة Modal للفيديو -->
    <div id="videoModal" class="video-modal">
        <span class="video-close" onclick="closeVideoModal()">&times;</span>
        <div class="video-modal-content">
            <video id="modalVideo" class="modal-video" controls>
                <source src="" type="video/mp4">
                {{ __('messages.carousel_browser_support') }}
            </video>
        </div>
    </div>

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column">
                        <img class="img-fluid w-100 align-self-end" src="{{ asset('img/about_home.jpg') }}" alt="">
                        <div class="w-50 bg-secondary" style="margin-top: -25%;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{ __('messages.about_us') }}</p>
                    <h1 class="text-uppercase mb-4" style="color:red">{{ __('messages.about_title') }}</h1>
                    <p>{{ __('messages.about_description') }}</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.about_backup') }}</h3>
                            <p class="mb-0">{{ __('messages.about_backup_description') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.about_compatibility') }}</h3>
                            <p class="mb-0">{{ __('messages.about_compatibility_description') }}</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.about_send_receive') }}</h3>
                            <p class="mb-0">{{ __('messages.about_send_receive_description') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.about_communication') }}
                            </h3>
                            <p class="mb-0">{{ __('messages.about_communication_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="text-uppercase" style="color:red">{{ __('messages.services_title') }}</h1>
            </div>
            <div class="row g-4">
                <!-- Files Manager -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-folder-open text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.files_manager') }}</h3>
                            <p>{{ __('messages.files_manager_description') }}</p>
                            <span class="text-uppercase mb-3">{{ __('messages.files_manager_features') }}</span>
                        </div>
                    </div>
                </div>
                <!-- SMS Manager -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-envelope text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.sms_manager') }}</h3>
                            <p>{{ __('messages.sms_manager_description') }}</p>
                            <span class="text-uppercase mb-3">{{ __('messages.sms_manager_features') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Call Log -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-phone text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.call_log') }}</h3>
                            <p>{{ __('messages.call_log_description') }}</p>
                            <span class="text-uppercase mb-3">{{ __('messages.call_log_features') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contacts -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-address-book text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.contacts') }}</h3>
                            <p>{{ __('messages.contacts_description') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Accounts -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.accounts') }}</h3>
                            <p>{{ __('messages.accounts_description') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Applications -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-th text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.applications') }}</h3>
                            <p>{{ __('messages.applications_description') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Screen Monitor -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-desktop text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.screen_monitor') }}</h3>
                            <p>{{ __('messages.screen_monitor_description') }}</p>
                            <span class="text-uppercase">{{ __('messages.screen_monitor_features') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Screen Reader -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-eye text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.screen_reader') }}</h3>
                            <p>{{ __('messages.screen_reader_description') }}</p>
                            <span class="text-uppercase">{{ __('messages.screen_reader_features') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-video text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.camera_monitor') }}</h3>
                            <p>{{ __('messages.camera_monitor_description') }}</p>
                            <span class="text-uppercase">{{ __('messages.camera_monitor_features') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-microphone text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.microphone_monitor') }}
                            </h3>
                            <p>{{ __('messages.microphone_monitor_description') }}</p>
                            <span class="text-uppercase">{{ __('messages.microphone_monitor_features') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-chart-line text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.activities_monitor') }}
                            </h3>
                            <p>{{ __('messages.activities_monitor_description') }}</p>
                            <span class="text-uppercase">{{ __('messages.activities_monitor_features') }}</span>
                        </div>
                    </div>
                </div>


                <!-- Location Monitor -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-map-marker-alt text-primary" style="font-size: 32px;"></i>
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3" style="color:red">{{ __('messages.location_monitor') }}</h3>
                            <p>{{ __('messages.location_monitor_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Price Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="bg-secondary h-100 d-flex flex-column justify-content-center p-5">
                        <h1 class="text-uppercase mb-4" style="color:red">{{ __('messages.pricing_title') }}</h1>
                        <div>
                            <div class=" border-bottom py-2">
                                <h6 class="text-uppercase" style="font-size: 25px">•
                                    {{ __('messages.pricing_live_alerts') }}</h6>
                                <span
                                    class="text-uppercase mb-0">{{ __('messages.pricing_live_alerts_details_1') }}</span><br>
                                <span
                                    class="text-uppercase mb-0">{{ __('messages.pricing_live_alerts_details_2') }}</span><br>
                                <span
                                    class="text-uppercase mb-0">{{ __('messages.pricing_live_alerts_details_3') }}</span><br>
                            </div>
                            <div class=" border-bottom py-2">
                                <h6 class="text-uppercase" style="font-size: 25px">•
                                    {{ __('messages.pricing_apk_builder') }}</h6>
                                <span
                                    class="text-uppercase mb-0">{{ __('messages.pricing_apk_builder_details_1') }}</span><br>
                                <span
                                    class="text-uppercase mb-0">{{ __('messages.pricing_apk_builder_details_2') }}</span><br>
                            </div>
                            <div class=" border-bottom py-2">
                                <h6 class="text-uppercase " style="font-size: 25px">• {{ __('messages.pricing_apk') }}
                                </h6>
                                <span class="text-uppercase mb-0">{{ __('messages.pricing_apk_details') }}</span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100">
                        <img class="img-fluid h-75" src="img/web_3.jfif" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Price End -->


    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{ __('messages.purchase') }}</p>
                <h1 class="text-uppercase">{{ __('messages.purchase_choose_version') }}</h1>
            </div>
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid" src="img/web_2.jpg" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href="{{ route('btcpay.pay', ['plan_id' => 1]) }}"
                            ><i class="fa fa-share"></i></a>
                            </div>
                        </div>
                        <div class="bg-secondary text-center p-4" style="min-height: 200px; overflow-y: auto;">
                            <h5 class="text-uppercase">{{ __('messages.purchase_personal_license') }}</h5>
                            <span class="text-primary">{{ __('messages.purchase_personal_price') }}</span>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid" src="img/web_3.jpg" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href="{{ route('pay') }}"><i class="fa fa-share"></i></a>
                            </div>
                        </div>
                        <div class="bg-secondary text-start p-4" style="max-height: 200px; overflow-y: auto;">
                            <h5 class="text-uppercase">{{ __('messages.purchase_custom_license') }}</h5>
                            <span class="text-primary">{{ __('messages.purchase_custom_price') }}</span>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid" src="img/web_1.jpg" alt="">
                            <div class="team-social">
                                <a class="btn btn-square" href="{{ route('pay') }}"><i class="fa fa-share"></i></a>
                            </div>
                        </div>
                        <div class="bg-secondary text-center p-4" style="min-height: 200px; overflow-y: auto;">
                            <h5 class="text-uppercase">{{ __('messages.purchase_full_source_code') }}</h5>
                            <span class="text-primary">{{ __('messages.purchase_full_source_code_price') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->



    <!-- Working Hours Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100">
                        <img class="img-fluid h-100" src="img/web_3.jfif" alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-secondary h-100 d-flex flex-column justify-content-center p-5">
                        <p class="d-inline-flex bg-dark text-primary py-1 px-4 me-auto">
                            {{ __('messages.working_hours_title') }}</p>
                        <h1 class="text-uppercase mb-4">{{ __('messages.working_hours_description') }}</h1>
                        <div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">{{ __('messages.working_hours_website_users') }}</h6>
                                <span class="text-uppercase">{{ $visitors }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">{{ __('messages.working_hours_purchases') }}</h6>
                                <span class="text-uppercase">{{ $users - 1 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Working Hours End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{ __('messages.testimonial_title') }}</p>
                <h1 class="text-uppercase">{{ __('messages.testimonial_clients_say') }}</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_1') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_2') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_3') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_4') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_5') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_6') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_7') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_8') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_9') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_10') }}</span>
                </div>
                <div class="testimonial-item text-center" data-dot="<span class='dot'></span>">
                    <span class="fs-5">{{ __('messages.recommend_11') }}</span>
                </div>
            </div>
            <center>
                <div class="d-flex pt-1 m-n1 justify-content-center">
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="https://t.me/craxsosp"><i
                            class="fab fa-telegram"></i></a>
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="#"><i
                            class="fab fa-instagram"></i></a>
                    <a class="btn btn-lg-square btn-dark text-primary m-1" href="#"><i
                            class="fab fa-facebook"></i></a>
                </div>
            </center>
        </div>
    </div>
    <!-- Testimonial End -->

@endsection


<script>
    // دالة فتح نافذة الفيديو
    function openVideoModal(videoUrl) {
        var modal = document.getElementById("videoModal");
        var modalVideo = document.getElementById("modalVideo");

        // تعيين مصدر الفيديو
        modalVideo.src = videoUrl;

        // عرض النافذة
        modal.style.display = "block";

        // تشغيل الفيديو
        modalVideo.play();
    }

    // دالة إغلاق نافذة الفيديو
    function closeVideoModal() {
        var modal = document.getElementById("videoModal");
        var modalVideo = document.getElementById("modalVideo");

        // إيقاف الفيديو
        modalVideo.pause();

        // إخفاء النافذة
        modal.style.display = "none";
    }

    // إغلاق النافذة عند النقر خارج نطاق الفيديو
    window.onclick = function(event) {
        var modal = document.getElementById("videoModal");
        if (event.target == modal) {
            closeVideoModal();
        }
    }
</script>
<script>
    function openVideoWindow(videoUrl) {
        // Define the new window's features (size, no scrollbars, etc.)
        const windowFeatures = "width=800,height=600,resizable=yes,scrollbars=no";

        // Open a new window and write the HTML content with the video
        const newWindow = window.open("", "_blank", windowFeatures);
        if (newWindow) {
            newWindow.document.write(`
                <html>
                    <head>
                        <title>Video Player</title>
                        <style>
                            body {
                                margin: 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                background-color: #000;
                                height: 100vh;
                            }
                            video {
                                max-width: 100%;
                                max-height: 100%;
                            }
                        </style>
                    </head>
                    <body>
                        <video controls autoplay style="width: 100%; height: auto;">
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </body>
                </html>
            `);
            newWindow.document.close();
        } else {
            alert("Popup blocked! Please allow popups for this site.");
        }
    }
</script>
