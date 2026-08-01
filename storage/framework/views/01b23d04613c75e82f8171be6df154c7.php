<?php $__env->startSection('title', 'Inscription – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <a href="<?php echo e(route('home')); ?>" class="devci-logo-text fs-2 text-decoration-none">
                       <?php echo $__env->make('components.logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </a>
                    <h5 class="fw-700 mt-3 mb-1">Créez votre compte</h5>
                    <p class="text-muted small">Rejoignez la communauté DevCI gratuitement</p>
                </div>

                <div class="auth-card">
                    
                    <div class="role-selector mb-4">
                        <p class="fw-600 small mb-2">Je suis :</p>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role_select" id="role_client" value="client" checked>
                                <label class="role-card w-100" for="role_client">
                                    <i class="bi bi-briefcase fs-3"></i>
                                    <div class="fw-600 mt-1">Client</div>
                                    <small class="text-muted">Je cherche un développeur</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role_select" id="role_dev" value="developer">
                                <label class="role-card w-100" for="role_dev">
                                    <i class="bi bi-code-slash fs-3"></i>
                                    <div class="fw-600 mt-1">Développeur</div>
                                    <small class="text-muted">Je propose mes services</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('register.post')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="role" id="roleInput" value="client">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-500">Nom complet</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-person input-icon"></i>
                                    <input type="text" name="name" class="form-control form-control-devci <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Kouamé Jean-Baptiste" value="<?php echo e(old('name')); ?>" required>
                                </div>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-500">Adresse email</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email" name="email" class="form-control form-control-devci <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="vous@exemple.com" value="<?php echo e(old('email')); ?>" required>
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-500">Numéro de téléphone</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-phone input-icon"></i>
                                    <input type="tel" name="phone" class="form-control form-control-devci"
                                           placeholder="+225 07 00 00 00 00" value="<?php echo e(old('phone')); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-500">Mot de passe</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password" name="password" id="pwd"
                                           class="form-control form-control-devci <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Minimum 8 caractères" required>
                                    <button type="button" class="btn-eye" onclick="togglePwd('pwd',this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-500">Confirmer le mot de passe</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-lock-fill input-icon"></i>
                                    <input type="password" name="password_confirmation" id="pwd2"
                                           class="form-control form-control-devci" placeholder="••••••••" required>
                                    <button type="button" class="btn-eye" onclick="togglePwd('pwd2',this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-devci-submit mt-4">
                            <i class="bi bi-person-plus me-2"></i>Créer mon compte
                        </button>

                        <p class="text-center text-muted mt-3" style="font-size:11px">
                            En créant un compte, vous acceptez nos conditions d'utilisation.
                        </p>
                    </form>
                </div>

                <p class="text-center mt-4 text-muted small">
                    Déjà inscrit ?
                    <a href="<?php echo e(route('login')); ?>" class="text-primary fw-600">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function togglePwd(id,btn){
    const i=document.getElementById(id),ic=btn.querySelector('i');
    i.type=i.type==='password'?'text':'password';
    ic.className=i.type==='password'?'bi bi-eye':'bi bi-eye-slash';
}
document.querySelectorAll('input[name="role_select"]').forEach(r=>{
    r.addEventListener('change',()=>{
        document.getElementById('roleInput').value=r.value;
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/auth/register.blade.php ENDPATH**/ ?>