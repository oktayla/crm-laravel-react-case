<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'stock',
        'is_active',
    ];

    protected $appends = [
        'out_of_stock'
    ];

    public function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function outOfStock(): Attribute
    {
        return new Attribute(
            get: fn() => $this->stock === 0,
        );
    }
}
