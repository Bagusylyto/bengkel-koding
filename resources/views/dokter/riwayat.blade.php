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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Riwayat Pasien</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pasien yang Mendaftar Poli</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if ($uniquePasien->isEmpty())
                                <p class="text-center">Tidak ada riwayat pasien yang ditemukan.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Pasien</th>
                                            <th>Nama Pasien</th>
                                            <th>Alamat</th>
                                            <th>No. KTP</th>
                                            <th>No. Telepon</th>
                                            <th>No. RM</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($uniquePasien as $index => $pasien)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pasien['id'] }}</td>
                                                <td>{{ $pasien['nama_pasien'] }}</td>
                                                <td>{{ $pasien['alamat'] }}</td>
                                                <td>{{ $pasien['no_ktp'] }}</td>
                                                <td>{{ $pasien['no_telepon'] }}</td>
                                                <td>{{ $pasien['no_rm'] }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info detail-btn" data-id="{{ $pasien['aksi'] }}">Detail</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #007bff; color: white;">
                    <h5 class="modal-title" id="detailModalLabel">Detail Riwayat Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Periksa</th>
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
                                <th>Keluhan</th>
                                <th>Catatan</th>
                                <th>Obat</th>
                                <th>Biaya Periksa</th>
                            </tr>
                        </thead>
                        <tbody id="modal-riwayat">
                            <!-- Data akan diisi via JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal -->
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.detail-btn').on('click', function() {
            var daftarPoliId = $(this).data('id');

            if (!daftarPoliId) {
                alert('ID tidak ditemukan.');
                return;
            }

            $.ajax({
                url: '{{ route("dokter.riwayatDetail", ["id" => ":id"]) }}'.replace(':id', daftarPoliId),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#modal-riwayat').empty();
                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(function(item) {
                            $('#modal-riwayat').append(`
                                <tr>
                                    <td>${item.no}</td>
                                    <td>${item.tanggal_periksa}</td>
                                    <td>${item.nama_pasien}</td>
                                    <td>${item.nama_dokter}</td>
                                    <td>${item.keluhan}</td>
                                    <td>${item.catatan}</td>
                                    <td>${item.obat}</td>
                                    <td>${item.biaya_periksa}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#modal-riwayat').append(`
                            <tr>
                                <td colspan="8">Tidak ada riwayat pemeriksaan.</td>
                            </tr>
                        `);
                    }
                    $('#detailModal').modal('show');
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    alert('Gagal memuat detail pasien: ' + (xhr.responseJSON?.error || 'Error tidak diketahui'));
                }
            });
        });
    });
</script>

@endsection