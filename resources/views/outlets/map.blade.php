@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body" id="mapid"></div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 630px; width: 1335px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([-8.703537179417122, 115.21847565025823], 15);
    var baseUrl = "{{ url('/') }}";

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var myHouse = L.icon({
        iconUrl: 'img/marker-house.png',
        iconSize: [45, 45],
    });

    var mySchool = L.icon({
        iconUrl: 'img/marker-school.png',
        iconSize: [45, 45],
    }); 

    var myStore = L.icon({
        iconUrl: 'img/marker-store.png',
        iconSize: [45, 45],
    });

    axios.get('{{ route('api.outlets.index') }}')
    .then(function (response) {
        // console.log(response.data);
        var point_type = response.data;
        // console.log(point_type);

        point_type.getFeaturesByProperty = function(key, value) {
            return this.features.filter(function(feature){
                if (feature.properties[key] === value){
                    return true;
                } else {
                    return false;
                }
            
            })
        }

        // RUMAH 
        L.geoJSON(point_type.getFeaturesByProperty('type', 'house'), {
            pointToLayer: function(geoJsonPoint, latlng) {
                return L.marker(latlng,{
                    icon: myHouse,
                    draggable: false
                }).addTo(map);            
            }
        })
        .bindPopup(function (layer) {
            return layer.feature.properties.map_popup_content;
        }).addTo(map);

        // TOKO
        L.geoJSON(point_type.getFeaturesByProperty('type', 'store'), {
            pointToLayer: function(geoJsonPoint, latlng) {
                return L.marker(latlng,{
                    icon: myStore,
                    draggable: false
                }).addTo(map);            
            }
        })
        .bindPopup(function (layer) {
            return layer.feature.properties.map_popup_content;
        }).addTo(map);

        // SEKOLAH
        L.geoJSON(point_type.getFeaturesByProperty('type', 'school'), {
            pointToLayer: function(geoJsonPoint, latlng) {
                return L.marker(latlng,{
                    icon: mySchool,
                    draggable: false
                }).addTo(map);            
            }
        })
        .bindPopup(function (layer) {
            return layer.feature.properties.map_popup_content;
        }).addTo(map);

    })
    .catch(function (error) {
        console.log(error);
    });

    // ada yg hilang disini (authorization)
    var theMarker;

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);

        if (theMarker != undefined) {
            map.removeLayer(theMarker);
        };

        var popupContent = `
        <div class="container">
            <div class="row">
                <div class="cell merged" style="text-align:center">Latitude</div>
            </div>
            <div class="row mb-3">
                <input type="text" class="form-control" name="latitude" value="`+ latitude +`">
            </div>
            <div class="row">
                <div class="cell merged" style="text-align:center">Longitude</div>
            </div>
            <div class="row">
                <input type="text" class="form-control" name="longitude" value="`+ longitude + `">
            </div>
        </div>
        `;
        popupContent += '<br><a class="btn btn-primary" style="color:white;" href="{{ route('outlets.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Tambah Data Lokasi</a>';

        theMarker = L.marker([latitude, longitude]).addTo(map);
        theMarker.bindPopup(popupContent)
        .openPopup();
    });
    
    axios.get('{{ route('api.outlets.index') }}')
    .then(function (response) {
        // console.log(response.data);
        var point_type = response.data;
        // console.log(point_type);
        
        })
    .catch(function (error) {
        console.log(error);
    });
    
    var coordinates = [];
    for (var i = 0; i < databaseValues.length; i++) {
      var latlng = L.latLng(databaseValues[i].latitude, databaseValues[i].longitude);
      coordinates.push(latlng);
    }

    var polyline = L.polyline(coordinates, {
      color: 'red',
      weight: 3,
      opacity: 0.5
    }).addTo(map);

    // ada yg hilang disini (authorization)
</script>
@endpush
