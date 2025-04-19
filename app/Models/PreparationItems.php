<?php

namespace App\Models;

use App\Models\Gear;
use App\Models\Preparation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreparationItems extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    public function preparation()
    {
        return $this->belongsTo(Preparation::class);
    }

    public function gear()
    {
        return $this->belongsTo(Gear::class);
    }
}
