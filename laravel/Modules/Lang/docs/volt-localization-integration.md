# Integrazione Livewire Volt + mcamara/laravel-localization

## 1. Obiettivo

- Gestire componenti Livewire Volt in un'applicazione Laravel multilingua con route localizzate tramite mcamara/laravel-localization.
- Permettere la localizzazione delle route che montano componenti Volt.
- Gestire la lingua corrente all'interno dei componenti Volt (sia per visualizzazione che per azioni dinamiche).

---

## 2. Setup di base

### 2.1. Installazione pacchetti

```bash
composer require livewire/volt
composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

### 2.2. Configurazione delle route

Tutte le route che montano componenti Volt devono essere wrappate dal gruppo localizzato:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Facades\Folio; // se usi Folio

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        // Route classiche
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Route che montano componenti Volt
        Route::get('/profile', \Livewire\Volt\Volt::component('profile'))->name('profile');

        // Oppure, se usi Folio:
        Folio::route('pages');
    }
);
```

Se usi Folio, tutte le pagine in `resources/views/pages` saranno automaticamente localizzate se Folio è incluso nel gruppo localizzato.

---

## 3. Localizzazione delle route Volt

### 3.1. Traduzione delle route

- Crea i file `lang/{locale}/routes.php` per ogni lingua, come da [documentazione mcamara](https://github.com/mcamara/laravel-localization#translated-routes).
- Esempio:
  ```php
  // lang/en/routes.php
  return [
      'profile' => 'profile',
      'dashboard' => 'dashboard',
  ];
  // lang/it/routes.php
  return [
      'profile' => 'profilo',
      'dashboard' => 'bacheca',
  ];
  ```
- Usa le route tradotte nei tuoi file di route:
  ```php
  Route::get(LaravelLocalization::transRoute('routes.profile'), \Livewire\Volt\Volt::component('profile'))->name('profile');
  ```

### 3.2. Link localizzati nei Blade/Volt

- Nei template Blade o Volt, usa sempre i metodi di LaravelLocalization per generare i link:
  ```blade
  <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('profile')) }}">
      {{ __('Profile') }}
  </a>
  ```

---

## 4. Gestione della lingua nei componenti Volt

### 4.1. Accesso alla lingua corrente

- All'interno di un componente Volt, puoi accedere alla lingua corrente con:
  ```php
  $locale = app()->getLocale();
  ```
- Puoi usare questa variabile per:
  - Caricare dati localizzati
  - Cambiare la lingua delle validazioni
  - Mostrare contenuti diversi in base alla lingua

### 4.2. Cambio lingua da Volt

- Per cambiare lingua da un componente Volt (es. tramite un pulsante), puoi:
  - Emettere un redirect verso la stessa route con il nuovo prefisso lingua:
    ```php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    $changeLocale = function ($locale) {
        return redirect(LaravelLocalization::getLocalizedURL($locale, url()->current()));
    };
    ```
  - Oppure aggiornare la sessione/cookie e ricaricare la pagina.

### 4.3. Esempio di language switcher in Volt

```php
<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$locales = LaravelLocalization::getSupportedLocales();
$current = app()->getLocale();
?>
<div>
    @foreach($locales as $localeCode => $properties)
        <button
            wire:click="$emit('changeLocale', '{{ $localeCode }}')"
            @if($localeCode === $current) style="font-weight:bold" @endif
        >
            {{ $properties['native'] }}
        </button>
    @endforeach
</div>
<script>
    Livewire.on('changeLocale', locale => {
        window.location.href = '{{ LaravelLocalization::getLocalizedURL('' ) }}'.replace('''', locale);
    });
</script>
```

---

## 5. Validazione e messaggi localizzati

- Livewire/Volt usa le stesse regole di validazione di Laravel.
- I messaggi di errore saranno automaticamente localizzati se la route è localizzata e la lingua è corretta.
- Puoi personalizzare i messaggi nei file `lang/{locale}/validation.php`.

---

## 6. Best practice e note operative

- Tutte le route che montano componenti Volt devono essere wrappate dal gruppo localizzato.
- Usa sempre i metodi di LaravelLocalization per generare link e redirect.
- Versiona i file di route tradotte e aggiorna la documentazione ogni volta che aggiungi nuove pagine Volt.
- Testa la localizzazione sia per le route che per i contenuti dinamici dei componenti Volt.
- Per la cache delle route, usa sempre `php artisan route:trans:cache` se usi la cache delle route localizzate.

---

## 7. Collegamenti utili

- [Livewire Volt - Docs](https://livewire.laravel.com/project_docs/volt)
- [mcamara/laravel-localization - GitHub](https://github.com/mcamara/laravel-localization)
- [Traduzione route con mcamara](https://github.com/mcamara/laravel-localization#translated-routes)

---

## 8. Checklist finale

- [ ] Tutte le route Volt sono wrappate dal gruppo localizzato
- [ ] I link nei Blade/Volt usano i metodi di LaravelLocalization
- [ ] I file `lang/{locale}/routes.php` sono completi e versionati
- [ ] I componenti Volt accedono e gestiscono la lingua corrente correttamente
- [ ] La documentazione è aggiornata e linkata nei README

</rewritten_file> 
