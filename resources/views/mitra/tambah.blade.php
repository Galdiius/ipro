@extends('layouts/header')

@include('layouts/sidenav')
<div class="main-content">
    @include('layouts/topnav')
    <div class="container-fluid mt-6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                @if (session('message'))    
                    <div class="alert alert-{{ session('message')["type"] }}">{{ session('message')["message"] }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Tambah mitra</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Nama </label>
                                        <input type="text" placeholder="Masukan nama..." class="form-control" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Alamat </label>
                                        <textarea type="text" placeholder="Masukan alamat..." class="form-control" name="alamat">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">No telepon </label>
                                                <input type="number" placeholder="Masukan no telepon..." class="form-control" name="no_telepon" value="{{ old('no_telepon') }}">
                                                @error('no_telepon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Proyek</label>
                                                <select name="proyek" class="form-control">
                                                    @foreach ($proyek as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Koordinat </label>
                                        <div id="map" style="width: 100%;height: 480px;"></div>
                                        <input type="text" placeholder="Masukan koordinat..." class="form-control" id="latlong" name="koordinat" readonly>
                                        @error('koordinat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success">Tambah</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyAYnW2QhI8UCUA7RXpmdWnTszqGnLTHtvI&libraries=places'></script>
<script>
    function updateMarkerPosition(latLng) {
        document.getElementById('latlong').setAttribute('value',[latLng.lat()]+' '+[latLng.lng()]) 
    }
        
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: new google.maps.LatLng(-6.174858376282209, 106.82717364762975),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    //posisi awal marker   
    var latLng = new google.maps.LatLng(-6.174858376282209, 106.82717364762975);
    
    /* buat marker yang bisa di drag lalu 
    panggil fungsi updateMarkerPosition(latLng)
    dan letakan posisi terakhir di id=latitude dan id=longitude
    */
    var marker = new google.maps.Marker({
        position : latLng,
        title : 'lokasi',
        map : map,
        draggable : true
    });
    
    updateMarkerPosition(latLng);
    google.maps.event.addListener(marker, 'drag', function() {
        console.log(marker.getPosition())
        updateMarkerPosition(marker.getPosition());
    });
</script>