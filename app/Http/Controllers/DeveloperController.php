<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DeveloperController extends Controller
{
    // ── Liste des développeurs ────────────────────────────────
    public function index(Request $request)
    {
        $query = User::where('role', 'developer')
            ->where('is_active', true)
            ->with('profil');

        // Filtres
        if ($request->filled('competence')) {
            $query->whereHas('profil', function ($q) use ($request) {
                $q->whereJsonContains('competences', $request->competence);
            });
        }

        if ($request->filled('disponibilite')) {
            $query->whereHas('profil', function ($q) use ($request) {
                $q->where('disponibilite', $request->disponibilite);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhereHas('profil', function ($q2) use ($search) {
                      $q2->where('bio', 'like', "%$search%")
                         ->orWhere('specialite', 'like', "%$search%");
                  });
            });
        }

        if ($request->filled('tarif_max')) {
            $query->whereHas('profil', function ($q) use ($request) {
                $q->where('tarif_jour', '<=', $request->tarif_max);
            });
        }

        $developers = $query->paginate(12)->withQueryString();

        // Toutes les compétences disponibles pour le filtre
        $allCompetences = \App\Models\Profil::pluck('competences')
            ->filter()
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('developers.index', compact('developers', 'allCompetences'));
    }

    // ── Profil développeur ────────────────────────────────────
    public function show(int $id)
    {
        $developer = User::where('role', 'developer')
            ->with(['profil', 'services' => fn($q) => $q->where('is_active', true)])
            ->findOrFail($id);

        // Incrémenter les vues
        if ($developer->profil) {
            $developer->profil->increment('vues');
        }

        return view('developers.show', compact('developer'));
    }

    // ── Contact (envoi de demande) ────────────────────────────
    public function contact(Request $request, int $id)
    {
        $developer = User::where('role', 'developer')->findOrFail($id);
        $client    = Auth::user();

        $request->validate([
            'sujet'               => 'required|string|max:255',
            'description_projet'  => 'required|string|min:20',
            'budget_propose'      => 'nullable|integer|min:0',
        ]);

        // Vérifier si une conversation existe déjà
        $existing = Conversation::where('client_id', $client->id)
            ->where('developer_id', $developer->id)
            ->whereIn('statut', ['en_attente', 'en_cours'])
            ->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id)
                ->with('info', 'Vous avez déjà une conversation ouverte avec ce développeur.');
        }

        $conversation = Conversation::create([
            'client_id'          => $client->id,
            'developer_id'       => $developer->id,
            'sujet'              => $request->sujet,
            'description_projet' => $request->description_projet,
            'budget_propose'     => $request->budget_propose,
            'statut'             => 'en_attente',
            'last_message_at'    => now(),
        ]);

        // Premier message automatique
        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $client->id,
            'contenu'         => "📋 **Nouvelle demande de projet**\n\n**Sujet :** {$request->sujet}\n\n**Description :** {$request->description_projet}" .
                ($request->budget_propose ? "\n\n**Budget proposé :** " . number_format($request->budget_propose, 0, ',', ' ') . ' FCFA' : ''),
        ]);

        return redirect()->route('chat.show', $conversation->id)
            ->with('success', 'Votre demande a été envoyée avec succès !');
    }
}
