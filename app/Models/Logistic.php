<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    use hasFactory;

    protected $guarded = ['id'];

    public function preparation()
    {
        return $this->belongsTo(Preparation::class);
    }
}
