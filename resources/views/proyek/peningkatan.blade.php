@extends('layouts/header')

@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h1>Peningkatan</h1>
                    <div class="table-responsive">
                        <table class="table">
                            <tr align="center">
                                <td>No</td>
                                <td>Nama jenis</td>
                                <td>Target</td>
                                <td>Aktual</td>
                                <td>growth</td>
                                <td>#</td>
                            </tr>
                            @foreach ($jenis as $v)
                                <?php 
                                    $peningkatan = DB::table('peningkatan')->where('id_jenis',$v->id)->first();
                                ?>
                                <tr align="center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $v->nama_jenis }}</td>
                                    <td>{{ $peningkatan->target }}</td>
                                    <td>{{ $peningkatan->aktual }}</td>
                                    <td>{{ $peningkatan->growth }}%</td>
                                    <td>
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $loop->iteration }}">Edit</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $loop->iteration }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">{{ $v->nama_jenis }}</h5>
                                          <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                                              <i class="fas fa-times"></i>
                                          </button>
                                        </div>
                                        <form action="/peningkatan" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="id_p" value="{{ $peningkatan->id }}">
                                                <input type="hidden" name="id" value="{{ $v->id }}">
                                                <div class="form-group">
                                                    <label for="" class="form-group-label">Target :</label>
                                                    <input type="number" name="target" class="form-control" value="{{ $peningkatan->target }}" id="target">
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-group-label">Aktual :</label>
                                                    <input type="number" name="aktual" class="form-control" value="{{ $peningkatan->aktual }}" id="aktual">
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-group-label">Growth :</label>
                                                    <input type="number" name="growth" class="form-control" readonly value="{{ $peningkatan->growth }}" id="growth">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    for (let i = 0; i < $('.modal').length; i++) {
        let modal = $('.modal')[i]
        let target = $(modal).find('#target')[0]
        let aktual = $(modal).find('#aktual')[0]
        let growth = $(modal).find('#growth')[0]
        $(aktual).keypress(function(){
            growth.value = (aktual.value/target.value) * 1000
        })
        $(target).keypress(function(){
            growth.value = (aktual.value/target.value) * 1000
        })
    }
</script>
@endsection