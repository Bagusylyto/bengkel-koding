@extends('layout')
@section('sidebar')

    <li class="nav-item menu-open">
      <a href="/pasien" class="nav-link {{ Request::is('/pasien') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/pasien/periksa" class="nav-link {{ Request::is('pasien/periksa*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>
          Periksa
          <span class="right badge badge-danger">New</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/pasien/riwayat" class="nav-link {{ Request::is('pasien/riwayat*') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Riwayat
          <span class="badge badge-info right">{{ $periksas->count() }}</span>
        </p>
      </a>
    </li>

@endsection

@section('content')

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pasien</h1>
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
                <h3 class="card-title">Periksa</h3>
              </div>
              <div class="card-body">
                <form action="/dokter/obat/store" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="nama_obat">Nama Anda</label>
                    <input type="text" name="nama_obat" class="form-control" placeholder="Input obat's name" required>
                  </div>
                  <div class="form-group">
                    <label for="kemasan">Pilih Dokter</label>
                    <select name="kemasan" class="form-control" required>
                      <option value="" disabled selected>Pilih Dokter</option>
                      <option value="Botol">Botol</option>
                      <option value="Strip">Strip</option>
                      <option value="Box">Box</option>
                      <option value="Sachet">Sachet</option>
                    </select>
                  </div>
                  
                  
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
            
           
          </div>
        </div>
      </div>
    </section>
    
@endsection