---
id: module-xot-readme
title: "Xot — Fondazione Architetturale di Laraxot"
type: module-readme
category: module-documentation
module: Xot
status: active
tags: [xot, foundation, laraxot, filament, architecture]
created: 2026-09-14
updated: 2026-09-28
qmd: "xot laraxot foundation base classes xotbase filament architecture module documentation"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/120"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/121"
related:
  - "./docs/"
sources: []
---

# 🏗️ Xot

> **Fondazione architetturale di Laraxot.**

Classi base, contratti e convenzioni condivise; nessuna logica di dominio.

## Cosa offre

- **BaseModel** – modello base per tutti i moduli
- **XotBase Filament** – base per pannelli admin
- **Migrazioni/provider** – schemi e provider
- **Convenzioni comuni** – standard di codifica

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Xot
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Maintain `declare(strict_types=1);` in PHP, adhere to project PHPStan config, and update docs when contracts evolve.

---

**Modulo** `xot` · **Laraxot ecosystem** · **Project-agnostic**
---

## Scheda tecnica verificata (2026-09-28)

| Voce | Valore |
|---|---|
| Nome dichiarato | `Xot` |
| Namespace | `Modules\\Xot\\` |
| File PHP (escluso vendor) | 1773 |
| File PHP di test | 286 |
| Aree `app/` rilevate | Actions, Adapters, Casts, Console, Contracts, DTOs, Database, Datas, Enums, Events, Exceptions, Exports, Facades, Filament, Helpers, Http, Interfaces, Mail, Mixins, Models, PHPStan, Phpstan, Providers, QueryBuilders, Relations, Resources, Routes, Rules, Services, States, Support, Traits, ValueObjects, View |
| Migrazioni PHP | 40 |
| SSoT locale | [`docs/`](docs/) e [`docs/bmad/`](docs/bmad/) |

Questa scheda è un inventario statico, non una dichiarazione di qualità. Per ogni
modifica eseguire i gate dal progetto Laravel:

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Xot
./vendor/bin/pest Modules/Xot
```

La responsabilità del modulo, le decisioni architetturali e le opportunità sono
documentate negli artefatti BMAD sotto [`docs/bmad/`](docs/bmad/). I numeri vanno
rigenerati quando il modulo cambia; non copiarli in badge non verificati.
