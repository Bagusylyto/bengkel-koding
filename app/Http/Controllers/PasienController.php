<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\User;
use App\Models\Poli;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\DetailPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function dashboardPasien(){
        $periksa = Periksa::all(); 
        return view('pasien.dashboard', compact('periksa'));
    }

    public function indexDaftar()
    {
        $poli = Poli::all();
        $jadwal = JadwalPeriksa::with('dokter')->get();
        $riwayat = DaftarPoli::with('jadwalPeriksa.dokter.poli')->where('id_pasien', Auth::id())->get();
        return view('pasien.daftar', compact('poli', 'jadwal', 'riwayat'));
    }

    public function showPoli(Request $request)
    {
        $poli = Poli::all();
        $selectedPoliId = $request->input('id_poli');
        $jadwal = JadwalPeriksa::with('dokter')
            ->when($selectedPoliId, function ($query) use ($selectedPoliId) {
                return $query->whereHas('dokter.poli', function ($query) use ($selectedPoliId) {
                    $query->where('id', $selectedPoliId);
                });
            })
            ->get();

        if ($request->ajax()) {
            return response()->json(['jadwal' => $jadwal]);
        }

        return view('pasien.daftar', compact('poli', 'jadwal'));
    }

    public function storeDaftar(Request $request)
    {
        $request->validate([
            'id_poli' => 'required|exists:poli,id',
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:1000',
        ]);

        $no_antrian = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian') + 1 ?? 1;
        DaftarPoli::create([
            'id_pasien' => Auth::id(),
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $this->generateQueueNumber($request->id_jadwal),
        ]);

        return redirect()->route('pasien.daftar')->with('success', 'Pendaftaran berhasil.');
    }

    public function indexPeriksa()
    {
        $periksa = Periksa::where('id_pasien', Auth::id())->with('detailPeriksa.obat')->get();
        return view('pasien.riwayat', compact('periksa'));
    }
    
    private function generateQueueNumber($id_jadwal)
    {
        return DaftarPoli::where('id_jadwal', $id_jadwal)->max('no_antrian') + 1 ?? 1;
    }
}