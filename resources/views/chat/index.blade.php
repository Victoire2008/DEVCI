@extends('layouts.app')
@section('title','Messages – DevCI')
@section('content')
<div class="py-5">
    <div class="container">
        <h4 class="fw-800 mb-4">Messages</h4>
        @if($conversations->isEmpty())
        <div class="empty-state text-center py-5">
            <i class="bi bi-chat-dots fs-1 text-muted"></i>
            <h5 class="mt-3">Aucune conversation</h5>
            @if($user->isClient())
            <a href="{{ route('developers.index') }}" class="btn btn-primary mt-2">Trouver un développeur</a>
            @endif
        </div>
        @else
        <div class="conv-list-card">
            @foreach($conversations as $conv)
            @php $other=$user->isDeveloper()?$conv->client:$conv->developer; $unread=$conv->getUnreadCountForUser($user->id); @endphp
            <a href="{{ route('chat.show',$conv->id) }}" class="conv-item {{ $unread>0?'conv-item--unread':'' }}">
                <img src="{{ $other->photo_url }}" alt="" class="conv-avatar"
                     onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                <div class="conv-info flex-grow-1 min-w-0">
                    <div class="d-flex justify-content-between">
                        <span class="fw-600">{{ $other->name }}</span>
                        <small class="text-muted">{{ $conv->last_message_at?->diffForHumans() }}</small>
                    </div>
                    <div class="{{ $unread>0?'fw-600 text-dark':'text-muted' }} small text-truncate">{{ $conv->sujet }}</div>
                </div>
                @if($unread>0)<span class="badge bg-primary rounded-pill ms-2">{{ $unread }}</span>@endif
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
