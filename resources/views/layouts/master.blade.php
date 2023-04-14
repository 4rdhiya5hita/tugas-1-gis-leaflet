<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leaflet') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ secure_asset('Leaflet.markercluster-1.4.1/dist/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css') }}" rel="stylesheet"> -->
    @yield('styles')    
</head>
<body>
    <div id="app">

    <main style="margin: 10px;">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
    </div>
    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <!-- <script src="{{ secure_asset('Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js') }}"></script>
    <script src="{{ secure_asset('Leaflet.markercluster-1.4.1/src/MarkerCluster.js') }}"></script> -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @stack('scripts')
</body>
</html>