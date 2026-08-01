@extends('layouts.app')
@section('title','Tableau de bord – DevCI')
@section('content')
<div class="dashboard-page py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <h4 class="fw-800 mb-0">Bonjour, {{ $user->name }} 👋</h4>
                <p class="text-muted mb-0">Gérez vos projets et votre profil</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-2"></i>Modifier mon profil
                </a>
                <a href="{{ route('services.index') }}" class="btn btn-primary">
                    <i class="bi bi-grid me-2"></i>Mes services
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            @foreach([
                ['icon'=>'bi-eye','label'=>'Vues du profil','value'=>$stats['vues_profil'],'color'=>'primary'],
                ['icon'=>'bi-folder2','label'=>'Total projets','value'=>$stats['total_projets'],'color'=>'info'],
                ['icon'=>'bi-gear','label'=>'En cours','value'=>$stats['en_cours'],'color'=>'warning'],
                ['icon'=>'bi-cash-coin','label'=>'Revenus (FCFA)','value'=>number_format($stats['revenus_total'],0,',',' '),'color'=>'success'],
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

        <div class="dash-card">
            <div class="dash-card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-700 mb-0"><i class="bi bi-chat-dots me-2"></i>Demandes reçues</h6>
                <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="dash-card-body p-0">
                @forelse($conversations as $conv)
                <a href="{{ route('chat.show', $conv->id) }}" class="conv-item">
                    <img src="{{ $conv->client->photo_url }}" alt=""
                         class="conv-avatar"
                         onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                    <div class="conv-info flex-grow-1 min-w-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-600 text-truncate">{{ $conv->client->name }}</span>
                            <small class="text-muted ms-2 flex-shrink-0">{{ $conv->last_message_at?->diffForHumans() }}</small>
                        </div>
                        <div class="text-muted small text-truncate">{{ $conv->sujet }}</div>
                    </div>
                    @php $unread = $conv->getUnreadCountForUser($user->id); @endphp
                    @if($unread > 0)
                    <span class="badge bg-danger rounded-pill ms-2">{{ $unread }}</span>
                    @else
                    <span class="badge bg-{{ $conv->statut_color }} ms-2">{{ $conv->statut_label }}</span>
                    @endif
                </a>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 mb-2 d-block"></i>
                    Aucune demande reçue pour l'instant.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
