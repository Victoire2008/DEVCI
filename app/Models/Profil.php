<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $table = 'profils';

    protected $fillable = [
        'user_id', 'photo', 'bio', 'competences', 'portfolio',
        'disponibilite', 'tarif_jour', 'specialite', 'annees_experience',
        'github_url', 'linkedin_url', 'website_url', 'vues',
    ];

    protected $casts = [
        'competences' => 'array',
        'portfolio'   => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisponibiliteColorAttribute(): string
    {
        return match($this->disponibilite) {
            'available'   => 'success',
            'busy'        => 'warning',
            'unavailable' => 'danger',
            default       => 'secondary',
        };
    }

    public function getDisponibiliteLabelAttribute(): string
    {
        return match($this->disponibilite) {
            'available'   => 'Disponible',
            'busy'        => 'Occupé',
            'unavailable' => 'Indisponible',
            default       => 'Inconnu',
        };
    }
}
