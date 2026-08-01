<?php $__env->startSection('title','Tableau de bord – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="dashboard-page py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
            <div>
                <h4 class="fw-800 mb-0">Bonjour, <?php echo e($user->name); ?> 👋</h4>
                <p class="text-muted mb-0">Gérez vos projets et votre profil</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-2"></i>Modifier mon profil
                </a>
                <a href="<?php echo e(route('services.index')); ?>" class="btn btn-primary">
                    <i class="bi bi-grid me-2"></i>Mes services
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <?php $__currentLoopData = [
                ['icon'=>'bi-eye','label'=>'Vues du profil','value'=>$stats['vues_profil'],'color'=>'primary'],
                ['icon'=>'bi-folder2','label'=>'Total projets','value'=>$stats['total_projets'],'color'=>'info'],
                ['icon'=>'bi-gear','label'=>'En cours','value'=>$stats['en_cours'],'color'=>'warning'],
                ['icon'=>'bi-cash-coin','label'=>'Revenus (FCFA)','value'=>number_format($stats['revenus_total'],0,',',' '),'color'=>'success'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-lg-3">
                <div class="stat-widget">
                    <div class="stat-widget-icon bg-<?php echo e($s['color']); ?>-soft">
                        <i class="bi <?php echo e($s['icon']); ?> text-<?php echo e($s['color']); ?>"></i>
                    </div>
                    <div class="stat-widget-body">
                        <div class="stat-widget-value"><?php echo e($s['value']); ?></div>
                        <div class="stat-widget-label"><?php echo e($s['label']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="dash-card">
            <div class="dash-card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-700 mb-0"><i class="bi bi-chat-dots me-2"></i>Demandes reçues</h6>
                <a href="<?php echo e(route('chat.index')); ?>" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="dash-card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('chat.show', $conv->id)); ?>" class="conv-item">
                    <img src="<?php echo e($conv->client->photo_url); ?>" alt=""
                         class="conv-avatar"
                         onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                    <div class="conv-info flex-grow-1 min-w-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-600 text-truncate"><?php echo e($conv->client->name); ?></span>
                            <small class="text-muted ms-2 flex-shrink-0"><?php echo e($conv->last_message_at?->diffForHumans()); ?></small>
                        </div>
                        <div class="text-muted small text-truncate"><?php echo e($conv->sujet); ?></div>
                    </div>
                    <?php $unread = $conv->getUnreadCountForUser($user->id); ?>
                    <?php if($unread > 0): ?>
                    <span class="badge bg-danger rounded-pill ms-2"><?php echo e($unread); ?></span>
                    <?php else: ?>
                    <span class="badge bg-<?php echo e($conv->statut_color); ?> ms-2"><?php echo e($conv->statut_label); ?></span>
                    <?php endif; ?>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 mb-2 d-block"></i>
                    Aucune demande reçue pour l'instant.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/dashboard/developer.blade.php ENDPATH**/ ?>