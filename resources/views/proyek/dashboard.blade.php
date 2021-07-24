<div class="main-content" id="panel">
    @include('layouts/topnav')
     <!-- Header -->
     <div class="header pb-6">
       <div class="container-fluid">
         <div class="header-body">
           <div class="row align-items-center py-4">
             <div class="col-lg-6 col-7">
               <h6 class="h2 d-inline-block mb-0">Dashboard</h6>
               <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                 <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                   <li class="breadcrumb-item"><a><i class="fas fa-home"></i></a></li>
                 </ol>
               </nav>
             </div>
             {{-- <div class="col-lg-6 col-5 text-right">
               <a href="#" class="btn btn-sm btn-neutral">New</a>
               <a href="#" class="btn btn-sm btn-neutral">Filters</a>
             </div> --}}
           </div>

           <form action="">
            <div class="row">
               <div class="col-12">
                 <ul class="nav nav-tabs">
                   <li class="nav-item">
                     <a class="nav-link active px-5" aria-current="page"><h3>Filter</h3></a>
                   </li>
                 </ul>
                 <div class="card" style="border-top-left-radius: 0;border-top-right-radius:0;">
                   <div class="card-body">
                     <div class="row">
                       <div class="col-lg-4">
                         <div class="form-group">
                           <label for="" class="form-control-label">Proyek</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="proyek" id="proyek" class="form-control">
                                @if(app('request')->input('proyek'))
                                  @foreach ($data['proyek'] as $v)
                                      <option value="{{ $v->id }}" {{ $v->id == app('request')->input('proyek') ? 'selected' : '' }} >{{ $v->nama }}</option>
                                  @endforeach
                                @else
                                  @foreach ($data['proyek'] as $v)
                                    @if ($v->id == session('id'))
                                      <option value="{{ $v->id }}" selected><b>{{ $v->nama }}(Anda)</b></option>
                                    @else    
                                      <option value="{{ $v->id }}">{{ $v->nama }}</option>  
                                    @endif
                                  @endforeach
                                @endif
                              </select>
                              <div class="input-group-append ml-5">
                                <button type="submit" id="submit" class="btn btn-success">Filter</button>
                              </div>
                            </div>
                          </div>
                       </div>
                       
                     </div>
                   </div>
                 </div>
               </div>
              </div>
            </form>

           <div class="row">
            @if (app('request')->input('proyek'))
              <div class="col-xl-4">
                <div class="card p-4">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Nama :</label>
                        <input type="text" disabled value="{{ $data['data_user']->nama }}" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Kategori :</label>
                        <input type="text" disabled value="{{ $data['data_user']->nama_kategori }}" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Capex :</label>
                        <input type="text" disabled value="{{ $data['data_user']->capex }}" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Opex :</label>
                        <input type="text" disabled value="{{ $data['data_user']->opex }}" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @if(app('request')->input('proyek'))
              <div class="col-xl-8">
            @else
              <div class="col-xl-12">
            @endif
               <!-- Card stats -->
           <div class="row">
             @if (app('request')->input('proyek'))
              <div class="col-xl-6 col-md-6">
             @else
              <div class="col-xl-4 col-md-6">
             @endif
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title text-uppercase  mb-0">Jumlah proyek</h3>
                      <h5 class="text-muted">Aktif</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $data['jumlah_proyek']->jumlah_proyek }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        {{-- <i class="ni ni-active-40"></i> --}}
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                  {{-- <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p> --}}
                </div>
              </div>
            </div>
            @if (app('request')->input('proyek'))
              <div class="col-xl-6 col-md-6">
             @else
              <div class="col-xl-4 col-md-6">
             @endif
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title text-uppercase mb-0">Jumlah mitra</h3>
                      <h5 class="text-muted">Semua mitra</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $data['jumlah_mitra']->jumlah_mitra }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if (app('request')->input('proyek'))
              <div class="col-xl-6 col-md-6">
             @else
              <div class="col-xl-4 col-md-6">
             @endif
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title text-uppercase mb-0">Jumlah pengepul</h3>
                      <h5 class="text-muted">Semua pengepul</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $data['jumlah_pengepul'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        {{-- <i class="ni ni-money-coins"></i> --}}
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if (app('request')->input('proyek'))
              <div class="col-xl-6 col-md-6">
             @else
              <div class="col-xl-4 col-md-6">
             @endif
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h3 class="card-title text-uppercase mb-0">Total kg</h3>
                      <h5 class="text-muted">Kg</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $data['total_kg'] }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
             </div>
           </div>
           
         </div>
       </div>
     </div>
     <!-- Page content -->
     <div class="container-fluid mt--6">
       <div class="row">
         <div class="col-xl-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                    <h5 class="h3 mb-0">Jenis material</h5>
                </div>
              </div>
              <div class="card-body text-center" style="height: 500px">
                <!-- Chart -->
                @if($data['data_jenis'] == null)
                    <span class="text-muted">Tidak ada data</span>
                @else
                  <div class="chart">
                    <canvas id="chart-jenis"></canvas>
                  </div>
                @endif
              </div>
            </div>
          </div>
         </div>
         <div class="col-xl-4">
           <div class="card">
                <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                    <div class="col">
                        <h5 class="h3 mb-0">Jenis material(Rp)</h5>
                    </div>
                  </div>
                <div class="card-body" style="height: 500px">
                  <!-- Chart -->
                    <div class="chart">
                      <canvas id="chart-jenis-rp"></canvas>
                    </div>
                </div>
            </div>
          </div>
         </div>
       </div>
       
       <!-- Footer -->
     </div>
   </div>
   <script>
     console.log(window.location.search);
   </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>

   
   <script>
     new Chart(
              document.getElementById('chart-jenis-rp'),
              {
                type : 'bar',
                data : {
                  labels: [
                    <?php foreach($data['data_jenis_rp'] as $k => $v) { ?>
                      '<?= $k ?>',
                    <?php } ?>
                  ],
                  datasets: [{
                  label: 'Rp',
                    data: [
                      <?php foreach($data['data_jenis_rp'] as $k => $v) { ?>
                        '<?= $v ?>',
                      <?php } ?>
                    ],
                    backgroundColor: ['green'],
                    hoverOffset: 4
                  }]
                },
                options : {
                  plugins : {
                    legend : {
                      onClick: function (e) {
                          e
                      }
                    },
                  },
                  
                }
              }
          )
    // Chart jenis
    new Chart(
            document.getElementById('chart-jenis'),
            {
              type : 'pie',
              data : {
                labels: [
                  <?php foreach($data['data_jenis'] as $k => $v) { ?>
                    '<?= $k ?>',
                  <?php }  ?>
                ],
                datasets: [{
                label: 'kg',
                  data: [
                    <?php foreach($data['data_jenis'] as $k => $v) { ?>
                      '<?= $v ?>',
                    <?php }  ?>
                  ],
                  backgroundColor: [
                    <?php foreach($data['data_jenis'] as $k => $v) { ?>
                      "#" + Math.floor(Math.random()*16777215).toString(16),
                    <?php }  ?>
                  ],
                  hoverOffset: 4
                }]
              },
              options : {
                plugins : {
                  legend : {
                    onClick: function (e) {
                        e
                    }
                  },
                },
                
              }
            }
        )

  </script>