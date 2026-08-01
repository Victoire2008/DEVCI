<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ── Liste des conversations ───────────────────────────────
    public function index()
    {
        $user = Auth::user();

        if ($user->isDeveloper()) {
            $conversations = Conversation::where('developer_id', $user->id)
                ->with(['client', 'lastMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        } else {
            $conversations = Conversation::where('client_id', $user->id)
                ->with(['developer.profil', 'lastMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        }

        return view('chat.index', compact('conversations', 'user'));
    }

    // ── Afficher une conversation ─────────────────────────────
    public function show(int $conversationId)
    {
        $user         = Auth::user();
        $conversation = $this->getConversationForUser($conversationId, $user);

        // Marquer les messages reçus comme lus
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('lu', false)
            ->update(['lu' => true, 'lu_at' => now()]);
 ? 
        $messages = $conversation->messages()->with('sender')->get();

        // Toutes les conversations pour la sidebar
        if ($user->isDeveloper()) {
            $conversations = Conversation::where('developer_id', $user->id)
                ->with(['client', 'lastMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        } else {
            $conversations = Conversation::where('client_id', $user->id)
                ->with(['developer.profil', 'lastMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        }

        return view('chat.show', compact('conversation', 'messages', 'conversations', 'user'));
    }

    // ── Envoyer un message ────────────────────────────────────
    public function send(Request $request, int $conversationId)
    {
        $user         = Auth::user();
        $conversation = $this->getConversationForUser($conversationId, $user);

        $request->validate([
            'contenu' => 'required|string|max:5000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $user->id,
            'contenu'         => $request->contenu,
        ]);

        $conversation->update(['last_message_at' => now()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'         => $message->id,
                    'contenu'    => nl2br(e($message->contenu)),
                    'sender_id'  => $message->sender_id,
                    'created_at' => $message->created_at->format('H:i'),
                    'is_mine'    => true,
                ],
            ]);
        }

        return redirect()->route('chat.show', $conversationId);
    }

    // ── Polling AJAX pour nouveaux messages ───────────────────
    public function poll(Request $request, int $conversationId)
    {
        $user         = Auth::user();
        $conversation = $this->getConversationForUser($conversationId, $user);

        $lastId   = $request->integer('last_id', 0);
        $messages = Message::where('conversation_id', $conversation->id)
            ->where('id', '>', $lastId)
            ->where('sender_id', '!=', $user->id)
            ->with('sender')
            ->get()
            ->map(function ($msg) {
                $msg->update(['lu' => true, 'lu_at' => now()]);
                return [
                    'id'         => $msg->id,
                    'contenu'    => nl2br(e($msg->contenu)),
                    'sender_id'  => $msg->sender_id,
                    'created_at' => $msg->created_at->format('H:i'),
                    'is_mine'    => false,
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    // ── Helper : vérifier l'accès ─────────────────────────────
    private function getConversationForUser(int $id, $user): Conversation
    {
        return Conversation::where('id', $id)
            ->where(function ($q) use ($user) {
                $q->where('client_id', $user->id)
                  ->orWhere('developer_id', $user->id);
            })
            ->with(['client', 'developer.profil'])
            ->firstOrFail();
    }
}
