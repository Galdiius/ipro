@extends('layouts/header')

@include('layouts/sidenav')

<div class="main-content">
    @include('layouts/topnav')
    <div class="container-fluid mt-6">
        <div class="col-lg-6 col-7">
            <h6 class="h2  d-inline-block mb-0">Pengepul</h6>
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a>Pengepul</a></li>
              </ol>
            </nav>
          </div>
        @if (session('message'))
            <div class="alert alert-{{ session('message')['type'] }}">{{ session('message')["message"] }}</div>
        @endif
        <a href="/pengepul/tambah" class="btn btn-primary">Tambah pengepul</a>
        <div class="row my-4">
            <div class="col-lg-5">
                <form action="" method="get">
                <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari pengepul..." name="search">
                        <button type="submit" class="btn btn-outline-success">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light text-center">
                <tr>
                  <th scope="col" class="sort">No</th>
                  <th scope="col" class="sort">Nama_petugas</th>
                  <th scope="col" class="sort">Nama_perusahaan</th>
                  <th scope="col" class="sort">Email</th>
                  <th scope="col" class="sort">Alamat</th>
                  <th scope="col">No telepon</th>
                  <th scope="col">Koordinat</th>
                  <th scope="col" class="sort">Status</th>
                  @if (session('level') == 'proyek')
                    <th scope="col" class="sort">Mitra</th>   
                  @endif
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody class="list bg-white text-center">
                  @forelse ($pengepul as $p)
                    <tr>
                        <td>
                            {{ $loop->index+1 }}
                        </td>
                        <td>
                            {{ $p->nama_petugas }}
                        </td>
                        <td>
                            {{ $p->nama_perusahaan }}
                        </td>
                        <td>
                            {!! $p->email == "" ? '<span class="text-muted">Belum ada email</span>' : $p->email !!}
                        </td>
                        <td>
                            {!! $p->alamat == "" ? '<span class="text-muted">Belum ada alamat</span>' : $p->alamat !!}
                        </td>
                        <td>
                            {{ $p->no_hp }}
                        </td>
                        <td>
                            {{ $p->koordinat }}
                        </td>
                        <td><span class="badge bg-{{ $p->status == 0 ? 'danger' : 'success'  }} text-white">{{ $p->status == 0 ? 'Belum diaktivasi' : 'Aktif' }}</span></td>
                        @if (session('level') == 'proyek')
                            <td>
                                @if (isset($p->nama_mitra))
                                    {{ $p->nama_mitra }}
                                @else
                                    <span class="text-muted">Tidak ada mitra</span>
                                @endif
                            </td>
                        @endif
                        <td>
                            <table align="center">
                                <tr>
                                    <td>
                                        <a class="text-danger" data-toggle="modal" data-target="#konfirmasi-hapus{{ $p->id }}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    @if ($p->status == 0)
                                        <td>
                                            <a class="text-success" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fas fa-paper-plane"></i></i></a>
                                        </td>
                                    @endif
                                    @if ($p->status == 1)
                                        <td>
                                            <a href="/pengepul/edit/{{ $p->id }}" class="text-purple"><i class="fas fa-user-edit"></i></a>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="text-primary" href="/pengepul/profile/{{ $p->id }}"><i class="fas fa-user"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <div class="modal fade" id="exampleModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Kirim link referal</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-center">
                                <a href="/sendVerifikasi/wa/pengepul/{{ $p->id }}" class="btn btn-success " style="width: 100%"><i class="fab fa-whatsapp"></i> Kirim melalui whatsapp</a><br>
                                <a href="/sendVerifikasi/sms/pengepul/{{ $p->id }}" class="btn btn-warning mt-3" style="width: 100%"><i class="fas fa-comment"></i> Kirim melalui sms</a><br>
                                {{-- <a href="/unduhQrcode/{{ $p->token }}/{{ $p->nama_petugas }}" class="btn btn-secondary mt-3" style="width: 100%" id="getQr"><i class="fas fa-qrcode"></i> Unduh qr code</a> --}}
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    {{-- modal --}}
                    <div class="modal fade" id="konfirmasi-hapus{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                        <div class="modal-dialog modal-warning modal-dialog-centered modal-" role="document">
                            <div class="modal-content bg-gradient-warning">
                                <div class="modal-body">
                                    
                                    <div class="py-3 text-center">
                                        <i class="ni ni-bell-55 ni-3x"></i>
                                        <h4 class="heading mt-4">Konfirmasi hapus pengepul!</h4>
                                        <p>Anda yakin ingin menghapus pengepul {{ $p->nama_petugas }}?</p>
                                    </div>
                                    
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                                    <form action="/pengepul/hapus" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{ $p->id }}" name="no_user">
                                        <button type="submit" type="button" class="btn btn-white">Hapus</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    {{-- Akhir modal --}}
                  @empty
                      <tr>
                          <td colspan="9">
                              <span class="text-muted">Tidak ada data pengepul</span>
                          </td>
                      </tr>
                  @endforelse
                
                
                
                
              </tbody>
            </table>
            <div>
                {{ $pengepul->links('vendor.pagination.custom') }}
            </div>
          </div>
    </div>
      
<script>   
    let password = document.getElementsByClassName('password')
    let btnShow = document.getElementById('btn-show-password')
    let btnHide = document.getElementById('btn-hide-password')
    btnShow.addEventListener('click',function(){
        btnHide.style.display = "inline"
        btnShow.style.display = "none"
        for(let i=0;i<password.length;i++){
            password[i].type = "text"
        }

    })
    btnHide.addEventListener("click",function(){
        btnShow.style.display = "inline"
        btnHide.style.display = "none"
        for(let i=0;i<password.length;i++){
            password[i].type = "password"
        }
    })
</script>