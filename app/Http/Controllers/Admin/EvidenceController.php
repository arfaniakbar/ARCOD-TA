<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    /**
     * Menampilkan halaman kelola evidence.
     */
    public function index()
    {
        $evidences = Evidence::with('user')->latest()->paginate(10);
        return view('admin.evidence.index', compact('evidences'));
    }

    /**
     * Menyetujui evidence.
     */
    public function approve(Evidence $evidence)
    {
        $evidence->update(['status' => 'approved', 'catatan_admin' => null]);
        return back()->with('success', 'Evidence berhasil disetujui.');
    }

    /**
     * Menolak evidence.
     */
    public function reject(Request $request, Evidence $evidence)
    {
        $request->validate(['catatan_admin' => 'required|string|max:255']);
        $evidence->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin
        ]);
        return back()->with('success', 'Evidence berhasil ditolak.');
    }

    /**
     * Menghapus evidence secara permanen.
     */
    public function destroy(Evidence $evidence)
    {
        // Logika diperbaiki untuk menangani 2 format data file_path
        if (is_array($evidence->file_path)) {
            foreach($evidence->file_path as $fileData) {
                // Mengecek apakah data file adalah string (format lama) atau array (format baru)
                $pathToDelete = is_array($fileData) ? ($fileData['path'] ?? null) : $fileData;

                if ($pathToDelete) {
                    Storage::disk('public')->delete($pathToDelete);
                }
            }
        }

        $evidence->delete();
        return back()->with('success', 'Evidence telah berhasil dihapus permanen.');
    }
}