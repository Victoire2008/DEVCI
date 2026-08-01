@extends('layouts.app')
@section('title','Paiements – DevCI')
@section('content')
<div class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-800 mb-0">Paiements</h4>
                <p class="text-muted mb-0">Historique de vos transactions</p>
            </div>
            @if($user->isClient())
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPayModal">
                <i class="bi bi-plus-circle me-2"></i>Nouveau paiement
            </button>
            @endif
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">{{ session('info') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        @if($paiements->isEmpty())
        <div class="empty-state text-center py-5">
            <i class="bi bi-wallet2 fs-1 text-muted"></i>
            <h5 class="mt-3">Aucune transaction</h5>
            <p class="text-muted">Vos paiements apparaîtront ici.</p>
        </div>
        @else
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Référence</th>
                            <th>{{ $user->isClient() ? 'Développeur' : 'Client' }}</th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiements as $p)
                        <tr>
                            <td><code class="small">{{ $p->reference }}</code></td>
                            <td>
                                @if($user->isClient())
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $p->developer->photo_url }}" class="rounded-circle" width="28" height="28"
                                         onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                                    {{ $p->developer->name }}
                                </div>
                                @else
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $p->client->photo_url }}" class="rounded-circle" width="28" height="28"
                                         onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                                    {{ $p->client->name }}
                                </div>
                                @endif
                            </td>
                            <td><strong class="text-primary">{{ $p->montant_formate }}</strong></td>
                            <td>
                                @if($p->methode === 'wave')
                                <span class="badge bg-info text-white"><i class="bi bi-phone me-1"></i>Wave</span>
                                @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-phone me-1"></i>Orange Money</span>
                                @endif
                            </td>
                            <td><span class="badge bg-{{ $p->statut_color }}">{{ $p->statut_label }}</span></td>
                            <td class="text-muted small">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('payments.show',$p->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $paiements->links() }}</div>
        </div>
        @endif
    </div>
</div>

@if($user->isClient())
<div class="modal fade" id="newPayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-700"><i class="bi bi-wallet2 me-2"></i>Initier un paiement</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('payments.initiate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-500">Conversation / Projet <span class="text-danger">*</span></label>
                        <select name="conversation_id" class="form-select" required>
                            <option value="">Sélectionnez un projet...</option>
                            @foreach(auth()->user()->conversationsAsClient()->with('developer')->get() as $conv)
                            <option value="{{ $conv->id }}">{{ $conv->sujet }} – {{ $conv->developer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Montant (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" name="montant" class="form-control" placeholder="150000" required min="500">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Méthode de paiement <span class="text-danger">*</span></label>
                        <div class="row g-2 mt-1">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="methode" id="wave" value="wave" required>
                                <label class="pay-method-label w-100" for="wave">
                                    <span class="pay-icon wave-icon-sm">W</span>
                                    <span class="fw-600">Wave</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="methode" id="orange" value="orange_money">
                                <label class="pay-method-label w-100" for="orange">
                                    <span class="pay-icon om-icon-sm">OM</span>
                                    <span class="fw-600">Orange Money</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i>Procéder au paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
