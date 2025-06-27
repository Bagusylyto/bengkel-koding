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

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Dokter</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title">Form Edit Dokter</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('admin.dokterUpdate', $dokter->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $dokter->nama }}" required>
                  </div>
                  <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" name="email" id="email" class="form-control" value="{{ $dokter->email }}" required>
                        </div>
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" name="password" id="password" class="form-control" value="{{ $dokter->password }}"required>
                        </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $dokter->alamat }}" required>
                  </div>
                  <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $dokter->no_hp }}" required>
                  </div>
                  <div class="form-group">
                 <div class="form-group">
                    <label for="id_poli">Poli</label>
                    <select name="id_poli" id="id_poli" class="form-control" required>
                        <option value="">Pilih Poli</option>
                        @foreach ($poli as $polis)
                        <option value="{{ $polis->id }}" {{ $dokter->id_polis == $polis->id ? 'selected' : '' }}>
                            {{ $polis->nama_poli }}
                        </option>
                        @endforeach
                    </select>
                  </div>

                  <button class="btn btn-primary">Update Dokter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection