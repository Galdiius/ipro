@extends('layouts/header')
@section('content')
  <!-- Main content -->
  <div class="main-content" style="height: 100vh;background: rgb(24,185,173);
  background: linear-gradient(180deg, rgba(24,185,173,1) 0%, rgba(0,86,96,1) 100%);">
      <!-- Header -->
      <div class="header py-7 py-lg-8 pt-lg-9">
        {{-- <div class="container mt-8"> --}}
          {{-- <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
              <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                <h1 class="text-white">Welcome!</h1>
              </div>
            </div>
          </div> --}}
        {{-- </div> --}}
        {{-- <div class="separator separator-bottom separator-skew zindex-100">
          <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div> --}}
      </div>
      
    
      <!-- Page content -->
      <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-7">
            <div class="card border-0 mb-0" style="background: #18b9ad">
              <div class="container">
                <div class="main-content">
                  @if (session('status'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                      <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                      <span class="alert-text">{{ session('status') }}</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                      <span class="alert-icon"><i class="ni ni-check-bold"></i></span>
                      <span class="alert-text">{{ session('message') }}</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  <div class="header-body text-center mt-2">
                    <img src="https://i.postimg.cc/GmvtDMBJ/Screenshot-689.png" width="300" alt="">
                  </div>
                </div>
              <div class="card-body px-lg-5 py-lg-5">
                <form role="form" method="POST" action="">
                  @csrf
                  <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                      <input class="form-control " placeholder="Email" type="" name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                      <span class="text-danger">{{ $message }}</span>    
                    @enderror
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input class="form-control" placeholder="Password" type="password" name="password">
                    </div>
                    @error('password')
                      <span class="text-danger">{{ $message }}</span>    
                    @enderror
                  </div>
                  {{-- <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                    <label class="custom-control-label" for=" customCheckLogin">
                      <span class="text-muted">Remember me</span>
                    </label>
                  </div> --}}
                  <div class="text-center">
                    <button type="submit" style="color: #18b9ad" class="btn btn-white my-4">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    {{-- <footer class="py-5" id="footer-main">
      <div class="container">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
            </div>
          </div>
        </div>
      </div>
    </footer> --}}

  </div>
@endsection