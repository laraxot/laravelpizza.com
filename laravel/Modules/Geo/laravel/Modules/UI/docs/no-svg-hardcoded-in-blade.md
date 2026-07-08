# Regola: No SVG Hardcoded nelle Blade

## Scopo

Gli SVG **non devono** essere scritti inline nelle view Blade. Vanno creati come file in `Modules/UI/resources/svg/` e richiamati tramite `@svg()` o `<x-filament::icon>`.

## Motivazione

1. **DRY**: Logo e icone riutilizzabili (Google, GitHub, Microsoft, Facebook) in un unico punto
2. **Manutenibilità**: Modifiche al logo in un solo file
3. **Filament way**: Preferire `<x-filament::icon>` per coerenza con l'ecosistema
4. **Consistenza**: Tutte le icone seguono lo stesso pattern di registrazione

## Dove Creare gli SVG

### Icone riutilizzabili (brand, utility)

```
laravel/Modules/UI/resources/svg/
├── google.svg              → ui-google (preferito per social login)
├── login.svg              → ui-login
├── logout.svg             → ui-logout
├── brands/
│   ├── github.svg        → ui-brands.github
│   ├── microsoft.svg     → ui-brands.microsoft
│   ├── facebook.svg      → ui-brands.facebook
│   ├── linkedin.svg     → ui-brands.linkedin
│   ├── twitter.svg      → ui-brands.twitter
│   ├── instagram.svg    → ui-brands.instagram
│   └── telegram.svg     → ui-brands.telegram
```

**Preferenza Google**: Per i pulsanti social login usare `ui-google` (file in root) anziché `ui-brands.google`.

### Convenzione Blade Icons (sottocartelle)

- `brands/github.svg` → nome icona `brands.github` (punto = separatore path)
- Con prefisso `ui` → `ui-brands.github`

## Utilizzo Corretto

### Filament way (preferito)

```blade
<x-filament::icon icon="ui-google" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.github" class="w-5 h-5 text-white" />
<x-filament::icon icon="ui-brands.microsoft" class="w-5 h-5" />
```

### Blade Icons @svg

```blade
@svg('ui-google', 'w-5 h-5')
@svg('ui-brands.github', ['class' => 'w-5 h-5 text-white'])
```

### Icone Heroicons

Le icone Heroicons sono già registrate da Filament e possono essere usate direttamente:

```blade
<x-filament::icon icon="heroicon-o-user" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-phone" class="w-5 h-5" />
```

## Anti-pattern da Evitare

```blade
{{-- ERRATO: SVG inline hardcoded --}}
<svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
    <path d="M22.56 12.25c0-.78..." fill="#4285F4"/>
    <path d="M12 23c2.97 0..." fill="#34A853"/>
</svg>
```

```blade
{{-- CORRETTO: Usa icona registrata --}}
<x-filament::icon icon="ui-google" class="w-5 h-5" />
```

## Eccezioni

- Icone Heroicons (`heroicon-o-*`) sono già registrate da Filament
- Per animazioni complesse o SVG one-off in componenti isolati, valutare caso per caso
- Icone in config/data (es. social-providers) - sono dati, non view

## Casi d'Uso Comuni

### Login Social

Per i pulsanti di login OAuth (Google, Microsoft, GitHub):

```blade
@if (config('services.google.client_id'))
    <a href="{{ route('socialite.oauth.redirect', ['provider' => 'google']) }}">
        <x-filament::icon icon="ui-google" class="w-5 h-5" />
        {{ __('Accedi con Google') }}
    </a>
@endif

@if (config('services.microsoft.client_id'))
    <a href="{{ route('socialite.oauth.redirect', ['provider' => 'microsoft']) }}">
        <x-filament::icon icon="ui-brands.microsoft" class="w-5 h-5" />
        {{ __('Accedi con Microsoft') }}
    </a>
@endif

@if (config('services.github.client_id'))
    <a href="{{ route('socialite.oauth.redirect', ['provider' => 'github']) }}">
        <x-filament::icon icon="ui-brands.github" class="w-5 h-5" />
        {{ __('Accedi con GitHub') }}
    </a>
@endif
```

### Header Navigation

```blade
{{-- Login button --}}
<a href="{{ route('login') }}">
    <x-filament::icon icon="ui-login" class="w-5 h-5" />
    {{ __('Accedi') }}
</a>

{{-- User icon (logged in) --}}
<img src="{{ auth()->user()->avatar_url }}" alt="Avatar" />

{{-- Phone CTA --}}
<a href="{{ route('contact') }}">
    <x-filament::icon icon="heroicon-o-phone" class="w-5 h-5" />
    {{ __('Contattaci') }}
</a>
```

## SVG Esistenti nel Progetto

### Brand Icons (già presenti)
- `Modules/UI/resources/svg/google.svg` → `ui-google`
- `Modules/UI/resources/svg/brands/microsoft.svg` → `ui-brands.microsoft`
- `Modules/UI/resources/svg/brands/github.svg` → `ui-brands.github`
- `Modules/UI/resources/svg/brands/facebook.svg` → `ui-brands.facebook`
- `Modules/UI/resources/svg/brands/linkedin.svg` → `ui-brands.linkedin`
- `Modules/UI/resources/svg/brands/twitter.svg` → `ui-brands.twitter`
- `Modules/UI/resources/svg/brands/telegram.svg` → `ui-brands.telegram`
- `Modules/UI/resources/svg/brands/instagram.svg` → `ui-brands.instagram`

### Utility Icons (già presenti)
- `Modules/UI/resources/svg/login.svg` → `ui-login`
- `Modules/UI/resources/svg/logout.svg` → `ui-logout`
- `Modules/UI/resources/svg/user-main.svg` → `ui-user-main`

## Aggiungere Nuove Icone

1. Creare il file SVG in `Modules/UI/resources/svg/`
2. Per le sottocartelle, usare il pattern `brands/xxx.svg`
3. L'icona sarà automaticamente disponibile come `ui-brands.xxx`

## Documentazione Collegata

- [Icon System](icon-system.md)
- [Blade Icons](../Xot/docs/registerbladeicons.md)
- [Auth Social Login Translations](../User/docs/auth-social-login-translations.md)
