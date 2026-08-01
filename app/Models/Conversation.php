<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'developer_id', 'sujet', 'description_projet',
        'statut', 'budget_propose', 'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'budget_propose'  => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'warning',
            'en_cours'   => 'info',
            'termine'    => 'success',
            'annule'     => 'danger',
            default      => 'secondary',
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'en_cours'   => 'En cours',
            'termine'    => 'Terminé',
            'annule'     => 'Annulé',
            default      => 'Inconnu',
        };
    }

    public function getUnreadCountForUser(int $userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('lu', false)
            ->count();
    }
}
