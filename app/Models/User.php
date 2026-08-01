<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'city', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ── Relations ────────────────────────────────────────────
    public function profil()
    {
        return $this->hasOne(Profil::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function conversationsAsClient()
    {
        return $this->hasMany(Conversation::class, 'client_id');
    }

    public function conversationsAsDeveloper()
    {
        return $this->hasMany(Conversation::class, 'developer_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function paiementsAsClient()
    {
        return $this->hasMany(Paiement::class, 'client_id');
    }

    public function paiementsAsDeveloper()
    {
        return $this->hasMany(Paiement::class, 'developer_id');
    }

    // ── Helpers ──────────────────────────────────────────────
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->profil && $this->profil->photo) {
            return asset('storage/' . $this->profil->photo);
        }
        return asset('images/default-avatar.svg');
    }

    public function getUnreadMessagesCountAttribute(): int
    {
        $conversationIds = $this->isDeveloper()
            ? $this->conversationsAsDeveloper()->pluck('id')
            : $this->conversationsAsClient()->pluck('id');

        return Message::whereIn('conversation_id', $conversationIds)
            ->where('sender_id', '!=', $this->id)
            ->where('lu', false)
            ->count();
    }
}
