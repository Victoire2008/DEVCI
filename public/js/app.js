/**
 * DevCI – JavaScript principal
 */
// ── partie hero  ────────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {

    if (typeof gsap === "undefined") return;

    gsap.set([
        ".hero-subtitle",
        ".hero-search-wrapper",
        ".hero-tags",
        ".card-1",
        ".card-2",
        ".card-3"
    ], {
        opacity: 0
    });

    const tl = gsap.timeline({
        defaults: {
            ease: "power3.out"
        }
    });

    // IMAGE

    tl.from(".hero-image-container", {
        opacity: 0,
        scale: 0.95,
        duration: 0.8
    });

    // TEXTE PRINCIPAL

    tl.to(".hero-word", {
        opacity: 1,
        y: 0,
        stagger: 0.08,
        duration: 0.7
    }, "-=0.4");

    // SOUS TITRE

    tl.to(".hero-subtitle", {
        opacity: 1,
        y: 0,
        duration: 0.6
    }, "-=0.3");

    // BARRE RECHERCHE

    tl.to(".hero-search-wrapper", {
        opacity: 1,
        y: 0,
        duration: 0.5
    }, "-=0.2");

    // TAGS

    tl.to(".hero-tag", {
        opacity: 1,
        y: 0,
        stagger: 0.05,
        duration: 0.3
    });

    // CARD 1

    tl.fromTo(".card-1",
        {
            x: -50,
            opacity: 0
        },
        {
            x: 0,
            opacity: 1,
            duration: 0.6
        },
        "-=0.3"
    );

    // CARD 2

    tl.fromTo(".card-2",
        {
            y: 50,
            opacity: 0
        },
        {
            y: 0,
            opacity: 1,
            duration: 0.6
        },
        "-=0.4"
    );

    // CARD 3

    tl.fromTo(".card-3",
        {
            x: 50,
            opacity: 0
        },
        {
            x: 0,
            opacity: 1,
            duration: 0.6
        },
        "-=0.5"
    );

});
document.addEventListener('DOMContentLoaded', function () {

    // ── Init AOS (Animate On Scroll) ───────────────────────
    if (typeof AOS !== 'undefined') {
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-cubic'
        });
    }

    // ── Auto-dismiss alerts après 5 secondes ─────────────────
    document.querySelectorAll('.alert.alert-success, .alert.alert-info').forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });

    // ── Smooth count-up animation pour les stats ─────────────
    const statNumbers = document.querySelectorAll('.stat-number[data-count]');
    if (statNumbers.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    countUp(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(el => observer.observe(el));
    }

    function countUp(el) {
        const target  = parseInt(el.dataset.count) || 0;
        const duration = 1500;
        const step     = Math.ceil(target / (duration / 16));
        let current    = 0;

        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current.toLocaleString('fr-FR');
            if (current >= target) clearInterval(timer);
        }, 16);
    }

    // ── Active nav link ───────────────────────────────────────
    const path = window.location.pathname;
    document.querySelectorAll('.navbar .nav-link').forEach(link => {
        if (link.getAttribute('href') === path) {
            link.classList.add('active');
        }
    });

    // ── Image fallback ────────────────────────────────────────
    document.querySelectorAll('img[onerror]').forEach(img => {
        img.addEventListener('error', function () {
            if (!this._fallbackApplied) {
                this._fallbackApplied = true;
            }
        });
    });

    // ── Tooltip Bootstrap ─────────────────────────────────────
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        bootstrap.Tooltip.getOrCreateInstance(el);
    });

    // ── Confirm delete ────────────────────────────────────────
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm(this.dataset.confirm || 'Confirmer cette action ?')) {
                e.preventDefault();
            }
        });
    });
});
