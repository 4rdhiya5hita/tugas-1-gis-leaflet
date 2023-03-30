<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polyline extends Model
{
    use HasFactory;
    
    protected $table = "tb_polyline";
    protected $fillable = ['latitude', 'longitude'];
}
