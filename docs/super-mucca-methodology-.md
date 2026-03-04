# Metodologia Super Mucca - Guida Completa 2026

**Data**: 2026-01-09  
**Filosofia**: DRY + KISS + SOLID + Robust + Laravel 12 + Filament 4 + PHP 8.3

---

## 🎯 Principi Fondamentali

### 1. Aumenta al Massimo la Confidenza
- **Studia prima di agire**: Analizza a fondo codice e documentazione
- **Comprendi il "Perché"**: Non solo implementazione, ma logica e filosofia
- **Focus sul contesto**: Business logic, scopo, architettura

### 2. Docs come Bibbia
- **Memoria viva del sistema**: Le cartelle `docs` sono la fonte di verità
- **Studia prima**: Leggi `Modules/{Modulo}/docs/` prima di modificare
- **Aggiorna dopo**: Documenta ogni modifica nelle `docs`

### 3. Workflow Modulo per Modulo
- **Un modulo alla volta**: Completa tutti gli errori prima di passare al successivo
- **Verifica continua**: PHPStan, PHPMD, PHPInsights dopo ogni batch
- **Commit incrementali**: Git commit dopo ogni modulo completato

---

## 📚 Best Practices Studiate (2026)

### Schema.org
- **Structured Data**: Implementare JSON-LD per SEO e semantic web
- **Pattern**: Trait `HasSchemaOrg` per modelli
- **Target**: Event, Organization, Person, BreadcrumbList

### PHPStan Level 10
- **Type Safety**: Zero compromessi, zero baseline
- **Pattern**: Type narrowing con `Webmozart\Assert\Assert`
- **Generics**: `Collection<int, Model>` invece di `Collection<mixed>`

### PHPMD
- **Code Quality**: Violations < 5 per modulo
- **Design Patterns**: Evitare static access, boolean flags
- **Naming**: CamelCase, nomi descrittivi (min 3 caratteri)

### PHPInsights
- **Target Score**: > 90% per tutti i moduli
- **Architecture**: > 80% (attualmente 47.1% - critico)
- **Complexity**: > 90% (attualmente 91.7% - eccellente)

### Pest Testing
- **Coverage**: > 80% per moduli core
- **Business Logic**: 100% coverage
- **Pattern**: Test descrittivi, organizzati per feature

---

## 🔧 Processo di Sviluppo

### Workflow Completo Super Mucca

1. **📚 STUDIO ATTENTO DELLE DOCS**
   - Leggi `Modules/{Modulo}/docs/` + `Themes/{Tema}/docs/`
   - Studia logica, filosofia, business logic, scopo
   - Comprendi il contesto completo

2. **✍️ AGGIORNA DOCS PRIMA DI IMPLEMENTARE**
   - Documenta ciò che stai per fare
   - Aggiorna documentazione esistente se necessario
   - Crea pattern riusabili se identificati

3. **🧠 SCEGLI LA SOLUZIONE PIÙ INTELLIGENTE**
   - Valuta tutte le opzioni possibili
   - Scegli autonomamente la priorità
   - Applica principi DRY + KISS + SOLID

4. **⚙️ IMPLEMENTA**
   - Scrivi il codice o la correzione
   - Segui sempre PHPStan livello 10
   - Applica principi DRY + KISS

5. **✅ VERIFICA E CONTROLLA**
   - PHPStan livello 10: `./vendor/bin/phpstan analyse Modules/{ModuleName} --level=10`
   - PHPMD: `./vendor/bin/phpmd Modules/{ModuleName} text codesize,design`
   - PHP Insights: `./vendor/bin/phpinsights analyse Modules/{ModuleName}`
   - Lint: Verifica formattazione

6. **📝 AGGIORNA DOCS DI NUOVO**
   - Finalizza documentazione con dettagli implementazione
   - Documenta decisioni prese e pattern applicati
   - Aggiorna indici e riferimenti

7. **🔄 GIT COMMIT E PUSH**
   - Commit dopo ogni modulo completato
   - Messaggi descrittivi
   - Non tornare indietro (solo forward)

---

## 🚨 Regole Critiche

### Property Exists - REGOLA ASSOLUTA
```php
// ❌ ERRATO
if (property_exists($model, 'attribute')) {
    $value = $model->attribute;
}

// ✅ CORRETTO
if (isset($model->attribute)) {
    $value = $model->attribute;
}
```

### Mixed Type - Solo Ultima Spiaggia
```php
// ❌ EVITARE
/** @var mixed $value */

// ✅ PREFERIRE
/** @var string|int|null $value */
// O
use Webmozart\Assert\Assert;
Assert::string($value);
```

### Filament Class Extension - REGOLA ASSOLUTA
```php
// ❌ VIETATO
class MyResource extends Resource { }

// ✅ CORRETTO
class MyResource extends XotBaseResource { }
```

### No Controller
- **Backoffice**: Filament
- **Frontoffice**: Folio + Volt
- **NO controller**: Non usiamo controller

### Test in Pest
- **Tutti i test**: Devono essere in Pest
- **Coverage**: > 80% per moduli core

---

## 📋 Convenzioni Naming

### File `.md`
- ✅ **Minuscolo**: `code-quality-guide.md`
- ✅ **Eccezioni**: `README.md`, `CHANGELOG.md`
- ❌ **Vietato**: Date nei nomi, maiuscole, underscore

### Cartelle `docs`
- ✅ **Solo minuscolo**: `docs/`, `docs/best-practices/`
- ❌ **Vietato**: Maiuscole, date, caratteri speciali

### Link
- ✅ **Relativi**: `../other-module/docs/guide.md`
- ❌ **Assoluti**: `/var/www/...`

---

## 🎯 Metriche Target

| Strumento | Target | Status Attuale |
|-----------|--------|----------------|
| PHPStan L10 | 0 errori | ✅ Raggiunto |
| PHPMD Violations | < 5/modulo | ⚠️ 11 (accettabile) |
| PHPInsights Code | > 90% | ⚠️ 75.3% |
| PHPInsights Architecture | > 80% | ❌ 47.1% (critico) |
| PHPInsights Complexity | > 90% | ✅ 91.7% |
| Test Coverage | > 80% | 🔄 In corso |

---

## 📚 Risorse di Riferimento

### Documentazione
- [Schema.org](https://schema.org/) - Structured data
- [PHPStan](https://phpstan.org/) - Static analysis
- [PHPMD](https://phpmd.org/) - Code quality
- [PHPInsights](https://phpinsights.com/) - Quality metrics
- [Pest](https://pestphp.com/) - Testing framework
- [Filament](https://filamentphp.com/docs) - Admin panel
- [Laravel Modules](https://laravelmodules.com/) - Modular architecture
- [Laravel 12](https://laravel.com/docs/12.x) - Framework

### Community
- [Laravel News](https://laravel-news.com/)
- [Laravel Daily](https://laraveldaily.com/)
- [Dev.to Laravel](https://dev.to/t/laravel)
- [Beyond CRUD](https://beyond-crud.stitcher.io/)

---

## ✅ Checklist Pre-Lavoro

- [ ] Ho aumentato al massimo il mio livello di confidenza?
- [ ] Ho studiato le cartelle docs del modulo interessato?
- [ ] Ho capito la logica, la filosofia, lo scopo?
- [ ] Ho verificato che non esista già documentazione sull'argomento?
- [ ] Ho verificato le convenzioni naming (minuscolo, no date)?

---

## ✅ Checklist Post-Lavoro

- [ ] PHPStan livello 10 senza errori?
- [ ] PHPMD senza errori critici?
- [ ] PHP Insights score > 80%?
- [ ] Documentazione aggiornata?
- [ ] Git commit e push eseguiti?
- [ ] Link relativi verificati (no path assoluti)?

---

**Status**: ✅ **DOCUMENTAZIONE COMPLETA**

**
