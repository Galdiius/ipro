<div class="main-content" id="panel">
    @include('layouts/topnav')
     <!-- Header -->
     <!-- Header -->
     <div class="header pb-6">
       <div class="container-fluid">
         <div class="header-body">
           <div class="row align-items-center py-4">
             <div class="col-lg-6 col-7">
               <h6 class="h2  d-inline-block mb-0">Dashboard</h6>
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
           <!-- Card stats -->
           <div class="row">
             <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase  mb-0">Total(kg)</h3>
                       <h5 class="text-muted">Material dikirim</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['total_kg'][0]->total_kg ? $data['total_kg'][0]->total_kg : '0' }}</span>
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
             <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase mb-0">Pengiriman</h3>
                       <h5 class="text-muted">Pengiriman berlangsung</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['pengiriman'][0]->pengiriman }}</span>
                     </div>
                     <div class="col-auto">
                       <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                         <i class="fas fa-truck"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase mb-0">Total pengiriman</h3>
                       <h5 class="text-muted">Semua pengiriman</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['total_pengiriman'][0]->total_pengiriman }}</span>
                     </div>
                     <div class="col-auto">
                       <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                         <i class="fas fa-truck"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             {{-- <div class="col-xl-4 col-md-6">
               <div class="card card-stats">
                 <!-- Card body -->
                 <div class="card-body">
                   <div class="row">
                     <div class="col">
                       <h3 class="card-title text-uppercase mb-0">Total barang</h3>
                       <h5 class="text-muted">Barang terkirim</h5>
                       <span class="h2 font-weight-bold mb-0">{{ $data['barang'][0]->barang }}</span>
                     </div>
                     <div class="col-auto">
                       <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                         <i class="fas fa-truck"></i>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div> --}}

           </div>
         </div>
       </div>
     </div>
     <!-- Page content -->
     <div class="container-fluid mt--6">
       <div class="row">
         <div class="col-xl-4">
             <div class="card">
               <form action="">
                   <div class="row mt-2">
                       <div class="col-9 pl-5">
                            <div class="form-group">
                            <select name="tahun" class="form-control">
                                <option disabled selected>{{ app('request')->input('tahun') ? app('request')->input('tahun') : date('Y') }}</option>
                                @for ($i = intval(date('Y',$user->tanggal_verifikasi)); $i <= 2022; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                         </div>
                       </div>
                       <div class="col-3">
                        <button class="btn btn-success">Filter</button>
                       </div>
                   </div>
                   
                    
               </form>
             <div class="card-header bg-transparent">
               <div class="row align-items-center">
                 <div class="col">
                    <h5 class="h3 mb-0">Total pendapatan</h5>
                   <h6 class="text-uppercase text-muted ls-1 mb-1">Tahun {{ date('Y') }}</h6>
                 </div>
               </div>
             </div>
             <div class="card-body">
               <!-- Chart -->
               <div class="chart">
                 <canvas id="chart-pendapatan" class="chart-canvas"></canvas>
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
                <div class="card-body" style="height: 500px">
                  <!-- Chart -->
                  <div class="chart">
                    <canvas id="chart-jenis"></canvas>
                  </div>
                </div>
           </div>
         </div>
       </div>
         <div class="col-xl-4">
             <div class="card">
                <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                    <div class="col">
                        <h5 class="h3 mb-0">Berat/pengiriman</h5>
                    </div>
                  </div>
                <div class="card-body" style="height: 500px">
                  <!-- Chart -->
                  <div class="chart">
                    <canvas id="chart-pengiriman-kg"></canvas>
                  </div>
                </div>
           </div>
         </div>
       </div>
         {{-- <div class="col-xl-4">
             <div class="card">
                <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                    <div class="col">
                        <h5 class="h3 mb-0">Jenis/pengiriman</h5>
                    </div>
                  </div>
                <div class="card-body" style="height: 500px">
                  <!-- Chart -->
                  <div class="chart">
                    <canvas id="chart-pengiriman-jenis"></canvas>
                  </div>
                </div>
           </div>
         </div>
       </div> --}}
       
       <!-- Footer -->
     </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
   {{-- <script src="{{ asset('js/pengepul/chart-jenis.js') }}"></script> --}}
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
                label: 'Pendapatan',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [
                    parseInt(<?= $data['pendapatan']['1']->total ?>),
                    parseInt(<?= $data['pendapatan']['2']->total ?>),
                    parseInt(<?= $data['pendapatan']['3']->total ?>),
                    parseInt(<?= $data['pendapatan']['4']->total ?>),
                    parseInt(<?= $data['pendapatan']['5']->total ?>),
                    parseInt(<?= $data['pendapatan']['6']->total ?>),
                    parseInt(<?= $data['pendapatan']['7']->total ?>),
                    parseInt(<?= $data['pendapatan']['8']->total ?>),
                    parseInt(<?= $data['pendapatan']['9']->total ?>),
                    parseInt(<?= $data['pendapatan']['10']->total ?>),
                    parseInt(<?= $data['pendapatan']['11']->total ?>),
                    parseInt(<?= $data['pendapatan']['12']->total ?>)
                ],
            }]
        }
        const config = {
            type: 'bar',
            data,
            options: {}
        };
        new Chart(
            document.getElementById('chart-pendapatan'),
            config
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
                label: 'Data jenis',
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
                  datalabels : {
                      formatter: (value, ctx) => {
                          let sum = 0;
                          let dataArr = ctx.chart.data.datasets[0].data;
                          dataArr.map(data => {
                              sum += data;
                          });
                          let percentage = (value*100 / sum).toFixed(2)+"%";
                          return percentage;
                      },
                      color: '#fff',
                  }
                },
                
              }
            }
        )


      // Chart pengiriman kg
      new Chart(document.getElementById('chart-pengiriman-kg'),{
        type : 'bar',
        data : {
          labels : [
            <?php foreach($data['data_berat_mitra'] as $k => $v) { ?>
              '<?= $k ?>',
            <?php } ?>
          ],
          datasets : [
            {
              label : 'Kg',
              backgroundColor : 'green',
              data : [
                <?php foreach($data['data_berat_mitra'] as $key => $val) { ?>
                  '<?= $val ?>',
                <?php } ?>
              ]
            },
            
          ]
        },
        options : {
          plugins : {
            legend : {
              onClick : function(e){
                e
              }
            }
          }
        }
      })

      // Chart pengiriman jenis
      // let datajenis
      // let dataj = []
      // new Chart(document.getElementById('chart-pengiriman-jenis'),{
      //   type : 'bar',
      //   data : {
      //     labels : [
      //       <?php foreach($data['data_jenis_mitra'] as $k => $v) { ?>
      //         addEl('<?= $k ?>',<?= json_encode($data['data_jenis_mitra']) ?>),
      //       <?php } ?>
      //     ],
      //     datasets : datajenis
      //   }
      // })

      // function addEl(data,arr){
      //   arr = Object.entries(arr[data]);
      //   datajenis = []  
      //   let d = {}
      //   arr.forEach((v,i) => {
      //     d[v[0]] = v[1]
      //     dataj[v[0]] = []
      //   });
      //   arr.forEach((v,i) => {
      //     let randomColor = Math.floor(Math.random()*16777215).toString(16);
      //   });
      //   console.log('------------');
      //   return data;
      // }
      // console.log(dataj['plastik bentukan']);

   </script>