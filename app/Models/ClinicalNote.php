<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_username',
        'patient_name',
        'patient_birthdate',
        'diagnosis',
        'treatment',
        'counselor_name',
        'counselor_license',
        'date',
    ];
}
