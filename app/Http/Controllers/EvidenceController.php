<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    /**
     * Menampilkan halaman riwayat evidence milik karyawan.
     */
    public function index()
    {
        $evidences = Evidence::where('user_id', Auth::id())->latest()->paginate(10);
        return view('karyawan.evidence.index', compact('evidences'));
    }

    /**
     * Menampilkan form untuk membuat evidence baru.
     */
    public function create()
    {
        return view('karyawan.evidence.create');
    }

    /**
     * Menyimpan evidence baru.
     * Kode ini sudah cukup baik, hanya sedikit dirapikan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => ['required', 'string', 'max:255'],
            'file' => ['required', 'array', 'min:1'], // min:1 agar tidak bisa kirim kosong
            'file.*' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
            // Menambahkan validasi untuk caption jika ada
            'caption' => ['nullable', 'array'],
            'caption.*' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $fileData = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $index => $file) {
                    $path = $file->store('evidences', 'public');
                    $fileData[] = [
                        'path' => $path,
                        // Mengambil caption sesuai urutan file
                        'caption' => $request->caption[$index] ?? $request->lokasi
                    ];
                }
            }

            Evidence::create([
                'user_id' => auth()->id(),
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi, // Ambil dari request jika ada
                'file_path' => $fileData,
            ]);

            return redirect()->route('karyawan.evidence.index')->with('success', 'Evidence berhasil di-upload.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit evidence.
     */
    public function edit(Evidence $evidence)
    {
        // Security check: pastikan hanya pemilik yang bisa mengedit
        if ($evidence->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK.');
        }
        return view('karyawan.evidence.edit', compact('evidence'));
    }

    /**
     * Memperbarui data evidence di database.
     * PERBAIKAN TOTAL DI FUNGSI INI
     */
    public function update(Request $request, Evidence $evidence)
    {
        // Security check
        if ($evidence->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK.');
        }

        $request->validate([
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            // Validasi untuk file yang sudah ada (captions) dan file baru
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'files' => ['nullable', 'array'],
            'files.*' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'deleted_files' => ['nullable', 'array'],
        ]);

        $files = $evidence->file_path; // Ambil data file yang sudah ada

        // 1. Hapus file yang ditandai untuk dihapus
        if ($request->has('deleted_files')) {
            $filesToDelete = $request->deleted_files;
            foreach ($filesToDelete as $pathToDelete) {
                Storage::disk('public')->delete($pathToDelete);
                // Hapus dari array $files
                $files = array_filter($files, fn($file) => $file['path'] !== $pathToDelete);
            }
        }

        // 2. Update caption untuk file yang sudah ada
        if ($request->has('captions')) {
            foreach ($request->captions as $path => $caption) {
                foreach ($files as $key => $file) {
                    if ($file['path'] === $path) {
                        $files[$key]['caption'] = $caption;
                    }
                }
            }
        }

        // 3. Tambahkan file baru jika ada
        if ($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                $path = $file->store('evidences', 'public');
                $files[] = [
                    'path' => $path,
                    'caption' => $request->lokasi // Default caption
                ];
            }
        }

        // 4. Update data utama dan simpan
        $evidence->update([
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'file_path' => array_values($files), // Re-index array setelah filter
            'status' => 'pending', // Set status kembali ke pending setelah diedit
        ]);

        return redirect()->route('karyawan.evidence.index')->with('success', 'Evidence berhasil diperbarui.');
    }

    /**
     * Menghapus evidence.
     * PERBAIKAN DI FUNGSI INI
     */
    public function destroy(Evidence $evidence)
    {
        // Security check
        if ($evidence->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK.');
        }

        // Hapus semua file terkait dari storage
        if (is_array($evidence->file_path)) {
            foreach ($evidence->file_path as $file) {
                // Pastikan $file adalah array dengan key 'path'
                if (is_array($file) && isset($file['path'])) {
                    Storage::disk('public')->delete($file['path']);
                }
            }
        }
        
        $evidence->delete();
        
        return redirect()->route('karyawan.evidence.index')->with('success', 'Evidence berhasil dihapus.');
    }
}