---
title: "phpstan fixes roadmap"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan fixes roadmap"
issues: []
discussions: []
---

# PHPStan Level 10 Fixes Roadmap - Modulo Cms

**Data Creazione**: [DATE]  
**Errori Totali**: 6 errori  
**Status**: 🟡 In Progress

## Panoramica

Il modulo Cms ha **6 errori PHPStan** che devono essere risolti per raggiungere la conformità Level 10. Tutti gli errori sono concentrati in `FolioVoltServiceProvider.php`.

## Errori Dettagliati

### File: `app/Providers/FolioVoltServiceProvider.php`

#### 1. Linea 73 - Parameter Type Issue
**Errore**: `Parameter #1 $array of function array_keys expects array, mixed given`

**Causa**: `config('laravellocalization.supportedLocales', ['it' => []])` può restituire `mixed`

**Soluzione**:
```php
/** @var array<string, array<string, mixed>> $supportedLocalesConfig */
$supportedLocalesConfig = config('laravellocalization.supportedLocales', ['it' => []]);
Assert::isArray($supportedLocalesConfig);
$supportedLocales = array_keys($supportedLocalesConfig);
```

#### 2. Linea 87, 110 - URI Parameter Type Issue
**Errore**: `Parameter #1 $uri of method Laravel\Folio\PendingRoute::uri() expects string, int|string given`

**Causa**: `$locale` dal foreach può essere `int|string` invece di solo `string`

**Soluzione**:
```php
foreach ($supportedLocales as $locale) {
    Assert::string($locale);
    Folio::path($theme_path)
        ->uri($locale)
        // ...
}
```

#### 3. Linea 91, 114 - setLocale Parameter Type Issue
**Errore**: `Parameter #1 $locale of method Illuminate\Foundation\Application::setLocale() expects string, int|string given`

**Causa**: Stesso problema del punto 2, `$locale` non è garantito essere `string`

**Soluzione**: Usare `Assert::string($locale)` prima di chiamare `setLocale()`

#### 4. Linea 93, 116 - Callable Type Issue
**Errore**: `Trying to invoke mixed but it's not a callable`

**Causa**: `$next` nel middleware closure è tipizzato come `mixed`

**Soluzione**:
```php
function ($request, $next) use ($locale): mixed {
    Assert::string($locale);
    app()->setLocale($locale);
    
    /** @var callable $next */
    return $next($request);
}
```

## Piano di Implementazione

### Fase 1: Type Assertions (Priorità Alta)
- [ ] Aggiungere `Assert::isArray()` per `config('laravellocalization.supportedLocales')`
- [ ] Aggiungere `Assert::string($locale)` in tutti i foreach
- [ ] Aggiungere PHPDoc `@var callable $next` nelle closure middleware

### Fase 2: Verifica
- [ ] Eseguire PHPStan Level 10
- [ ] Verificare che tutti gli errori siano risolti
- [ ] Testare funzionalità Folio dopo le modifiche

### Fase 3: Documentazione
- [ ] Aggiornare questa roadmap con status ✅
- [ ] Documentare pattern utilizzati per future reference

## Note Tecniche

- Utilizzare `Webmozart\Assert\Assert` per type assertions
- Mantenere compatibilità con Laravel Folio
- Verificare che le modifiche non rompano il routing multi-lingua

## Riferimenti

- [PHPStan Type Assertions](https://phpstan.org/writing-php-code/phpdoc-types#type-assertions)
- [Laravel Folio Documentation](https://laravel.com/docs/folio)
