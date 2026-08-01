<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isDeveloper()) {
            return $this->developerDashboard($user);
        }
        return $this->clientDashboard($user);
    }

    private function clientDashboard($user)
    {
        $conversations = Conversation::where('client_id', $user->id)
            ->with(['developer.profil', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $stats = [
            'total_projets'    => $conversations->count(),
            'en_cours'         => $conversations->where('statut', 'en_cours')->count(),
            'termines'         => $conversations->where('statut', 'termine')->count(),
            'messages_non_lus' => Message::whereIn('conversation_id', $conversations->pluck('id'))
                ->where('sender_id', '!=', $user->id)
                ->where('lu', false)
                ->count(),
        ];

        $paiements = Paiement::where('client_id', $user->id)
            ->with('developer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.client', compact('user', 'conversations', 'stats', 'paiements'));
    }

    private function developerDashboard($user)
    {
        $conversations = Conversation::where('developer_id', $user->id)
            ->with(['client', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $stats = [
            'vues_profil'      => $user->profil?->vues ?? 0,
            'total_projets'    => $conversations->count(),
            'en_cours'         => $conversations->where('statut', 'en_cours')->count(),
            'messages_non_lus' => Message::whereIn('conversation_id', $conversations->pluck('id'))
                ->where('sender_id', '!=', $user->id)
                ->where('lu', false)
                ->count(),
            'revenus_total'    => Paiement::where('developer_id', $user->id)
                ->where('statut', 'paye')
                ->sum('montant'),
        ];

        return view('dashboard.developer', compact('user', 'conversations', 'stats'));
    }
}
