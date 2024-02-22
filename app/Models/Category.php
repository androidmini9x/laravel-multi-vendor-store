<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'description', 'slug', 'parent_id', 'status', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Self Relation
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault([
            'name' => '-'
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function roles($id = 0) {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id)
            ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => ['image', 'max:2000000'],
            'status' => 'in:active,archived'
        ];
    }

    public static function scopeFilter(Builder $builder, $filters) {
        if ($filters['term'] ?? false) {
            $builder->where('categories.name', 'LIKE', "%{$filters['term']}%");
        }
        if ($filters['status'] ?? false) {
            $builder->where('categories.status', $filters['status']);
        }
    }
}
