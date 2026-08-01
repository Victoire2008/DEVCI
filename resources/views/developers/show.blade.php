@extends('layouts.app')
@section('title', $developer->name . ' – DevCI')
@section('content')

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Colonne profil --}}
            <div class="col-lg-4">
                <div class="profile-sidebar">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $developer->photo_url }}" alt="{{ $developer->name }}"
                                 class="profile-avatar-lg"
                                 onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                            <span class="profile-status-dot bg-{{ $developer->profil?->disponibilite_color ?? 'secondary' }}"
                                  title="{{ $developer->profil?->disponibilite_label }}"></span>
                        </div>
                        <h4 class="fw-800 mt-3 mb-0">{{ $developer->name }}</h4>
                        <p class="text-muted">{{ $developer->profil?->specialite ?? 'Développeur Freelance' }}</p>
                        <span class="badge bg-{{ $developer->profil?->disponibilite_color ?? 'secondary' }}-soft text-{{ $developer->profil?->disponibilite_color ?? 'secondary' }} px-3 py-2">
                            {{ $developer->profil?->disponibilite_label ?? 'Statut inconnu' }}
                        </span>
                    </div>

                    <div class="profile-meta mb-4">
                        @if($developer->city)
                        <div class="meta-item"><i class="bi bi-geo-alt"></i> {{ $developer->city }}</div>
                        @endif
                        @if($developer->profil?->annees_experience)
                        <div class="meta-item"><i class="bi bi-calendar3"></i> {{ $developer->profil->annees_experience }} an(s) d'expérience</div>
                        @endif
                        @if($developer->profil?->tarif_jour)
                        <div class="meta-item"><i class="bi bi-cash-coin"></i>
                            <strong>{{ number_format($developer->profil->tarif_jour, 0, ',', ' ') }} FCFA</strong>/jour
                        </div>
                        @endif
                        <div class="meta-item"><i class="bi bi-eye"></i> {{ $developer->profil?->vues ?? 0 }} vues du profil</div>
                    </div>

                    {{-- Réseaux sociaux --}}
                    @if($developer->profil?->github_url || $developer->profil?->linkedin_url || $developer->profil?->website_url)
                    <div class="d-flex gap-2 justify-content-center mb-4">
                        @if($developer->profil->github_url)
                        <a href="{{ $developer->profil->github_url }}" target="_blank" class="social-btn github">
                            <i class="bi bi-github"></i>
                        </a>
                        @endif
                        @if($developer->profil->linkedin_url)
                        <a href="{{ $developer->profil->linkedin_url }}" target="_blank" class="social-btn linkedin">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        @endif
                        @if($developer->profil->website_url)
                        <a href="{{ $developer->profil->website_url }}" target="_blank" class="social-btn web">
                            <i class="bi bi-globe2"></i>
                        </a>
                        @endif
                    </div>
                    @endif

                    {{-- Compétences --}}
                    @if($developer->profil?->competences)
                    <div class="mb-4">
                        <h6 class="fw-700 mb-3">Compétences</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($developer->profil->competences as $skill)
                            <span class="skill-badge skill-badge-lg">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- CTA contact --}}
                    @auth
                        @if(auth()->id() !== $developer->id)
                        <button class="btn btn-primary w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-send me-2"></i>Contacter ce développeur
                        </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Connectez-vous pour contacter
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Contenu principal --}}
            <div class="col-lg-8">

                {{-- Bio --}}
                @if($developer->profil?->bio)
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i>À propos</h5>
                    <p class="text-muted" style="white-space:pre-line">{{ $developer->profil->bio }}</p>
                </div>
                @endif

                {{-- Services --}}
                @if($developer->services->isNotEmpty())
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-4"><i class="bi bi-grid me-2 text-primary"></i>Services proposés</h5>
                    <div class="row g-3">
                        @foreach($developer->services as $service)
                        <div class="col-md-6">
                            <div class="service-card h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-700 mb-0">{{ $service->titre }}</h6>
                                    @if($service->categorie)
                                    <span class="badge bg-light text-dark">{{ $service->categorie }}</span>
                                    @endif
                                </div>
                                <p class="small text-muted mb-3">{{ Str::limit($service->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-700 text-primary">{{ $service->prix_formate }}</span>
                                    @if($service->delai)
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $service->delai }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Portfolio --}}
                @if($developer->profil?->portfolio && count($developer->profil->portfolio) > 0)
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-4"><i class="bi bi-collection me-2 text-primary"></i>Portfolio</h5>
                    <div class="row g-3">
                        @foreach($developer->profil->portfolio as $item)
                        @if(isset($item['title']))
                        <div class="col-md-6">
                            <div class="portfolio-card">
                                @if(isset($item['image']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="portfolio-img">
                                @endif
                                <div class="portfolio-info">
                                    <h6 class="fw-700 mb-1">{{ $item['title'] }}</h6>
                                    @if(isset($item['url']))
                                    <a href="{{ $item['url'] }}" target="_blank" class="small text-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Voir le projet
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- Modal contact --}}
@auth
@if(auth()->id() !== $developer->id)
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-send me-2 text-primary"></i>Envoyer une demande à {{ $developer->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('developers.contact', $developer->id) }}" method="POST">
                @csrf
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-500">Sujet du projet <span class="text-danger">*</span></label>
                        <input type="text" name="sujet" class="form-control" placeholder="ex: Développement site e-commerce" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Description du projet <span class="text-danger">*</span></label>
                        <textarea name="description_projet" class="form-control" rows="5"
                                  placeholder="Décrivez votre projet en détail : objectifs, fonctionnalités attendues, délais..." required minlength="20"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Budget proposé (FCFA) <span class="text-muted small">(optionnel)</span></label>
                        <input type="number" name="budget_propose" class="form-control" placeholder="ex: 500000" min="0">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i>Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

@endsection
