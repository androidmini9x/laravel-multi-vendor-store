<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['payment_method', 'store_id'];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Guest']);
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->using(OrderItems::class)
            ->withPivot(['product_name', 'price', 'quantity', 'options']);
    }

    public function address() {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress() {
        return $this->hasOne(OrderAddress::class)->where('type', '=', 'billing');
    }

    public function shippingAddress() {
        return $this->hasOne(OrderAddress::class)->where('type', '=', 'shipping');
    }

    public static function booted() {
        static::creating(function(Order $order) {
            $order->number = Order::gerNextOrderName();
        });
    }

    public static function gerNextOrderName() {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
