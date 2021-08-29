<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://use.fontawesome.com/c3bd807fb1.js"></script>
    <script src="https://kit.fontawesome.com/2d332e0009.js" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">

</head>
<body>
<div id="app">
    <main class="py-4">
        @include('layouts.header')

        @yield('content')

        @if (Route::currentRouteName() !== 'freelancer.index' && Route::currentRouteName() !== 'freelancer.search')
            @include('layouts.footer')
        @endif
    </main>
</div>

<!-- Scripts -->
<script>
    (function () {
        let userAvatar = document.getElementById('user-avatar');
        let dropDownuserAvatar = document.getElementById('dropdown-user-avatar');
        let setStatusOnline = document.getElementById('set-status-online');
        let setStatusOffline = document.getElementById('set-status-offline');

        if (sessionStorage.getItem('activityStatus') === 'online') {
            // Removing offline status in class
            userAvatar.classList.remove('status-offline');
            dropDownuserAvatar.classList.remove('status-offline');

            // Switching current status
            setStatusOffline.classList.remove('current-status');
            setStatusOnline.classList.add('current-status');

            // Adding online status in class
            userAvatar.classList.add('status-online');
            dropDownuserAvatar.classList.add('status-online');
        } else {
            // Removing online status in class
            userAvatar.classList.remove('status-online');
            dropDownuserAvatar.classList.remove('status-online');

            // Switching current status
            setStatusOnline.classList.remove('current-status');
            setStatusOffline.classList.add('current-status');

            // Adding offline status in class
            userAvatar.classList.add('status-offline');
            dropDownuserAvatar.classList.add('status-offline');
        }
    })();
</script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.3.2.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function () {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',
            backgroundColor: '#383838'
        });
    });
</script>
<script>
    // Change Activity Status in navbar
    let setStatusOnline = document.getElementById('set-status-online');
    let setStatusOffline = document.getElementById('set-status-offline');
    let userAvatar = document.getElementById('user-avatar');
    let dropDownuserAvatar = document.getElementById('dropdown-user-avatar');

    setStatusOnline.addEventListener('click', () => {
        userAvatar.classList.remove('status-offline');
        dropDownuserAvatar.classList.remove('status-offline');

        sessionStorage.setItem('activityStatus', 'online');

        userAvatar.classList.add('status-online');
        dropDownuserAvatar.classList.add('status-online');
    });

    setStatusOffline.addEventListener('click', () => {
        userAvatar.classList.remove('status-online');
        dropDownuserAvatar.classList.remove('status-online');

        sessionStorage.setItem('activityStatus', 'offline');

        userAvatar.classList.add('status-offline');
        dropDownuserAvatar.classList.add('status-offline');

    })
</script>
</body>
</html>
