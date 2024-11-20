<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_pelapor',
        'date_pelapor',
        'type_category',
        'location',
        'desc_report',
    ];

    public function imageReports()
    {
        return $this->hasMany(ImageReports::class, 'id_report', 'id');
    }

}
