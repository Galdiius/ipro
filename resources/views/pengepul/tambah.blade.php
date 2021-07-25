@extends('layouts/header')

@include('layouts/sidenav')

<div class="main-content">
    @include('layouts/topnav')
    <div class="container-fluid mt-6">
        <div class="row">
            <div class="col-lg-6 col-7">
                <h6 class="h2  d-inline-block mb-0">Tambah pengepul</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="/pengepul">Pengepul</a></li>
                    <li class="breadcrumb-item"><a>Tambah</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-8 order-xl-1">
                @if (session('message'))    
                    <div class="alert alert-{{ session('message')["type"] }}">{{ session('message')["message"] }}</div>
                @endif
                <div class="card">
                    {{-- <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Tambah pengepul</h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama petugas</label>
                                                <input type="text" placeholder="Masukan nama petugas..." class="form-control" name="namaPetugas" value="{{ old('namaPetugas') }}">
                                                @error('namaPetugas')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama nama perusahaan</label>
                                                <input type="text" placeholder="Masukan nama perusahaan..." class="form-control" name="namaPerusahaan" value="{{ old('namaPerusahaan') }}">
                                                @error('namaPerusahaan')
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
                                                <label class="form-control-label">No telepon </label>
                                                <input type="number" placeholder="Masukan no telepon..." class="form-control" name="no_telepon" value="{{ old('no_telepon') }}">
                                                @error('no_telepon')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option disabled selected>Pilih status</option>
                                                    @foreach ($status as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Kategori</label>
                                                <select name="kategori" class="form-control">
                                                    <option disabled selected>Pilih kategori</option>
                                                    @foreach ($kategori as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kategori')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (session('level') == 'proyek')
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Mitra</label>
                                                    <select name="mitra" class="form-control">
                                                        <option selected disabled>Pilih mitra</option>
                                                        @foreach ($mitra as $v)
                                                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('mitra')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
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