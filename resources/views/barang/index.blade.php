@extends('layouts/header')

@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')

        <div class="container-fluid mt-6">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-form">Tambah barang</button>
            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
              <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                  <div class="modal-content">
                      <div class="modal-body p-0">
                        <div class="card bg-secondary border-0 mb-0">
                            <div class="card-header bg-transparent text-center">
                                <h3>Tambah barang</h3>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5">
                                <form role="form" action="/barang/tambah" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Nama barang" name="nama" required type="text" value="{{ old('nama') }}">
                                        </div>
                                        <select name="kategori" class="form-control mt-3">
                                            <option disabled selected>Masukan jenis barang</option>
                                            @foreach ($jenis as $k)
                                                <option value="{{ $k->id }},{{$k->kategori_id}}">{{ $k->nama_jenis }}</option>
                                            @endforeach
                                        </select>
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
                <div class="col-lg-5">
                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @error('kategori')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="card">
                        <div class="table-responsive text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama brang</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barang as $v)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $v->nama_barang }}</td>
                                            <td>{{ $v->nama_jenis }}</td>
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
                                                            <h4 class="heading mt-4">Konfirmasi hapus barang!</h4>
                                                            <p>Anda yakin ingin menghapus barang {{ $v->nama_barang }}?</p>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                                                        <form action="/barang/hapus" method="POST">
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
                                                              <h3>Edit barang</h3>
                                                          </div>
                                                          <div class="card-body px-lg-5 py-lg-5">
                                                              <form role="form" action="/barang/edit" method="POST">
                                                                  @csrf
                                                                  <input type="hidden" name="id" value="{{ $v->id }}">
                                                                  <div class="form-group mb-3">
                                                                      <div class="input-group input-group-merge input-group-alternative">
                                                                          <div class="input-group-prepend">
                                                                              <span class="input-group-text"><i class="fas fa-chart-pie"></i></span>
                                                                          </div>
                                                                          <input class="form-control" placeholder="Nama kategori" name="nama" value="{{ $v->nama_barang }}" required type="text">
                                                                    </div>
                                                                    <select name="jenis" class="form-control mt-3">
                                                                        <option selected value="{{ $v->id_jenis }},{{ $v->id_kategori }}">{{ $v->nama_jenis }}</option>
                                                                        @foreach ($jenis as $k)
                                                                            <option value="{{ $k->id }},{{ $k->kategori_id }}">{{ $k->nama_jenis }}</option>
                                                                        @endforeach
                                                                      </select>
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
                                            <td colspan="4"><span class="text-muted">Tidak ada barang</span></td>
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