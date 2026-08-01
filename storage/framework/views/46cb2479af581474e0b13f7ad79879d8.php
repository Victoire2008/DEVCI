<?php $__env->startSection('title','Messages – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <h4 class="fw-800 mb-4">Messages</h4>
        <?php if($conversations->isEmpty()): ?>
        <div class="empty-state text-center py-5">
            <i class="bi bi-chat-dots fs-1 text-muted"></i>
            <h5 class="mt-3">Aucune conversation</h5>
            <?php if($user->isClient()): ?>
            <a href="<?php echo e(route('developers.index')); ?>" class="btn btn-primary mt-2">Trouver un développeur</a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="conv-list-card">
            <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $other=$user->isDeveloper()?$conv->client:$conv->developer; $unread=$conv->getUnreadCountForUser($user->id); ?>
            <a href="<?php echo e(route('chat.show',$conv->id)); ?>" class="conv-item <?php echo e($unread>0?'conv-item--unread':''); ?>">
                <img src="<?php echo e($other->photo_url); ?>" alt="" class="conv-avatar"
                     onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                <div class="conv-info flex-grow-1 min-w-0">
                    <div class="d-flex justify-content-between">
                        <span class="fw-600"><?php echo e($other->name); ?></span>
                        <small class="text-muted"><?php echo e($conv->last_message_at?->diffForHumans()); ?></small>
                    </div>
                    <div class="<?php echo e($unread>0?'fw-600 text-dark':'text-muted'); ?> small text-truncate"><?php echo e($conv->sujet); ?></div>
                </div>
                <?php if($unread>0): ?><span class="badge bg-primary rounded-pill ms-2"><?php echo e($unread); ?></span><?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views\chat\index.blade.php ENDPATH**/ ?>