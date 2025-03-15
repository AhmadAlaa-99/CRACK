<title>
    @yield('title')
</title>

<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

<!-- Nucleo Icons -->
<link href="{{ \Illuminate\Support\Facades\URL::asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
<link href="{{ \Illuminate\Support\Facades\URL::asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />

<link rel="apple-touch-icon" sizes="76x76" href="{{ \Illuminate\Support\Facades\URL::asset('assets/img/apple-icon.png')}}">

<link rel="icon" type="image/png" href="{{ \Illuminate\Support\Facades\URL::asset('assets/img/favicon.png')}}">

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<!-- CSS Files -->

<link id="pagestyle" href="{{ \Illuminate\Support\Facades\URL::asset('assets/css/material-dashboard.css?v=3.1.0')}}" rel="stylesheet" />

@yield('css')
