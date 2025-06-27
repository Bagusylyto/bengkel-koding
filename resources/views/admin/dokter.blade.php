@extends('layout')

@section('sidebar')

    <li class="nav-item">
      <a href="/admin" class="nav-link {{ Request::is('/admin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>
          Dashboard
          <span class="right badge badge-success">Admin</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/admin/dokter" class="nav-link {{ Request::is('admin/dokter*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-md"></i>
        <p>
          Dokter
          <span class="right badge badge-success">Admin</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/admin/pasien" class="nav-link {{ Request::is('admin/pasien*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-injured"></i>
        <p>
          Pasien
          <span class="right badge badge-success">Admin</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/admin/poli" class="nav-link {{ Request::is('admin/poli*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hospital"></i>
        <p>
          Poli
          <span class="right badge badge-success">Admin</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="/admin/obat" class="nav-link {{ Request::is('admin/obat*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pills"></i>
        <p>
          Obat
          <span class="right badge badge-success">Admin</span>
        </p>
      </a>
    </li>
    <li class="nav-item">
      <form action={{route('auth.logout.post')}} method="post">
          @csrf
      
      <button type="submit" class="nav-link ">
      <p>
        Logout
      </p>
      </button>
      </form>
   </li>

@endsection

@section('content')

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah / Edit Dokter</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dokter</li>
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
              {{-- <div class="card-header bg-primary text-white">
                <h3 class="card-title">Tambah / Edit Dokter</h3>
              </div> --}}
              <div class="card-body">
                <form action="{{ route('admin.dokterStore') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="nama">Nama Dokter</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Dokter" required>
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                  </div>
                  <div class="form-group">
                    <label for="no_hp">No_Hp</label>
                    <input type="number" name="no_hp" class="form-control" placeholder="No Hp" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="email@gmail.com" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="****" required>
                  </div>
                  <div class="form-group">
                    <label for="id_poli">Poli</label>
                    {{-- <input type="name" name="harga" class="form-control" placeholder="Input Poli" required> --}}
                    <select name="id_poli" id="id_poli" class="form-control" required>
                    <option value="">Pilih Poli</option>
                      @foreach ($poli as $polis)
                        <option value="{{ $polis->id }}">{{ $polis->nama_poli }}</option>
                      @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Tambah Dokter</button>
                </form>
              </div>
            </div>
            
            <!-- Tabel List Obat -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Dokter</h3>

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
                      <th>No</th>
                      <th>Nama Dokter</th>
                      <th>Alamat</th>
                      <th>No_Hp</th>
                      <th>Poli</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dokter as $dokters)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$dokters->nama}}</td>
                        <td>{{$dokters->alamat}}</td>
                        <td>{{$dokters->no_hp}}</td>
                        <td>{{$dokters->poli->nama_poli}}</td>
                        <td>
                          <a href="{{ route('admin.dokterEdit', $dokters->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <form action="{{ route('admin.dokterDelete', $dokters->id) }}" method="POST" style="display:inline;">
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