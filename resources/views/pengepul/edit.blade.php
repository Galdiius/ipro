@extends('layouts/header')

@include('layouts/sidenav')
<div class="main-content" id="panel">
    @include('layouts/topnav')

    <!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-lg-6 col-7">
          <h6 class="h2  d-inline-block mb-0">Edit pengepul</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="/pengepul">Pengepul</a></li>
              <li class="breadcrumb-item"><a>Edit</a></li>
              </ol>
          </nav>
        </div>
        <div class="col-xl-8 order-xl-1">
            @if (session('message'))
                <div class="alert alert-{{ session("message")["type"] }}">{{ session('message')["message"] }}</div>
            @endif
          <div class="card">
            {{-- <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Pengepul</h3>
                </div>
              </div>
            </div> --}}
            <div class="card-body">
              <form action="/pengepul/edit" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $pengepul->id_user }}">
                <h6 class="heading-small text-muted mb-4">Informasi user</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label" for="input-username">Nama petugas</label>
                            <input type="text" id="input-username" class="form-control" name="nama" placeholder="Username" value="{{ old('nama',$pengepul->nama_petugas) }}">
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label" for="input-username">Nama perusahaan</label>
                            <input type="text" id="input-username" class="form-control" name="namaPerusahaan" placeholder="Username" value="{{ old('namaPerusahaan',$pengepul->nama_perusahaan) }}">
                            @error('namaPerusahaan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" placeholder="Email" class="form-control" name="email" value="{{ old('email',$pengepul->email) }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Informasi kontak</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Alamat</label>
                        <input id="input-address" class="form-control" name="alamat" placeholder="Alamat" value="{{ old('alamat',$pengepul->alamat) }}" type="text">
                        @error('alamat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="no">No telepon</label>
                        <input type="number" id="no" class="form-control" placeholder="No telepon" name="no_telepon" value="{{ old('no_telepon',$pengepul->no_hp) }}">
                        @error('no_telepon')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
                
                <hr class="my-4">
                <h6 class="heading-small text-muted mb-4">Informasi keamanan</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <label class="form-control-label" for="password">Password</label>
                            <div class="input-group">
                                <input class="form-control" id="password" placeholder="Home Address" name="password" value="{{ old('password',$user->password) }}" type="password" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-show-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button" style="display:none" id="btn-hide-password">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                  </div>
                            </div>
                        </div> --}}
                        <div class="col-md-12 mt-3" id="form-new-password">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" class="form-control-label">Password baru</label>
                                        <input type="password" class="form-control" id="newPasswordInput" name="newPassword">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="" class="form-control-label">konfirmasi password baru</label>
                                        <input type="password" class="form-control" id="confNewPasswordInput" name="confirmNewPassword">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <button class="btn btn-primary" id="btn-ubah-password" type="button" id="btn-ubah-password">Ubah password</button>
                                <button class="btn btn-danger" id="btn-batal" type="button" id="btn-batal">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <button class="btn btn-success text-white">Edit profile</button>
                        </div>
                    </div>
                </div>

              </form>
            </div>
          </div>
        </div>

        
      </div>
    </div>
  </div>
{{-- show hide password --}}
  {{-- <script>   
      let password = document.getElementById('password')
      let btnShow = document.getElementById('btn-show-password')
      let btnHide = document.getElementById('btn-hide-password')
      btnShow.addEventListener('click',function(){
          btnHide.style.display = "block"
          btnShow.style.display = "none"
          password.type = "text"

      })
      btnHide.addEventListener("click",function(){
          btnShow.style.display = "block"
          btnHide.style.display = "none"
          password.type = "password"
      })
  </script> --}}
  {{-- show hide form ubah password --}}
  <script>
    let formNewPassword = document.getElementById("form-new-password")
    let btnBatal = document.getElementById("btn-batal")
    let btnUbahPassword = document.getElementById("btn-ubah-password")
    let newPasswordInput = document.getElementById("newPasswordInput")
    let confNewPasswordInput = document.getElementById("confNewPasswordInput")
    formNewPassword.style.display = "none"
    btnBatal.style.display = "none"
    btnUbahPassword.addEventListener("click",function(){
        formNewPassword.style.display = "block"
        btnBatal.style.display = "block"
        btnUbahPassword.style.display = "none"
    })
    btnBatal.addEventListener("click",function(){
        newPasswordInput.value = ""
        confNewPasswordInput.value = ""
        formNewPassword.style.display = "none"
        btnBatal.style.display = "none"
        btnUbahPassword.style.display = "block"
    })
  </script>
  <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyAYnW2QhI8UCUA7RXpmdWnTszqGnLTHtvI&libraries=places'></script>
  <script>
    function updateMarkerPosition(latLng) {
        document.getElementById('latlong').setAttribute('value',[latLng.lat()]+' '+[latLng.lng()]) 
    }
        
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: new google.maps.LatLng(<?= explode(' ',$pengepul->koordinat)[0] ?>, <?= explode(' ',$pengepul->koordinat)[1] ?>),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    //posisi awal marker   
    var latLng = new google.maps.LatLng(<?= explode(' ',$pengepul->koordinat)[0] ?>, <?= explode(' ',$pengepul->koordinat)[1] ?>);
    
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