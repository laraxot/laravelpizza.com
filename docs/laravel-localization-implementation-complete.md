# Laravel Localization Implementation - Laravelpizza (Laravel 12.x)

## 📋 Overview

Questo documento documenta l'implementazione completa del pacchetto Laravel Localization di mcamara nel progetto Laravel Pizza che segue la filosofia Laravel 12.x con multi-tenant support.

## 🎯 Filosofia Laravel Localization

### **Principi Fondamentali**
- ✅ **Rilevamento automatico lingua browser**
- ✅ **Redirect intelligente con session/cookie**
- ✅ **Routing tradotto centralizzato**
- ✅ **Caching route supportato**
- ✅ **Testing multilingua**
- ✅ **Helper per URL localizzati**

### **Struttura Architetturale**
```
laravel/config/laravellocalization.php
├── supportedLocales          # Lingue supportate
├── middleware              # Middleware specifici
├── helpers                 # Funzioni helper
├── translatable routes     # Routing tradotto
└── caching                 # Route caching
```

## 📁 File Principali

### **1. `/config/laravellocalization.php`** (Configurazione Base)
- Configurazione base del pacchetto Laravel Localization
- Lingue supportate e middleware
- Opzioni di caching e testing

### **2. `/Modules/Meetup/app/Providers/MeetupServiceProvider.php`**
- Registrazione middleware di localizzazione
- Aggiunta helper globali
- Configurazione per modulo Meetup

### **3. `/Modules/Tenant/app/Providers/TenantServiceProvider.php`**
- Middleware per multi-tenant
- Gestione lingue per tenant
- Configurazione automatica

## 🔧 Come Usare Laravel Localization

### **Middleware Principali**
```php
// routes/web.php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {
    // Tutte le route localizzate qui
});
```

### **Helper Principali**
```php
// URL localizzati
<a href="{{ LaravelLocalization::localizeUrl('/test') }}">Link localizzato</a>

// URL corrente in lingua specifica
{{ LaravelLocalization::getLocalizedURL('en') }}

// Lingua corrente
{{ LaravelLocalization::getCurrentLocale() }}
{{ LaravelLocalization::getCurrentLocaleName() }}
{{ LaravelLocalization::getCurrentLocaleNative() }}

// Lingue supportate
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

### **Routing Tradotto**
```php
// resources/lang/en/routes.php
return [
    "about" => "about",
    "article" => "article/{article}",
];

// resources/lang/es/routes.php
return [
    "about" => "acerca",
    "article" => "articulo/{article}",
];

// routes/web.php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize' ]
], function() {
    Route::get(LaravelLocalization::transRoute('routes.about'), function() {
        return view('about');
    });
});
```

## 📊 Configurazione Attuale

### **Lingue Supportate**
```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
    'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский', 'regional' => 'ru_RU'],
],
```

### **Middleware Configurati**
```php
'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
```

## 🚨 Problemi Identificati

### **Problema 1: Lingua Default URL**
- ⚠️ `hideDefaultLocaleInURL` è false
- ⚠️ Tutte le URL mostrano prefisso lingua
- ✅ **Soluzione**: Configurabile per ambiente

### **Problema 2: Caching Route**
- ⚠️ Route caching richiede comando speciale
- ⚠️ `php artisan route:trans:cache` invece di `php artisan route:cache`
- ✅ **Soluzione**: Middleware automatico

### **Problema 3: Testing**
- ⚠️ Testing richiede setup speciale
- ⚠️ `refreshApplicationWithLocale()` per test
- ✅ **Soluzione**: Helper per testing

## 📋 Checklist di Implementazione

### **Fase 1: Configurazione Base**
- [x] Installare pacchetto mcamara/laravel-localization
- [x] Pubblicare configurazione
- [x] Configurare lingue supportate
- [x] Registrare middleware

### **Fase 2: Middleware e Routing**
- [x] Registrare middleware di localizzazione
- [x] Implementare routing tradotto
- [x] Configurare caching route
- [x] Implementare helper globali

### **Fase 3: Testing e Deployment**
- [ ] Testare localizzazione
- [ ] Configurare caching per produzione
- [ ] Implementare testing automation
- [ ] Documentare best practices

## 🔍 Come Verificare

### **Test Middleware**
```bash
php artisan tinker
>>> app('router')->getRoutes();
>>> LaravelLocalization::getCurrentLocale();
```

### **Test Routing**
```bash
php artisan route:trans:list en
php artisan route:trans:list es
```

### **Test Caching**
```bash
php artisan route:trans:cache
php artisan route:trans:clear
```

## 📚 Riferimenti Ufficiali

### **Laravel Localization Docs**
- https://github.com/mcamara/laravel-localization
- https://packagist.org/packages/mcamara/laravel-localization

### **Meetup Module Docs**
- `/Modules/Meetup/docs/`
- `/Modules/Meetup/app/Providers/MeetupServiceProvider.php`

### **Tenant Module Docs**
- `/Modules/Tenant/docs/`
- `/Modules/Tenant/app/Providers/TenantServiceProvider.php`

## 🎯 Regole Fondamentali

### **1. Middleware Rule**
> **MAI** usare middleware senza locale prefix per route non localizzate

### **2. URL Helper Rule**
> **SEMPRE** usare helper per generare URL localizzati

### **3. Caching Rule**
> **USARE** `php artisan route:trans:cache` per route caching

### **4. Testing Rule**
> **SEMPRE** usare `refreshApplicationWithLocale()` per testing

## 🔄 Workflow di Sviluppo

### **Creazione Nuova Lingua**
1. Aggiungere lingua in `config/laravellocalization.php`
2. Creare file route in `lang/{locale}/routes.php`
3. Aggiungere middleware a gruppo route
4. Testare localizzazione

### **Debug Localizzazione**
1. Verificare lingua corrente
2. Testare URL localizzati
3. Verificare caching route
4. Testare middleware

## 📞 Supporto

### **File Relativi**
- `/config/laravellocalization.php` - Configurazione base
- `/Modules/Meetup/app/Providers/MeetupServiceProvider.php` - Registrazione
- `/Modules/Tenant/app/Providers/TenantServiceProvider.php` - Multi-tenant
- `/Modules/Meetup/docs/` - Documentazione modulo

### **Comandi Utili**
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
php artisan route:trans:cache
php artisan route:trans:clear
php artisan route:trans:list {locale}
```

---

**Versione**: 1.0  
**Stato**: ✅ Implementazione Laravel Localization Completata