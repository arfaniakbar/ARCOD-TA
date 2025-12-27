<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pangwas; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use App\Models\Evidence; // Diperlukan untuk pengecekan relasi, sudah diimport

class PangwasController extends Controller
{
    /**
     * Menampilkan daftar semua Pangwas.
     */
    public function index()
    {
        // Menggunakan latest() agar data terbaru muncul di atas, mengatasi masalah sorting
        $pangwas_list = Pangwas::latest()->paginate(10); 
        
        return view('admin.pangwas.index', compact('pangwas_list'));
    }

    /**
     * Menampilkan formulir untuk membuat Pangwas baru.
     */
    public function create()
    {
        return view('admin.pangwas.create');
    }

    /**
     * Menyimpan Pangwas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pangwas' => 'required|string|max:255|unique:pangwas,nama_pangwas',
        ]);

        Pangwas::create([
            'nama_pangwas' => $request->nama_pangwas,
        ]);

        return redirect()->route('admin.pangwas.index')
                         ->with('success', 'Data Pangwas berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail Pangwas tertentu.
     */
    public function show(Pangwas $pangwas)
    {
        abort(404);
    }


    /**
     * Menampilkan formulir untuk mengedit Pangwas tertentu.
     */
    public function edit(Pangwas $pangwas)
    {
        return view('admin.pangwas.edit', compact('pangwas'));
    }

    /**
     * Memperbarui Pangwas tertentu di database.
     */
    public function update(Request $request, Pangwas $pangwas)
    {
        $request->validate([
            'nama_pangwas' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pangwas', 'nama_pangwas')->ignore($pangwas->id), 
            ],
        ]);

        $pangwas->update([
            'nama_pangwas' => $request->nama_pangwas,
        ]);

        return redirect()->route('admin.pangwas.index')
                         ->with('success', 'Data Pangwas berhasil diperbarui.');
    }

    /**
     * Menghapus Pangwas tertentu dari database.
     */
    public function destroy(Pangwas $pangwas) // Menggunakan $pangwas
    {
        // Cek apakah Pangwas digunakan di tabel evidence
        if ($pangwas->evidence()->exists()) {
            return redirect()->route('admin.pangwas.index')
                             ->with('error', 'Pangwas tidak dapat dihapus karena sudah memiliki data Evidence terkait.');
        }
        
        try {
            $pangwas->delete();

            return redirect()->route('admin.pangwas.index')
                             ->with('success', 'Data Pangwas berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.pangwas.index')
                             ->with('error', 'Gagal menghapus data Pangwas. Error: ' . $e->getMessage());
        }
    }
}