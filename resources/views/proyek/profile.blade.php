@extends('layouts/header')
@section('content')
@include('layouts/sidenav')
<div class="main-content" id="panel">
    @include('layouts/topnav')

    <!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        
        <div class="col-xl-8 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
              </div>
            </div>
            <div class="card-body">
              <form>
                @csrf
                <h6 class="heading-small text-muted mb-4">Informasi proyek</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Nama</label>
                        <input type="text" id="input-username" class="form-control" placeholder="Username" value="{{ $proyek->nama }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" class="form-control" value="{{ $proyek->email == "" ? "Belum ada email" : $proyek->email }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">Capex</label>
                                    <input type="text" readonly id="capex" value="Rp.{{ $proyek->capex }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">Opex</label>
                                    <input type="text" readonly id="opex" value="Rp.{{ $proyek->opex }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label for="" class="form-control-label">Convert</label><br>
                                  <button type="button" class="btn btn-success " id="rupiah">Convert To Rp</button>
                                  <button type="button" class="btn btn-success " id="usd">Convert To Usd</button>
                              </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Informasi kontak</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Alamat</label>
                        <input id="input-address" class="form-control" placeholder="Alamat" value="{{ $proyek->alamat == "" ? "Belum ada alamat" : $proyek->alamat }}" type="text" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">No telepon</label>
                        <input type="text" id="input-city" class="form-control" placeholder="No_hp" value="{{ $proyek->no_hp }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Koordinat</label>
                        <input type="text" id="input-country" class="form-control" placeholder="Country" value="{{ $proyek->koordinat }}" disabled>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Kategori</label>
                        <input type="text" id="input-country" class="form-control" placeholder="Country" value="{{ $proyek->nama_kategori }}" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-xl-4 order-xl-2">
            <div class="card p-3">
                <iframe
                    height="450"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCG42x9_Qwd44qK_ZopjRQcTdlAjn0G724
                        &q={{ $proyek->koordinat }}">
                </iframe>
            </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    let rupiah = document.getElementById('rupiah')
    let usd = document.getElementById('usd')

    rupiah.style.display = 'none'
    usd.addEventListener('click',function(){
      axios.get('https://free.currconv.com/api/v7/convert?q=IDR_USD&compact=ultra&apiKey=8faa5bca67f3618aaac8').then(res=>{
        let capex = res.data.IDR_USD * parseInt(document.getElementById('capex').value.split('.')[1])
        let opex = res.data.IDR_USD * parseInt(document.getElementById('opex').value.split('.')[1])
        document.getElementById('capex').value = "$"+capex.toFixed(2)
        document.getElementById('opex').value = "$"+opex.toFixed(2)
        rupiah.style.display = "block"
        usd.style.display = "none"
      });
    })
    rupiah.addEventListener('click',function(){
      axios.get('https://free.currconv.com/api/v7/convert?q=USD_IDR&compact=ultra&apiKey=8faa5bca67f3618aaac8').then(res=>{
        let capex = '<?= $proyek->capex ?>'
        let opex =  '<?= $proyek->opex ?>'
        document.getElementById('capex').value = "Rp."+capex
        document.getElementById('opex').value = "Rp."+opex
        usd.style.display = "block"
        rupiah.style.display = "none"
      });
    })
  </script>
@endsection