<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\User;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\DetailPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{

    public function dashboardPasien(){
        return view('pasien.dashboard');
        // $periksas = Periksa::all(); 
        // return view('pasien.dashboard', compact('periksas'));
    }

    public function showPeriksas()
    {
        $daftarPoli = DaftarPoli::where('id_pasien', Auth::id())->with('periksa')->get();
        return view('pasien.riwayat', compact('daftarPoli'));
    //     $DetailPeriksas = DetailPeriksa::all(); 
    //     $periksas = Periksa::where('id_pasien', Auth::user()->id)->get();
    //    return view('pasien.riwayat', compact('DetailPeriksas', 'periksas'));
    }

    public function createPeriksa()
    {
         $jadwal = JadwalPeriksa::with('dokter')->get();
        return view('pasien.periksa', compact('jadwal'));
        // $dokters = User::where('role', 'dokter')->get(); // Ambil semua dokter dari database
        // return view('pasien.periksa', compact('dokters'));
    }

    /**
     * Menyimpan data pemeriksaan baru ke database.
     */
    public function storePeriksa(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_dokter' => 'required|exists:users,id,role,dokter',
            'tgl_periksa' => 'required|date|after:now',
        ]);

        // Simpan data pemeriksaan
        Periksa::create([
            'id_pasien' => Auth::user()->id,
            'id_dokter' => $request->id_dokter,
            'tgl_periksa' => $request->tgl_periksa,
            'biaya_periksa' => 0, // Default, bisa diubah oleh dokter nanti
            'catatan' => null, // Default, bisa diisi oleh dokter nanti
        ]);

        // Redirect ke halaman riwayat dengan pesan sukses
        return redirect()->route('pasien.riwayat')->with('success', 'Pemeriksaan berhasil dijadwalkan!');
    }

   
}