<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    protected $userID = 1;

    public function __construct()
    {
        $this->userID;
    }
    public function index()
    {
        $dokter = User::where('id', $this->userID)->first();
        $namaDokter = $dokter->nama;
        return view('dokter.dashboard',compact('namaDokter'));
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

        return redirect()->route('dokter.obat');
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

        return redirect()->route('dokter.obat');

    }

    public function destroyObat($id){

        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('dokter.obat');
    }

    public function editObat($id)
    {
        $obat = Obat::findOrFail($id);
        return view('dokter.obatEdit', compact('obat'));
    }
}