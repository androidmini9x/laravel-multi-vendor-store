<?php

namespace App\Models;

use App\Models\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'price', 'compare_price', 'status', 'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id', 'id', 'id');
    }

    public static function booted() {
        // static::addGlobalScope('store', function(Builder $builder) {
        //     $user = Auth::user();
        //     if ($user->store_id) {
        //         $builder->where('store_id', '=', $user->store_id);
        //     }
        // });
        static::addGlobalScope(new ProductScope());
    }

    public function scopeActive(Builder $builder) {
        return $builder->where('status', 'active');
    }

    public function getImageUrlAttribute() {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getDiscountPriceAttribute() {
        if (!$this->compare_price) {
            return 0;
        }
        return number_format(($this->compare_price - $this->price) / $this->compare_price * 100, 1);
    }

}
