<?php $__env->startSection('title','Paiements – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-800 mb-0">Paiements</h4>
                <p class="text-muted mb-0">Historique de vos transactions</p>
            </div>
            <?php if($user->isClient()): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPayModal">
                <i class="bi bi-plus-circle me-2"></i>Nouveau paiement
            </button>
            <?php endif; ?>
        </div>

        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
        <?php if(session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show"><?php echo e(session('info')); ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <?php if($paiements->isEmpty()): ?>
        <div class="empty-state text-center py-5">
            <i class="bi bi-wallet2 fs-1 text-muted"></i>
            <h5 class="mt-3">Aucune transaction</h5>
            <p class="text-muted">Vos paiements apparaîtront ici.</p>
        </div>
        <?php else: ?>
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Référence</th>
                            <th><?php echo e($user->isClient() ? 'Développeur' : 'Client'); ?></th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><code class="small"><?php echo e($p->reference); ?></code></td>
                            <td>
                                <?php if($user->isClient()): ?>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?php echo e($p->developer->photo_url); ?>" class="rounded-circle" width="28" height="28"
                                         onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                                    <?php echo e($p->developer->name); ?>

                                </div>
                                <?php else: ?>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?php echo e($p->client->photo_url); ?>" class="rounded-circle" width="28" height="28"
                                         onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                                    <?php echo e($p->client->name); ?>

                                </div>
                                <?php endif; ?>
                            </td>
                            <td><strong class="text-primary"><?php echo e($p->montant_formate); ?></strong></td>
                            <td>
                                <?php if($p->methode === 'wave'): ?>
                                <span class="badge bg-info text-white"><i class="bi bi-phone me-1"></i>Wave</span>
                                <?php else: ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-phone me-1"></i>Orange Money</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-<?php echo e($p->statut_color); ?>"><?php echo e($p->statut_label); ?></span></td>
                            <td class="text-muted small"><?php echo e($p->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('payments.show',$p->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3"><?php echo e($paiements->links()); ?></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($user->isClient()): ?>
<div class="modal fade" id="newPayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-700"><i class="bi bi-wallet2 me-2"></i>Initier un paiement</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payments.initiate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-500">Conversation / Projet <span class="text-danger">*</span></label>
                        <select name="conversation_id" class="form-select" required>
                            <option value="">Sélectionnez un projet...</option>
                            <?php $__currentLoopData = auth()->user()->conversationsAsClient()->with('developer')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($conv->id); ?>"><?php echo e($conv->sujet); ?> – <?php echo e($conv->developer->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views\payments\index.blade.php ENDPATH**/ ?>