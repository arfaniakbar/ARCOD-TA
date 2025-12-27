<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tematik extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'tematik';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = ['nama_tematik'];

    /**
     * Relasi ke tabel evidence.
     * Satu Tematik memiliki banyak evidence (One-to-Many).
     */
    public function evidence(): HasMany
    {
        return $this->hasMany(Evidence::class, 'tematik_id');
    }
}