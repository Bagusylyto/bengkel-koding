<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Poli;
use App\Models\Obat;

class AdminController extends Controller
{
    public function dashboardAdmin(){
        return view('admin.dashboard');
    }

    //Dokter
    public function showDokter(){
        $dokters = User::where('role', 'dokter')->get();
        return view('admin.dokter', compact('dokters'));
    }

    public function listDokter(Request $request){
        return $this->showDokter();
    }

    public function editDokter($id){
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        return view('admin.dokterEdit', compact('dokter'));
    }

    public function updateDokter(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $dokter->update($request->only(['nama', 'alamat', 'no_hp', 'email']));

        return redirect()->route('admin.dokter')->with('success', 'Data dokter berhasil diperbarui');
    }

    public function destroyDokter($id){
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $dokter->delete();

        return redirect()->route('admin.dokter')->with('success', 'Data dokter berhasil dihapus');
    }

    //Pasien
    public function showPasien(){
        $pasiens = User::where('role', 'pasien')->get();
        return view('admin.pasien', compact('pasiens'));
    }

    public function listPasien(Request $request){
        return $this->showPasien();
    }

    public function editPasien($id){
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        return view('admin.pasienEdit', compact('pasien'));
    }

    public function updatePasien(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $pasien->update($request->only(['nama', 'alamat', 'no_hp', 'email']));

        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroyPasien($id){
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $pasien->delete();

        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil dihapus');
    }

    //Poli
    public function showPoli(){
        $polis = Poli::all();
        return view('admin.poli', compact('polis'));
    }

    public function listPoli(Request $request){
        return $this->showPoli();
    }

    public function editPoli($id){
        $poli = Poli::findOrFail($id);
        return view('admin.poliEdit', compact('poli'));
    }

    public function updatePoli(Request $request, $id){
        $validatedData = $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($validatedData);

        return redirect()->route('admin.poli')->with('success', 'Poli berhasil diperbarui');
    }

    public function destroyPoli($id){
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('admin.poli')->with('success', 'Poli berhasil dihapus');
    }

    //Obat
    public function showObat()
    {
        $obats = Obat::all();
        return view('admin.obat', compact('obats'));
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

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil ditambahkan');
    }

    public function updateObat(Request $request, $id){

        $validatedData = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => ['required'],
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validatedData);

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil diperbarui');

    }

    public function editObat($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obatEdit', compact('obat'));
    }

    public function destroyObat($id){

        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil dihapus!');
    }
}
