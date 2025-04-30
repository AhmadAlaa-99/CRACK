<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_id',
        'order_id',
        'coingate_id',
        'amount',
        'currency',
        'status',
        'payment_method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
