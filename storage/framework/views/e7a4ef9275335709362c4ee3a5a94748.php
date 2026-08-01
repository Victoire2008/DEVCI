<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'DevCI'); ?> – La plateforme des développeurs freelances en Côte d'Ivoire</title>
    <link rel="icon" href="<?php echo e(asset('images/favicon.svg')); ?>" type="image/svg+xml">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>?v=<?php echo e(filemtime(public_path('css/app.css'))); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<!-- ── Navbar ─────────────────────────────────────────────── -->
<nav class="navbar navbar-expand-lg devci-navbar sticky-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('home')); ?>">
            
            <div class="devci-logo-placeholder">
               <?php echo $__env->make('components.logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('developers.*') ? 'active' : ''); ?>" href="<?php echo e(route('developers.index')); ?>">
                        Développeurs
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <!-- Notifications messages -->
                    <?php $unread = auth()->user()->unread_messages_count; ?>
                    <a href="<?php echo e(route('chat.index')); ?>" class="nav-icon-btn position-relative" title="Messages">
                        <i class="bi bi-chat-dots fs-5"></i>
                        <?php if($unread > 0): ?>
                            <span class="badge bg-danger rounded-pill nav-badge"><?php echo e($unread); ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Dropdown utilisateur -->
                    <div class="dropdown">
                        <button class="btn btn-sm d-flex align-items-center gap-2 user-dropdown-btn" data-bs-toggle="dropdown">
                            <img src="<?php echo e(auth()->user()->photo_url); ?>" alt="Avatar"
                                 class="rounded-circle" width="32" height="32"
                                 style="object-fit:cover"
                                 onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                            <span class="d-none d-lg-inline fw-500"><?php echo e(Str::limit(auth()->user()->name, 15)); ?></span>
                            <i class="bi bi-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li class="px-3 py-2 border-bottom">
                                <small class="text-muted d-block">Connecté en tant que</small>
                                <strong class="small"><?php echo e(auth()->user()->email); ?></strong>
                                <span class="badge bg-primary-soft text-primary ms-1 small">
                                    <?php echo e(auth()->user()->isDeveloper() ? 'Développeur' : 'Client'); ?>

                                </span>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>"><i class="bi bi-person-gear me-2"></i>Mon profil</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('chat.index')); ?>"><i class="bi bi-chat-dots me-2"></i>Messages</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('payments.index')); ?>"><i class="bi bi-wallet2 me-2"></i>Paiements</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-sm px-4">Connexion</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm px-4">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- ── Flash Messages ──────────────────────────────────────── -->
<?php if(session('success') || session('error') || session('info')): ?>
<div class="container mt-3">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-info-circle-fill"></i> <?php echo e(session('info')); ?>

            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ── Contenu principal ───────────────────────────────────── -->
<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="<?php echo e(asset('js/app.js')); ?>?v=<?php echo e(filemtime(public_path('js/app.js'))); ?>" defer></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views\layouts\app.blade.php ENDPATH**/ ?>