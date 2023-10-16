<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $table = 'specifications';

    public $timestamps = true;

    protected $guarded = [];


    public function components()
    {
        return $this->belongsToMany(Component::class, 'specification_component', 'specifiction_id', 'component_id')->withPivot('quantity');
    }

    public function productConfigs(){
        return $this->belongsToMany(ProductConfig::class, 'product_config_specification', 'specification_id', 'product_config_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($specification) {
            $specification->productConfigs->detach(); // Detach productConfigs from the pivot table
            $specification->components->detach(); // Detach components from the pivot table
        });
    }
}
