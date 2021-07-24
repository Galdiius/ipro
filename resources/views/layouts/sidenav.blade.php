    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" style="overflow: hidden" id="sidenav-main">
      <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header">
          <a class="" href="/">
            <img src="https://i.postimg.cc/ZYjh8QqK/logo.png" width="250" alt="">
              {{-- <img src="{{ asset('argon/assets/img/brand/blue.png')}}" class="navbar-brand-img" alt="..."> --}}
              {{-- <h1 class="text-primary">{{ $user->nama }}</h1> --}}
            </a>
          </div>
          <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
              <!-- Nav items -->
              <ul class="navbar-nav">
                <li class="nav-item sidenav-toggler d-xl-none" data-action="sidenav-pin" data-target="#sidenav-main">
                  <a class="nav-link">
                    <i class="fas fa-arrow-left text-primary"></i>
                  </a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/">
                      <i class="ni ni-tv-2 text-primary"></i>
                      <span class="nav-link-text">Dashboard</span>
                    </a>
                  </li>

                <li class="nav-item">
                  <a class="nav-link" href="/profile">
                    <i class="ni ni-single-02 text-yellow"></i>
                    <span class="nav-link-text">Profile</span>
                  </a>
                </li>
                @if (session('level') != 'admin')
                  <li class="nav-item">
                    <a class="nav-link " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      <i class="fas fa-dolly text-purple"></i>
                      <span class="nav-link-text">Data entry</span>
                      <i class="fas fa-caret-down text-right"></i>
                    </a>
                  </li>
                  <div class="collapse" id="collapseExample">
                    @if (session('level') == 'pengepul')
                      <li class="nav-item">
                        <a class="nav-link ml-4" href="/kirimMaterial">
                          <i class="fas fa-truck"></i>
                          <span class="nav-link-text">Kirim material</span>
                        </a>
                      </li>
                      @endif
                      @if (session('level'))
                        <li class="nav-item">
                          <a class="nav-link ml-4" href="/pengiriman">
                            <i class="fas fa-truck"></i>
                            <span class="nav-link-text">Kelola pengiriman</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link ml-4" href="/riwayat">
                            <i class="fas fa-history"></i>
                            <span class="nav-link-text">Riwayat pengiriman</span>
                          </a>
                        </li>
                      @endif
                    @if (session('level') != 'pengepul')
                      <li class="nav-item">
                        <a class="nav-link ml-4" href="/jenis">
                          <i class="fas fa-chart-pie"></i>
                          <span class="nav-link-text">Kelola jenis</span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link ml-4" href="/barang">
                          <i class="fas fa-box-open"></i>
                          <span class="nav-link-text">Kelola barang</span>
                        </a>
                      </li>
                    @endif
                  </div>
                @endif
                @if (session('level') != 'admin')
                  <li class="nav-item">
                    <a class="nav-link" href="/pengepul">
                      <i class="fas fa-users text-success"></i>
                      <span class="nav-link-text">Kelola pengepul</span>
                    </a>
                  </li>
                    
                @endif
                  @if (session('level') == 'proyek')
                    <li class="nav-item">
                      <a class="nav-link" href="/mitra">
                        <i class="fas fa-users-cog"></i>
                        <span class="nav-link-text">Proyek & Mitra</span>
                      </a>
                    </li>
                  @endif
                  @if (session('level') == 'proyek' || session('level') == 'admin')
                    <li class="nav-item">
                      <a class="nav-link" href="/proyek">
                        <i class="fas fa-user-tie"></i>
                        <span class="nav-link-text">proyek</span>
                      </a>
                    </li>
                  @endif
                  @if (session('level') == 'proyek')    
                    <li class="nav-item">
                      <a class="nav-link" href="/peningkatan">
                        <i class="fas fa-chart-line"></i>
                        <span class="nav-link-text">peningkatan</span>
                      </a>
                    </li>
                  @endif
                    @if (session('level') == 'admin')
                      <li class="nav-item">
                        <a class="nav-link" href="/users">
                          <i class="fas fa-users"></i>
                          <span class="nav-link-text">users</span>
                        </a>
                      </li>
                        
                    @endif
                <li class="nav-item" data-toggle="modal" data-target="#modal-notification" style="cursor: pointer">
                  <a class="nav-link">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span class="nav-link-text">Log out</span>
                  </a>
                </li>
              </ul>
              <!-- Divider -->
              <hr class="my-3">
              <!-- Heading -->
              
              <!-- Navigation -->
              
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-danger">
                    
                    {{-- <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div> --}}
                    
                    <div class="modal-body">
                        
                        <div class="py-3 text-center">
                            <i class="ni ni-bell-55 ni-3x"></i>
                            <h4 class="heading mt-4">Konfirmasi logout!</h4>
                            <p>Anda yakin untuk logout?</p>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-white">Ok, Log out</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
      </nav>
  