<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductConfig extends Model
{
    use HasFactory;
    
    protected $table = 'product_configs';

    public $timestamps = true;

    protected $guarded = [];

    const TYPE_DEFAULT = 1;
    const TYPE_ADD = 2;

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function specifications(){
        return $this->belongsToMany(Specification::class, 'product_config_specification', 'product_config_id', 'specification_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productConfig) {
            $productConfig->specifications->detach(); // Detach specifications from the pivot table
        });
    }
}
