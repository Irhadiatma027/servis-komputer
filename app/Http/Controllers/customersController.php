<?php

namespace App\Http\Controllers;


use App\Models\customers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class customersController extends Controller
{
    public function tampilData(string $id):View {

        return view('customers.profile',[
        'customers' => customers::findOrFail($id)
        ]);
    }

    public function index(): View
    {
       $customers = customers::latest()->paginate(10);
       return view('customers.index',compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
       
        //validate form
        $request->validate([
            'nama_customers'      => 'required|min:5|',
            'alamat'         => 'required|min:5|',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        customers::create([
            'nama_customers'          => $request->nama_customers,
            'alamat'             => $request->alamat,
            'jenis_kelamin'          => bcrypt($request->jenis_kelamin), 
        ]);
        //redirect to index
        return redirect()->route('customers.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $customers = customers::findOrFail($id);

        return view('customers.show', compact('customers'));
    }

    public function edit(string $id): View
    {
        $customers = customers::findOrFail($id);

        return view('customers.edit', compact('customers'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'nama_customers'      => 'required|min:5',
            'alamat'         => 'required|min:5',
            'jenis_kelamin'      => 'required|min:5',
        ]);

        $customers = customers::findOrFail($id);
        $customers->update([
                'nama_customers'  => $request->nama_customers,
                'alamat'     => $request->alamat,
                'jenis_kelamin'  => md5($request->jenis_kelamin),
            ]);

        return redirect()->route('customers.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


     public function destroy($id): RedirectResponse
    {
        $customers = customers::findOrFail($id);
        $customers->delete();
        return redirect()->route('customers.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


}