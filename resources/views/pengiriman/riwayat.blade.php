@extends('layouts/header')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')
        <div class="container-fluid mt-6">
            <div class="col-lg-6 col-7">
                <h6 class="h2 d-inline-block mb-0">Riwayat pengiriman</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a>Riwayat</a></li>
                  </ol>
                </nav>
              </div>
            <div class="card p-3">
                {{-- <h1>Riwayat pengiriman</h1> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr align="center">
                                <th>No</th>
                                <th>No invoice</th>
                                <th>Tanggal</th>
                                @if (session('level') == "mitra")
                                    <th>Nama pengepul</th>
                                @endif
                                @if (session('level') == 'proyek')
                                    <th>Pengepul</th>
                                    <th>Mitra</th>
                                @endif
                                @if (session('level') == 'pengepul')
                                    <th>Tujuan</th>
                                @endif
                                <th>#</th>
                            </tr>
                            @forelse ($data as $v)
                                <tr align="center">
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $v['id'] }}</td>
                                    <td>{{ $v['tanggal_konfirmasi'] }}</td>
                                    @if (session('level') == 'mitra')
                                        <td>{{ $v['nama_perusahaan'] }}</td>
                                    @endif
                                    @if (session('level') == 'pengepul')
                                        <td>{{ $v['nama_mitra'] }}</td>
                                    @endif
                                    @if (session('level') == 'proyek')
                                        <td>{{ $v['nama_perusahaan'] }}</td>
                                        <td>{{ $v['nama_mitra'] }}</td>
                                    @endif
                                    <td>
                                        <table>
                                            <tr>
                                                <td><a href="pengiriman/print/{{ $v['id'] }}" class="link"><i class="fas fa-print"></i></a></td>
                                                <td><a data-toggle="modal" data-target="#info{{ $loop->index }}" class="link text-primary"><i class="fas fa-info"></i></a></td>
                                                {{-- <td><a class="link text-primary"><i class="fas fa-clock"></i></a></td> --}}
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <div class="modal fade" id="info{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h5 class="modal-title" id="exampleModalLabel">Informasi pengiriman</h5>
                                                        </div>
                                                        <div class="col-4">
                                                            @if ($v['status'] == 'sedang dikirim')
                                                                <span class="badge badge-danger ml-2">*Material sedang dikirim</span>
                                                            @endif
                                                            @if ($v['status'] == 'diterima')
                                                                <span class="badge badge-success ml-2">*Material diterima</span>
                                                            @endif
                                                            @if ($v['status'] == 'ditolak')
                                                                <span class="badge badge-danger ml-2">*Material ditolak</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <div>
                                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{ $loop->index }}" type="button" role="tab" aria-controls="home" aria-selected="true">{{session('level') == 'pengepul' ? "Destinasi" : "Pengirim"}}</button>
                                                            </li>
                                                            @if (session('level') == 'proyek')
                                                                <li class="nav-item" role="presentation">
                                                                <button class="nav-link" id="destinasi-tab" data-bs-toggle="tab" data-bs-target="#destinasi{{ $loop->index }}" type="button" role="tab" aria-controls="home" aria-selected="true">Destinasi</button>
                                                                </li>
                                                            @endif
                                                            <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile{{ $loop->index }}" type="button" role="tab" aria-controls="profile" aria-selected="false">Material</button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact{{ $loop->index }}" type="button" role="tab" aria-controls="contact" aria-selected="false">Material terkirim</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body" style="max-height: 400px;overflow:auto">
                                            
                                            <div class="tab-content p-2" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home{{ $loop->index }}" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="container">
                                                        @if (session('level') == 'mitra' || session('level') == 'proyek')
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Nama petugas</label>
                                                                <input type="text" readonly class="form-control" value="{{ $v['nama_petugas'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Nama perusahaan</label>
                                                                <input type="text" readonly class="form-control" value="{{ $v['nama_perusahaan'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Tanggal dikirim</label>
                                                                <input type="text" readonly class="form-control" value="{{ $v['tanggal'] }}">
                                                            </div>
                                                            @endif
                                                        @if (session('level') == 'pengepul')
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Nama mitra</label>
                                                                <input type="text" readonly class="form-control" value="{{ $v['nama_mitra'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Tanggal dikonfirmasi</label>
                                                                <input type="text" readonly class="form-control" value="{{ $v['tanggal_konfirmasi'] }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if (session('level') == 'proyek')
                                                    <div class="tab-pane fade" id="destinasi{{ $loop->index }}" aria-labelledby="destinasi-tab">
                                                        <div class="container">
                                                            <div class="form-group">
                                                                <label for="" class="form-group-label">Nama mitra</label>
                                                                <input type="text" class="form-control" readonly value="{{ $v['nama_mitra'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="form-group-label">Koordinat</label>
                                                                <input type="text" class="form-control" readonly value="{{ $v['koordinat'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="form-group-label">Tanggal konfirmasi</label>
                                                                <input type="text" class="form-control" readonly value="{{ $v['tanggal_konfirmasi'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="tab-pane fade" id="profile{{ $loop->index }}" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">Total harga</label>
                                                        <input type="text" readonly value="Rp.{{ $v['total_harga'] }}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">Total berat</label>
                                                        <input type="text" readonly value="{{ $v['total_berat'] }}Kg" class="form-control">
                                                    </div>
                                                    <label for="" class="form-control-label">Material</label>
                                                        @php
                                                            $idloop = $loop->index
                                                        @endphp
                                                        <div class="accordion" id="accccc{{ $idloop }}">
                                                            @foreach ($v['material'] as $m)
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="heading{{ $m['id'] }}{{ $loop->index }}">
                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc{{ $m['id'] }}{{ $loop->index }}" aria-expanded="false" aria-controls="acc{{ $loop->index }}">
                                                                            Material-{{ $loop->index+1 }} | Berat {{ $m['berat_kg'] }}Kg | Total barang {{ count($m['barang']) }}
                                                                        </button>
                                                                    </h2>
                                                                    <div id="acc{{ $m['id'] }}{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accccc{{ $idloop }}">
                                                                        <div class="accordion-body">
                                                                            <div class="form-group">
                                                                                <label class="form-control-label">Harga/kg</label>
                                                                                <input type="text" value="Rp.{{ $m['harga/kg'] }}" readonly class="form-control">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="form-control-label">Total harga</label>
                                                                                <input type="text" value="Rp.{{ $m['total_harga'] }}" readonly class="form-control">
                                                                            </div>
                                                                            <label class="form-control-label">Barang</label>
                                                                            <ul>
                                                                                @foreach ($m['barang'] as $b)
                                                                                    <li>{{ $b->nama_barang }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                <div class="tab-pane fade" id="contact{{ $loop->index }}" role="tabpanel" aria-labelledby="contact-tab">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Total berat terkirim</label>
                                                        <input readonly type="text" class="form-control" value="{{ $v['status'] == 'sedang dikirim' ? 'Material sedang dikirim' : $v['total_berat_terkirim']."Kg" }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">Total harga</label>
                                                        <input readonly type="text" class="form-control" value="{{ $v['status'] == 'sedang dikirim' ? 'Material sedang dikirim' : "Rp.".$v['total_harga_diterima'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @empty
                                <tr align="center">
                                    <td colspan="100%">Belum ada riwayat pengiriman</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection