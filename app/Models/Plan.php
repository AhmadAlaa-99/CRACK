<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'file_path',
        'is_active',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

