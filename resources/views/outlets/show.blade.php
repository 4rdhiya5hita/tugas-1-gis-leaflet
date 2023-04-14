@extends('layouts.master')

@section('title', __('outlet.detail'))

@section('content')
<div style="background-image: url('/img/bg-peta.jpg'); background-size: cover; height:625px; padding-top:10px;">

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
        <div class="card-header bg-primary font-weight-bold" style="color: white; font-size:large;">{{ __('outlet.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm" style="margin: 0;">
                    <tbody>
                            <tr><td>{{ __('outlet.name') }}</td><td>{{ $outlet->name }}</td></tr>
                            <tr><td>{{ __('outlet.address') }}</td><td>{{ $outlet->address }}</td></tr>
                        @if ($outlet->type == 'school')
                                <tr><td>{{ __('outlet.akreditas') }}</td><td>{{ $schools->akreditas }}</td></tr>
                                <tr><td>{{ __('outlet.jenjang') }}</td><td>{{ $schools->jenjang }}</td></tr>
                                <tr><td>{{ __('outlet.jumlah_siswa') }}</td><td>{{ $schools->jumlah_siswa }}</td></tr>
                        @endif
                            <tr><td>{{ __('outlet.latitude') }}</td><td>{{ $outlet->latitude }}</td></tr>
                            <tr><td>{{ __('outlet.longitude') }}</td><td>{{ $outlet->longitude }}</td></tr>
                    </tbody>
                </table>
            </div>
            <!-- <div class="card-header">{{ trans('outlet.location') }}</div> -->
            @if ($outlet->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('outlet.no_coordinate') }}</div>
            @endif

            <div class="card-footer">
                <a href="{{ route('outlets.edit', $outlet) }}" id="edit-outlet-{{ $outlet->id }}" class="btn btn-primary">{{ __('outlet.edit') }}</a>
                <!-- <a href="{{ route('outlets.index') }}" class="btn btn-outline-primary">{{ __('outlet.back_to_index') }}</a> -->
                <a href="{{ route('outlet_map.index') }}" class="btn btn-outline-primary">{{ __('app.back_to_map') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 200px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $outlet->latitude }}, {{ $outlet->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $outlet->latitude }}, {{ $outlet->longitude }}]).addTo(map)
        .bindPopup('{!! $outlet->map_popup_content !!}');
</script>
@endpush
