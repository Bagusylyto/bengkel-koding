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
                <h1>Form Pemeriksaan Pasien</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form type="submit" action="{{ route('dokter.periksaUpdate', $daftarPoli->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            {{-- <input type="hidden" name="id_daftar_poli" value="{{ $daftarPoli->id }}"> --}}
                            <div class="form-group">
                                <label for="nama_pasien">Nama Pasien</label>
                                <input type="text" class="form-control" value="{{ $daftarPoli->pasien->nama ?? '' }}" disabled>
                            </div>

                            {{-- <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea class="form-control" disabled>{{ $daftarPoli->keluhan ?? '' }}</textarea>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="jadwal">Jadwal Periksa</label>
                                <select class="form-control">
                                    <option>{{ $daftarPoli->jadwalPeriksa->hari }} ({{ $daftarPoli->jadwalPeriksa->jam_mulai }} - {{ $daftarPoli->jadwalPeriksa->jam_selesai }})</option>
                                </select>
                            </div> --}}

                            <div class="form-group">
                                <label for="jadwal">Tanggal Periksa</label>
                                <input type="date" name="tgl_periksa" class="form-control">
                                    
                                </input>
                            </div>

                            {{-- <div class="form-group">
                                      <label for="tgl_periksa">Tanggal Periksa</label>
                                      <input value="{{ $daftarPoli->periksa->first() ? (\Carbon\Carbon::parse($daftarPoli->periksa->first()->tgl_periksa)->format('Y-m-d\TH:i') ?? '') : now()->format('Y-m-d\TH:i') }}" type="datetime-local" name="tgl_periksa" class="form-control" id="tgl_periksa" placeholder="Pilih tanggal dan jam periksa">
                                      @error('tgl_periksa')
                                          <span class="text-danger">{{ $message }}</span>
                                      @enderror
                            </div> --}}

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control">{{ old('catatan', $catatan) }}</textarea>
                            </div>

                            {{-- <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea name="catatan" class="form-control" placeholder="Masukkan catatan pemeriksaan"></textarea>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="biaya_periksa">Biaya Periksa</label>
                                <input type="number" name="biaya_periksa" id="biaya_periksa" class="form-control" value="{{ old('biaya_periksa', $periksa->biaya_periksa) }}" min="150000" step="0.01" required>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label>Pilih Obat</label>
                                <div id="selected-obats"></div>
                                <select class="form-control" id="obat-select" name="obat_select" style="margin-top: 10px;">
                                    <option value="">Pilih Obat...</option>
                                    @foreach ($obat as $obats)
                                        <option value="{{ $obats->id }}" data-nama="{{ $obats->nama_obat }}" data-kemasan="{{ $obats->kemasan }}" data-harga="{{ $obats->harga }}">
                                            {{ $obats->nama_obat }} - {{ $obats->kemasan }} - Rp {{ number_format($obats->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="add-obat" class="btn btn-primary btn-sm mt-2">Tambah Obat</button>
                                <input type="hidden" name="id_obat" id="id_obat" value="">
                            </div> --}}

                            <div class="form-group">
                                <label>Pilih Obat</label>
                                <select name="id_obat[]" id="obatSelect" class="form-control select2" multiple required>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->id }}"
                                            data-harga="{{ $item->harga }}"
                                            {{ in_array($item->id, $selectedObat) ? 'selected' : '' }}>
                                            {{ $item->nama_obat }} ({{ $item->kemasan }}) - Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group">
                                <label for="biaya_periksa">Biaya Periksa</label>
                                <input type="number" name="biaya_periksa" class="form-control" value="{{ old('biaya_periksa', $periksa->biaya_periksa) }}" min="150000" step="0.01" required>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="total_biaya">Total Biaya (Periksa + Obat)</label>
                                <input type="text" id="total_biaya" class="form-control" value="Rp {{ number_format($periksa->total_biaya, 2, ',', '.') }}" readonly>
                            </div>
                            </div> --}}

                            <div class="form-group">
                                <label>Biaya Periksa</label>
                                <input type="text" id="biayaPeriksa" class="form-control" value="{{ number_format($biayaPeriksa, 0, ',', '.') }}" readonly>
                                <input type="hidden" name="biaya_periksa" id="biayaPeriksaHidden" value="{{ $biayaPeriksa }}">
                            </div>

                            {{-- <div class="form-group">
                                <label for="biaya_periksa">Total Harga</label>
                                <input type="text" class="form-control" id="biaya_periksa" value="{{ number_format($biayaPeriksa, 0, ',', '.') }}" disabled>
                                <input type="hidden" name="biaya_periksa" id="biaya_periksa_hidden" value="{{ $biayaPeriksa }}">
                            </div> --}}

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('dokter.periksa') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            {{-- <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk perhitungan biaya real-time -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#obatSelect').select2({
            placeholder: "Pilih obat",
            allowClear: true
        });

        // Fungsi untuk menghitung biaya total
        function calculateTotal() {
            let totalHargaObat = 0;
            const biayaDasar = 150000;

            $('#obatSelect option:selected').each(function() {
                const harga = parseFloat($(this).data('harga')) || 0;
                totalHargaObat += harga;
            });

            const totalBiaya = biayaDasar + totalHargaObat;
            $('#biayaPeriksa').val('Rp ' + totalBiaya.toLocaleString('id-ID'));
            $('#biayaPeriksaHidden').val(totalBiaya);
        }

        // Hitung biaya saat halaman dimuat
        calculateTotal();

        // Hitung ulang biaya saat obat berubah
        $('#obatSelect').on('change', function() {
            calculateTotal();
        });
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection