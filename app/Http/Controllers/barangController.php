<?php

namespace App\Http\Controllers;


use App\Models\barang;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class barangController extends Controller
{
    public function tampilData(string $id):View {

        return view('barang.profile',[
        'barang' => barang::findOrFail($id)
        ]);
    }

    public function index(): View
    {
       $barang = barang::latest()->paginate(10);
       return view('barang.index',compact('barang'));
    }

    public function create(): View
    {
        return view('barang.create');
    }

    public function store(Request $request): RedirectResponse
    {
       
        //validate form
        $request->validate([
            'nama_barang'      => 'required|min:5|',
            'alamat'         => 'required|min:5|',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        barang::create([
            'nama_barang'          => $request->nama_barang,
            'alamat'             => $request->alamat,
            'jenis_kelamin'          => bcrypt($request->jenis_kelamin), 
        ]);
        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $barang = barang::findOrFail($id);

        return view('barang.show', compact('barang'));
    }

    public function edit(string $id): View
    {
        $barang = barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'nama_barang'      => 'required|min:5',
            'alamat'         => 'required|min:5',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        $barang = barang ::findOrFail($id);
        $barang ->update([
                'nama_barang r'  => $request->nama_barang ,
                'alamat'     => $request->alamat,
                'jenis_kelamin'  => md5($request->jenis_kelamin),
            ]);

        return redirect()->route('barang .index')->with(['success' => 'Data Berhasil Diubah!']);
    }


     public function destroy($id): RedirectResponse
    {
        $barang  = barang ::findOrFail($id);
        $barang ->delete();
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


}