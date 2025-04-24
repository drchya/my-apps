<?php

namespace App\Models;

use App\Models\Gear;
use App\Models\Preparation;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
