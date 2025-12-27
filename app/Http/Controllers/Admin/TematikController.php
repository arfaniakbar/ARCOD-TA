<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tematik; // Wajib diimport
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TematikController extends Controller
{
    /**
     * Menampilkan daftar semua Tematik.
     */
    public function index()
    {
        $tematik_list = Tematik::orderBy('nama_tematik')->paginate(10);
        
        return view('admin.tematik.index', compact('tematik_list'));
    }

    /**
     * Menampilkan formulir untuk membuat Tematik baru.
     */
    public function create()
    {
        return view('admin.tematik.create');
    }

    /**
     * Menyimpan Tematik baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tematik' => 'required|string|max:255|unique:tematik,nama_tematik',
        ], [
            'nama_tematik.required' => 'Nama Tematik wajib diisi.',
            'nama_tematik.unique' => 'Nama Tematik ini sudah terdaftar.',
        ]);

        Tematik::create(['nama_tematik' => $request->nama_tematik]);

        return redirect()->route('admin.tematik.index')
                         ->with('success', 'Data Tematik berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit Tematik tertentu.
     */
    public function edit(Tematik $tematik) 
    {
        return view('admin.tematik.edit', compact('tematik'));
    }

    /**
     * Memperbarui Tematik tertentu di database.
     */
    public function update(Request $request, Tematik $tematik)
    {
        $request->validate([
            'nama_tematik' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tematik', 'nama_tematik')->ignore($tematik->id),
            ],
        ], [
            'nama_tematik.required' => 'Nama Tematik wajib diisi.',
            'nama_tematik.unique' => 'Nama Tematik ini sudah digunakan oleh data lain.',
        ]);

        $tematik->update(['nama_tematik' => $request->nama_tematik]);

        return redirect()->route('admin.tematik.index')
                         ->with('success', 'Data Tematik berhasil diperbarui.');
    }

    /**
     * Menghapus Tematik tertentu dari database.
     */
    public function destroy(Tematik $tematik)
    {
        // Pengecekan relasi sebelum hapus (Asumsi relasi evidence() sudah ada di Model Tematik)
        if ($tematik->evidence()->exists()) {
            return redirect()->route('admin.tematik.index')
                             ->with('error', 'Tematik tidak dapat dihapus karena sudah memiliki data Evidence terkait.');
        }
        
        $tematik->delete();

        return redirect()->route('admin.tematik.index')
                         ->with('success', 'Data Tematik berhasil dihapus.');
    }
}