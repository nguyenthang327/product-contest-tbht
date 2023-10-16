<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public $timestamps = true;

    protected $guarded = [];

    public function productConfigs(){
        return $this->hasMany(ProductConfig::class);
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->productConfigs->each->delete(); // delete all product_config
        });
    }


    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function childProducts()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function getSortOrderAttribute()
    {
        $sortOrder = $this->attributes['sort_order'] ?? 'a';
        return $sortOrder;
    }

    public function getSortOrder1Attribute()
    {
        $parentSortOrder = $this->parentProduct ? $this->parentProduct->sort_order_1 : 'a';
        return $parentSortOrder . '.' . $this->sort_order . '.' . $this->id;
    }

    
}
