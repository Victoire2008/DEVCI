<?php $__env->startSection('title', $developer->name . ' – DevCI'); ?>
<?php $__env->startSection('content'); ?>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            
            <div class="col-lg-4">
                <div class="profile-sidebar">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="<?php echo e($developer->photo_url); ?>" alt="<?php echo e($developer->name); ?>"
                                 class="profile-avatar-lg"
                                 onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                            <span class="profile-status-dot bg-<?php echo e($developer->profil?->disponibilite_color ?? 'secondary'); ?>"
                                  title="<?php echo e($developer->profil?->disponibilite_label); ?>"></span>
                        </div>
                        <h4 class="fw-800 mt-3 mb-0"><?php echo e($developer->name); ?></h4>
                        <p class="text-muted"><?php echo e($developer->profil?->specialite ?? 'Développeur Freelance'); ?></p>
                        <span class="badge bg-<?php echo e($developer->profil?->disponibilite_color ?? 'secondary'); ?>-soft text-<?php echo e($developer->profil?->disponibilite_color ?? 'secondary'); ?> px-3 py-2">
                            <?php echo e($developer->profil?->disponibilite_label ?? 'Statut inconnu'); ?>

                        </span>
                    </div>

                    <div class="profile-meta mb-4">
                        <?php if($developer->city): ?>
                        <div class="meta-item"><i class="bi bi-geo-alt"></i> <?php echo e($developer->city); ?></div>
                        <?php endif; ?>
                        <?php if($developer->profil?->annees_experience): ?>
                        <div class="meta-item"><i class="bi bi-calendar3"></i> <?php echo e($developer->profil->annees_experience); ?> an(s) d'expérience</div>
                        <?php endif; ?>
                        <?php if($developer->profil?->tarif_jour): ?>
                        <div class="meta-item"><i class="bi bi-cash-coin"></i>
                            <strong><?php echo e(number_format($developer->profil->tarif_jour, 0, ',', ' ')); ?> FCFA</strong>/jour
                        </div>
                        <?php endif; ?>
                        <div class="meta-item"><i class="bi bi-eye"></i> <?php echo e($developer->profil?->vues ?? 0); ?> vues du profil</div>
                    </div>

                    
                    <?php if($developer->profil?->github_url || $developer->profil?->linkedin_url || $developer->profil?->website_url): ?>
                    <div class="d-flex gap-2 justify-content-center mb-4">
                        <?php if($developer->profil->github_url): ?>
                        <a href="<?php echo e($developer->profil->github_url); ?>" target="_blank" class="social-btn github">
                            <i class="bi bi-github"></i>
                        </a>
                        <?php endif; ?>
                        <?php if($developer->profil->linkedin_url): ?>
                        <a href="<?php echo e($developer->profil->linkedin_url); ?>" target="_blank" class="social-btn linkedin">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <?php endif; ?>
                        <?php if($developer->profil->website_url): ?>
                        <a href="<?php echo e($developer->profil->website_url); ?>" target="_blank" class="social-btn web">
                            <i class="bi bi-globe2"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($developer->profil?->competences): ?>
                    <div class="mb-4">
                        <h6 class="fw-700 mb-3">Compétences</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php $__currentLoopData = $developer->profil->competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="skill-badge skill-badge-lg"><?php echo e($skill); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->id() !== $developer->id): ?>
                        <button class="btn btn-primary w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-send me-2"></i>Contacter ce développeur
                        </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Connectez-vous pour contacter
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="col-lg-8">

                
                <?php if($developer->profil?->bio): ?>
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i>À propos</h5>
                    <p class="text-muted" style="white-space:pre-line"><?php echo e($developer->profil->bio); ?></p>
                </div>
                <?php endif; ?>

                
                <?php if($developer->services->isNotEmpty()): ?>
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-4"><i class="bi bi-grid me-2 text-primary"></i>Services proposés</h5>
                    <div class="row g-3">
                        <?php $__currentLoopData = $developer->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="service-card h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-700 mb-0"><?php echo e($service->titre); ?></h6>
                                    <?php if($service->categorie): ?>
                                    <span class="badge bg-light text-dark"><?php echo e($service->categorie); ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="small text-muted mb-3"><?php echo e(Str::limit($service->description, 100)); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-700 text-primary"><?php echo e($service->prix_formate); ?></span>
                                    <?php if($service->delai): ?>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i><?php echo e($service->delai); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($developer->profil?->portfolio && count($developer->profil->portfolio) > 0): ?>
                <div class="content-card mb-4">
                    <h5 class="fw-700 mb-4"><i class="bi bi-collection me-2 text-primary"></i>Portfolio</h5>
                    <div class="row g-3">
                        <?php $__currentLoopData = $developer->profil->portfolio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($item['title'])): ?>
                        <div class="col-md-6">
                            <div class="portfolio-card">
                                <?php if(isset($item['image'])): ?>
                                <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['title']); ?>" class="portfolio-img">
                                <?php endif; ?>
                                <div class="portfolio-info">
                                    <h6 class="fw-700 mb-1"><?php echo e($item['title']); ?></h6>
                                    <?php if(isset($item['url'])): ?>
                                    <a href="<?php echo e($item['url']); ?>" target="_blank" class="small text-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Voir le projet
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>


<?php if(auth()->guard()->check()): ?>
<?php if(auth()->id() !== $developer->id): ?>
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-send me-2 text-primary"></i>Envoyer une demande à <?php echo e($developer->name); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('developers.contact', $developer->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
<?php endif; ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/developers/show.blade.php ENDPATH**/ ?>