<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EventParticipantStatus;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => EventParticipantStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($participant) {
            $participant->token = Str::random(40);
        });
    }

    public function generateQrCode()
    {
        return QrCode::format('png')
            ->size(200)
            ->generate(route('event.checkin', $this->token));
    }

    public function event() { return $this->belongsTo(Event::class); }
    public function user() { return $this->belongsTo(User::class); }
}
