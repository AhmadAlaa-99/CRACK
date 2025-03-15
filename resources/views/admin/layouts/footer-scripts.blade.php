<!--   Core JS Files   -->
<script src="{{ \Illuminate\Support\Facades\URL::asset('assets/js/core/popper.min.js')}}" ></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('assets/js/core/bootstrap.min.js')}}" ></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('assets/js/plugins/perfect-scrollbar.min.js')}}" ></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('assets/js/plugins/smooth-scrollbar.min.js')}}" ></script>



<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>



<!-- Nepcha Analytics (nepcha.com) -->
<!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
<script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

@yield('scripts')
