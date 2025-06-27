@extends('layout')
@section('sidebar')

    <li class="nav-item menu-open">
      <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ Request::is('/dokter*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <span class="right badge badge-danger">Dokter</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('dokter.jadwal')}}" class="nav-link {{ Request::is('dokter/jadwal*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>
          Jadwal Periksa
          <span class="right badge badge-danger">Dokter</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('dokter.periksa')}}" class="nav-link {{ Request::is('dokter/periksa*') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Memeriksa Pasien
          <span class="right badge badge-danger">Dokter</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('dokter.riwayat')}}" class="nav-link {{ Request::is('dokter/riwayat*') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Riwayat Pasien
          <span class="right badge badge-danger">Dokter</span>
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('dokter.profile')}}" class="nav-link {{ Request::is('dokter/profil*') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Profil
          <span class="right badge badge-danger">Dokter</span>
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

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile Dokter</h1>
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
            
            <!-- Profile Dokter -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Profile Dokter</h3>
                </div>
                <div class="card-body">
                        <form action="{{ route('dokter.profileUpdate') }}" method="POST" id="editForm">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nama">Nama Dokter</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ auth()->user()->nama }}" required>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat Dokter</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ auth()->user()->alamat }}" required>
                            </div>

                            <div class="form-group">
                                <label for="no_hp">Nomor Telepon Dokter</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ auth()->user()->no_hp }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3" id="submitBtn" disabled>
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
           </div>
          </div>
        </div>
      </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('editForm');
        const submitBtn = document.getElementById('submitBtn');

        // Simpan nilai awal
        const initialValues = {
            nama: form.nama.value,
            alamat: form.alamat.value,
            no_hp: form.no_hp.value
        };

        // Deteksi perubahan
        form.addEventListener('input', function () {
            const isChanged =
                form.nama.value !== initialValues.nama ||
                form.alamat.value !== initialValues.alamat ||
                form.no_hp.value !== initialValues.no_hp;

            submitBtn.disabled = !isChanged;
        });
    });
</script>
    
@endsection