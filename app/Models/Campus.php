<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'contact_number', 'address'];

    public static function names(): array
    {
        return static::query()->orderBy('name')->pluck('name')->all();
    }
}
