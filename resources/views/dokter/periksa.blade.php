@extends('layout')
@section('sidebar')

    <li class="nav-item menu-open">
      <a href="#" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/dokter/periksa" class="nav-link {{ Request::is('dokter/periksa*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>
          Periksa
          <span class="right badge badge-danger">New</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/dokter/obat" class="nav-link {{ Request::is('dokter/obat*') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Obat
          <span class="badge badge-info right">{{ $obats->count() }}</span>
        </p>
      </a>
    </li>

@endsection
@section('content')

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dokter</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tabless</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Periksa</h3>

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
                      <th>ID</th>
                      <th>ID Periksa</th>
                      <th>Nama Pasien</th>
                      <th>Tanggal Periksa</th>
                      <th>Catatan</th>
                      <th>Biaya</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($periksas as $periksa)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$periksa->id}}</td>
                        <td>{{$periksa->pasien->nama}}</td>
                        <td>{{$periksa->tgl_periksa}}</td>
                        <td><span class="tag tag-success">{{$periksa->catatan}}</span></td>
                        <td>{{$periksa->biaya_periksa}}</td>
                      </tr>
                     
                        
                    @endforeach
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        
        <!-- /.row -->
        
        <!-- /.row -->
       
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
@endsection