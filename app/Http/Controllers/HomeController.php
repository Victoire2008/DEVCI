<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Développeurs en vedette (disponibles, avec profil complet)
        $featuredDevelopers = Cache::remember('home.featured_developers', now()->addMinutes(10), fn () => User::where('role', 'developer')
            ->where('is_active', true)
            ->with('profil')
            ->whereHas('profil', function ($q) {
                $q->where('disponibilite', 'available')
                  ->whereNotNull('bio');
            })
            ->inRandomOrder()
            ->take(6)
            ->get());

        $stats = Cache::remember('home.stats', now()->addMinutes(10), fn () => [
            'developers' => User::where('role', 'developer')->count(),
            'clients'    => User::where('role', 'client')->count(),
            'projects'   => \App\Models\Conversation::where('statut', 'termine')->count(),
        ]);

        return view('home.index', compact('featuredDevelopers', 'stats'));
    }
}
