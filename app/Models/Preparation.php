<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Preparation extends Model
{
    use hasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($preparation) {
            $mountain = \App\Models\Mountain::find($preparation->mountain_id);
            $mountainName = $mountain ? $mountain->name : 'gunung';
            $via = $preparation->via ?? 'via';
            $date = $preparation->departure_date ?? now()->toDateString();

            $slugBase = Str::slug("{$mountainName} via {$via} {$date}");

            $count = Preparation::where('slug', 'like', "{$slugBase}%")->count();
            $slug = $count ? "{$slugBase}-{$count}" : $slugBase;

            $preparation->slug = $slug;
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function items()
    {
        return $this->hasMany(PreparationItem::class);
    }

    public function logistics()
    {
        return $this->hasMany(Logistic::class);
    }

    public function transportations()
    {
        return $this->hasMany(Transportation::class);
    }
}
