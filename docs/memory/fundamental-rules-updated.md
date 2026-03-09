# 🔧 MEMORIES AGGIORNATE

**Date**: 2026-02-16  
**Type**: MEMORY UPDATE

---

## 🎯 Memoria Fondamentale

### 🚨 REGOLA #1: RELAZIONI LARAVEL

**MAI VIOLARE**: nei modelli applicativi `belongsToManyX()` e' la convenzione corretta.

**PERCHÉ?**
- `belongsToManyX()` riflette la convenzione RelationX del progetto
- evita di reintrodurre configurazione Laravel standard dove il progetto usa un layer architetturale proprio
- mantiene coerenza tra moduli, pivot e basi multi-tenant / multi-db

**CONSEGUENZE CRITICHE se la ignoro**:
- ❌ regole di progetto violate
- ❌ documentazione e codice in conflitto
- ❌ refactor incoerenti tra moduli
- ❌ regressioni relazionali difficili da uniformare

---

## 🚨 REGOLA #2: SVG ICONS IN BLADE

**MAI FARE**: SVG hardcoded nei file Blade!

**PERCHÉ?**
- ❌ Manutenibilità impossibile
- ❌ Cache browser non funzionante
- ❌ Performance penalizzata
- ❌ Theming limitato

**CORRETTO**:
```php
<!-- ✅ SEMPRE così! -->
<x-filament::icon icon="meetup-logo" />
```

---

## 🚨 REGOLA #3: CONFIGURAZIONE DYNAMIC THEMES

**SEMPRE**: Tema determinato da `config/local/{tenant}/config.php`

**MAI FARE**: Hardcoding logica di tema nel codice

**PERCHÉ?**
- Multi-tenancy broken
- Performance issues
- Manutenibilità impossibile

---

## 🚨 REGOLA #4: CODE QUALITY

**PHPStan Level 10**: OBBLIGATORIO, non negoziabile!

**SEMPRE**:
- `declare(strict_types=1);` su ogni file
- Type hints ovunque
- Error-free commits

---

## 🚨 REGOLA #5: NAMING CONVENTIONS

**MAIUSCOLE**: lowercase_con_trattini.md
**CORRETTO**: lowercase-with-hyphens.md

**ESEMPI**:
```
✅ docs/schema-org-implementation-summary.md
❌ docs/SCHEMA_ORG_Summary.md
✅ docs/filo-pages-json-only-rule.md
❌ docs/FOLIO-PAGES-JSON-ONLY-RULE.md
```

---

## 🚨 REGOLA #6: FRONTEND ARCHITETTURE

**MAI FARE**: Controller e rotte tradizionali per pagine pubbliche

**SEMPRE**: CMS-driven + Folio + Volt

---

## 🚨 REGOLA #7: BACKEND ARCHITETTURE

**MAI FARE**: Business logic nei controller

**SEMPRE**: Action pattern con Spatie\QueueableAction

---

## 🚨 REGOLA #8: SERVICE PROVIDER

**MAI FARE**: Provider complessi con metodi non necessari

**SEMPRE**: Structure minimale con XotBaseServiceProvider

---

## 🚨 REGOLA #9: TESTING

**MAI FARE**: Commit senza test completi

**SEMPRE**: PHPStan + Pint + Feature test prima di ogni commit

---

## 🚨 REGOLA #10: PHPSTAN PATTERNS COMUNI

**FACTORY NON ESISTONO**:
- MAI usare trait `HasXotFactory` se la factory non esiste
- Rimuovere riferimenti `@method static Factory` dai docblock
- Rimuovere import della factory

**TYPE CASTING ARRAY**:
- Per dati JSON, usare `@var array<array<string, mixed>>`
- Usare `array_merge([], $data)` per forzare il tipo

**FILTER DATEPICKER**:
- MAI usare `when()` con date, usare `if (!empty())` invece

**TYPO FILAMENT**:
- `Tablecolumn` → SEMPRE `TextColumn`

**NULLSAFE CON ??**:
- `$user?->name ?? 'User'` → `$user ? $user->name : 'User'`

---

## 🎯 Checklist per Sviluppatore

Prima di scrivere codice:

- [ ] Sto usando `belongsToManyX()` per le many-to-many applicative?
- [ ] Ci sono SVG hardcoded nelle Blade?
- [ ] La logica di tema è hardcoded o configurabile?
- [ ] Ho PHPStan level 10 attivo?
- [ ] Sto seguendo le regole di naming?
- [ ] Sto usando Actions pattern per business logic?

Se **NO** a qualsiasi domanda → **FERMA E CORREGGI**!

Dopo aver corretto:

- [ ] Aggiornare documentazione in `/docs/`
- [ ] Testare con PHPStan e Pint
- [ ] Fare commit solo se tutti i test passano
- [ ] Creare pull request per code review

---

## 🎉 CONCLUSIONE

Queste regole sono **fondamentali** per garantire:
1. **Stabilità** del sistema
2. **Performance** ottimizzata
3. **Manutenibilità** del codice
4. **Scalabilità** a lungo termine
5. **Qualità** professionale del codice

**Violare queste regole = rischiare la stabilità dell'intero sistema!** 🚨
