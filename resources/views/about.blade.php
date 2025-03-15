@extends('layouts.master')  {{-- Assuming master.blade.php is in the layouts folder --}}

@section('title', 'About')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-primary text-uppercase mb-3 animated slideInDown">{{__('messages.about')}}</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column">
                    <video id="video1" class="img-fluid w-100 align-self-end" autoplay loop muted>
                    <source src="{{ asset('videos/about_video.mp4') }}" type="video/mp4">
                    {{__('messages.carousel_browser_support')}}
        </video>
                    
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="d-inline-block bg-secondary text-primary py-1 px-4">{{__('messages.about_us')}}</p>
                    <h1 class="text-uppercase mb-4" style="color:red">{{__('messages.about_title')}}</h1>
                    <p>{{__('messages.about_description')}}</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{__('messages.about_backup')}}</h3>
                            <p class="mb-0">{{__('messages.about_backup_description')}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{__('messages.about_compatibility')}}</h3>
                            <p class="mb-0">{{__('messages.about_compatibility_description')}}</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{__('messages.about_send_receive')}}</h3>
                            <p class="mb-0">{{__('messages.about_send_receive_description')}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3" style="color:red">{{__('messages.about_communication')}}</h3>
                            <p class="mb-0">{{__('messages.about_communication_description')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

@endsection
