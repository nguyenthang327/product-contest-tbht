<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = 'components';

    public $timestamps = true;

    protected $guarded = [];

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'specification_component', 'component_id', 'specifiction_id')->withPivot('quantity');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($component) {
            $component->specifications()->detach(); // Detach specifications from the pivot table
        });
    }

}
