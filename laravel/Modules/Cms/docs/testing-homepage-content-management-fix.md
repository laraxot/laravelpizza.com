---
title: "testing homepage content management fix"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "testing homepage content management fix"
issues: []
discussions: []
---

# Fix: HomepageContentManagementTest - Redirect Behavior

**Problema**: Test fallisce con "Expected status code [200] but received 302"
**Principio**: Il sito funziona, quindi il test deve essere corretto per riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
```
Expected response status code [200] but received 302.
Failed asserting that 302 is identical to 200.
```

### Causa
- La rotta `/` in `Modules/Cms/routes/web.php` fa un redirect a `/{locale}` (riga 17)
- Il test si aspetta status 200 su `/`, ma riceve 302 (redirect)
- Il sito funziona correttamente con questo comportamento

### Comportamento Reale
```php
// Modules/Cms/routes/web.php
Route::get(
    '/',
    fn () => redirect('/'.app()->getLocale()),
);
```

### Test Corretto Esistente
Esiste già `HomepageRoutingTest.php` che verifica correttamente:
- Redirect da `/` a `/{locale}`
- Status 200 su `/{locale}`

## 🛠️ Soluzione

### Pattern Corretto
1. Usare `/{locale}` invece di `/` per testare il contenuto
2. Oppure seguire il redirect e verificare il contenuto sulla pagina localizzata
3. Verificare che il redirect funzioni correttamente

### Implementazione
```php
// ✅ CORRETTO - Usa rotta localizzata
$response = get('/it');  // o '/en', '/de', etc.
$response->assertStatus(200);

// ✅ CORRETTO - Segui redirect
$response = get('/');
$response->assertRedirect('/it');
$response = get('/it');
$response->assertStatus(200);
```

## 📝 Note

- Il sito funziona, quindi il test deve riflettere il comportamento reale
- La homepage è accessibile su `/{locale}`, non su `/`
- Il redirect è intenzionale per gestire la localizzazione

## 🔗 Collegamenti

- [Testing Rules](testing-rules.md)
- [HomepageRoutingTest](../tests/Feature/Frontoffice/HomepageRoutingTest.php) - Test corretto esistente
- [Homepage Structure](homepage-structure.md) - Documentazione homepage

---

title: "testing homepage content management fix"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "testing homepage content management fix"
issues: []
discussions: []
**Status**: In Progress
**Prossimo step**: Correggere tutti i test per usare `/{locale}` invece di `/`
