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
                <h1 class="m-0">Edit Poli</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Form Edit Poli</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.poliUpdate', $poli->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_poli">Nama Poli</label>
                            <input type="text" name="nama_poli" class="form-control" value="{{ $poli->nama_poli }}" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control" required>{{ $poli->keterangan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Poli</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection