<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Event extends Model
{
    use HasFactory;



    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'user_id',
    ];

    public function generateQrCode()
    {
        return QrCode::format('png')
            ->size(200)
            ->generate(url('/event_participants/register/checkin/'.$this->id));
    }


    public function eventParticipants() { return $this->hasMany(EventParticipant::class); }
    public function user() { return $this->belongsTo(User::class); }


    // Vérifie si l'événement est complet
    public function getIsFullAttribute(): bool
    {
        return $this->eventParticipants()->where('status', 'registered')->count() >= $this->capacity;
    }

    // Nombre de places restantes
    public function getRemainingSeatsAttribute(): int
    {
        return $this->capacity - $this->eventParticipants()->where('status', 'registered')->count();
    }
}
