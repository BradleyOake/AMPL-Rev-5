<!doctype html>
<html>
    <head>
        <title>@yield('title')</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta name="author" content="AMPL Publishing">
        <meta name="_token" content="[!! csrf_token() !!]"/>

        @yield('metatags')

        @yield('css')

        <!-- AMPL Icon -->
        <link rel="shortcut icon" href="[[asset('/images/AMPL-logo5.png')]]">

        <link href="[[ URL::asset('css/main.css') ]]" rel="stylesheet">
        <script src="https://apis.google.com/js/api:client.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="[[ URL::asset('js/main.js') ]]"></script>
    </head>


    <body ng-app="myApp">
        <div id="fb-root">
        </div>
            
        @include('navbar')
        <div ng-controller="cartCtrl" style="min-height:84%;">
            @include('cart.cart')

            @if(!Auth::User())

            @include('modals.login')
            @include('modals.registration')
            @include('modals.password_reset')

            @endif

            <br><br>
            @yield('content')
        </div>
        @include('footer')

        @if(!Auth::User())
            <script src="[[ URL::asset('js/authentication.js') ]]"></script>
        @endif

        @yield('scripts')
    </body>
</html>
