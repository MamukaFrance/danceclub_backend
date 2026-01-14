<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'type',
        'price',
        'starts_at',
        'ends_at', 
        'status',
        'stripe_subscription_id',
    ];
    public function user() { return $this->belongsTo(User::class); }
}
