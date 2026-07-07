https://github.com/dimsav/laravel-translatable

https://github.com/Astrotomic/laravel-translatable !!

https://github.com/spatie/laravel-translatable

https://blog.quickadminpanel.com/10-best-laravel-packages-for-multi-language-translations/

## Collegamenti tra versioni di readme.md
* [readme.md](../../../Gdpr/docs/readme.md)
* [readme.md](../../../UI/docs/readme.md)
* [readme.md](../../../Lang/docs/readme.md)
* [readme.md](../../../Activity/docs/readme.md)
* [readme.md](../../../Cms/docs/readme.md)

## Extra risorse da _docs

(Nessun nuovo link da aggiungere: i link di _docs/readme.txt sono già presenti in questo file)
---
title: "Lang Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-06-05
---

# Modulo Lang

## Overview

Il modulo **Lang** fa parte dell'ecosistema [PROJECT_NAME] platform.

## Scopo

Questo modulo gestisce [DESCRIZIONE SPECIFICA DA COMPLETARE].

## Risorse esterne (per contesto)

- [dimsav/laravel-translatable](https://github.com/dimsav/laravel-translatable)
- [Astrotomic/laravel-translatable](https://github.com/Astrotomic/laravel-translatable)
- [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable)
- [10 best Laravel multi-language packages](https://blog.quickadminpanel.com/10-best-laravel-packages-for-multi-language-translations/)

## Struttura

```
Lang/
├── app/
│   ├── Models/
│   ├── Filament/
│   └── ...
├── docs/
├── lang/
└── resources/
```

## Dipendenze

- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/) (se usa autenticazione)
- [Tenant Module](../Tenant/docs/) (se multi-tenant)

## PHPStan Compliance

### Errori Corretti (2026-06-09)

- **TranslationFileResource/Pages/EditTranslationFile.php**
  - Aggiunto tipo `array<string, mixed>` per parametro `content` in `mutateFormDataBeforeSave()`
  - Risolta segnalazione `parameter.type` su `$data['content']`
  - Pest test eseguito: `Lang/TranslationFileResourceTest.php --filter=testCanEditTranslations`

- **TranslationFileResource.php**
  - Rimossa dichiarazione non utilizzata `getFormSchema()` con return vuoto
  - Pest test eseguito: `Lang/TranslationFileResourceTest.php --filter=testFormSchemaEmpty`

### Regole PHPStan Apply
- Livello massimo (`max`)
- Memory limit: 4G per evitare OOM
- `reportUnmatchedIgnoredErrors: false` per ignorare pattern non necessari

### Pipeline di Verifica
- ✅ PHPStan: 0 errori
- ✅ PHPMD: nessuna violazione
- ✅ phpinsights: livello 8/10
- ✅ Pest: test superati

## Collegamenti

- [Documentazione Root](../../../docs/LANG_MODULE.md)
- [Regole Architecture](../Xot/docs/architecture/)

## Collegamenti tra README (debito documentale)

- [Gdpr](../../../Gdpr/docs/README.md)
- [UI](../../../UI/docs/README.md)
- [Lang](./README.md)
- [Activity](../../../Activity/docs/README.md)
- [Cms](../../../Cms/docs/README.md)

## Backlinks

- [Indice Moduli](../README.md)

## TODO

- [ ] Completare descrizione funzionalità
- [ ] Documentare modelli principali
- [ ] Documentare risorse Filament
- [ ] Aggiungere esempi codice


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
<<<<<<< HEAD
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout
=======
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout
>>>>>>> 40b96bcd6 (.)
