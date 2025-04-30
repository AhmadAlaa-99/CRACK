<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'path',
        'extension',
        'size',
        'mime_type',
        'description',
        'plan_id',
        'user_id',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan associated with the file.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}


