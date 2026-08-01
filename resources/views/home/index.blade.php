@extends('layouts.app')
@section('title', 'DevCI – Trouvez votre développeur freelance en Côte d\'Ivoire')

@section('content')

{{-- ══════════════════════════════════════════════════════ --}}
{{-- HERO                                                   --}}
{{-- ══════════════════════════════════════════════════════ --}}
<section class="hero-section position-relative overflow-hidden">
    <!-- Background Shapes -->
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-hero py-5">

            <!-- LEFT CONTENT -->
            <div class="col-lg-6 pe-lg-5" data-aos="fade-right">
              <h1 class="hero-title">

                    <span class="hero-line">
                        <span class="hero-word">Trouvez</span>
                        <span class="hero-word">le</span>
                    </span>
   
                    <span class="hero-line">
                        <span class="hero-word hero-highlight">Développeur</span>
                    </span>
   
                    <span class="hero-line">
                        <span class="hero-word">parfait</span>
                        <span class="hero-word">pour</span>
                        <span class="hero-word">votre</span>
                        <span class="hero-word">projet</span>
                    </span>

                </h1>
                
                <p class="hero-subtitle mt-4">
                    Connectez-vous instantanément avec des développeurs freelances vérifiés.
                    Gérez vos projets et payez en toute sécurité via
                    <strong>Wave</strong> ou <strong>Orange Money</strong>.
                </p>

                <!-- SEARCH BAR -->
                <div class="hero-search-wrapper mt-5">

                    <form action="{{ route('developers.index') }}"
                          method="GET"
                          class="hero-search-bar">

                        <div class="search-input-wrapper">
                            <i class="bi bi-search hero-search-icon"></i>

                            <input type="text"
                                   name="search"
                                   class="form-control hero-search-input"
                                   placeholder="React, Laravel, Flutter, WordPress...">
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-hero-search">
                            Rechercher
                        </button>

                    </form>

                </div>

                <!-- CTA sous la recherche -->
                <div class="hero-register-cta mt-5">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-hero-search btn-lg px-5 fw-600 d-flex align-items-center justify-content-center gap-2 w-100">
                        <i class="bi bi-person-plus"></i>
                        <span class="text-center">Créer un compte gratuit</span>
                    </a>
                </div>



                <!-- TAGS -->
                <div class="hero-tags mt-4">


                    @foreach(['Laravel', 'React', 'Flutter', 'WordPress', 'Node.js', 'Python'] as $tag)

                    <a href="{{ route('developers.index', ['competence' => $tag]) }}"
                       class="hero-tag">
                        {{ $tag }}
                    </a>

                    @endforeach

                </div>

            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-lg-6 mt-5 mt-lg-0"
                 data-aos="fade-left">

                <div class="hero-visual position-relative">

                    <!-- FLOATING CARD -->
                    <div class="floating-card card-1">
                        <div class="d-flex align-items-center gap-3">

                            <div class="mini-avatar bg-success"></div>

                            <div>
                                <div class="fw-bold small">
                                    Konan A.
                                </div>

                                <div class="small text-success">
                                    <i class="bi bi-circle-fill me-1"
                                       style="font-size: 6px;"></i>
                                    Disponible
                                </div>
                            </div>

                            <span class="badge hero-soft-badge ms-auto">
                                Laravel
                            </span>

                        </div>
                    </div>

                    <!-- FLOATING CARD -->
                    <div class="floating-card card-2">

                        <div class="d-flex align-items-center gap-3">

                            <div class="icon-box">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <div class="fw-semibold small">
                                    Paiement sécurisé
                                </div>

                                <div class="small text-muted">
                                    Wave · Orange Money
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- FLOATING CARD -->
                    <div class="floating-card card-3 text-center">

                        <div class="display-6 fw-bold text-primary">
                            {{ $stats['developers'] }}+
                        </div>

                        <div class="small text-muted">
                            Développeurs actifs
                        </div>

                    </div>

                    <!-- MAIN IMAGE -->
                    <div class="hero-image-container">

                    <!-- IMAGE PLACE -->
                        <img src="{{ asset('images/dev-freelance.jpg') }}"
                             alt="Hero Illustration"
                             class="img-fluid hero-main-image"
                             width="720"
                             height="520"
                             onerror="this.classList.add('d-none'); this.nextElementSibling.classList.remove('d-none');">

                        <!-- FALLBACK -->
                        <div class="hero-image-placeholder d-none">

                            <i class="bi bi-image"></i>

                            <span>
                                Votre illustration ici
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════ --}}
                      {{-- STATS --}}
{{-- ══════════════════════════════════════════════════════ --}}
<section class="stats-section py-5">
    <div class="container">
        <div class="stats-card">
            <div class="row g-0 text-center">
                <div class="col-4 stat-item">
                    <div class="stat-number" data-count="{{ $stats['developers'] }}">{{ $stats['developers'] }}</div>
                    <div class="stat-label">Développeurs</div>
                </div>
                <div class="col-4 stat-item border-start border-end">
                    <div class="stat-number" data-count="{{ $stats['clients'] }}">{{ $stats['clients'] }}</div>
                    <div class="stat-label">Clients satisfaits</div>
                </div>
                <div class="col-4 stat-item">
                    <div class="stat-number" data-count="{{ $stats['projects'] }}">{{ $stats['projects'] }}</div>
                    <div class="stat-label">Projets réalisés</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- COMMENT ÇA MARCHE                                     --}}
{{-- ══════════════════════════════════════════════════════ --}}
<section class="section-how py-6">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-badge">Simple & Rapide</span>
            <h2 class="section-title mt-2">Comment ça marche ?</h2>
            <p class="section-subtitle">Trouvez et collaborez avec un développeur en 3 étapes</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach([
                ['icon' => 'bi-search', 'num' => '01', 'color' => 'blue',
                 'title' => 'Cherchez un développeur',
                 'text'  => 'Parcourez les profils vérifiés et filtrez par compétences, disponibilité ou tarif.'],
                ['icon' => 'bi-chat-dots', 'num' => '02', 'color' => 'green',
                 'title' => 'Discutez de votre projet',
                 'text'  => 'Envoyez votre demande et échangez directement via la messagerie intégrée.'],
                ['icon' => 'bi-phone', 'num' => '03', 'color' => 'orange',
                 'title' => 'Payez en toute sécurité',
                 'text'  => 'Réglez votre prestation via Wave ou Orange Money une fois le travail validé.'],
            ] as $step)
            <div class="col-md-4">
                <div class="how-card">
                    <div class="how-step-num text-{{ $step['color'] }}">{{ $step['num'] }}</div>
                    <div class="how-icon-wrap bg-{{ $step['color'] }}-soft">
                        <i class="bi {{ $step['icon'] }} fs-2 text-{{ $step['color'] }}"></i>
                    </div>
                    <h5 class="fw-700 mt-3">{{ $step['title'] }}</h5>
                    <p class="text-muted">{{ $step['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- DÉVELOPPEURS EN VEDETTE                               --}}
{{-- ══════════════════════════════════════════════════════ --}}
@if($featuredDevelopers->isNotEmpty())
<section class="section-developers py-6 bg-light-section">
    <div class="container">
        <div class="section-header d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3">
            <div>
                <span class="section-badge">Top Talents</span>
                <h2 class="section-title mt-2">Développeurs disponibles</h2>
            </div>
            <a href="{{ route('developers.index') }}" class="btn btn-outline-primary">
                Voir tous <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredDevelopers as $dev)
            <div class="col-md-6 col-lg-4">
                <div class="dev-card h-100">
                    <div class="dev-card-header">
                        <div class="dev-card-status bg-{{ $dev->profil?->disponibilite_color ?? 'success' }}"></div>
                        <img src="{{ $dev->photo_url }}" alt="{{ $dev->name }}"
                             class="dev-avatar"
                             onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                        <div class="dev-card-info">
                            <h6 class="fw-700 mb-0">{{ $dev->name }}</h6>
                            <small class="text-muted">{{ $dev->profil?->specialite ?? 'Développeur Full Stack' }}</small>
                        </div>
                    </div>

                    <p class="dev-card-bio text-muted small mt-3">
                        {{ Str::limit($dev->profil?->bio, 100) }}
                    </p>

                    <div class="dev-card-skills d-flex flex-wrap gap-1 mt-3">
                        @foreach(array_slice($dev->profil?->competences ?? [], 0, 4) as $skill)
                        <span class="skill-badge">{{ $skill }}</span>
                        @endforeach
                    </div>

                    <div class="dev-card-footer d-flex justify-content-between align-items-center mt-4">
                        <div>
                            @if($dev->profil?->tarif_jour)
                            <span class="fw-700 text-primary">{{ number_format($dev->profil->tarif_jour, 0, ',', ' ') }} FCFA</span>
                            <small class="text-muted">/jour</small>
                            @else
                            <span class="text-muted small">Tarif sur demande</span>
                            @endif
                        </div>
                        <a href="{{ route('developers.show', $dev->id) }}" class="btn btn-sm btn-primary">
                            Voir profil
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAIEMENT MOBILE                                       --}}
{{-- ══════════════════════════════════════════════════════ --}}
<section class="section-payment py-6">
    <div class="container">
        <div class="payment-banner">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h2 class="fw-800 mb-3">Paiement 100% local & sécurisé</h2>
                    <p class="text-muted mb-4">
                        Réglez vos prestataires directement depuis votre téléphone avec vos applications de paiement mobile préférées. Transactions sécurisées, confirmées instantanément.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <div class="payment-method-card">
                            <div class="payment-method-icon wave-icon">
                            @include ('components.waveicon')
                                
                            </div>
                            ---xxx-e"éb            <div>
                                <div class="fw-600">Wave</div>
                                <small class="text-muted">Transfert instantané</small>
                            </div>
                        </div>
                        <div class="payment-method-card">
                            <div class="payment-method-icon om-icon">
                            @include ('components.omicon')
                                
                            </div>
                            <div>
                                <div class="fw-600">Orange Money</div>
                                <small class="text-muted">Paiement sécurisé</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <div class="payment-shield">
                        <i class="bi bi-shield-lock-fill"></i>
                        <div class="shield-badge">Sécurisé</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- CTA FINAL                                             --}}
{{-- ══════════════════════════════════════════════════════ --}}
<section class="section-cta py-6">
    <div class="container">
        <div class="cta-block text-center">
            <h2 class="cta-title">Prêt à démarrer ?</h2>
            <p class="cta-subtitle mt-3">Rejoignez des centaines d'entreprises et de développeurs qui font confiance à DevCI.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-600">
                    <i class="bi bi-person-plus me-2"></i>Créer un compte gratuit
                </a>
                <a href="{{ route('developers.index') }}" class="btn btn-outline-light btn-lg px-5 fw-600">
                    Parcourir les développeurs
                </a>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')

@endsection
