<div class="main-content" id="panel">
  <style>
    #reset:focus {outline:0;};
  </style>
    @include('layouts/topnav')
     <!-- Header -->
     <!-- Header -->
     <div class="header pb-6">
       <div class="container-fluid">
         <div class="header-body">
           <div class="row align-items-center py-4">
             <div class="col-lg-6 col-7">
               <h6 class="h2 d-inline-block mb-0">Dashboard</h6>
               <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                 <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                   <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                   <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
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
                 <div class="card" style="border-top-left-radius: 0;border-top-right-radius: 0;">
                   <div class="card-body">
                     <div class="row">
                       <div class="col-lg-4">
                         <div class="form-group">
                           <label for="" class="form-control-label">Pengepul</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="pengepul" id="pengepul" class="form-control">
                                <option value="all">Semua pengepul</option>
                                @foreach ($data['data_pengepul'] as $i)
                                  @if (app('request')->input('pengepul') == $i['id'])
                                    <option selected value="{{ $i['id'] }}">{{ $i['nama_petugas'] }} ({{ $i['nama_perusahaan'] }})</option>
                                  @else
                                    <option value="{{ $i['id'] }}">{{ $i['nama_petugas'] }} ({{ $i['nama_perusahaan'] }})</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                       </div>
  
                       <div class="col-lg-4">
                         <div class="form-group">
                           <label for="" class="form-control-label">Tanggal/bulan/tahun</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                              </div>
                              @if (app('request')->input('date'))
                                <input class="form-control" placeholder="Tanggal" id="tanggal" name="date" value="{{ app('request')->input('date') }}" type="date">
                              @else    
                                <input class="form-control" placeholder="Tanggal" name="date" type="date" id="tanggal">
                              @endif
                              <div class="input-group-append">
                                <button type="button" class="input-group-text" id="reset">
                                  <i class="fas fa-redo"></i>
                                </button>
                                <button type="submit" class="btn btn-success ml-5">Filter</button>
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
           <!-- Card stats -->
           <div class="row">
             <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase  mb-0">Total(kg)</h3>
                       <h5 class="text-muted">Barang daur ulang</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['total_kg'][0]->total_kg == null ? '0' : $data['total_kg'][0]->total_kg }}</span>
                     </div>
                     <div class="col-auto">
                       <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                         {{-- <i class="ni ni-active-40"></i> --}}
                         <i class="fas fa-dice-d6"></i>
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

             @if (!app('request')->input('pengepul'))
              <div class="col-xl-4 col-md-6">
                <div class="card card-stats">
                  <!-- Card body -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h3 class="card-title text-uppercase mb-0">Total pengepul</h3>
                        <h5 class="text-muted">Jumlah pengepul</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['total_pengepul'][0]->total_pengepul }}</span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif


             <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase mb-0">Total pengiriman</h3>
                       <h5 class="text-muted">Seluruh pengiriman</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['total_pengiriman'][0]->total_pengiriman }}</span>
                     </div>
                     <div class="col-auto">
                       <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                         {{-- <i class="ni ni-money-coins"></i> --}}
                         <i class="fas fa-truck"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

             
             
            </div>
            <div class="row">
              <div class="col-xl-4">
                  <div class="card">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                            <h5 class="h3 mb-0">Total kg/bulan</h5>
                        </div>
                      </div>
                    <div class="card-body" style="height: 500px">
                      <!-- Chart -->
                      @if (!app('request')->input('date'))
                        <div class="chart">
                          <canvas id="chart-kg"></canvas>
                        </div>
                      @else
                        <div class="chart">
                          <canvas id="chart-kg-bulan"></canvas>
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
                         <h5 class="h3 mb-0">Jenis material</h5>
                     </div>
                   </div>
                 <div class="card-body text-center" style="height: 500px">
                   <!-- Chart -->
                   @if ($data['data_jenis'] == null)
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
            </div>

           
         </div>
       </div>
     </div>
     <!-- Page content -->
     <div class="container-fluid mt--6">
       <div class="row">
        
       </div>
       
       <!-- Footer -->
     </div>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
   <script>
     let btnReset = document.getElementById('reset')
     let pengepul = document.getElementById('pengepul')
     let tanggal = document.getElementById('tanggal')
     btnReset.addEventListener('click',function(){
      pengepul.value = 'all'
      tanggal.value = ''
     })
   </script>
   @if (app('request')->input('date') != null)
       <script>
         new Chart(
              document.getElementById('chart-kg-bulan'),
              {
                type : 'bar',
                data : {
                  labels: [getDate()],
                  datasets: [{
                  label: 'kg',
                    data: ['<?= $data["total_kg_bulan"]->total ?>',],
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

          function getDate(){
            let url = window.location.href;
            let params = (new URL(url)).searchParams
            let date = params.get('date').split('-')
            let tgl = date[2]
            let bln = date[1]
            switch (bln) {
              case '01':
                  bln = 'januari'
                break;
              case '02':
                  bln = 'februari'
                break;
              case '03':
                  bln = 'maret'
                break;
              case '04':
                  bln = 'april'
                break;
              case '05':
                  bln = 'mei'
                break;
              case '06':
                  bln = 'juni'
                break;
              case '07':
                  bln = 'juli'
                break;
              case '08':
                  bln = 'agustus'
                break;
              case '09':
                  bln = 'september'
                break;
              case '10':
                  bln = 'oktober'
                break;
              case '11':
                  bln = 'november'
                break;
              case '12':
                  bln = 'desember'
                break;
            
              default:
                break;
            }
            return `${tgl}-${bln}`
          }
       </script>
   @endif
   @if (app('request')->input('date') == null )
    <script>
      const labels = [
              'Januari',
              'Februari',
              'Maret',
              'April',
              'May',
              'Juni',
              'Juli',
              'Agustus',
              'September',
              'Oktober',
              'November',
              'Desember'
          ];
          const data = {
              labels: labels,
              datasets: [{
                  label: 'Kg',
                  backgroundColor: 'rgb(255, 99, 132)',
                  borderColor: 'rgb(255, 99, 132)',
                  data: [
                      parseInt(<?= $data['total_kg_bulan']['1']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['2']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['3']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['4']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['5']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['6']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['7']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['8']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['9']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['10']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['11']->total ?>),
                      parseInt(<?= $data['total_kg_bulan']['12']->total ?>)
                  ],
              }]
          }
          const config = {
              type: 'bar',
              data,
              options: {}
          };
          new Chart(
              document.getElementById('chart-kg'),
              config
          )


      
    </script>
       
   @endif
    <script>
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