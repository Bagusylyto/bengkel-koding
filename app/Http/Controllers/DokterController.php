<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\User;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function dashboardDokter()
    {
        return view('dokter.dashboard');
        // $dokter = User::where('id', Auth::user()->id)->first();
        // $namaDokter = $dokter->nama;
        // $periksas = Periksa::all(); 
        // // $periksas = Periksa::where('id_dokter', Auth::user()->id)->get();
        // $obats = Obat::all(); 
        // return view('dokter.dashboard', compact('namaDokter', 'periksas', 'obats'));
    }
    
    public function showObat()
    {
        $obats = Obat::all();
        return view('dokter.obat', compact('obats'));
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

    public function updatePeriksa(Request $request, $id)
    {
        $validatedData = $request->validate([
            'catatan' => 'required|string|max:255',
            'biaya_periksa' => 'required',
            'id_obat' => 'array', // Harus array jika multiple
            'id_obat.*' => 'exists:obats,id', // Pastikan setiap id_obat valid
        ]);

        $periksa = Periksa::findOrFail($id);

        $periksa->update([
            'catatan' => $validatedData['catatan'],
            'biaya_periksa' => $validatedData['biaya_periksa'],
        ]);

        // Hapus data obat sebelumnya, agar tidak dobel
        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        // Simpan data obat baru
        if (!empty($validatedData['id_obat'])) {
            foreach ($validatedData['id_obat'] as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.periksa')->with('success', 'Pemeriksaan berhasil diperbarui!');
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

    public function editPeriksa($id)
    {
        $periksa = Periksa::findOrFail($id);
        $obats = Obat::all(); // Semua obat
        $selectedObats = $periksa->detailPeriksas()->pluck('id_obat')->toArray(); 
        return view('dokter.periksaEdit', compact('periksa', 'obats', 'selectedObats'));
    }

    public function showPeriksa()
    {
        $periksas = Periksa::where('id_dokter', Auth::user()->id)->get();
        $obats = Obat::all();
        return view('dokter.periksa', compact('periksas', 'obats'));
    }
}