<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realestate_type extends Model
{
    use HasFactory;
    public function realestates(){
        $this->belongsToMany(Realestate::class);
    }
}
