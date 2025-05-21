<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'costumer_name',
        'product_id',
        'quantity',
        'order_date',
        'status',
        'costumer_comment',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
