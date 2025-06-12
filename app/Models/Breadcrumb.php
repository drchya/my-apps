<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Breadcrumb extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($breadcrumbs) {
            $breadcrumbs->slug = self::generateUniqueSlug();
        });
    }

    public static function generateUniqueSlug()
    {
        do {
            $slug = Str::random(8);
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }
}
