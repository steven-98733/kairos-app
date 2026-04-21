@extends('layouts.app')

@section('page')

<div class="menu-page">
    <div class="hero">
        <div class="hero-copy">
            <p class="eyebrow">Espace personnel</p>
            <h1>Parametres du compte</h1>
            <p class="hero-text">
                Toutes les options importantes sont maintenant actives sur cette page:
                mot de passe, reinitialisation, email, adresse et telephone.
            </p>
        </div>

        <div class="hero-card">
            <span class="hero-label">Compte local actif</span>
            <strong>{{ $user->name }}</strong>
            <span>{{ $user->email }}</span>
            <p>
                Si tu ne connais pas encore le mot de passe actuel, utilise directement
                le bloc <b>Mot de passe oublie</b> avec l email ci-dessus.
            </p>
        </div>
    </div>

    <div class="shortcut-grid">
        <a class="shortcut" href="#password-form">🔐 Changer Mots de passe</a>
        <a class="shortcut" href="#reset-form">🔑 Mot de passe oublie</a>
        <a class="shortcut" href="#email-form">📧 Modifier mon Email</a>
        <a class="shortcut" href="#address-form">📍 Modifier mon Adresse</a>
        <a class="shortcut" href="#phone-form">📞 Modifier mon Telephone</a>
    </div>

    <div class="settings-grid">
        <section class="panel" id="password-form">
            <div class="panel-header">
                <div class="icon-chip">🔐</div>
                <div>
                    <h2>Changer le mot de passe</h2>
                    <p>Utilise cette partie quand tu connais deja le mot de passe actuel.</p>
                </div>
            </div>

            @if (session('password_status'))
                <div class="feedback feedback-success">{{ session('password_status') }}</div>
            @endif

            @if ($errors->passwordUpdate->any())
                <div class="feedback feedback-error">
                    @foreach ($errors->passwordUpdate->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="form-grid" method="POST" action="{{ route('settings.password.update') }}">
                @csrf
                @method('PATCH')

                <label class="field">
                    <span>Mot de passe actuel</span>
                    <input type="password" name="current_password" placeholder="Entre le mot de passe actuel" required>
                </label>

                <label class="field">
                    <span>Nouveau mot de passe</span>
                    <input type="password" name="password" placeholder="Minimum 8 caracteres" required>
                </label>

                <label class="field">
                    <span>Confirmation</span>
                    <input type="password" name="password_confirmation" placeholder="Retape le nouveau mot de passe" required>
                </label>

                <button type="submit">Enregistrer le nouveau mot de passe</button>
            </form>
        </section>

        <section class="panel" id="reset-form">
            <div class="panel-header">
                <div class="icon-chip">🔑</div>
                <div>
                    <h2>Mot de passe oublie</h2>
                    <p>Reinitialise ton acces avec l email du compte local affiche en haut.</p>
                </div>
            </div>

            @if (session('reset_status'))
                <div class="feedback feedback-success">{{ session('reset_status') }}</div>
            @endif

            @if ($errors->passwordReset->any())
                <div class="feedback feedback-error">
                    @foreach ($errors->passwordReset->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="form-grid" method="POST" action="{{ route('settings.password.reset') }}">
                @csrf
                @method('PATCH')

                <label class="field">
                    <span>Email du compte</span>
                    <input
                        type="email"
                        name="reset_email"
                        value="{{ old('reset_email', $user->email) }}"
                        placeholder="compte@kairos.local"
                        required
                    >
                </label>

                <label class="field">
                    <span>Nouveau mot de passe</span>
                    <input type="password" name="reset_password" placeholder="Choisis un nouveau mot de passe" required>
                </label>

                <label class="field">
                    <span>Confirmation</span>
                    <input type="password" name="reset_password_confirmation" placeholder="Confirme le nouveau mot de passe" required>
                </label>

                <button type="submit">Reinitialiser le mot de passe</button>
            </form>
        </section>

        <section class="panel" id="email-form">
            <div class="panel-header">
                <div class="icon-chip">📧</div>
                <div>
                    <h2>Modifier l email</h2>
                    <p>Change l adresse email principale du compte local.</p>
                </div>
            </div>

            @if (session('email_status'))
                <div class="feedback feedback-success">{{ session('email_status') }}</div>
            @endif

            @if ($errors->emailUpdate->any())
                <div class="feedback feedback-error">
                    @foreach ($errors->emailUpdate->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="form-grid" method="POST" action="{{ route('settings.email.update') }}">
                @csrf
                @method('PATCH')

                <label class="field">
                    <span>Nouvel email</span>
                    <input
                        type="email"
                        name="new_email"
                        value="{{ old('new_email', $user->email) }}"
                        placeholder="ton@email.com"
                        required
                    >
                </label>

                <button type="submit">Mettre a jour l email</button>
            </form>
        </section>

        <section class="panel" id="address-form">
            <div class="panel-header">
                <div class="icon-chip">📍</div>
                <div>
                    <h2>Modifier l adresse</h2>
                    <p>Ajoute une adresse postale ou corrige celle qui est deja enregistree.</p>
                </div>
            </div>

            @if (session('address_status'))
                <div class="feedback feedback-success">{{ session('address_status') }}</div>
            @endif

            @if ($errors->addressUpdate->any())
                <div class="feedback feedback-error">
                    @foreach ($errors->addressUpdate->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="form-grid" method="POST" action="{{ route('settings.address.update') }}">
                @csrf
                @method('PATCH')

                <label class="field">
                    <span>Adresse complete</span>
                    <textarea name="address" placeholder="Exemple: Dakar, Medina, Rue 14, Villa 23">{{ old('address', $user->address) }}</textarea>
                </label>

                <button type="submit">Mettre a jour l adresse</button>
            </form>
        </section>

        <section class="panel" id="phone-form">
            <div class="panel-header">
                <div class="icon-chip">📞</div>
                <div>
                    <h2>Modifier le telephone</h2>
                    <p>Renseigne un numero joignable pour le compte local.</p>
                </div>
            </div>

            @if (session('phone_status'))
                <div class="feedback feedback-success">{{ session('phone_status') }}</div>
            @endif

            @if ($errors->phoneUpdate->any())
                <div class="feedback feedback-error">
                    @foreach ($errors->phoneUpdate->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="form-grid" method="POST" action="{{ route('settings.phone.update') }}">
                @csrf
                @method('PATCH')

                <label class="field">
                    <span>Numero de telephone</span>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+221 77 000 00 00"
                    >
                </label>

                <button type="submit">Mettre a jour le telephone</button>
            </form>
        </section>
    </div>
</div>

<style>
.menu-page {
    width: 100%;
    min-height: 100vh;
    padding: 32px 20px 48px;
    background:
        radial-gradient(circle at top left, rgba(46, 196, 182, 0.35), transparent 32%),
        linear-gradient(180deg, #f5fbfb 0%, #eef3f7 100%);
}

.hero,
.shortcut-grid,
.settings-grid {
    width: min(1150px, 100%);
    margin: 0 auto;
}

.hero {
    display: grid;
    grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.8fr);
    gap: 24px;
    align-items: stretch;
    margin-bottom: 22px;
}

.hero-copy,
.hero-card,
.panel,
.shortcut {
    box-shadow: 0 24px 60px rgba(16, 42, 67, 0.12);
}

.hero-copy {
    padding: 30px;
    border-radius: 28px;
    background: rgba(255, 255, 255, 0.88);
}

.eyebrow {
    margin: 0 0 8px;
    font-size: 12px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #2f7a73;
    font-weight: 700;
}

.hero-copy h1 {
    margin: 0;
    font-size: clamp(32px, 6vw, 52px);
    line-height: 1;
    color: #102a43;
}

.hero-text {
    max-width: 620px;
    margin: 18px 0 0;
    font-size: 16px;
    line-height: 1.7;
    color: #486581;
}

.hero-card {
    display: grid;
    gap: 10px;
    padding: 28px;
    border-radius: 28px;
    background: linear-gradient(160deg, #102a43 0%, #1d4d63 100%);
    color: #f5f7fa;
}

.hero-card strong {
    font-size: 26px;
}

.hero-label {
    font-size: 12px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.7);
}

.hero-card p {
    margin: 0;
    font-size: 14px;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.84);
}

.shortcut-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.shortcut {
    padding: 18px 20px;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.94);
    text-decoration: none;
    color: #102a43;
    font-weight: 600;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
}

.shortcut:hover {
    transform: translateY(-2px);
    box-shadow: 0 30px 60px rgba(16, 42, 67, 0.16);
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 22px;
}

.panel {
    padding: 24px;
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.94);
}

.panel-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 18px;
}

.panel-header h2 {
    margin: 0 0 6px;
    color: #102a43;
    font-size: 22px;
}

.panel-header p {
    margin: 0;
    color: #627d98;
    line-height: 1.6;
}

.icon-chip {
    display: grid;
    place-items: center;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, #d9f3f0 0%, #f0f7ff 100%);
    font-size: 22px;
}

.feedback {
    margin-bottom: 16px;
    padding: 13px 15px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.6;
}

.feedback p {
    margin: 0;
}

.feedback p + p {
    margin-top: 4px;
}

.feedback-success {
    background: #e7f9f2;
    color: #0f6a47;
    border: 1px solid #b7ebd0;
}

.feedback-error {
    background: #fff1f1;
    color: #9b1c1c;
    border: 1px solid #f4c7c7;
}

.form-grid {
    display: grid;
    gap: 14px;
}

.field {
    display: grid;
    gap: 8px;
    color: #243b53;
    font-size: 14px;
    font-weight: 600;
}

.field input,
.field textarea {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #d9e2ec;
    border-radius: 16px;
    background: #f8fbfd;
    color: #102a43;
    font: inherit;
    box-sizing: border-box;
}

.field input:focus,
.field textarea:focus {
    outline: none;
    border-color: #20c9c3;
    box-shadow: 0 0 0 4px rgba(32, 201, 195, 0.12);
}

.field textarea {
    min-height: 120px;
    resize: vertical;
}

.form-grid button {
    width: fit-content;
    border: none;
    border-radius: 999px;
    padding: 14px 20px;
    background: linear-gradient(135deg, #102a43 0%, #1d4d63 100%);
    color: white;
    font: inherit;
    font-weight: 700;
    cursor: pointer;
}

.form-grid button:hover {
    filter: brightness(1.05);
}

@media (max-width: 860px) {
    .hero {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .menu-page {
        padding: 20px 14px 32px;
    }

    .panel,
    .hero-copy,
    .hero-card {
        padding: 20px;
        border-radius: 20px;
    }

    .shortcut {
        padding: 15px 16px;
    }

    .form-grid button {
        width: 100%;
    }
}
</style>

@endsection
