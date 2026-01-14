<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 
        'payable_id', 
        'payable_type', 
        'gateway',
        'gateway_payment_id',
        'amount',
        'status',
    ];


    public function user() { return $this->belongsTo(User::class); }
    public function payable() { return $this->morphTo(); }
}
