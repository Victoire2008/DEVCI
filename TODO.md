# TODO - Image hero introuvable

- [ ] Constater où le template référence l’image du hero.
- [ ] Vérifier où l’image devrait se trouver (public/images vs storage/app/public/images) et ce qui existe réellement.
- [ ] Corriger le chemin dans la vue (asset() vs asset('storage/...')).
- [ ] S’assurer que le lien symbolique public/storage -> storage/app/public existe (php artisan storage:link).
- [ ] Recharger la page et vérifier le rendu (test en devtools: URL image 200/404).

