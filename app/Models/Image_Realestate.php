<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image_Realestate extends Model
{
    use HasFactory;
    public function realestate(){
        $this->belongsTo(Realestate::class);
    }
}
