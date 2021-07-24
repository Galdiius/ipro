@extends('layouts/header')
    <link rel="stylesheet" href="{{ asset('css/material.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
@section('content')
    @include('layouts/sidenav')
    <div class="main-content" id="panel">
        @include('layouts/topnav')
        <div class="container-fluid">
            <div class="row justify-content-center mt-0">
                <div class="col-11 col-sm-9 col-md-7 col-lg-8 text-center p-0 mt-3 mb-2">
                    <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                        <h2><strong>Kirim material</strong></h2>
                        <p>Harap isi form yang disediakan</p>
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <form id="msform" method="POST" action="/material/submit">
                                    @csrf
                                    <input type="hidden" name="id_pengepul" value="{{ session('id') }}">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active" id="account">
                                            <strong>Material</strong>
                                        </li>
                                        {{-- <li id="personal"><strong>Harga</strong></li> --}}
                                        <li id="payment"><strong>Destination</strong></li>
                                        <li id="confirm"><strong>Konfirmasi</strong></li>
                                    </ul> <!-- fieldsets -->
                                    <fieldset>
                                        <div class="form-card" style="max-height: 400px;overflow:auto">
                                            {{-- <div class="form-group">
                                                <label class="form-control-label">Harga/kg</label>
                                                <input type="number" value="" onkeypress="return isNumberKey(event)" required name="hargaperkg" id="harga" placeholder="harga(per kg)" class="form-control">
                                            </div> --}}
                                            <h2 class="fs-title">Material</h2>

                                            <div class="accordion" id="accordion">
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                      Material <pre> </pre> <span class="no-material">1</span> <pre> </pre> | Total Rp.<span class="total-header">0</span> <pre> </pre>| <pre> </pre> Total berat <pre> </pre><span class="berat-header">0</span>kg |<pre> </pre> Jumlah barang : <span class="barang-header">0</span>
                                                    </button>
                                                  </h2>
                                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                    <div class="accordion-body">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Berat material :</label>
                                                            <input type="number" onkeypress="return isNumberKey(event)" placeholder="masukan berat(kg)" class="berat" name="berat[material-1][]">
                                                            <label class="form-control-label">Harga/kg :</label>
                                                            <input type="number" required  placeholder="harga(per kg)" name="hargaperkg[material-1][]" class="form-control harga">
                                                            <label class="form-control-label">Kategori material :</label>
                                                            <select  class="form-control kategori" id="inputkategori">
                                                                <option disabled selected>Pilih kategori</option>     
                                                                @foreach ($kategori as $v)
                                                                    <option value="{{ $v->id }}">{{ $v->nama }}</option>     
                                                                @endforeach
                                                            </select>
                                                            <label class="form-control-label">Jenis material :</label>
                                                            <select disabled class="form-control jenis mt-2" id="inputjenis">
                                                                <option disabled selected>Pilih jenis</option>
                                                            </select>
                                                            <label for="" class="form-control-label mt-2">Pilih barang</label>
                                                            <div class="nama-barang">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input disabled type="checkbox" class="custom-control-input" id="customCheck1">
                                                                    <label class="custom-control-label" for="customCheck1">Silahkan pilih jenis untuk memunculkan barang</label>
                                                                </div>
                                                            </div>
                                                            <label for="" class="form-control-label mt-2">Total</label><br>
                                                            <input type="hidden" name="harga[material-1][]" class="inputHarga">
                                                            <span><strong class="total">Rp.0</strong></span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-card">
                                                <h4>Total harga : Rp.<span id="totalHarga">0</span></h4>
                                                <h4>Total berat : <span id="totalBerat">0</span>Kg</h4>
                                                <h4>Total barang : <span id="totalBarang">0</span></h4>
                                                <input type="hidden" name="totalHarga" id="inputTotalHarga">
                                                <input type="hidden" name="totalBerat" id="inputTotalBerat">
                                                <input type="hidden" name="totalBarang" id="inputTotalBarang">
                                            </div>
                                            <button type="button" id="tambahMaterial" class="btn btn-success">tambah</button>
                                            <button type="button" class="next btn btn-primary set1">selanjutnya</button>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-card">
                                            <h2 class="fs-title">Destinasi</h2>
                                            <select name="mitra" id="mitra" class="form-control">
                                                <option disabled selected>Pilih mitra</option>
                                                @foreach ($mitra as $v)
                                                    <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                                @endforeach
                                            </select>
                                            <div class="card p-3 mt-2" id="map">
                                                <iframe
                                                    height="400"
                                                    style="border:0"
                                                    loading="lazy"
                                                    allowfullscreen
                                                    src="">
                                                </iframe>
                                            </div>
                                            <input type="hidden" id="destinasi" name="destinasi">
                                        </div>
                                        <button type="button" class="previous btn btn-secondary">Kembali</button>
                                        <button type="button" class="next btn btn-success set2">Selanjutnya</button>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-card">
                                            <h2 class="fs-title">Konfirmasi</h2>
                                            <div class="card p-4">
                                                {{-- <h3>Harga/kg : Rp.<span id="hargakg">0</span></h3> --}}
                                                <h3>Jumlah material : <span id="jumlahmaterial">0</span></h3>
                                                <h3>Jumlah barang : <span id="jumlahbarang">0</span></h3>
                                                <h3>Total kg : <span id="totalkg">0</span>Kg</h3>
                                                <h3>Total harga : Rp.<span id="total-harga">0</span></h3>
                                                <h3>Dikirim ke : <span id="destination"></span></h3>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Komen (opsional)</label>
                                                <textarea name="comment" class="form-control"></textarea>
                                            </div>
                                        </div> 
                                        <button type="button" class="previous btn btn-secondary">Kembali</button>
                                        <button type="submit" class="btn btn-success">Kirim</button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset("js/material.js") }}"></script>
    <script>
        $("#tambahMaterial").click(function(){
        let accordionLength = $('.accordion-item').length
        let lastitem = $('.accordion-item')[accordionLength - 1]
        let materialTitle = $(lastitem).find('.accordion-button')[0]
        let lastNoMaterial = parseInt($(materialTitle).find('.no-material')[0].innerHTML)
        $("#accordion").append(`
            <div class="accordion-item">
                <h2 class="accordion-header d-inline" id="heading${accordionLength}">
                    <div class="row">
                        <div class="col-10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${accordionLength+1}" aria-expanded="false" aria-controls="collapseTwo">
                                Material <pre> </pre> <span class="no-material">${lastNoMaterial + 1}</span> <pre> </pre> | Total Rp.<span class="total-header">0</span><pre> </pre>| <pre> </pre> Total berat <pre> </pre><span class="berat-header">0</span>kg |<pre> </pre> Jumlah barang : <span class="barang-header">0</span>
                            </button>
                        </div>
                        <div class="col-1 pt-1">
                            <button type="button" class="btn btn-danger hapusMaterial">hapus</button>
                        </div>
                    </div>
                    
                    
                </h2>
                <div id="collapse${accordionLength+1}" class="accordion-collapse collapse" aria-labelledby="heading${accordionLength+1}" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <div class="form-group">
                        <label class="form-control-label">Berat material :</label>
                        <input type="number" onkeypress="return isNumberKey(event)" placeholder="masukan berat(kg)" class="berat" name="berat[material-${lastNoMaterial + 1}][]">
                        <label class="form-control-label">Harga/kg :</label>
                        <input type="number" required  placeholder="harga(per kg)" name="hargaperkg[material-${lastNoMaterial+1}][]" class="form-control harga">
                        <label class="form-control-label">Kategori material :</label>
                        <select class="form-control kategori">
                            <option disabled selected>Pilih kategori</option>  
                            @foreach ($kategori as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>     
                            @endforeach
                        </select>
                        <label class="form-control-label">Jenis material :</label>
                        <select disabled class="form-control jenis mt-2">
                            <option disabled selected>Pilih jenis</option>
                        </select>
                        <label for="" class="form-control-label mt-2">Pilih barang</label>
                        <div class="nama-barang">
                            <div class="custom-control custom-checkbox">
                                <input disabled type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Silahkan pilih jenis untuk memunculkan barang</label>
                            </div>
                        </div>
                        <input type="hidden" name="harga[material-${lastNoMaterial+1}][]" class="inputHarga">
                        <label for="" class="form-control-label mt-2">Total</label><br>
                        <span><strong class="total">Rp.0</strong></span>
                    </div>
                </div>
                </div>
            </div>
        `)
        // $('#harga').trigger('keyup')
        })

        $('.accordion').on('change','.kategori',function(e){
            $("option[value=" + this.value + "]", this)
            .attr("selected", true).siblings()
            .removeAttr("selected")
            $.ajax({
                type : 'GET',
                url : '/api/getJenis',
                data : { id : e.target.value },
                success : function(res){
                    let data = JSON.parse(res);
                    let jenisForm = $(e.target).siblings("select")
                    jenisForm.removeAttr('disabled')
                    jenisForm[0].innerHTML = '<option disabled selected>Pilih jenis</option>'
                    data.data.forEach(v => {
                        jenisForm[0].innerHTML += `<option value="${v.id}">${v.nama_jenis}</option>`
                    });
                    $(e.target.parentElement).find('.nama-barang')[0].innerHTML = `<div class="custom-control custom-checkbox">
                                                                                        <input disabled type="checkbox" class="custom-control-input" id="customCheck1">
                                                                                        <label class="custom-control-label" for="customCheck1">Silahkan pilih jenis untuk memunculkan barang</label>
                                                                                    </div>`;
                    // $('#harga').trigger('keyup')
                    changeTotalHarga()
                    let barang = $(e.target.parentElement).find('.nama-barang')[0]
                    let input = $(barang).find('input')[0];
                    $(input).trigger('change')
                    changeTotalBarang()
                }
            })
        })

        $('.accordion').on('change','.jenis',function(e){
            let accordionLength = $('.accordion-item').length
            let lastitem = $('.accordion-item')[accordionLength - 1]
            let materialTitle = $(lastitem).find('.accordion-button')[0]
            let lastNoMaterial = parseInt($(materialTitle).find('.no-material')[0].innerHTML)
            let barangForm = $(e.target).siblings('.nama-barang')[0]
            let noMaterial = $(e.target.parentElement.parentElement.parentElement.parentElement).find('.no-material')[0].innerHTML
            $.ajax({
                type : "GET",
                url : "/api/getbarang",
                data : { id : e.target.value },
                success : function(res){
                    barangForm.innerHTML = ``
                    let data = JSON.parse(res)
                    data.data.forEach((v,i) => {
                        barangForm.innerHTML += `
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="nama_barang[material-${noMaterial}][]" value="${v.id}" class="custom-control-input barang" id="customCheck${noMaterial}${v.id}">
                                <label class="custom-control-label" for="customCheck${noMaterial}${v.id}">${v.nama_barang}</label>
                            </div>
                        `
                    })
                }
            })
        })
        $('.accordion').on('click','.hapusMaterial',function(e){
            $(e.target).parents('.accordion-item')[0].remove();
            changeTotalHarga()
            changeTotalBerat()
            changeTotalBarang()
        })

        $('.accordion').on('keyup change','.berat',function(e){
            let berat = e.target.value
            let harga = $(e.target.parentElement).find('.harga')[0].value;
            let totalbarang = $(e.target.parentElement).find('.barang:checked').length;
            let total = (harga * berat) * totalbarang
            $(e.target.parentElement.parentElement.parentElement.parentElement).find('.berat-header')[0].innerHTML = berat
            $(e.target.parentElement.parentElement.parentElement.parentElement).find('.total-header')[0].innerHTML = total;
            $(e.target.parentElement).find('.inputHarga')[0].value = total;
            $(e.target.parentElement.parentElement.parentElement).find('.total')[0].innerHTML = 'Rp.'+total;
            changeTotalHarga()
            changeTotalBerat()
        })

        $('.accordion').on('change','.nama-barang',function(e){
            let harga = $(e.target.parentElement.parentElement.parentElement).find('.harga')[0].value;
            // let harga = $('#harga')[0].value
            let berat = $(e.target.parentElement.parentElement.parentElement).find('.berat')[0].value;
            let totalbarang = $(e.target.parentElement.parentElement).find('.barang:checked').length;
            let total = (harga * berat) * totalbarang
            $(e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement).find('.barang-header')[0].innerHTML = totalbarang;
            $(e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement).find('.total-header')[0].innerHTML = total;
            $(e.target.parentElement.parentElement.parentElement).find('.inputHarga')[0].value = total
            $(e.target.parentElement.parentElement.parentElement).find('.total')[0].innerHTML = 'Rp.'+total;
            changeTotalHarga()
            changeTotalBerat()
            changeTotalBarang()
        })
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('.accordion').on('keyup','.harga',function(e){
            let harga = e.target.value
            let berat = $(e.target.parentElement).find('.berat')[0].value;
            let totalbarang = $(e.target.parentElement).find('.barang:checked').length;
            let total = (harga * berat) * totalbarang
            $(e.target.parentElement.parentElement.parentElement.parentElement).find('.total-header')[0].innerHTML = total;
            $(e.target.parentElement).find('.inputHarga')[0].value = total;
            $(e.target.parentElement.parentElement.parentElement).find('.total')[0].innerHTML = 'Rp.'+total;
            changeTotalHarga()
            changeTotalBerat()
        })
        // $('#harga').on('keyup change',function(e){
        //     let harga = $('.harga')
        //     $('#hargakg')[0].innerHTML = e.target.value
        //     let event = new CustomEvent('aya')
        //     for (let i = 0; i < harga.length; i++) {
        //         harga[i].value = e.target.value;
        //         $(harga[i]).trigger('keyup')
        //     }
        // })

        function changeTotalHarga(){
            let totalHeader = $('.total-header')
            let total = 0
            for (let i = 0; i < totalHeader.length; i++) {
                total += parseInt(totalHeader[i].innerHTML);
            }
            $('#totalHarga')[0].innerHTML = total
            $('#inputTotalHarga')[0].value = total
            $('#total-harga')[0].innerHTML = total
            
        }
        function changeTotalBarang(){
            let totalHeader = $('.barang-header')
            let total = 0
            for (let i = 0; i < totalHeader.length; i++) {
                total += parseInt(totalHeader[i].innerHTML);
            }
            $('#totalBarang')[0].innerHTML = total
            $('#inputTotalBarang')[0].value = total
            $('#jumlahbarang')[0].innerHTML = total
        }
        function changeTotalBerat(){
            let totalHeader = $('.berat')
            let total = 0
            for (let i = 0; i < totalHeader.length; i++) {
                if(totalHeader[i].value == ''){
                    total += 0
                }else{
                    total += parseInt(totalHeader[i].value);
                }
            }
            
            $('#totalBerat')[0].innerHTML = total
            $('#inputTotalBerat')[0].value = total
            $('#totalkg')[0].innerHTML = total
        }


        $('#mitra').on('change',function(e){
            $("#map > iframe").attr('src','')
            $.ajax({
                url : "/api/getMitra",
                type : "GET",
                data : {id : e.target.value},
                success : function(res){
                    let data = JSON.parse(res).data[0];
                    $('#destinasi')[0].value = data.koordinat
                    $('#destination')[0].innerHTML = data.nama
                    $('#map > iframe').attr('src',`https://www.google.com/maps/embed/v1/place?key=AIzaSyCG42x9_Qwd44qK_ZopjRQcTdlAjn0G724&q=${data.koordinat}`)
                }
            })
        })
    </script>
@endsection