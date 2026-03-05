<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 
        'title', 
        'style',
        'level',
        'capacity',
        'date',
        'start_time',
        'end_time',
        'description',
        'remaining_seats',
    ];

    // Casts pour formater les dates
    protected $casts = [
        'date' => 'date',
    ];

    public function isFull()
    {
        return $this->remaining_seats <= 0;
    }


    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function reservations() { return $this->hasMany(Reservation::class); }
}
