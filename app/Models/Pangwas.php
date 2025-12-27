<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangwas extends Model
{
    use HasFactory;
    protected $table = 'pangwas';
    protected $fillable = ['nama_pangwas'];
    
    // Relasi untuk pengecekan hapus di Controller
    public function evidence()
    {
        return $this->hasMany(Evidence::class, 'pangwas_id');
    }
}