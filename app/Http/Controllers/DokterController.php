<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function dashboardDokter(){
        $jumlahPasienMenunggu = DaftarPoli::where('status', 'menunggu')->count();
        $jumlahJadwalHariIni = JadwalPeriksa::where('hari', now()->dayOfWeek)->count();
        $totalPemeriksaan = Periksa::count();
        $jumlahObat = Obat::count();
        
        return view('dokter.dashboard', compact('jumlahPasienMenunggu', 'jumlahJadwalHariIni', 'totalPemeriksaan', 'jumlahObat'));
    }

    //Jadwal Periksa
    public function indexJadwal()
    {
        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('hari','asc')
            ->orderBy('jam_mulai','asc')
            ->get();
        return view('dokter.jadwal',compact('jadwal'));
    }

    public function addJadwal()
    {   
        return view('dokter.jadwalAdd');
    }

    public function storeJadwal(Request $request){

        // Validasi input dari form
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Simpan data ke database
        JadwalPeriksa::create([
            'id_dokter' => Auth::id(), // diasumsikan dokter login
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status ?? 'nonaktif', // hardcoded status
        ]);

        return redirect()->route('dokter.jadwal')->with('success', 'Jadwal periksa berhasil ditambahkan.');

    }

     public function editJadwal($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        return view('dokter.jadwalEdit', compact('jadwal'));
    }

    public function updateJadwal(Request $request, $id){
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jadwal = JadwalPeriksa::findOrFail($id);

        if ($request->status == 'aktif') {
            // Nonaktifkan semua jadwal milik dokter yang sama
            JadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                ->where('id', '!=', $jadwal->id)
                ->update(['status' => 'nonaktif']);
        }

        // Update status jadwal ini
        $jadwal->update(['status' => $request->status]);
        $jadwal->save();

        return redirect()->route('dokter.jadwal')->with('success', 'Status jadwal berhasil diperbarui.');

    }

    // Periksa
    public function indexPeriksa()
    {
        $dokterId = Auth::id(); // Ambil ID dokter yang sedang login
        if (!$dokterId) {
            $poli = collect(); // Koleksi kosong jika tidak ada dokter
        } else {
            $poli = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })->with('jadwalPeriksa', 'pasien', 'periksa')->get();
        }

        return view('dokter.periksa', compact('poli'));

    }

    public function formPeriksa($id_daftar_poli)
    {
        $daftarPoli = DaftarPoli::with('jadwalPeriksa.dokter', 'pasien')->findOrFail($id_daftar_poli);
        $obat = Obat::all();
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())->get();

        return view('dokter.periksaForm', compact('obat', 'jadwalPeriksa', 'daftarPoli'));
    }

    public function storePeriksa(Request $request)
    {
        $validatedData = $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'catatan' => 'nullable|string|max:255',
            'biaya_periksa' => 'required|numeric|min:150000', // Biaya minimal 150000
            'id_obat' => 'nullable|array',
            'id_obat.*' => 'exists:obat,id',
            'tgl_periksa' => 'required|date',
        ]);

        return DB::transaction(function () use ($validatedData) {
            $daftarPoli = DaftarPoli::findOrFail($validatedData['id_daftar_poli']);

            // Logika untuk menyimpan data ke tabel Periksa dan DetailPeriksa
            $periksa = Periksa::create([
                'id_daftar_poli' => $validatedData['id_daftar_poli'],
                'id_dokter' => Auth::id(), // Ambil ID dokter yang sedang login
                'id_pasien' => $daftarPoli->id_pasien, // Ambil ID pasien dari DaftarPoli            
                'catatan' => $validatedData['catatan'],
                'biaya_periksa' => $validatedData['biaya_periksa'],
                'tgl_periksa' => $validatedData['tgl_periksa'],
            ]);

            if (!empty($validatedData['id_obat'])) {
                foreach ($validatedData['id_obat'] as $obatId) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $obatId,
                        'jumlah' => 1, // Asumsikan jumlah obat adalah 1
                    ]);
                }
            }
        
            // Update status daftar_poli menjadi 'selesai'
            $daftarPoli->update(['status' => 'selesai']);

            return redirect()->route('dokter.periksa')->with('success', 'Periksa pasien berhasil disimpan.');
        }, 5); // Retry up to 5 times in case of deadlock
    }

    public function editPeriksa($id_daftar_poli)
    {
        try {
            $daftarPoli = DaftarPoli::with(['periksa.detailPeriksa.obat', 'pasien', 'jadwalPeriksa'])->findOrFail($id_daftar_poli);
            $obat = Obat::select('id', 'nama_obat', 'kemasan', 'harga')->get();
            $periksa = $daftarPoli->periksa;
            $selectedObat = $periksa ? $periksa->detailPeriksa->pluck('id_obat')->toArray() : [];
            $catatan = $periksa ? $periksa->catatan ?? '' : '';
            $biayaPeriksa = $periksa ? $periksa->biaya_periksa ?? 150000 : 150000;

            return view('dokter.periksaEdit', compact('periksa', 'obat', 'selectedObat','catatan','daftarPoli', 'biayaPeriksa'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

    }

    public function updatePeriksa(Request $request, $id)
    {
        $catatan = $request->input('catatan');
        $tgl_periksa = $request->input('tgl_periksa');
        $biaya_periksa = $request->input('biaya_periksa');
        $id_obat = $request->input('id_obat');
        
        $daftarPoli = DaftarPoli::findOrFail($id);
        $periksa = $daftarPoli->periksa()->firstOrNew([
            'id_daftar_poli' => $id,
            'id_dokter' => Auth::id(),
            'id_pasien' => $daftarPoli->id_pasien,
        ]);
            // dd($periksa);

            // Hitung total biaya obat
            $totalHargaObat = Obat::whereIn('id', $id_obat)->sum('harga');
            $biayaPeriksa = 150000 + $totalHargaObat;

            // Update atau buat data periksa
            $periksa->fill([
                'id_daftar_poli' => $id,
                'id_dokter' => Auth::id(),
                'id_pasien' => $daftarPoli->id_pasien,
                'catatan' => $catatan,
                'tgl_periksa' => $tgl_periksa,
                'biaya_periksa' => $biayaPeriksa,
            ])->save();

            // Hapus detail periksa sebelumnya
            $periksa->detailPeriksa()->delete();

            foreach ($id_obat as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                    'jumlah' => 1 // Asumsikan jumlah obat adalah 1
                ]);
                $periksa->detailPeriksa()->create(['id_obat' => $obatId]);
            }

            // Update status daftar_poli menjadi 'selesai'
            $daftarPoli->update(['status' => 'selesai']); // Perbaikan: Tambah update status

            return redirect()->route('dokter.periksa')->with('success', 'Pemeriksaan pasien berhasil diperbarui.');
    }

    // Riwayat
    public function indexRiwayat()
    {
        $dokter = Auth::user();
        if (!$dokter || $dokter->role !== 'dokter') {
            return redirect()->back()->with('error', 'Anda bukan dokter.');
        }

        // $jadwal = $dokter->jadwalPeriksa()->get();
        $jadwal = JadwalPeriksa::where('id_dokter', $dokter->id)->get();
        $daftarPoli = DaftarPoli::whereIn('id_jadwal', $jadwal->pluck('id'))
            ->with(['pasien'])
            ->get();
        $uniquePasien = $daftarPoli->unique('id_pasien')->map(function ($daftarPoli) {
            $pasien = $daftarPoli->pasien;
            return [
                'no' => null,
                'id' => $pasien->id ?? 'N/A',
                'nama_pasien' => $pasien->nama ?? 'N/A',
                'alamat' => $pasien->alamat ?? 'N/A',
                'no_ktp' => $pasien->no_ktp ?? 'N/A',
                'no_telepon' => $pasien->no_hp ?? 'N/A',
                'no_rm' => $pasien->no_rm ?? 'N/A',
                'aksi' => $daftarPoli->id,
            ];
        })->values();

        return view('dokter.riwayat', compact('uniquePasien'));
    }

    public function riwayatDetail($id)
    {
        try {
            $daftarPoli = DaftarPoli::with(['pasien', 'periksa.detailPeriksa.obat', 'jadwalPeriksa.dokter'])->findOrFail($id);
            $allPeriksa = DaftarPoli::where('id_pasien', $daftarPoli->id_pasien)
                ->with(['periksa.detailPeriksa.obat', 'jadwalPeriksa.dokter'])
                ->get()
                ->pluck('periksa')
                ->flatten()
                ->filter();

            $riwayat = $allPeriksa->map(function ($periksa, $index) use ($daftarPoli) {
                $obatList = $periksa->detailPeriksa->map(function ($detail) {
                    return $detail->obat ? "{$detail->obat->nama_obat} {$detail->obat->kemasan} - Rp " . number_format($detail->obat->harga, 0, ',', '.') : 'N/A';
                })->implode('<br>');

                return [
                    'no' => $index + 1,
                    'tanggal_periksa' => $periksa ? \Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d H:i:s') : 'Belum diperiksa',
                    'nama_pasien' => $daftarPoli->pasien->nama ?? 'N/A',
                    'nama_dokter' => $periksa->dokter->nama ?? 'N/A',
                    'keluhan' => $periksa->daftarPoli->keluhan ?? 'N/A',
                    'catatan' => $periksa->catatan ?? 'Belum ada catatan',
                    'obat' => $obatList,
                    'biaya_periksa' => $periksa->biaya_periksa ? "Rp " . number_format($periksa->biaya_periksa ?? 0, 0, ',', '.') : 'Rp 0',
                ];
            })->all();

            return response()->json($riwayat);
        } catch (\Exception $e) {
            Log::error('Error in showPasienDetail: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memuat detail pasien.'], 500);
        }
    }

    // Profil
    public function indexProfile()
    {
        $dokter = Auth::user(); // Jika user adalah dokter

        return view('dokter.profile', compact('dokter'));
    }

    public function profileUpdate(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        // $dokterId = Auth::user(); // Ambil user yang sedang login

        $dokterId = Auth::id();

        $dokter = User::find($dokterId);

        if (!$dokter) {
            return redirect()->back()->with('error', 'Dokter tidak ditemukan.');
        }

        // Update data
        $dokter->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
        ]);


        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    //Obat
    public function showObat()
    {
        $obat = Obat::all();
        return view('dokter.obat', compact('obat'));
    }

    public function storeObat(Request $request)
    {
        $validateData = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => ['required']
        ]);

        Obat::create([
            'nama_obat' => $validateData['nama_obat'],
            'kemasan' => $validateData['kemasan'],
            'harga' => $validateData['harga']
        ]);

        return redirect()->route('dokter.obat')->with('success', 'Obat berhasil ditambahkan');
    }

    public function updateObat(Request $request, $id){

        $validatedData = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => ['required'],
        ]);

        $obat = Obat::findOrFail($id);

        $obat->update([
            'nama_obat' => $validatedData['nama_obat'],
            'kemasan' => $validatedData['kemasan'],
            'harga' => $validatedData['harga'],
        ]);

        return redirect()->route('dokter.obat')->with('success', 'Obat berhasil diperbarui');

    }


    public function destroyObat($id){

        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('dokter.obat')->with('success', 'Obat berhasil dihapus!');
    }

    public function editObat($id)
    {
        $obat = Obat::findOrFail($id);
        return view('dokter.obatEdit', compact('obat'));
    }
}
//     // public function editPeriksa($id)
//     // {
//     //     $periksa = Periksa::findOrFail($id);
//     //     $obats = Obat::all(); // Semua obat
//     //     $selectedObats = $periksa->detailPeriksas()->pluck('id_obat')->toArray(); 
//     //     return view('dokter.periksaEdit', compact('periksa', 'obats', 'selectedObats'));
//     // }

//     // public function showPeriksa()
//     // {
//     //     $periksas = Periksa::where('id_dokter', Auth::user()->id)->get();
//     //     $obats = Obat::all();
//     //     return view('dokter.periksa', compact('periksas', 'obats'));
//     // }