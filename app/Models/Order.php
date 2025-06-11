<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'shipping_method', // Tambahkan ini
        'status',
        'shipping_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function processOrderCompletion()
    {
        if ($this->status === 'completed') {
            foreach ($this->orderItems as $item) {
                $product = $item->product;
                if ($product) {
                    // Kurangi stok produk
                    $product->decrement('stock', $item->quantity);
                }
            }
        }
    }
}
