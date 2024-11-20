<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnouncementVillage extends Model
{
    use HasFactory;


    protected $fillable = [
        'image',
        'content'
    ];
}
