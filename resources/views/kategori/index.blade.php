@extends('layouts/header')

@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')

        <div class="container-fluid mt-6">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-form">Tambah kategori</button>
            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
              <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                  <div class="modal-content">
                      <div class="modal-body p-0">
                        <div class="card bg-secondary border-0 mb-0">
                            <div class="card-header bg-transparent text-center">
                                <h3>Tambah kategori</h3>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5">
                                <form role="form" action="/kategori/tambah" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Nama kategori" name="nama" required type="text">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success my-4">tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div> 
                      </div>
                  </div>
              </div>
          </div>
            <div class="row mt-5">
                <div class="col-lg-4">
                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="card">
                        <div class="table-responsive text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama kategori</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategori as $v)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $v->nama }}</td>
                                            <td>
                                                <a class="text-danger" data-toggle="modal" data-target="#konfirmasi-hapus{{ $v->id }}"><i class="fas fa-trash-alt"></i></a>
                                                <a class="text-primary ml-4" data-toggle="modal" data-target="#edit{{ $v->id }}"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        {{-- Modal hapus --}}
                                        <div class="modal fade" id="konfirmasi-hapus{{ $v->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                            <div class="modal-dialog modal-warning modal-dialog-centered modal-" role="document">
                                                <div class="modal-content bg-gradient-warning">
                                                    <div class="modal-body">
                                                        
                                                        <div class="py-3 text-center">
                                                            <i class="ni ni-bell-55 ni-3x"></i>
                                                            <h4 class="heading mt-4">Konfirmasi hapus kategori!</h4>
                                                            <p>Anda yakin ingin menghapus kategori {{ $v->nama }}?</p>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                                                        <form action="/kategori/hapus" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" value="{{ $v->id }}" name="id">
                                                            <button type="submit" type="button" class="btn btn-white">Hapus</button>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Akhir modal hapus --}}
                                        {{-- Modal edit --}}
                                        <div class="modal fade" id="edit{{ $v->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                      <div class="card bg-secondary border-0 mb-0">
                                                          <div class="card-header bg-transparent text-center">
                                                              <h3>Edit kategori</h3>
                                                          </div>
                                                          <div class="card-body px-lg-5 py-lg-5">
                                                              <form role="form" action="/kategori/edit" method="POST">
                                                                  @csrf
                                                                  <input type="hidden" name="id" value="{{ $v->id }}">
                                                                  <div class="form-group mb-3">
                                                                      <div class="input-group input-group-merge input-group-alternative">
                                                                          <div class="input-group-prepend">
                                                                              <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                                                          </div>
                                                                          <input class="form-control" placeholder="Nama kategori" name="nama" value="{{ $v->nama }}" required type="text">
                                                                      </div>
                                                                  </div>
                                                                  <div class="text-center">
                                                                      <button type="submit" class="btn btn-success my-4">Edit</button>
                                                                  </div>
                                                              </form>
                                                          </div>
                                                      </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Akhir Modal edit --}}
                                    @empty
                                        <tr>
                                            <td colspan="3"><span class="text-muted">Tidak ada kategori</span></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection