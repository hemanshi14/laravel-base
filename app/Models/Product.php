<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'buy_price',
        'sell_price',
        'quantity',
        'status',
    ];

    public static function financialYearPrefix(): string
    {
        $year = now()->year;
        $financialYearStart = 4;

        $financialYear = now()->month >= $financialYearStart ? $year : $year - 1;

        return 'INV-' . $financialYear;
    }

    public static function generateSku(): string
    {
        $prefix = self::financialYearPrefix();

        $latestProduct = self::where('sku', 'like', $prefix . '-%')->orderByDesc('id')->first();

        if ($latestProduct && preg_match('/' . preg_quote($prefix, '/') . '-(\d{4})$/', $latestProduct->sku, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        return $prefix . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public function buyItems()
    {
        return $this->hasMany(BuyItem::class, 'inventory_id');
    }
}
