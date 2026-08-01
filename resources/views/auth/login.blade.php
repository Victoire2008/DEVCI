@extends('layouts.app')
@section('title', 'Connexion – DevCI')
@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="devci-logo-text fs-2 text-decoration-none">
                        @include('components.logo') 
                    </a>
                    <h5 class="fw-700 mt-3 mb-1">Bon retour !</h5>
                    <p class="text-muted small">Connectez-vous à votre espace</p>
                </div>
                <div class="auth-card">
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-500">Adresse email</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control form-control-devci @error('email') is-invalid @enderror"
                                       placeholder="vous@exemple.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-500">Mot de passe</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password" id="passwordField"
                                       class="form-control form-control-devci @error('password') is-invalid @enderror"
                                       placeholder="••••••••" required>
                                <button type="button" class="btn-eye" onclick="togglePwd('passwordField',this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-devci-submit">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </form>
                </div>
                <p class="text-center mt-4 text-muted small">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-primary fw-600">S'inscrire gratuitement</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function togglePwd(id,btn){
    const i=document.getElementById(id),ic=btn.querySelector('i');
    i.type=i.type==='password'?'text':'password';
    ic.className=i.type==='password'?'bi bi-eye':'bi bi-eye-slash';
}
</script>
@endpush
