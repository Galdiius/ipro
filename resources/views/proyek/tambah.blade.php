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
                                <h3 class="mb-0">Tambah proyek</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama proyek</label>
                                                <input type="text" placeholder="Masukan nama proyek..." class="form-control" name="nama" value="{{ old('nama') }}">
                                                @error('nama')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama PIC</label>
                                                <input type="text" placeholder="Masukan nama PIC..." class="form-control" name="nama_pic" value="{{ old('nama_pic') }}">
                                                @error('nama_pic')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Email </label>
                                                <input type="text" placeholder="Masukan email..." class="form-control" name="email" value="{{ old('email') }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Alamat</label>
                                        <textarea placeholder="Masukan alamat..." class="form-control" name="alamat">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
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
                                                <label class="form-control-label">Kategori</label>
                                                <input type="text" placeholder="Masukan kategori" class="form-control" name="kategori" value="{{ old('kategori') }}">
                                                @error('kategori')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Material</label>
                                                <input type="text" placeholder="Masukan material..." class="form-control" name="material" value="{{ old('material') }}">
                                                @error('material')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Capex </label>
                                                <input type="number" placeholder="Masukan capex(Rp)" class="form-control" name="capex" value="{{ old('capex') }}">
                                                @error('capex')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Opex </label>
                                                <input type="number" placeholder="Masukan opex(Rp)" class="form-control" name="opex" value="{{ old('opex') }}">
                                                @error('opex')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <h6 class="heading-small text-muted mb-4">Jangka waktu</h6>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Start </label>
                                                <input type="date" name="start" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">End </label>
                                                <input type="date" name="end" class="form-control">
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
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Password</label>
                                                <input type="password" placeholder="Masukan password..." class="form-control" name="password">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">konfirmasi password</label>
                                                <input type="password" name="konfirmasiPassword" placeholder="Konfirmasi password..." class="form-control">
                                                @error('konfirmasiPassword')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
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
            {{-- <div class="col-xl-4 order-xl-2">
                <div class="card p-3">
                    <iframe
                        id="maps"
                        height="450"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCG42x9_Qwd44qK_ZopjRQcTdlAjn0G724
                            &q={{ $user->koordinat }}">
                    </iframe>
                </div>
            </div> --}}
        </div>
    </div>
</div>
{{-- <script>
    let koordinat = document.getElementById('koordinat')
    let maps = document.getElementById('maps')
    koordinat.addEventListener('keyup',function(){
        maps.src = `https://www.google.com/maps/embed/v1/place?key=AIzaSyCG42x9_Qwd44qK_ZopjRQcTdlAjn0G724&q=${koordinat.value}`
    })
</script> --}}
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