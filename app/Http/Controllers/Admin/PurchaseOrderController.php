<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder; 
use App\Models\Evidence; // Wajib diimpor untuk logika status
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    /**
     * Menampilkan daftar semua Purchase Order.
     */
    public function index()
{
    // EAGER LOAD SEMUA RELASI YANG DIPERLUKAN di view, termasuk 'evidences'
    $po_list = PurchaseOrder::with([
        'evidences', 
        'evidences.user', 
        'evidences.tematik', 
        'evidences.pangwas'
    ])
    // Tambahkan withCount atau select raw untuk approved_count jika diperlukan di tempat lain
    ->paginate(10);

    return view('admin.po.index', compact('po_list'));
}

    /**
     * Menampilkan formulir untuk membuat Purchase Order baru.
     */
    public function create()
    {
        return view('admin.po.create');
    }

    /**
     * Menyimpan Purchase Order baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input: no_po wajib diisi dan harus unik
        $request->validate([
            'no_po' => 'required|string|max:255|unique:purchase_order,no_po',
        ], [
            'no_po.required' => 'Nomor Purchase Order wajib diisi.',
            'no_po.unique' => 'Nomor Purchase Order ini sudah terdaftar.',
        ]);

        PurchaseOrder::create(['no_po' => $request->no_po]);

        return redirect()->route('admin.po.index')
                         ->with('success', 'Data Purchase Order berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit Purchase Order tertentu.
     */
    public function edit(PurchaseOrder $po) // Menggunakan $po karena rute resource menggunakan 'po'
    {
        return view('admin.po.edit', compact('po'));
    }

    /**
     * Memperbarui Purchase Order tertentu di database.
     */
    public function update(Request $request, PurchaseOrder $po)
    {
        // Validasi: no_po harus unik, kecuali dirinya sendiri
        $request->validate([
            'no_po' => [
                'required',
                'string',
                'max:255',
                Rule::unique('purchase_order', 'no_po')->ignore($po->id),
            ],
        ], [
            'no_po.required' => 'Nomor Purchase Order wajib diisi.',
            'no_po.unique' => 'Nomor Purchase Order ini sudah digunakan oleh data lain.',
        ]);

        $po->update(['no_po' => $request->no_po]);

        return redirect()->route('admin.po.index')
                         ->with('success', 'Data Purchase Order berhasil diperbarui.');
    }

    /**
     * Menghapus Purchase Order tertentu dari database.
     */
    public function destroy(PurchaseOrder $po)
    {
        // Cek apakah PO digunakan di tabel evidence (Relasi evidence() sudah ada di Model PO)
        if ($po->evidence()->exists()) {
            return redirect()->route('admin.po.index')
                             ->with('error', 'Purchase Order tidak dapat dihapus karena sudah memiliki data Evidence terkait.');
        }
        
        $po->delete();

        return redirect()->route('admin.po.index')
                         ->with('success', 'Data Purchase Order berhasil dihapus.');
    }
}