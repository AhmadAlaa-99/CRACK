<?php

// app/Models/Purchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'order_id', 'payment_id',
        'amount', 'currency', 'status', 'ip_address','download_allowed',
    ];
    
    

    public function user () { return $this->belongsTo(User::class); }
    public function plan () { return $this->belongsTo(Plan::class); }
}
