@extends('layouts/header')

@include('layouts/sidenav')

<div class="main-content">
    @include('layouts/topnav')
    <div class="container-fluid mt-6">
        @if (session('message'))
            <div class="alert alert-{{ session('message')['type'] }}">{{ session('message')["message"] }}</div>
        @endif
        @if (session('level') == 'admin')
            <a href="/tambahProyek" class="btn btn-primary">Tambah user</a>
        @endif
        <div class="row my-4">
            <div class="col-lg-5">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari proyek..." name="search">
                        <button type="submit" class="btn btn-outline-success">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light text-center">
                <tr>
                  <th scope="col" class="sort">No</th>
                  <th scope="col" class="sort">Nama proyek</th>
                  <th scope="col" class="sort">Nama PIC</th>
                  <th scope="col" class="sort">Email</th>
                  <th scope="col" class="sort">Alamat</th>
                  <th scope="col">No hp</th>
                  <th scope="col">Koordinat</th>
                  <th scope="col">Capex</th>
                  <th scope="col">Opex</th>
                  <th scope="col">Jangka waktu</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody class="list bg-white text-center">
                  @forelse ($proyek as $p)
                    <tr>
                        <td>
                            {{ $loop->index+1 }}
                        </td>
                        <td>
                            {{ $p->nama }}
                        </td>
                        <td>
                            {{ $p->nama_pic }}
                        </td>
                        <td>
                            {{ $p->email }}
                        </td>
                        <td>
                            {{ $p->alamat }}
                        </td>
                        <td>
                            {{ $p->no_hp }}
                        </td>
                        <td>
                            {{ $p->koordinat }}
                        </td>
                        <td>
                            {{ $p->capex }}
                        </td>
                        <td>
                            {{ $p->opex }}
                        </td>
                        <td>
                            <?php
                                $now = strtotime($p->end);
                                $your_date = strtotime($p->start);
                                $datediff = $now - $your_date;
                                $jarak = round($datediff / (60 * 60 * 24));
                            ?>
                            {{ $jarak.' Hari' }}
                        </td>
                        <td class="text-right">
                            <table align="center">
                                <tr>
                                    <td>
                                        <a class="text-primary" href="/proyek/profile/{{ $p->id }}"><i class="fas fa-user"></i></a>
                                    </td>
                                    @if (session('level') == 'admin')
                                    <td>
                                        <form action="/proyek/delete/{{ $p->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Anda yakin akan menghapus proyek {{ $p->nama }}')" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="text-success" href="/proyek/edit/{{ $p->id }}"><i class="fas fa-pen"></i></a>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                        
                    </tr>
                  @empty
                      <tr>
                          <td colspan="100%">
                              <span class="text-muted">Tidak ada data proyek lain</span>
                          </td>
                      </tr>
                  @endforelse
                
                
                
                
              </tbody>
            </table>
            <div>
                {{ $proyek->links('vendor.pagination.custom') }}
            </div>
          </div>
    </div>
