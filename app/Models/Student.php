<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'sid',
        'campus',
        'class',
        'father_name',
        'first_name',
        'last_name',
        'student_name',
        'phone',
        'dob',
        'address',
        'image',
        'is_registered',
    ];
}
