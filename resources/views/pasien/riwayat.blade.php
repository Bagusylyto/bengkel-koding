@extends('layout')

@section('sidebar')
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('pasien.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pasien.periksa') }}" class="nav-link">
                    <p>Periksa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pasien.riwayat') }}" class="nav-link active">
                    <p>Riwayat</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Sukses!</h5>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
        {{ session('error') }}
    </div>
@endif
    <section class="content-header"></section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Periksa</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dokter</th>
                                        <th>Tanggal Periksa</th>
                                        <th>Biaya Periksa</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periksas as $periksa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $periksa->dokter->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d-m-Y H:i') }}</td>
                                        <td><span class="badge badge-success">{{ $periksa->biaya_periksa }}</span></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modalDetail{{ $periksa->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal Detail untuk setiap pemeriksaan -->
                                    <div class="modal fade" id="modalDetail{{ $periksa->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $periksa->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Pemeriksaan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Dokter:</strong> {{ $periksa->dokter->nama }}</p>
                                                    <p><strong>Tanggal Periksa:</strong> {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d-m-Y H:i') }}</p>
                                                    <p><strong>Biaya:</strong> {{ $periksa->biaya_periksa }}</p>
                                                    <p><strong>Catatan:</strong> {{ $periksa->catatan ?? 'Belum Ada Catatan' }}</p>
                                                    <p><strong>Obat:</strong></p>
                                                    <ul>
                                                        @forelse ($periksa->detailPeriksas as $detail)
                                                            <li>{{ $detail->obat->nama_obat }} | {{ $detail->obat->kemasan }}</li>
                                                        @empty
                                                            <li>-</li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection