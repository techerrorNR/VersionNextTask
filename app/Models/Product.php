<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
use HasFactory;
protected $fillable=[
    'user_id',
        'name',
        'price',
        'quantity',
        'type',
        'discount',
];
 protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getComputedTotalAttribute(): string
    {
        $unit = $this->type === 'discount'
            ? max($this->price - ($this->discount ?? 0), 0)
            : $this->price;

        return number_format($unit * $this->quantity, 2, '.', '');
    }
}
