@extends('layouts.app')
@section('title','Chat – DevCI')
@section('content')
<div class="chat-layout">
    <div class="chat-sidebar d-none d-lg-flex flex-column">
        <div class="chat-sidebar-header"><h6 class="fw-700 mb-0">Messages</h6></div>
        <div class="chat-sidebar-list flex-grow-1 overflow-auto">
            @foreach($conversations as $conv)
            @php $other=$user->isDeveloper()?$conv->client:$conv->developer; $unread=$conv->getUnreadCountForUser($user->id); @endphp
            <a href="{{ route('chat.show',$conv->id) }}" class="chat-sidebar-item {{ $conv->id==$conversation->id?'active':'' }}">
                <img src="{{ $other->photo_url }}" alt="" class="conv-avatar-sm"
                     onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                <div class="flex-grow-1 min-w-0">
                    <div class="fw-600 small text-truncate">{{ $other->name }}</div>
                    <div class="text-muted text-truncate" style="font-size:11px">{{ $conv->sujet }}</div>
                </div>
                @if($unread>0)<span class="badge bg-primary rounded-pill">{{ $unread }}</span>@endif
            </a>
            @endforeach
        </div>
    </div>

    <div class="chat-main d-flex flex-column">
        @php $other=$user->isDeveloper()?$conversation->client:$conversation->developer; @endphp
        <div class="chat-header">
            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-light d-lg-none me-2"><i class="bi bi-arrow-left"></i></a>
            <img src="{{ $other->photo_url }}" alt="" class="conv-avatar-sm"
                 onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
            <div class="ms-2 flex-grow-1">
                <div class="fw-700">{{ $other->name }}</div>
                <div class="text-muted small">{{ $conversation->sujet }}</div>
            </div>
            <span class="badge bg-{{ $conversation->statut_color }}">{{ $conversation->statut_label }}</span>
            @if($user->isClient() && in_array($conversation->statut,['en_attente','en_cours']))
            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-success ms-2">
                <i class="bi bi-wallet2 me-1"></i>Payer
            </a>
            @endif
        </div>

        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $msg)
            @php $isMine=$msg->sender_id===$user->id; @endphp
            <div class="msg-wrap {{ $isMine?'msg-mine':'msg-other' }}">
                @if(!$isMine)
                <img src="{{ $msg->sender->photo_url }}" alt="" class="msg-avatar"
                     onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                @endif
                <div class="msg-bubble {{ $isMine?'msg-bubble-mine':'msg-bubble-other' }}">
                    {!! nl2br(e($msg->contenu)) !!}
                    <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
            @endforeach
            <div id="chatBottom"></div>
        </div>

        <div class="chat-input-area">
            <form id="chatForm" action="{{ route('chat.send',$conversation->id) }}" method="POST">
                @csrf
                <div class="d-flex gap-2 align-items-end">
                    <textarea name="contenu" id="msgInput" class="form-control chat-textarea"
                              placeholder="Écrivez votre message... (Entrée pour envoyer)" rows="1" required></textarea>
                    <button type="submit" class="btn btn-primary chat-send-btn"><i class="bi bi-send-fill"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
body { overflow: hidden; }
main { height: calc(100vh - 66px); display: flex; }
.chat-layout { display: flex; flex: 1; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
const convId = {{ $conversation->id }};
const userId = {{ $user->id }};
let lastId   = {{ $messages->last()?->id ?? 0 }};
const msgsEl = document.getElementById('chatMessages');
const scrollBottom = () => msgsEl.scrollTop = msgsEl.scrollHeight;
scrollBottom();

const ta = document.getElementById('msgInput');
ta.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 150) + 'px';
});
ta.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
    }
});

document.getElementById('chatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = ta.value.trim();
    if (!msg) return;
    const btn = this.querySelector('button[type=submit]');
    btn.disabled = true;
    try {
        const r = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ contenu: msg })
        });
        const d = await r.json();
        if (d.success) {
            appendMsg(d.message);
            ta.value = '';
            ta.style.height = 'auto';
            lastId = d.message.id;
            scrollBottom();
        }
    } catch(err) { console.error(err); }
    btn.disabled = false;
});

function appendMsg(m) {
    const w = document.createElement('div');
    w.className = 'msg-wrap ' + (m.is_mine ? 'msg-mine' : 'msg-other');
    const avatarSrc = '{{ asset("images/default-avatar.svg") }}';
    w.innerHTML = (m.is_mine ? '' : `<img src="${avatarSrc}" class="msg-avatar">`) +
        `<div class="msg-bubble ${m.is_mine ? 'msg-bubble-mine' : 'msg-bubble-other'}">
            ${m.contenu}
            <div class="msg-time">${m.created_at}</div>
        </div>`;
    document.getElementById('chatBottom').before(w);
}

setInterval(async () => {
    try {
        const r = await fetch(`/messages/${convId}/poll?last_id=${lastId}`, {
            headers: { 'Accept': 'application/json' }
        });
        const d = await r.json();
        if (d.messages && d.messages.length) {
            d.messages.forEach(m => { appendMsg(m); lastId = m.id; });
            scrollBottom();
        }
    } catch(e) {}
}, 3000);
</script>
@endpush
