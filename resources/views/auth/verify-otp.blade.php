<!-- resources/views/auth/verify-otp.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-light">
                <div class="card-header border-0">
                    <h3 class="text-uppercase text-center">{{ __('messages.verify_your_email') }}</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <p class="text-center mb-4">{{ __('messages.otp_sent_to_email') }}</p>

                    <form method="POST" action="{{ route('verify.otp') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="otp" class="form-label">{{ __('messages.verification_code') }}</label>
                            <input id="otp" type="text" class="form-control bg-secondary text-light border-0 @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autofocus>

                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 text-uppercase py-2">
                                {{ __('messages.verify') }}
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>{{ __('messages.didnt_receive_code') }}
                            <a href="{{ route('resend.otp') }}" class="text-primary">
                                {{ __('messages.resend_code') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
