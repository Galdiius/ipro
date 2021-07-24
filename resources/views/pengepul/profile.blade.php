@extends('layouts/header')
@section('content')
@include('layouts/sidenav')
<div class="main-content" id="panel">
    @include('layouts/topnav')

    <!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        
        <div class="col-lg-6 col-7">
          <h6 class="h2 d-inline-block mb-0">Profile</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="/pengepul">Pengepul</a></li>
              <li class="breadcrumb-item"><a>Profile</a></li>
              </ol>
          </nav>
      </div>

        <div class="col-xl-8 order-xl-1">
          <div class="card">
            {{-- <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Profile </h3>
                </div>
              </div>
            </div> --}}
            <div class="card-body">
              <form>
                @csrf
                <h6 class="heading-small text-muted mb-4">Informasi user</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Nama</label>
                        <input type="text" id="input-username" class="form-control" placeholder="Username" value="{{ $pengepul->nama_petugas }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" class="form-control" value="{{ $pengepul->email == '' ? 'Belum ada email' : $pengepul->email }}" disabled>
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
                        <input id="input-address" class="form-control" placeholder="Home Address" value="{{ $pengepul->alamat == '' ? 'Belum ada alamat' : $pengepul->alamat }}" type="text" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">No telepon</label>
                        <input type="text" id="input-city" class="form-control" placeholder="No hp" value="{{ $pengepul->no_hp }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Koordinat</label>
                        <input type="text" id="input-country" class="form-control" placeholder="Country" value="{{ $pengepul->koordinat }}" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-xl-4 order-xl-2">
            <div class="card p-3">
                <iframe
                    height="450"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCG42x9_Qwd44qK_ZopjRQcTdlAjn0G724
                        &q={{ $pengepul->koordinat }}">
                </iframe>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection