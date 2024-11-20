<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter',
        'type_letter',
        'id_user_maker',
        'name_user_maker',
        'type_maker',
        'status',
    ];
}
