<?php $__env->startSection('title','Mes services – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h4 class="fw-800 mb-0">Mes services</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus-circle me-2"></i>Ajouter un service
            </button>
        </div>

        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <?php if($services->isEmpty()): ?>
        <div class="empty-state text-center py-5">
            <i class="bi bi-grid fs-1 text-muted"></i>
            <h5 class="mt-3">Aucun service encore</h5>
            <p class="text-muted">Ajoutez vos offres pour attirer des clients.</p>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                <div class="service-card h-100 position-relative">
                    <div class="position-absolute top-0 end-0 p-2 d-flex gap-1">
                        <button class="btn btn-sm btn-light" data-bs-toggle="modal"
                                data-bs-target="#editService<?php echo e($service->id); ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="<?php echo e(route('services.destroy',$service->id)); ?>" method="POST"
                              onsubmit="return confirm('Supprimer ce service ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                    <div class="mb-2">
                        <?php if($service->categorie): ?>
                        <span class="badge bg-light text-dark mb-2"><?php echo e($service->categorie); ?></span>
                        <?php endif; ?>
                        <h6 class="fw-700"><?php echo e($service->titre); ?></h6>
                        <p class="small text-muted"><?php echo e(Str::limit($service->description,120)); ?></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="fw-700 text-primary"><?php echo e($service->prix_formate); ?></span>
                        <?php if($service->delai): ?>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i><?php echo e($service->delai); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="editService<?php echo e($service->id); ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-0"><h5 class="modal-title fw-700">Modifier le service</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                        <form action="<?php echo e(route('services.update',$service->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <div class="modal-body">
                                <div class="mb-3"><label class="form-label fw-500">Titre</label><input type="text" name="titre" class="form-control" value="<?php echo e($service->titre); ?>" required></div>
                                <div class="mb-3"><label class="form-label fw-500">Description</label><textarea name="description" class="form-control" rows="3" required><?php echo e($service->description); ?></textarea></div>
                                <div class="row g-2">
                                    <div class="col-6"><label class="form-label fw-500">Prix (FCFA)</label><input type="number" name="prix" class="form-control" value="<?php echo e($service->prix); ?>" required min="1000"></div>
                                    <div class="col-6"><label class="form-label fw-500">Délai</label><input type="text" name="delai" class="form-control" value="<?php echo e($service->delai); ?>" placeholder="3 jours"></div>
                                    <div class="col-12"><label class="form-label fw-500">Catégorie</label><input type="text" name="categorie" class="form-control" value="<?php echo e($service->categorie); ?>" placeholder="Web, Mobile, Design..."></div>
                                </div>
                            </div>
                            <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0"><h5 class="modal-title fw-700">Nouveau service</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="<?php echo e(route('services.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-500">Titre <span class="text-danger">*</span></label><input type="text" name="titre" class="form-control" placeholder="ex: Développement site vitrine" required></div>
                    <div class="mb-3"><label class="form-label fw-500">Description <span class="text-danger">*</span></label><textarea name="description" class="form-control" rows="4" placeholder="Décrivez votre service en détail..." required></textarea></div>
                    <div class="row g-2">
                        <div class="col-6"><label class="form-label fw-500">Prix (FCFA) <span class="text-danger">*</span></label><input type="number" name="prix" class="form-control" placeholder="150000" required min="1000"></div>
                        <div class="col-6"><label class="form-label fw-500">Délai estimé</label><input type="text" name="delai" class="form-control" placeholder="1 semaine"></div>
                        <div class="col-12"><label class="form-label fw-500">Catégorie</label><input type="text" name="categorie" class="form-control" placeholder="Web, Mobile, Design, API..."></div>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn btn-primary">Ajouter le service</button></div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views\profile\services.blade.php ENDPATH**/ ?>