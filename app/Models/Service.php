<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'titre', 'description', 'prix', 'delai', 'categorie', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'prix'      => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrixFormateAttribute(): string
    {
        return number_format($this->prix, 0, ',', ' ') . ' FCFA';
    }
}
