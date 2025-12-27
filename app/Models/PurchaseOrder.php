<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    // WAJIB: Tentukan nama tabel yang sebenarnya (purchase_order)
    protected $table = 'purchase_order'; 

    protected $fillable = [
        'no_po', 
        // ...
    ];

    public function evidences(): HasMany
    {
        return $this->hasMany(Evidence::class, 'po_id');
    }
}