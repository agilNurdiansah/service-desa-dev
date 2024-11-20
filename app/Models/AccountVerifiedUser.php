<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountVerifiedUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'is_verified'
    ];
}
