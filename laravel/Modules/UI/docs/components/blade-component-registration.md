# Registrazione corretta dei componenti Blade nei moduli

## Problema

In un'architettura modulare Laravel, i componenti Blade registrati con sintassi punto (ad esempio `profile.dropdown`) possono causare errori quando:

1. Si utilizza la funzione `@include()` o `<x-profile.dropdown>` nei template Blade
2. Si esegue il comando `php artisan view:cache` o `php artisan optimize`
3. Laravel non riesce a risolvere correttamente il componente

Errore tipico:
```
Unable to locate a class or view for component [profile.dropdown].
```

## Cause

1. **Conflitto di namespace**: La notazione punto (`profile.dropdown`) può creare ambiguità
2. **Caricamento dei moduli**: L'ordine di caricamento dei ServiceProvider può influenzare la registrazione
3. **Cache delle viste**: La cache può contenere riferimenti obsoleti o incorretti

## Soluzione consigliata

### 1. Utilizzare la notazione del trattino invece della notazione punto

```php
// NON CONSIGLIATO
Blade::component('profile.dropdown', ProfileDropdown::class);

// CONSIGLIATO
Blade::component('profile-dropdown', ProfileDropdown::class);
```

### 2. Utilizzare un prefisso del modulo per evitare collisioni

```php
// Aggiungere prefisso del modulo
Blade::component('user-profile-dropdown', ProfileDropdown::class);
```

### 3. Modificare il modo in cui il componente viene utilizzato nei template

```blade
{{-- NON CONSIGLIATO --}}
<x-profile.dropdown>...</x-profile.dropdown>

{{-- CONSIGLIATO --}}
<x-user-profile-dropdown>...</x-user-profile-dropdown>

{{-- ALTERNATIVA: Utilizzare il namespace completo --}}
<x-user::profile.dropdown>...</x-user::profile.dropdown>
```

### 4. Mantenere entrambe le registrazioni per retrocompatibilità durante la migrazione

```php
// Registrazione con nuova convenzione
Blade::component('user-profile-dropdown', ProfileDropdown::class);

// Mantenere temporaneamente la vecchia registrazione
Blade::component('profile.dropdown', ProfileDropdown::class);
```

## Automatic Blade Component Registration

Nei moduli che estendono `XotBaseServiceProvider` (incluso il modulo UI), **non è necessario** registrare manualmente i componenti Blade con `Blade::component()` o `Blade::componentNamespace()`.
Il provider base gestisce automaticamente la registrazione di tutti i componenti presenti in `Modules/UI/View/Components`, esponendoli con il prefisso `ui` in formato dash-case.

### Usage
```blade
<x-ui-example-component />
```

## Best Practices

1. Utilizzare sempre la notazione trattino per i nomi dei componenti
2. Aggiungere un prefisso del modulo ai componenti per evitare collisioni
3. Utilizzare il namespace del componente quando possibile (`<x-user::component>`)
4. Evitare nomi generici che potrebbero entrare in conflitto con altri moduli

## Collegamenti correlati

- [Documentazione Laravel Blade Components](https://laravel.com/docs/10.x/blade#components)
- [Registrazione componenti in Laravel Blade](https://laravel.com/docs/10.x/blade#manually-registering-components)
