<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Import Models Master Data yang baru
use App\Models\Pangwas;
use App\Models\Tematik;
use App\Models\PurchaseOrder;

class Evidence extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'evidences';

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     * Telah ditambahkan kolom kunci asing yang baru.
     */
    protected $fillable = [
        'user_id',
        'project_id',
        // Kolom Kunci Asing Baru
        'pangwas_id',
        'po_id',
        'tematik_id',
        // Kolom Detail & Status
        'lokasi',
        'deskripsi',
        'file_path',
        'status',
        'catatan_admin',
    ];

    /**
     * Cast kolom tertentu ke tipe data native.
     */
    protected $casts = [
        'file_path' => 'array',
    ];

    /**
     * Relasi ke tabel users (Karyawan/Uploader).
     */
    public function user(): BelongsTo
    {
        // Asumsi Model User adalah default Laravel
        return $this->belongsTo(User::class); 
    }
    
    // --- START: PENAMBAHAN RELASI MASTER DATA ---
    
    /**
     * Relasi ke tabel Pangwas.
     */
    public function pangwas(): BelongsTo
    {
        return $this->belongsTo(Pangwas::class, 'pangwas_id');
    }

    /**
     * Relasi ke tabel Tematik.
     */
    public function tematik(): BelongsTo
    {
        return $this->belongsTo(Tematik::class, 'tematik_id');
    }
    
    /**
     * Relasi ke tabel Purchase Order (PO).
     */
    public function po(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    /**
     * Relasi ke tabel Project.
     */
 
    // --- END: PENAMBAHAN RELASI MASTER DATA ---
}