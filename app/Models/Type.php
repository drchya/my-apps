<?php

namespace App\Models;

use App\Models\Gear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Type extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->slug = Str::slug($type->name);
        });

        static::updating(function ($type) {
            $type->slug = Str::slug($type->name);
        });
    }

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }

    public function preparationItems()
    {
        return $this->hasMany(PreparationItems::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
