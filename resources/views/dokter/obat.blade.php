@extends('layout')
@section('sidebar')

    <li class="nav-item menu-open">
      <a href="/dokter" class="nav-link {{ Request::is('/dokter') ? 'active' : '' }}">
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
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
            
            <!-- Form Tambah Obat -->
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">Form Tambah Obat</h3>
              </div>
              <div class="card-body">
                <form action="/dokter/obat/store" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" placeholder="Input obat's name" required>
                  </div>
                  <div class="form-group">
                    <label for="kemasan">Kemasan</label>
                    <input type="text" name="kemasan" class="form-control" placeholder="Input kemasan's name" required>
                  </div>
                  <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" class="form-control" placeholder="Input the price" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Tambah Obat</button>
                </form>
              </div>
            </div>
            
            <!-- Tabel List Obat -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Obat</h3>

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

              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>ID Obat</th>
                      <th>Nama Obat</th>
                      <th>Kemasan</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($obats as $obat)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$obat->id}}</td>
                        <td>{{$obat->nama_obat}}</td>
                        <td>{{$obat->kemasan}}</td>
                        <td>{{$obat->harga}}</td>
                        <td>
                          <a href="" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <form action="" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
                              <i class="fas fa-trash"></i> Delete
                            </button>
                          </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>
    
@endsection