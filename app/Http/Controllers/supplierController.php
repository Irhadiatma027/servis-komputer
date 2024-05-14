<?php

namespace App\Http\Controllers;


use App\Models\supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class supplierController extends Controller
{
    public function tampilData(string $id):View {

        return view('supplier.profile',[
        'supplier' => supplier::findOrFail($id)
        ]);
    }

    public function index(): View
    {
       $supplier = supplier::latest()->paginate(10);
       return view('supplier.index',compact('supplier'));
    }

    public function create(): View
    {
        return view('supplier.create');
    }

    public function store(Request $request): RedirectResponse
    {
       
        //validate form
        $request->validate([
            'nama_supplier'      => 'required|min:5|',
            'alamat'         => 'required|min:5|',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        supplier::create([
            'nama_supplier'          => $request->nama_supplier,
            'alamat'             => $request->alamat,
            'jenis_kelamin'          => bcrypt($request->jenis_kelamin), 
        ]);
        //redirect to index
        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $supplier = supplier::findOrFail($id);

        return view('supplier.show', compact('supplier'));
    }

    public function edit(string $id): View
    {
        $supplier = supplier::findOrFail($id);

        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'nama_supplier'      => 'required|min:5',
            'alamat'         => 'required|min:5',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        $supplier = supplier::findOrFail($id);
        $supplier->update([
                'nama_supplier'  => $request->nama_supplier,
                'alamat'     => $request->alamat,
                'jenis_kelamin'  => md5($request->jenis_kelamin),
            ]);

        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


     public function destroy($id): RedirectResponse
    {
        $supplier = supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


}