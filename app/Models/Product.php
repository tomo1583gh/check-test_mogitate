<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 複数代入（Mass Assignment）を許可するカラム
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
    ];
}
