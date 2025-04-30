<style>
/* Modal Styles */
.modal-content.bg-dark {
    background-color: #2a2a2a; /* Dark background color */
}

.modal-header .modal-title {
    color: #f8f9fa; /* Light title color */
    font-weight: bold;
}

.modal-body .form-label {
    color: #cccccc; /* Slightly off-white label text */
}

.modal-body .form-control {
    background-color: #343a40; /* Dark input background */
    color: #f8f9fa; /* Light input text color */
}

.btn-primary {
    background-color: #ff3d3d; /* Red button color for actions */
    border: none;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #e63946; /* Slightly darker red on hover */
}

.modal-footer .btn-primary {
    width: 100%; /* Full width for buttons in modal */
    text-transform: uppercase; /* Match uppercase style */
}

.btn-close-white {
    filter: invert(1); /* White close button for dark background */
}

.btn-close-white:hover {
    filter: invert(0.8); /* Slightly dim close button on hover */
}

.bg-secondary {
    background-color: #495057 !important; /* Dark gray for input fields */
}

.text-light {
    color: #f8f9fa !important; /* Light color for text */
}

.navbar-brand img {
    max-width: 200px; /* Adjust as needed */
    height: auto; /* Maintain aspect ratio */
}

</style>
<nav class="navbar navbar-expand-lg bg-secondary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <a href="{{ route('index') }}" class="navbar-brand ms-4 ms-lg-0">
        <h1 class="mb-0 text-primary text-uppercase"><img src="img/logo.png" width="100px" height="auto" alt="Craxsrat Logo" style="margin-right:10px">
        {{ __('messages.Craxsrat') }}</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('index') }}" class="nav-item nav-link @yield('active-home', '')">{{ __('messages.home') }}</a>
            <a href="{{ route('about') }}" class="nav-item nav-link @yield('active-about', '')">{{ __('messages.about') }}</a>
            <a href="{{ route('pay') }}" class="nav-item nav-link @yield('active-service', '')">{{ __('messages.purchase') }}</a>


            <!-- Authentication Links -->
            @guest

            <a href="#"  data-bs-toggle="modal" data-bs-target="#loginModal" class="nav-item nav-link">Login</a>


            @else
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu m-0">
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profileModal">{{ __('messages.Profile') }}</a>
                        <a href="{{ route('logout') }}"
                           class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           {{__('messages.logout')}}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
            <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Select Your Language </a>
                    <div class="dropdown-menu m-0">
                        <a href="{{route('change-language','en')}}" class="dropdown-item">{{ __('messages.English') }}</a>
                        <a href="{{route('change-language','ar')}}" class="dropdown-item">{{ __('messages.Arabic') }}</a>
                        <a href="{{route('change-language','ch')}}" class="dropdown-item">{{ __('messages.Chinese') }}</a>

                    </div>
                </div>
        </div>
    </div>
</nav>
@guest
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-uppercase" id="loginModalLabel">{{__('messages.login')}}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label text-light">{{__('messages.email')}}</label>
                        <input type="email" class="form-control bg-secondary text-light border-0" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-light">{{__('messages.password')}}</label>
                        <input type="password" class="form-control bg-secondary text-light border-0" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 text-uppercase py-2">{{__('messages.login')}}</button>
                    <!-- Link to open Register Modal -->
                    <p class="text-center mt-3">
                        <span class="text-light">{{__('messages.no_account')}}</span>
                        <a href="#" class="text-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Create Account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<!-- Update the register modal in your navigation file -->
<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-uppercase" id="registerModalLabel">{{__('messages.register')}}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Alert explaining OTP verification -->
                    <div class="alert alert-info mb-4">
                        {{__('messages.otp_verification_notice')}}
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label text-light">{{__('messages.name')}}</label>
                        <input type="text" class="form-control bg-secondary text-light border-0" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-light">{{__('messages.email')}}</label>
                        <input type="email" class="form-control bg-secondary text-light border-0" id="email" name="email" required>
                        <small class="text-info">{{__('messages.verification_code_will_be_sent')}}</small>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label text-light">{{__('messages.city')}}</label>
                        <select name="city" id="city" class="form-control bg-secondary text-light border-0" >
                            <option value="">{{__('messages.select_country')}}</option>
                            <!-- Country options remain the same -->
                            <option value="Algeria">{{__('messages.Algeria')}}</option>
                            <!-- Other countries... -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-light">{{__('messages.password')}}</label>
                        <input type="password" class="form-control bg-secondary text-light border-0" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-light">{{__('messages.confirm_password')}}</label>
                        <input type="password" class="form-control bg-secondary text-light border-0" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 text-uppercase py-2">{{__('messages.register')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@else
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">{{__('messages.your_profile')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>{{__('messages.name')}}:</strong> {{ Auth::user()->name }}</p>
                <p><strong>{{__('messages.email')}}</strong> {{ Auth::user()->email }}</p>
                <!-- Add other profile details here if needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>
@endguest
