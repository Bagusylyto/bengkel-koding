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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar Pemeriksaan</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                    {{-- <th>Biaya Periksa</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($poli as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pasien->nama ?? 'N/A' }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{{ $item->jadwalPeriksa->hari }} ({{ $item->jadwalPeriksa->jam_mulai }} - {{ $item->jadwalPeriksa->jam_selesai }})</td>
                                    <td>{{ $item->status }}</td>
                                    {{-- <td>
                                        @if ($item->periksa)
                                            Rp {{ number_format($item->periksa->biaya_periksa, 0, ',', '.') }}
                                        @else
                                            Belum diperiksa
                                        @endif
                                    </td> --}}
                                    <td>
                                        @if ($item->status == 'menunggu')
                                            <a href="{{ route('dokter.periksaEdit', $item->id) }}" class="btn btn-primary btn-sm">Periksa</a> 
                                        @endif
                                        @if ($item->periksa)
                                            <a href="{{ route('dokter.periksaEdit', $item->periksa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        @endif
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