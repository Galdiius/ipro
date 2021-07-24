@extends('layouts/header')

    {{-- <link rel="stylesheet" href="{{ asset('css/material.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

@section('content')
    @include('layouts.sidenav')
    <div class="main-content" id="panel">
        @include('layouts.topnav')
        <div class="container-fluid mt-6">

            <div class="col-lg-6 col-7">
                <h6 class="h2 d-inline-block mb-0">Daftar pengiriman</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a >Pengiriman</a></li>
                    </ol>
                </nav>
            </div>

            <div class="card p-3">
                {{-- <h1>Daftar pengiriman</h1> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr align="center">
                                <th>No</th>
                                <th>No invoice</th>
                                <th>Tanggal</th>
                                <th>Total kg</th>
                                <th>Total harga</th>
                                <th>material</th>
                                <th>Jumlah barang</th>
                                @if (session('level') == 'pengepul')
                                    <th>Tujuan</th>
                                @endif
                                @if (session('level') == 'mitra')
                                    <th>Pengepul</th>
                                @endif
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                            @forelse ($data as $v)
                                <tr align="center">
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $v['id'] }}</td>
                                    <td>{{ $v['tanggal'] }}</td>
                                    <td>{{ $v['total_berat'] }}</td>
                                    <td>{{ $v['total_harga'] }}</td>
                                    <td>
                                        <div class="accordion" id="{{$v['id']}}">
                                            @foreach ($v['material'] as $m)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $m['id'] }}{{ $loop->index }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $m['id'] }}{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                                            {{ $m['nama_material'] }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $m['id'] }}{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#{{ $v['id'] }}">
                                                        <div class="accordion-body">
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
                                    </td>
                                    <td>{{ $v['total_barang'] }}</td>
                                    @if (session('level') == 'pengepul')
                                        <td>{{ $v['nama_mitra'] }}</td>
                                    @endif
                                    @if (session('level') == 'mitra')
                                        <td>{{ $v['nama_perusahaan'] }}</td>
                                    @endif
                                    <td>{{ $v['status'] }}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="pengiriman/print/{{ $v['id'] }}" class="link"><i class="fas fa-print"></i></a>
                                                </td>
                                                <td>
                                                    @if (session('level') == 'pengepul')
                                                        @if ($v['status'] == 'sedang dikirim')
                                                            <a data-toggle="modal" data-target="#modal-form{{ $loop->index }}" class="link text-primary"><i class="fas fa-clipboard-check"></i></a>
                                                        @else
                                                            <a data-toggle="modal" data-target="#modal-info{{ $loop->index }}" class="link text-primary"><i class="fas fa-clipboard-check"></i></a>
                                                        @endif
                                                    @else
                                                        <a class="link text-primary" data-toggle="modal" data-target="#a{{ $loop->index }}"><i class="fas fa-clipboard-check"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @if (session('level') == 'pengepul')
                                    <div class="modal fade" id="modal-info{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card bg-secondary border-0 mb-0">
                                                        <div class="card-header bg-transparent pb-2">
                                                            <div class="text-muted text-center mt-2"><h1>Informasi</h1></div>
                                                        </div>
                                                        <div class="card-body py-lg-5">
                                                            <div class="text-muted mb-4">
                                                                {{-- <input type="hidden" value="{{ $v['harga'] }}" class="hargaperkg"> --}}
                                                                <input type="hidden" value="{{ $v['total_harga'] }}" class="totalharga">
                                                                <div class="form-group mb-3">
                                                                    <label for="" class="form-control-label">Total berat terkirim</label>
                                                                    <div class="input-group input-group-merge input-group-alternative">
                                                                        <input class="form-control totalberat pl-2" readonly placeholder="Berat terkirim" id="" type="number" value="{{ $v['total_berat_terkirim'] }}">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">Kg</i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="form-control-label">Tanggal terkirim</label>
                                                                    <input type="text" readonly value="{{ $v['tanggal_terkirim'] }}" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="form-control-label">Total harga</label>
                                                                    <div class="input-group input-group-merge input-group-alternative">
                                                                        <input  class="form-control total pl-2" placeholder="Total harga" value="Rp.{{ $v['total_harga_diterima'] }}" readonly type="text">
                                                                    </div>
                                                                </div>
                                                                <span class="badge badge-warning">Menunggu konfirmasi {{ $v['nama_mitra'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                @endif

                                {{-- Modal pengepul --}}
                                @if (session('level') == 'pengepul' && $v['status'] == 'sedang dikirim')
                                <div class="modal fade" id="modal-form{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="card bg-secondary border-0 mb-0">
                                                    <div class="card-header bg-transparent pb-2">
                                                        <div class="text-muted text-center mt-2"><h1>Konfirmasi material</h1></div>
                                                    </div>
                                                    <div class="card-body py-lg-5">
                                                        <div class="text-muted mb-4">
                                                            {{-- <input type="hidden" value="{{ $v['harga'] }}" class="hargaperkg"> --}}
                                                            <input type="hidden" value="{{ $v['total_harga'] }}" class="totalharga">
                                                            <form method="POST" action="/terkirim">
                                                                <input type="hidden" name="id" value="{{ $v['id'] }}">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <div class="input-group input-group-merge input-group-alternative">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                                        </div>
                                                                        <input class="form-control totalberat" required placeholder="Berat terkirim" id="" name="total_berat_terkirim" type="number" max="{{ $v['total_berat'] }}">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">Kg</i></span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="text-danger message"></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-merge input-group-alternative">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                                        </div>
                                                                        <input name="total_harga_diterima" class="form-control total pl-2" placeholder="Total harga" value="Rp.{{ $v['total_harga'] }}" readonly type="text">
                                                                    </div>
                                                                </div>
                                                                <div class="text-center">
                                                                    <button type="button" class="btn btn-danger my-4" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary my-4 terkirim" data-id="{{ $v['id'] }}">Terkirim</button>
                                                                </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                @endif
                                {{-- Modal mitra --}}
                                @if (session('level') == 'mitra' || session('level') == 'proyek')
                                    <div class="modal fade" id="a{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi material</h5>
                                                            </div>
                                                            <div class="col-4">
                                                                @if ($v['status'] == 'sedang dikirim')
                                                                    <span class="badge badge-danger ml-2">*Material sedang dikirim</span>
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
                                                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{ $loop->index }}" type="button" role="tab" aria-controls="home" aria-selected="true">Pengirim</button>
                                                                </li>
                                                                @if (session('level') == 'proyek')
                                                                    <li class="nav-item" role="presentation">
                                                                        <button class="nav-link" id="destinasi-tab" data-bs-toggle="tab" data-bs-target="#destinasi{{ $loop->index }}" type="button" role="tab" aria-controls="profile" aria-selected="false">Destinasi</button>
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
                                                            <div class="form-group">
                                                                <label for="" class="form-control-label">Pesan :</label>
                                                                <textarea class="form-control" readonly cols="30" rows="3">{{ $v['comment'] }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (session('level') == 'proyek')
                                                        <div class="tab-pane fade" id="destinasi{{ $loop->index }}" role="tabpanel" aria-labelledby="destinasi-tab">
                                                            <div class="container">
                                                                <div class="form-group">
                                                                    <label for="" class="form-group-label">Nama mitra</label>
                                                                    <input type="text" readonly value="{{ $v['nama_mitra'] }}" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="form-group-label">Koordinat</label>
                                                                    <input type="text" readonly value="{{ $v['koordinat'] }}" class="form-control">
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
                                            <div class="modal-footer text-left">
                                            @if (session('level') == 'mitra')
                                                @if ($v['status'] == "terkirim")
                                                    <form action="/konfirmasi" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $v['id'] }}">
                                                        <input type="hidden" name="konfirmasi" value="ditolak">
                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                    </form>
                                                    <form action="/konfirmasi" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $v['id'] }}">
                                                        <input type="hidden" name="konfirmasi" value="diterima">
                                                        <button type="submit" class="btn btn-success">Terima</button>
                                                    </form>
                                                @else
                                                    <button type="button" style="cursor: not-allowed" disabled class="btn btn-danger" data-dismiss="modal">Tolak</button>
                                                    <button type="button" style="cursor: not-allowed" class="btn btn-success" disabled>Terima</button>
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr align="center">
                                    <td colspan="100%">Belum ada pengiriman</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        let input = $('.totalberat')
        for (let i = 0; i < input.length; i++) {
            $(input[i]).on('input',function(e){
                let max = $(e.target).attr('max');
                if(parseInt(e.target.value) > parseInt(max)){
                    $(e.target.parentElement.parentElement).find('.message')[0].innerHTML = "Berat tidak boleh lebih dari "+max+"Kg"
                }else{
                    $(e.target.parentElement.parentElement).find('.message')[0].innerHTML = ""
                }
                let inputBerat = parseInt(e.target.value)
                // let hargaperkg = parseInt($(e.target.parentElement.parentElement.parentElement).find('.hargaperkg')[0].value)
                let totalharga = parseInt($(e.target.parentElement.parentElement.parentElement).find('.totalharga')[0].value)
                let persen = (inputBerat / parseInt(max)) * 100
                let harga = Math.round((persen / 100) * totalharga)
                if(isNaN(harga)){
                    harga = 0
                }
                $(e.target.parentElement.parentElement.parentElement).find('.total')[0].value = "Rp."+harga;

            })
        }
        let terkirim = $('.terkirim')
        for (let i = 0; i < terkirim.length; i++) {
            $(terkirim[i]).on('click',function(e){
                let totalberat = $(e.target.parentElement.parentElement).find('.totalberat')[0].value;
                let max = $(e.target.parentElement.parentElement).find('.totalberat').attr('max')
                if(parseInt(totalberat) > parseInt(max)){
                        alert(`Berat tidak boleh lebih dari ${max}Kg`)
                        e.preventDefault()
                    }
                // let totalberat = $(e.target.parentElement.parentElement).find('.totalberat')[0].value;
                // let max = $(e.target.parentElement.parentElement).find('.totalberat').attr('max')
                // let total = $(e.target.parentElement.parentElement).find('.total')[0].value;
                // if(totalberat == ''){
                //     alert('Anda belum mengisi total berat')
                //     return false
                // }else{
                //     if(parseInt(totalberat) > parseInt(max)){
                //         alert(`Berat tidak boleh lebih dari ${max}Kg`)
                //         return false
                //     }
                //     let id = $(e.target).attr('data-id')
                //     let totalharga = total.slice(3)
                //     $.ajax({
                //         url : '/api/terkirim',
                //         type : 'POST',
                //         data : {
                //             id : id,
                //             total_berat_terkirim : totalberat,
                //             total_harga_diterima : totalharga
                //         },
                //         success : function(res){
                //             let data = JSON.parse(res).data
                //             console.log(data);
                //         }
                //     })
                // }
            })
        }
    </script>
@endsection