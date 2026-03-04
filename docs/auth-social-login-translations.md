# Traduzioni Auth Social Login - Filosofia Laraxot

## Scopo

Definisce la struttura corretta delle traduzioni per i pulsanti di login social (Google, GitHub, Microsoft) nel modulo User, in linea con la filosofia Laraxot.

## Chiavi Corrette

### Struttura in `user::auth`

Le traduzioni per i provider social **devono** usare la chiave `auth.social.*`:

```php
// Modules/User/lang/it/auth.php
'social' => [
    'title' => 'Accedi con',
    'google' => 'Google',
    'github' => 'GitHub',
    'microsoft' => 'Microsoft',
    'error' => 'Si è verificato un errore con il login social.',
],
```

### Uso nella View

```blade
{{ __('user::auth.social.google') }}
{{ __('user::auth.social.github') }}
{{ __('user::auth.social.microsoft') }}
```

## Anti-pattern da Evitare

### Chiavi Errate

```blade
{{-- ERRATO: chiave inesistente --}}
{{ __('user::auth.login.google') }}

{{-- ERRATO: chiave non in linea con la struttura --}}
{{ __('user::auth.login.with_google') }}
```

**Motivazione**: La struttura `auth.social.*` centralizza tutte le etichette dei provider social in un unico punto, seguendo il principio DRY. Le chiavi `auth.login.*` sono riservate a elementi specifici del form di login (email, password, submit, ecc.).

## Visibilità Condizionale

I pulsanti social sono mostrati solo se il provider è configurato:

```blade
@if(config('services.google.client_id'))
    <a href="{{ route('socialite.oauth.redirect', ['provider' => 'google']) }}">
        {{ __('user::auth.social.google') }}
    </a>
@endif
@if(config('services.microsoft.client_id'))
    ...
@endif
@if(config('services.github.client_id'))
    ...
@endif
```

## Colori Pulsanti (WCAG AA)

Per garantire visibilità e accessibilità, i pulsanti devono usare colori espliciti:

- **Pulsante Accedi**: gradient `#1E5A96` → `#2D8659` (contrasto ≥ 4.5:1)
- **Google**: sfondo bianco, bordo grigio, testo grigio scuro
- **Microsoft**: `#00A4EF` con testo bianco
- **GitHub**: `#24292F` con testo bianco

Evitare classi Tailwind non definite (es. `from-primary-600`) che possono risultare bianche su sfondo bianco.

## Icone Brand (No SVG Inline)

I pulsanti social usano icone da `Modules/UI/resources/svg/` tramite `<x-filament::icon>`:

- `ui-google` (google.svg in root) — preferito rispetto a `ui-brands.google`
- `ui-brands.github` (brands/github.svg)
- `ui-brands.microsoft` (brands/microsoft.svg)

**Vietato** SVG inline: vedi [No SVG Hardcoded](../../UI/docs/no-svg-hardcoded-in-blade.md).

```blade
<x-filament::icon icon="ui-google" class="w-5 h-5 flex-shrink-0" />
```

## SocialLoginWidget (Riutilizzabile)

I pulsanti social sono estratti nel widget `Modules\User\Filament\Widgets\Auth\SocialLoginWidget`, riutilizzabile in login, register e altre pagine auth:

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\SocialLoginWidget::class)
```

Il widget mostra automaticamente solo i provider configurati in `config/services` (Google, Microsoft, GitHub).

## Collegamenti

- [Translation Philosophy](../../Xot/docs/translation-philosophy.md)
- [Auth Login Implementation](auth-login-implementation.md)
- [Socialite Microsoft Integration](socialite-microsoft-integration.md)
- [Auth Widgets View Namespaces](auth-widgets-view-namespaces.md)
