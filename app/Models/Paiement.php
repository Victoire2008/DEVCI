<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'conversation_id', 'client_id', 'developer_id', 'montant',
        'methode', 'statut', 'reference', 'transaction_id', 'meta', 'paye_at'
    ];

    protected $casts = [
        'montant'  => 'integer',
        'meta'     => 'array',
        'paye_at'  => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function getMontantFormateAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'warning',
            'paye'       => 'success',
            'echoue'     => 'danger',
            'rembourse'  => 'info',
            default      => 'secondary',
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'paye'       => 'Payé',
            'echoue'     => 'Échoué',
            'rembourse'  => 'Remboursé',
            default      => 'Inconnu',
        };
    }

    public static function generateReference(): string
    {
        return 'DEVCI-' . strtoupper(uniqid()) . '-' . date('Ymd');
    }
}
