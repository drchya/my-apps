<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gear extends Model
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

        static::creating(function ($gear) {
            if (!$gear->slug) {
                $gear->slug = Str::random(8);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
