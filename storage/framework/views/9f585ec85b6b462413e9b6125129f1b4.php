<?php $__env->startSection('title','Paiement #' . $paiement->id . ' – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="content-card text-center">
                    <div class="mb-4">
                        <?php if($paiement->statut === 'paye'): ?>
                            <div class="payment-status-icon bg-success-soft text-success"><i class="bi bi-check-circle-fill fs-1"></i></div>
                            <h4 class="fw-800 mt-3">Paiement confirmé !</h4>
                        <?php elseif($paiement->statut === 'echoue'): ?>
                            <div class="payment-status-icon bg-danger-soft text-danger"><i class="bi bi-x-circle-fill fs-1"></i></div>
                            <h4 class="fw-800 mt-3">Paiement échoué</h4>
                        <?php else: ?>
                            <div class="payment-status-icon bg-warning-soft text-warning"><i class="bi bi-hourglass-split fs-1"></i></div>
                            <h4 class="fw-800 mt-3">Paiement en attente</h4>
                        <?php endif; ?>
                    </div>

                    <div class="payment-detail-box">
                        <div class="payment-detail-row">
                            <span>Référence</span>
                            <code><?php echo e($paiement->reference); ?></code>
                        </div>
                        <div class="payment-detail-row">
                            <span>Montant</span>
                            <strong class="text-primary fs-5"><?php echo e($paiement->montant_formate); ?></strong>
                        </div>
                        <div class="payment-detail-row">
                            <span>Méthode</span>
                            <span><?php echo e($paiement->methode === 'wave' ? 'Wave CI' : 'Orange Money'); ?></span>
                        </div>
                        <div class="payment-detail-row">
                            <span>Client</span>
                            <span><?php echo e($paiement->client->name); ?></span>
                        </div>
                        <div class="payment-detail-row">
                            <span>Développeur</span>
                            <span><?php echo e($paiement->developer->name); ?></span>
                        </div>
                        <div class="payment-detail-row">
                            <span>Projet</span>
                            <span><?php echo e($paiement->conversation->sujet); ?></span>
                        </div>
                        <div class="payment-detail-row">
                            <span>Date</span>
                            <span><?php echo e($paiement->created_at->format('d/m/Y à H:i')); ?></span>
                        </div>
                        <div class="payment-detail-row">
                            <span>Statut</span>
                            <span class="badge bg-<?php echo e($paiement->statut_color); ?> px-3 py-2"><?php echo e($paiement->statut_label); ?></span>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-center flex-wrap">
                        <a href="<?php echo e(route('chat.show', $paiement->conversation_id)); ?>" class="btn btn-outline-primary">
                            <i class="bi bi-chat-dots me-2"></i>Voir la conversation
                        </a>
                        <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-primary">
                            <i class="bi bi-wallet2 me-2"></i>Tous les paiements
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/payments/show.blade.php ENDPATH**/ ?>