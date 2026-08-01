<?php $__env->startSection('title','Mon profil – DevCI'); ?>
<?php $__env->startSection('content'); ?>
<div class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-800 mb-4">Mon profil</h4>

                <?php if(session('success')): ?>
                <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                
                <div class="content-card mb-4">
                    <h6 class="fw-700 mb-3">Photo de profil</h6>
                    <div class="d-flex align-items-center gap-4">
                        <img src="<?php echo e($user->photo_url); ?>" alt="" class="profile-avatar-lg"
                             onerror="this.src='<?php echo e(asset('images/default-avatar.svg')); ?>'">
                        <form action="<?php echo e(route('profile.photo')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <label class="btn btn-outline-primary btn-sm mb-2">
                                <i class="bi bi-upload me-2"></i>Changer la photo
                                <input type="file" name="photo" accept="image/*" class="d-none"
                                       onchange="this.closest('form').submit()">
                            </label>
                            <p class="text-muted small mb-0">JPG, PNG, WebP. Max 2 Mo.</p>
                        </form>
                    </div>
                </div>

                
                <div class="content-card mb-4">
                    <h6 class="fw-700 mb-4">Informations personnelles</h6>
                    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-500">Nom complet</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(old('name',$user->name)); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-500">Téléphone</label>
                                <input type="tel" name="phone" class="form-control" value="<?php echo e(old('phone',$user->phone)); ?>" placeholder="+225 07 00 00 00 00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-500">Ville</label>
                                <input type="text" name="city" class="form-control" value="<?php echo e(old('city',$user->city)); ?>" placeholder="Abidjan">
                            </div>

                            <?php if($user->isDeveloper()): ?>
                            <div class="col-md-6">
                                <label class="form-label fw-500">Spécialité</label>
                                <input type="text" name="specialite" class="form-control" value="<?php echo e(old('specialite',$profil->specialite)); ?>" placeholder="ex: Développeur Full Stack">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-500">Bio</label>
                                <textarea name="bio" class="form-control" rows="4" placeholder="Présentez-vous..."><?php echo e(old('bio',$profil->bio)); ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">Tarif journalier (FCFA)</label>
                                <input type="number" name="tarif_jour" class="form-control" value="<?php echo e(old('tarif_jour',$profil->tarif_jour)); ?>" placeholder="50000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">Années d'expérience</label>
                                <input type="number" name="annees_experience" class="form-control" value="<?php echo e(old('annees_experience',$profil->annees_experience)); ?>" min="0" max="50">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">Disponibilité</label>
                                <select name="disponibilite" class="form-select">
                                    <option value="available" <?php echo e(($profil->disponibilite??'available')==='available'?'selected':''); ?>>Disponible</option>
                                    <option value="busy"      <?php echo e(($profil->disponibilite??'')==='busy'?'selected':''); ?>>Occupé</option>
                                    <option value="unavailable" <?php echo e(($profil->disponibilite??'')==='unavailable'?'selected':''); ?>>Indisponible</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-500">Compétences <small class="text-muted">(séparées par des virgules)</small></label>
                                <input type="text" name="competences" class="form-control"
                                       value="<?php echo e(old('competences', implode(', ', $profil->competences ?? []))); ?>"
                                       placeholder="Laravel, React, Flutter, MySQL...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">GitHub</label>
                                <input type="url" name="github_url" class="form-control" value="<?php echo e(old('github_url',$profil->github_url)); ?>" placeholder="https://github.com/...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">LinkedIn</label>
                                <input type="url" name="linkedin_url" class="form-control" value="<?php echo e(old('linkedin_url',$profil->linkedin_url)); ?>" placeholder="https://linkedin.com/in/...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">Site web</label>
                                <input type="url" name="website_url" class="form-control" value="<?php echo e(old('website_url',$profil->website_url)); ?>" placeholder="https://...">
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamp\htdocs\DevCI-Laravel (1)\devci\resources\views/profile/edit.blade.php ENDPATH**/ ?>