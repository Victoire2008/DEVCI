<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DevCI') – La plateforme des développeurs freelances en Côte d'Ivoire</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @stack('styles')
</head>
<body>

<!-- ── Navbar ─────────────────────────────────────────────── -->
<nav class="navbar navbar-expand-lg devci-navbar sticky-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            {{-- Espace logo : remplacez l'image ci-dessous par votre vrai logo --}}
            <div class="devci-logo-placeholder">
               @include('components.logo')
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('developers.*') ? 'active' : '' }}" href="{{ route('developers.index') }}">
                        Développeurs
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                @auth
                    <!-- Notifications messages -->
                    @php $unread = auth()->user()->unread_messages_count; @endphp
                    <a href="{{ route('chat.index') }}" class="nav-icon-btn position-relative" title="Messages">
                        <i class="bi bi-chat-dots fs-5"></i>
                        @if($unread > 0)
                            <span class="badge bg-danger rounded-pill nav-badge">{{ $unread }}</span>
                        @endif
                    </a>

                    <!-- Dropdown utilisateur -->
                    <div class="dropdown">
                        <button class="btn btn-sm d-flex align-items-center gap-2 user-dropdown-btn" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->photo_url }}" alt="Avatar"
                                 class="rounded-circle" width="32" height="32"
                                 style="object-fit:cover"
                                 onerror="this.src='{{ asset('images/default-avatar.svg') }}'">
                            <span class="d-none d-lg-inline fw-500">{{ Str::limit(auth()->user()->name, 15) }}</span>
                            <i class="bi bi-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li class="px-3 py-2 border-bottom">
                                <small class="text-muted d-block">Connecté en tant que</small>
                                <strong class="small">{{ auth()->user()->email }}</strong>
                                <span class="badge bg-primary-soft text-primary ms-1 small">
                                    {{ auth()->user()->isDeveloper() ? 'Développeur' : 'Client' }}
                                </span>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i>Mon profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('chat.index') }}"><i class="bi bi-chat-dots me-2"></i>Messages</a></li>
                            <li><a class="dropdown-item" href="{{ route('payments.index') }}"><i class="bi bi-wallet2 me-2"></i>Paiements</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4">S'inscrire</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- ── Flash Messages ──────────────────────────────────────── -->
@if(session('success') || session('error') || session('info'))
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>
@endif

<!-- ── Contenu principal ───────────────────────────────────── -->
<main>
    @yield('content')
</main>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
<script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
@stack('scripts')
</body>
</html>
