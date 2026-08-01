@extends('layouts.app')
@section('title','Tableau de bord – DevCI')
@section('content')
<div class="dashboard-page py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <h4 class="fw-800 mb-0">Bonjour, {{ $user->name }} 👋</h4>
                <p class="text-muted mb-0">Gérez vos projets et communications</p>
            </div>
            <a href="{{ route('developers.index') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Nouveau projet
            </a>
        </div>

        {{-- Stats --}}
        <div class="row g-4 mb-5">
            @foreach([
                ['icon'=>'bi-folder2','label'=>'Total projets','value'=>$stats['total_projets'],'color'=>'primary'],
                ['icon'=>'bi-gear','label'=>'En cours','value'=>$stats['en_cours'],'color'=>'info'],
                ['icon'=>'bi-check-circle','label'=>'Terminés','value'=>$stats['termines'],'color'=>'success'],
                ['icon'=>'bi-envelope','label'=>'Msgs non lus','value'=>$stats['messages_non_lus'],'color'=>'warning'],
            ] as $s)
            <div class="col-6 col-lg-3">
                <div class="stat-widget">
                    <div class="stat-widget-icon bg-{{ $s['color'] }}-soft">
                        <i class="bi {{ $s['icon'] }} text-{{ $s['color'] }}"></i>
                    </div>
                    <div class="stat-widget-body">
                        <div class="stat-widget-value">{{ $s['value'] }}</div>
                        <div class="stat-widget-label">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row g-4">
            {{-- Conversations --}}
            <div class="col-lg-8">
                <div class="dash-card">
                    <div class="dash-card-header d-flex justify-content-between align-items-center">
                        <h6 class="fw-700 mb-0"><i class="bi bi-chat-dots me-2"></i>Mes conversations</h6>
                        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="dash-card-body p-0">
                        @forelse($conversations as $conv)
                        <a href="{{ route('chat.show', $conv->id) }}" class="conv-item">
                            <img src="{{ $conv->developer->photo_url }}" alt=""
                                 class="conv-avatar"
                                 onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                            <div class="conv-info flex-grow-1 min-w-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-600 text-truncate">{{ $conv->developer->name }}</span>
                                    <small class="text-muted ms-2 flex-shrink-0">{{ $conv->last_message_at?->diffForHumans() }}</small>
                                </div>
                                <div class="text-muted small text-truncate">{{ $conv->sujet }}</div>
                            </div>
                            <span class="badge bg-{{ $conv->statut_color }} ms-2">{{ $conv->statut_label }}</span>
                        </a>
                        @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-chat-dots fs-2 mb-2 d-block"></i>
                            Aucune conversation. <a href="{{ route('developers.index') }}">Trouvez un développeur</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Paiements récents --}}
            <div class="col-lg-4">
                <div class="dash-card h-100">
                    <div class="dash-card-header d-flex justify-content-between align-items-center">
                        <h6 class="fw-700 mb-0"><i class="bi bi-wallet2 me-2"></i>Paiements</h6>
                        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="dash-card-body p-0">
                        @forelse($paiements as $p)
                        <div class="payment-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-600 small">{{ $p->developer->name }}</div>
                                    <div class="text-primary fw-700">{{ $p->montant_formate }}</div>
                                </div>
                                <span class="badge bg-{{ $p->statut_color }}">{{ $p->statut_label }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted small">
                            <i class="bi bi-wallet2 fs-3 mb-2 d-block"></i>Aucun paiement
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
