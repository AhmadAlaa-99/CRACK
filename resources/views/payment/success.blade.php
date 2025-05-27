<!-- resources/views/payment/success.blade.php -->
@extends('layouts.master')

@section('title', 'Home')
@section('content')
<style>
    .bg-success {
    background-color: #495057 !important;
}
.card {

    margin: 18px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>{{ __('Payment Successful') }}</h3>
                </div>

                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle fa-2x mr-2"></i>
                        {{ __('Your payment was successful!') }}
                    </div>

                
                    <div class="text-center mt-4">
                        <a href="{{ $downloadUrl }}" class="btn btn-primary btn-lg">
                            <i class="fa fa-download mr-2"></i> {{ __('Download Your File') }}
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('index') }}" class="btn btn-link">
                            {{ __('Return to Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 