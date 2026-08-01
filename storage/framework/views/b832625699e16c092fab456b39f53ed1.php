<?php $__env->startSection('title','Développeurs – DevCI'); ?>
<?php $__env->startSection('content'); ?>

<section class="page-header">
    <div class="container py-5">
        <h1 class="fw-800">Nos développeurs freelances</h1>
        <p class="text-muted mt-2"><?php echo e($developers->total()); ?> développeur(s) disponible(s) en Côte d'Ivoire</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            
            <div class="col-lg-3">
                <div class="filter-card">
                    <h6 class="fw-700 mb-4"><i class="bi bi-funnel me-2"></i>Filtres</h6>
                    <form method="GET" action="<?php echo e(route('developers.index')); ?>" id="filterForm">
                        <div class="mb-3">
                            <label class="form-label small fw-600">Rechercher</label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="Nom, compétence..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-600">Compétence</label>
                            <select name="competence" class="form-select form-select-sm">
                                <option value="">Toutes</option>
                                <?php $__currentLoopData = $allCompetences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($comp); ?>" <?php echo e(request('competence')==$comp?'selected':''); ?>><?php echo e($comp); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-600">Disponibilité</label>
                            <select name="disponibilite" class="form-select form-select-sm">
                                <option value="">Toutes</option>
                                <option value="available" <?php echo e(request('disponibilite')=='available'?'selected':''); ?>>Disponible</option>
                                <option value="busy"      <?php echo e(request('disponibilite')=='busy'?'selected':''); ?>>Occupé</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-600">Tarif max (FCFA/jour)</label>
                            <input type="number" name="tarif_max" class="form-control form-control-sm"
                                   placeholder="ex: 100000" value="<?php echo e(request('tarif_max')); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 mb-2">Appliquer</button>
                        <a href="<?php echo e(route('developers.index')); ?>" class="btn btn-outline-secondary btn-sm w-100">Réinitialiser</a>
                    </form>
                </div>
            </div>

            
            <div class="col-lg-9">
                <?php if($developers->isEmpty()): ?>
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <h5 class="mt-3">Aucun développeur trouvé</h5>
                        <p class="text-muted">Essayez d'autres critères de recherche.</p>
                        <a href="<?php echo e(route('developers.index')); ?>" class="btn btn-primary">Voir tous les développeurs</a>
                    </div>
                <?php else: ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $developers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="dev-card h-100">
                            <div class="dev-card-header">
                                <div class="dev-card-status bg-<?php echo e($dev->profil?->disponibilite_color ?? 'secondary'); ?>"
                                     title="<?php echo e($dev->profil?->disponibilite_label); ?>"></div>
                                <img src="<?php echo e($dev->photo_url); ?>" alt="<?php echo e($dev->name); ?>"
                                     class="dev-avatar"
                                     onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                                <div class="dev-card-info">
                                    <h6 class="fw-700 mb-0"><?php echo e($dev->name); ?></h6>
                                    <small class="text-muted"><?php echo e($dev->profil?->specialite ?? 'Développeur'); ?></small>
                                </div>
                            </div>

                            <?php if($dev->profil?->bio): ?>
                            <p class="dev-card-bio text-muted small mt-3"><?php echo e(Str::limit($dev->profil->bio, 90)); ?></p>
                            <?php endif; ?>

                            <div class="dev-card-skills d-flex flex-wrap gap-1 mt-3">
                                <?php $__currentLoopData = array_slice($dev->profil?->competences ?? [], 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="skill-badge"><?php echo e($skill); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($dev->profil?->competences ?? []) > 4): ?>
                                <span class="skill-badge bg-secondary text-white">+<?php echo e(count($dev->profil->competences) - 4); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex align-items-center gap-2 mt-2">
                                <i class="bi bi-eye text-muted small"></i>
                                <small class="text-muted"><?php echo e($dev->profil?->vues ?? 0); ?> vues</small>
                                <?php if($dev->profil?->annees_experience): ?>
                                <span class="ms-auto text-muted small"><?php echo e($dev->profil->annees_experience); ?> an(s) d'exp.</span>
                                <?php endif; ?>
                            </div>

                            <div class="dev-card-footer d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <?php if($dev->profil?->tarif_jour): ?>
                                    <span class="fw-700 text-primary"><?php echo e(number_format($dev->profil->tarif_jour, 0, ',', ' ')); ?> FCFA</span>
                                    <small class="text-muted">/jour</small>
                                    <?php else: ?>
                                    <span class="text-muted small">Sur demande</span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo e(route('developers.show', $dev->id)); ?>" class="btn btn-sm btn-primary">
                                    Voir profil <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    <?php echo e($developers->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views\developers\index.blade.php ENDPATH**/ ?>