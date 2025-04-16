<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mountain extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($mountain) {
            if (!$mountain->slug) {
                $mountain->slug = Str::random(8);
            }
        });
    }
}
