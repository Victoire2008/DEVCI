<!-- ── Footer ─────────────────────────────────────────────── -->
<footer class="devci-footer mt-auto">
    <div class="container">
        <div class="row g-4 py-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="devci-logo-text fs-4">
                       @include("components.logo")
                    </span>
                </div>
                <p class="text-muted small">La plateforme qui connecte les meilleurs développeurs freelances aux entreprises et particuliers en Côte d'Ivoire.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2 offset-lg-2">
                <h6 class="footer-heading">Plateforme</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('developers.index') }}">Trouver un développeur</a></li>
                    <li><a href="{{ route('register') }}">Devenir freelance</a></li>
                    <li><a href="{{ route('home') }}">Comment ça marche</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">Compte</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                    @auth
                    <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-2">
                <h6 class="footer-heading">Support</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Politique de confidentialité</a></li>
                </ul>
            </div>
        </div>
        <div class="border-top py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <small class="text-muted">© {{ date('Y') }} DevCI – Tous droits réservés</small>
            <div class="d-flex gap-3 align-items-center">
                <img src="{{ asset('images/wave-logo.svg') }}" alt="Wave" height="20"
                     onerror="this.outerHTML='<span class=\'badge bg-secondary\'>Wave</span>'">
                <img src="{{ asset('images/orange-money-logo.svg') }}" alt="Orange Money" height="20"
                     onerror="this.outerHTML='<span class=\'badge bg-warning text-dark\'>Orange Money</span>'">
            </div>
        </div>
    </div>
</footer>
