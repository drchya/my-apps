<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }
}
