<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Status extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }
        protected static function boot()
    {
        parent::boot();

        static::creating(function ($status) {
            $status->slug = Str::slug($status->name);
        });

        static::updating(function ($status) {
            $status->slug = Str::slug($status->name);
        });
    }
}
