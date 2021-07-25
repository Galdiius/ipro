@extends('layouts/header')

@section('content')
@include('layouts/sidenav')
<div class="main-content" id="panel">
    @include('layouts/topnav')
    <div class="container-fluid mt-3">
        <h1>Kategori pengepul</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah kategori</button>

        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah kategori</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="form-control-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control">
                            @error('kategori')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        

        <div class="row mt-4">
            <div class="col-lg-6">
                @if (session('message'))
                    <div class="alert alert-success text-center">{{ session('message')['message'] }}</div>
                    @endif
                @error('edit_kategori')
                    <div class="alert alert-danger text-center">Field tidak boleh kosong</div>
                @enderror
                <div class="table-responsive">
                    <table class="table">
                        <tr class="bg-secondary" align="center">
                            <th>No</th>
                            <th>Kategori</th>
                            <th>#</th>
                        </tr>
                        @foreach ($kategori as $v)
                            <tr align="center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v->nama_kategori }}</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <a href="/pengepul/kategori/hapus/{{ $v->id }}" onclick="return confirm('Anda yakin akan menghapus kategori {{ $v->nama_kategori }}')" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $loop->iteration }}">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="modalEdit{{ $loop->iteration }}" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit kategori</h5>
                                                            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <form action="/pengepul/kategori/edit" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{ $v->id }}">
                                                                    <label for="" class="form-control-label">Kategori</label>
                                                                    <input type="text" name="edit_kategori" value="{{ $v->nama_kategori }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection