<?php $__env->startSection('title', 'DevCI – Trouvez votre développeur freelance en Côte d\'Ivoire'); ?>

<?php $__env->startSection('content'); ?>




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

                    <form action="<?php echo e(route('developers.index')); ?>"
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
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-hero-search btn-lg px-5 fw-600 d-flex align-items-center justify-content-center gap-2 w-100">
                        <i class="bi bi-person-plus"></i>
                        <span class="text-center">Créer un compte gratuit</span>
                    </a>
                </div>



                <!-- TAGS -->
                <div class="hero-tags mt-4">


                    <?php $__currentLoopData = ['Laravel', 'React', 'Flutter', 'WordPress', 'Node.js', 'Python']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a href="<?php echo e(route('developers.index', ['competence' => $tag])); ?>"
                       class="hero-tag">
                        <?php echo e($tag); ?>

                    </a>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                            <?php echo e($stats['developers']); ?>+
                        </div>

                        <div class="small text-muted">
                            Développeurs actifs
                        </div>

                    </div>

                    <!-- MAIN IMAGE -->
                    <div class="hero-image-container">

                    <!-- IMAGE PLACE -->
                        <img src="<?php echo e(asset('images/dev-freelance.jpg')); ?>"
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


                      

<section class="stats-section py-5">
    <div class="container">
        <div class="stats-card">
            <div class="row g-0 text-center">
                <div class="col-4 stat-item">
                    <div class="stat-number" data-count="<?php echo e($stats['developers']); ?>"><?php echo e($stats['developers']); ?></div>
                    <div class="stat-label">Développeurs</div>
                </div>
                <div class="col-4 stat-item border-start border-end">
                    <div class="stat-number" data-count="<?php echo e($stats['clients']); ?>"><?php echo e($stats['clients']); ?></div>
                    <div class="stat-label">Clients satisfaits</div>
                </div>
                <div class="col-4 stat-item">
                    <div class="stat-number" data-count="<?php echo e($stats['projects']); ?>"><?php echo e($stats['projects']); ?></div>
                    <div class="stat-label">Projets réalisés</div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="section-how py-6">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-badge">Simple & Rapide</span>
            <h2 class="section-title mt-2">Comment ça marche ?</h2>
            <p class="section-subtitle">Trouvez et collaborez avec un développeur en 3 étapes</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php $__currentLoopData = [
                ['icon' => 'bi-search', 'num' => '01', 'color' => 'blue',
                 'title' => 'Cherchez un développeur',
                 'text'  => 'Parcourez les profils vérifiés et filtrez par compétences, disponibilité ou tarif.'],
                ['icon' => 'bi-chat-dots', 'num' => '02', 'color' => 'green',
                 'title' => 'Discutez de votre projet',
                 'text'  => 'Envoyez votre demande et échangez directement via la messagerie intégrée.'],
                ['icon' => 'bi-phone', 'num' => '03', 'color' => 'orange',
                 'title' => 'Payez en toute sécurité',
                 'text'  => 'Réglez votre prestation via Wave ou Orange Money une fois le travail validé.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="how-card">
                    <div class="how-step-num text-<?php echo e($step['color']); ?>"><?php echo e($step['num']); ?></div>
                    <div class="how-icon-wrap bg-<?php echo e($step['color']); ?>-soft">
                        <i class="bi <?php echo e($step['icon']); ?> fs-2 text-<?php echo e($step['color']); ?>"></i>
                    </div>
                    <h5 class="fw-700 mt-3"><?php echo e($step['title']); ?></h5>
                    <p class="text-muted"><?php echo e($step['text']); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>




<?php if($featuredDevelopers->isNotEmpty()): ?>
<section class="section-developers py-6 bg-light-section">
    <div class="container">
        <div class="section-header d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3">
            <div>
                <span class="section-badge">Top Talents</span>
                <h2 class="section-title mt-2">Développeurs disponibles</h2>
            </div>
            <a href="<?php echo e(route('developers.index')); ?>" class="btn btn-outline-primary">
                Voir tous <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $featuredDevelopers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                <div class="dev-card h-100">
                    <div class="dev-card-header">
                        <div class="dev-card-status bg-<?php echo e($dev->profil?->disponibilite_color ?? 'success'); ?>"></div>
                        <img src="<?php echo e($dev->photo_url); ?>" alt="<?php echo e($dev->name); ?>"
                             class="dev-avatar"
                             onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                        <div class="dev-card-info">
                            <h6 class="fw-700 mb-0"><?php echo e($dev->name); ?></h6>
                            <small class="text-muted"><?php echo e($dev->profil?->specialite ?? 'Développeur Full Stack'); ?></small>
                        </div>
                    </div>

                    <p class="dev-card-bio text-muted small mt-3">
                        <?php echo e(Str::limit($dev->profil?->bio, 100)); ?>

                    </p>

                    <div class="dev-card-skills d-flex flex-wrap gap-1 mt-3">
                        <?php $__currentLoopData = array_slice($dev->profil?->competences ?? [], 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="skill-badge"><?php echo e($skill); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="dev-card-footer d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <?php if($dev->profil?->tarif_jour): ?>
                            <span class="fw-700 text-primary"><?php echo e(number_format($dev->profil->tarif_jour, 0, ',', ' ')); ?> FCFA</span>
                            <small class="text-muted">/jour</small>
                            <?php else: ?>
                            <span class="text-muted small">Tarif sur demande</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('developers.show', $dev->id)); ?>" class="btn btn-sm btn-primary">
                            Voir profil
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>




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
                            <?php echo $__env->make('components.waveicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                            </div>
                            ---xxx-e"éb            <div>
                                <div class="fw-600">Wave</div>
                                <small class="text-muted">Transfert instantané</small>
                            </div>
                        </div>
                        <div class="payment-method-card">
                            <div class="payment-method-icon om-icon">
                            <?php echo $__env->make('components.omicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
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




<section class="section-cta py-6">
    <div class="container">
        <div class="cta-block text-center">
            <h2 class="cta-title">Prêt à démarrer ?</h2>
            <p class="cta-subtitle mt-3">Rejoignez des centaines d'entreprises et de développeurs qui font confiance à DevCI.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg px-5 fw-600">
                    <i class="bi bi-person-plus me-2"></i>Créer un compte gratuit
                </a>
                <a href="<?php echo e(route('developers.index')); ?>" class="btn btn-outline-light btn-lg px-5 fw-600">
                    Parcourir les développeurs
                </a>
            </div>
        </div>
    </div>
</section>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/home/index.blade.php ENDPATH**/ ?>