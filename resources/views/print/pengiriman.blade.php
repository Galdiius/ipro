<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <style>
        body{
            font-family: sans-serif;
        }
        .wrapper{
            width: 100%;
        }
        .header{
            text-align: center;
        }.data{
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1 class="title">Struk laporan</h1>
            <h5>No Invoice : {{ $data['id_data'] }}</h5>
        </div>
        <div class="body">
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr align="left" >
                    <th colspan="6"><h3>Informasi pengepul</h3></th>
                </tr>
                <tr>
                    <th><small>Nama petugas</small></th>
                    <th><small>Nama perusahaan</small></th>
                    <th><small>Email</small></th>
                    <th><small>Alamat</small></th>
                    <th><small>No telepon</small></th>
                    <th><small>koordinat</small></th>
                </tr>
                <tr align="center" class="data">
                    <td><small>{{ $data['nama_petugas'] }}</small></td>
                    <td><small>{{ $data['nama_perusahaan'] }}</small></td>
                    <td><small>{{ $data['email'] }}</small></td>
                    <td><small>{{ $data['alamat'] }}</small></td>
                    <td><small>{{ $data['no_hp'] }}</small></td>
                    <td><small>{{ $data['koordinat'] }}</small></td>
                </tr>
                <tr align="left" >
                    <th colspan="6"><h3>Informasi mitra</h3></th>
                </tr>
                <tr>
                    <th><small>Nama mitra</small></th>
                    <th><small>Alamat</small></th>
                    <th><small>Email</small></th>
                    <th><small>No telepon</small></th>
                    <th colspan="2"><small>koordinat</small></th>
                </tr>
                <tr align="center" class="data">
                    <td><small>{{ $data['nama_mitra'] }}</small></td>
                    <td><small>{{ $data['alamat'] }}</small></td>
                    <td><small>{{ $data['email'] }}</small></td>
                    <td><small>{{ $data['no_hp'] }}</small></td>
                    <td colspan="2"><small>{{ $data['koordinat'] }}</small></td>
                </tr>
                <tr align="left" >
                    <th colspan="6"><h3>Informasi pengiriman</h3></th>
                </tr>
                <tr>
                    <th><small>Tanggal</small></th>
                    <th><small>Jumlah material</small></th>
                    <th><small>Jumlah barang</small></th>
                    <th><small>Total berat</small></th>
                    <th><small>Total harga</small></th>
                    <th><small>Status</small></th>
                </tr>
                <tr align="center" class="data">
                    <td><small>{{ $data['tanggal'] }}</small></td>
                    <td><small>{{ count($data['material']) }}</small></td>
                    <td><small>{{ $data['total_barang'] }}</small></td>
                    <td><small>{{ $data['total_berat'] }}Kg</small></td>
                    <td><small>Rp.{{ $data['total_harga'] }}</small></td>
                    <td><small>{{ $data['status_data'] }}</small></td>
                </tr>
                <tr align="left" >
                    <th colspan="6"><h3>Informasi material</h3></th>
                </tr>
                @foreach ($data['material'] as $m)
                    <tr align="center">
                        <td colspan="6">{{ $m['nama_material'] }}</td>
                    </tr>
                    <tr align="center">
                        <td>Harga/kg</td>
                        <td>Berat</td>
                        <td>Total</td>
                        <td colspan="3">Barang</td>
                    </tr>
                    <tr align="center">
                        <td>Rp.{{ $m['harga/kg'] }}</td>
                        <td>{{ $m['berat_kg'] }}</td>
                        <td>Rp.{{ $m['total_harga'] }}</td>
                        <td colspan="3">
                            <ul>
                                @foreach ($m['barang'] as $b)
                                   <li>{{ $b->nama_barang }}</li> 
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                @if ($data['status_data'] != 'sedang dikirim')
                    <tr align="left">
                        <th colspan="6"><h3>Hasil pengiriman</h3></th>
                    </tr>
                    <tr>
                        <th colspan="2"><small>Tanggal terkirim</small></th>
                        <th><small>Berat terkirim</small></th>
                        <th><small>Harga diterima</small></th>
                        <th colspan="2"><small>Status</small></th>
                    </tr>
                    <tr align="center">
                        <td colspan="2"><small>{{ $data['tanggal_terkirim'] }}</small></td>
                        <td><small>{{ $data['total_berat_terkirim'] }}kg</small></td>
                        <td><small>Rp.{{ $data['total_harga_diterima'] }}</small></td>
                        <td colspan="2"><small>{{ $data['tanggal_konfirmasi'] == null ? "Menunggu konfirmasi" : $data['status_data'] }}</small></td>
                    </tr>
                    
                @endif
            </table>
        </div>
    </div>
</body>
</html>