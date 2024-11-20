<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'message'
    ];
}
