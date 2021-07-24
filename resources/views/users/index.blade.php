@extends('layouts/header')
@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')
        <div class="container-fluid">
            <h1>Daftar users</h1>
            <div class="row">
                <div class="col-6">
                    <form action="" method="GET">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" name="q" placeholder="Search.."></input>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <table class="table">
                <tr align="center">
                    <td>No</td>
                    <td>Nama</td>
                    <td>Level</td>
                    <td>#</td>
                </tr>
                @forelse ($data as $v)
                    <tr align="center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $v->nama }}</td>
                        <td>
                            <span class="badge badge-{{ $v->color }}">{{ $v->data }}</span>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <a href="/{{ $v->data }}/edit/{{ $v->id }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $loop->iteration }}">
                                            <i class="fas fa-trash"></i>
                                        </button>                                          
                                    </td>
                                </tr>
                                <div class="modal fade" id="modalHapus{{ $loop->iteration }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header text-center">
                                          <h5 class="modal-title text-center" id="exampleModalLabel">Konfirmasi hapus</h5>
                                          <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                                              <i class="fas fa-times"></i>
                                          </button>
                                        </div>
                                        <div class="modal-body text-center">
                                          <h4>Anda yakin akan menghapus user {{ $v->nama }}({{ $v->data }})?</h4>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                          @if ($v->data == 'pengepul' || $v->data == 'mitra')
                                            <form action="/{{ $v->data }}/hapus" method="POST">
                                                @csrf
                                                @method('delete')
                                                    <input type="hidden" name="no_user" value="{{ $v->id }}">
                                                    <input type="hidden" name="id" value="{{ $v->id }}">  
                                                <button type="submit" class="btn btn-success">Hapus</button>
                                            </form>
                                          @else
                                          <form action="/{{ $v->data }}/delete/{{ $v->id }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-success">Hapus</button>
                                        </form>
                                          @endif
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            </table>
                        </td>
                    </tr>
                    @empty
                    <tr align="center">
                        <td colspan="100%"><span class="text-subtitle">Tidak ada data</span></td>
                    </tr>
                    @endforelse
                </table>
                <div>
                    {{ $data->links('vendor.pagination.custom') }}
                </div>
        </div>
    </div>
@endsection