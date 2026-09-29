<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'quantity',
        'unit_price',
        'total_price',
        'supplier_name',
        'note',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function inventory()
    {
        return $this->belongsTo(Product::class, 'inventory_id');
    }
}
