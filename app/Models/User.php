<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
     use HasFactory, Notifiable, HasApiTokens;

    // Champs remplissables
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'api_token'
    ];

    // Champs cachés pour JSON
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    // Casts pour dates ou autres types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Relations

     // Un utilisateur peut avoir plusieurs professeurs
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    // Abonnements de l'utilisateur
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Réservations de cours
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Paiements effectués
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Événements auxquels il participe
    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
