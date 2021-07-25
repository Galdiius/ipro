@extends('layouts/header')

@include('layouts/sidenav')

<div class="main-content">
    @include('layouts/topnav')
    <div class="container-fluid mt-6">
        @if (session('message'))
            <div class="alert alert-{{ session('message')['type'] }}">{{ session('message')["message"] }}</div>
        @endif
        <a href="/mitra/tambah" class="btn btn-primary">Tambah mitra</a>
        <div class="row my-4">
            <div class="col-lg-5">
                <form action="" method="get">
                <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari mitra..." name="search">
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
                  <th scope="col" class="sort">Nama</th>
                  <th scope="col" class="sort">Email</th>
                  <th scope="col" class="sort">Alamat</th>
                  <th scope="col">No hp</th>
                  <th scope="col">Koordinat</th>
                  <th scope="col">Jumlah pengepul</th>
                  <th scope="col">status</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody class="list bg-white text-center">
                  @forelse ($mitra as $p)
                    <tr>
                        <td>
                            {{ $loop->index+1 }}
                        </td>
                        <td>
                            {{ $p->nama }}
                        </td>
                        <td>
                            {!! $p->email == "" ? '<span class="text-muted">Belum ada email</span>' : $p->email !!}
                        </td>
                        <td>
                            {!! $p->alamat == "" ? '<span class="text-muted">Belum ada alamat</span>' : $p->alamat !!}
                        </td>
                        <td>
                            {{ $p->no_hp }}
                            @if ($p->status == 0)
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editNoHp{{ $loop->iteration }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <div class="modal fade" id="editNoHp{{ $loop->iteration }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit no telepon</h5>
                                            <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <form action="/mitra/edit_no_hp" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="{{ $p->id }}">
                                                    <label class="form-control-label">No telepon</label>
                                                    <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $p->koordinat }}
                        </td>
                        <td>
                            {{ $p->jumlah_pengepul }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $p->status == 0 ? 'danger' : 'success'  }} text-white">{{ $p->status == 0 ? 'Belum diaktivasi' : 'Aktif' }}</span>
                        </td>
                        <td class="text-right">
                            <table align="center">
                                <tr>
                                    <td>
                                        <a class="text-danger" data-toggle="modal" data-target="#konfirmasiHapus{{ $loop->index }}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    @if ($p->status == 0)
                                        <td>
                                            <a class="text-success" data-toggle="modal" data-target="#exampleModal{{ $loop->index }}"><i class="fas fa-paper-plane"></i></i></a>
                                        </td>
                                    @endif
                                    @if ($p->status == 1)
                                        <td>
                                            <a href="/mitra/edit/{{ $p->id }}" class="text-purple"><i class="fas fa-user-edit"></i></a>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="text-primary" href="/mitra/profile/{{ $p->id }}"><i class="fas fa-user"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                      
                      <!-- Modal -->
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
                                <a href="/sendVerifikasi/wa/mitra/{{ $p->id }}" class="btn btn-success " style="width: 100%"><i class="fab fa-whatsapp"></i> Kirim melalui whatsapp</a><br>
                                <a href="/sendVerifikasi/sms/mitra/{{ $p->id }}" class="btn btn-warning mt-3" style="width: 100%"><i class="fas fa-comment"></i> Kirim melalui sms</a><br>
                                {{-- <a href="/unduhQrcode/{{ $p->token }}/{{ $p->nama }}" class="btn btn-secondary mt-3" style="width: 100%" id="getQr"><i class="fas fa-qrcode"></i> Unduh qr code</a> --}}
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    {{-- modal --}}
                    <div class="modal fade" id="konfirmasiHapus{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                        <div class="modal-dialog modal-warning modal-dialog-centered modal-" role="document">
                            <div class="modal-content bg-gradient-warning">
                                <div class="modal-body">
                                    
                                    <div class="py-3 text-center">
                                        <i class="ni ni-bell-55 ni-3x"></i>
                                        <h4 class="heading mt-4">Konfirmasi hapus mitra!</h4>
                                        <p>Anda yakin ingin menghapus mitra {{ $p->nama }}?</p>
                                    </div>
                                    
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                                    <form action="/mitra/hapus" method="POST">
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
                              <span class="text-muted">Tidak ada data mitra</span>
                          </td>
                      </tr>
                  @endforelse
                
                
                
                
              </tbody>
            </table>
            <div>
                {{ $mitra->links('vendor.pagination.custom') }}
            </div>
          </div>
    </div>
      
<script>
    let btnQr = document.getElementById('getQr')
    btnQr.addEventListener('click',function(){
        $.ajax({
           url : '/getCodeQr',
           type : 'GET',
           success : function(e){
               console.log(e);
           }
        })
    })
</script>
