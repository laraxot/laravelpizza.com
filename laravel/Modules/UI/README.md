---
id: module-ui-readme
title: "UI - componenti visuali condivisi"
type: module-readme
category: module-documentation
module: UI
status: active
tags: [ui, components, filament, module, blade, livewire, accessibility]
created: 2026-09-14
updated: 2026-10-07
qmd: "ui blade livewire filament components accessibility module documentation"
issues:
  - "https://github.com/laraxot/module_ui_fila5/issues/33"
discussions:
  - "https://github.com/laraxot/module_ui_fila5/discussions/34"
related:
  - "./docs/"
sources: []
---

# UI

[![Domain-UI](https://img.shields.io/badge/Domain-UI%20Kit-7B1FA2.svg)](#)
[![Laravel 13](https://img.shields.io/badge/Laravel-13-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-777BB4.svg)](https://php.net/)
[![Stars](https://img.shields.io/github/stars/laraxot/module_ui_fila5?style=plastic&color=yellow)]()
[![Forks](https://img.shields.io/github/forks/laraxot/module_ui_fila5?style=plastic&color=green)]()
[![Issues](https://img.shields.io/github/issues/laraxot/module_ui_fila5?style=plastic&color=red)]()
[![License](https://img.shields.io/github/license/laraxot/module_ui_fila5?style=plastic&color=blue)]()
[![Last Commit](https://img.shields.io/github/last-commit/laraxot/module_ui_fila5?style=plastic&color=purple)]()
[![Release](https://img.shields.io/github/v/release/laraxot/module_ui_fila5?style=plastic&color=orange&display_name=release)]()
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://php.net/)
[![Filament](https://img.shields.io/badge/Filament-5-ffab00?style=for-the-badge)](https://filamentphp.com/)
[![Laravel](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge)](https://laravel.com/)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-purple?style=plastic)]()
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)

> **Componenti UI riutilizzabili e design system**
> Componenti UI, layout, temi e pattern di design per Filament v5, senza logica di dominio.

## Perché esiste
## 🎯 La Visione

Crediamo che il software debba essere **chiaro, modulare e potente**. Ogni modulo è stato pensato per risolvere problemi reali con soluzioni eleganti.

## Perché esiste questo modulo?

**Componenti UI, layout, temi e pattern di design per Filament v5.**

In un mondo dove la complessità è l'avere, abbiamo scritto codice semplice. Questo modulo non è solo una libreria: è una **promessa di qualità** mantenuta.

## Cosa offre

- **Blade/Livewire** — componenti riusabili
- **Filament XotBase** — base per admin
- **Accessibilità** — a11y conforme
- **Tailwind/DaisyUI** — design system

## Confini architetturali

Questo modulo pubblica contratti usabili da altri moduli. La logica vive nelle `Actions`; la UI admin segue Laraxot/XotBase. Nessuna logica di dominio: quella resta nei moduli che la possiedono (vedi [docs/purpose.md](./docs/purpose.md)).

## 🧘 I Principi Zen (e la nostra filosofia)

## 🎯 La Visione
## La visione
## La visione

Crediamo che il software debba essere **chiaro, modulare e potente**. Ogni modulo è stato pensato per risolvere problemi reali con soluzioni eleganti.

## Perché esiste questo modulo

**Componenti UI, layout, temi e pattern di design per Filament v5.**

In un mondo dove la complessità è l'avere, abbiamo scritto codice semplice. Questo modulo non è solo una libreria: è una **promessa di qualità** mantenuta.

## Cosa offre

- **Blade/Livewire**: componenti riusabili
- **Filament XotBase**: base per admin
- **Accessibilità**: a11y conforme
- **Tailwind/DaisyUI**: design system

## Confini architetturali

Questo modulo pubblica contratti usabili da altri moduli. La logica vive nelle `Actions`; la UI admin segue Laraxot/XotBase. Nessuna logica di dominio: quella resta nei moduli che la possiedono (vedi [docs/purpose.md](./docs/purpose.md)).

## I principi zen e la nostra filosofia

1. **Semplicità vince sulla complessità** - Il codice chiaro è più potente di mille righe di commenti.
2. **Modulare è dare vita** - Ogni pezzo può vivere da solo, ma insieme diventa un universo.
3. **Documentare è onniscienza** - La mancanza di documentazione è la paura del futuro.
4. **Testare è fidarsi** - Non fidarsi del proprio codice è fidarsi del caos.
5. **Rifattorizzare è crescere** - Lentamente, incrementalmente, diventiamo migliori.

## Superpoteri

- **Architettura modulare** - Separazione netta tra logica di business e presentazione
- **PHPStan Level 10** - Massima sicurezza tipizzazione
- **PSR-12** - Codice che parla lo stesso linguaggio del mondo
- **Filament 5** - Admin panel d'eccellenza
- **XotBase** - Pattern consolidati che funzionano

## Quick start

```bash
# Installazione modulo
php artisan module:enable UI
php artisan module:list
php artisan migrate

# Sviluppo locale
cd laravel
composer dev
./vendor/bin/pest Modules/UI/tests
./vendor/bin/phpstan analyse Modules/UI --memory-limit=-1
```

Configuration is in `config/config.php`. Adjust as needed.

## Contributing

Esegui i comandi di sviluppo locale del Quick start, poi:

**Before submitting:**
- [ ] Tests pass
- [ ] PHPStan L10 passes
- [ ] Code style (Pint) applied
- [ ] Documentation updated

See [docs/architecture.md](./docs/architecture.md) for design decisions.

## Documentazione

| Tipo | Link |
|--------|------|
| 🇮🇹 Presentazione | Questo file (`README.md`) |
| 🇬🇧 Business card | [docs/readme-en.md](./docs/readme-en.md) |
| 📚 Wiki tecnica | [./docs/](./docs/) |
| 🗺️ Mappa tecnica docs | [docs/README.md](./docs/README.md) |
| 🎯 Esempi | [docs/examples/](./docs/examples/) |
| 📋 Story BMAD | [docs/stories/](./docs/stories/) |
| 🏗️ Architettura | [docs/architecture.md](./docs/architecture.md) |
| 🧪 Testing | [docs/testing.md](./docs/testing.md) |
| 📜 Changelog | [CHANGELOG.md](./CHANGELOG.md) |
| 📐 Regole del progetto | [../../../docs/wiki/](../../../docs/wiki/) |
| 🏠 README del progetto | [../../../README.md](../../../README.md) |

## 🔧 Tecnologie chiave
| Presentazione (IT) | Questo file (`README.md`) |
| Business card (EN) | [docs/readme-en.md](./docs/readme-en.md) |
| Wiki tecnica | [./docs/](./docs/) |
| Mappa tecnica docs | [docs/README.md](./docs/README.md) |
| Esempi | [docs/examples/](./docs/examples/) |
| Story BMAD | [docs/stories/](./docs/stories/) |
| Architettura | [docs/architecture.md](./docs/architecture.md) |
| Testing | [docs/testing.md](./docs/testing.md) |
| Changelog | [CHANGELOG.md](./CHANGELOG.md) |
| Regole del progetto | [../../../docs/wiki/](../../../docs/wiki/) |
| README del progetto | [../../../README.md](../../../README.md) |

## Tecnologie chiave

**Stack principale:** Laravel 13, Filament 5, XotBase

**Keywords:** UI, Components, Design System

## Qualità e manutenzione

Mantenere `declare(strict_types=1);` in PHP, aderire alla configurazione PHPStan del progetto e aggiornare i docs quando i contratti evolvono.

---

**Modulo** `UI` · **Laraxot ecosystem** · **Project-agnostic** · PHPStan 10 · Filament 5

## Scheda tecnica verificata (2026-10-07)

| Voce | Valore |
|---|---|
| Nome dichiarato | `UI` |
| Namespace | `Modules\UI\` |
| File PHP (escluso vendor) | 747 |
| File PHP di test | 81 |
| Aree `app/` rilevate | Actions, Adapters, Console, Contracts, Data, Datas, Enums, Filament, Forms, Http, Livewire, Models, Providers, Rules, Services, Traits, View |
| Migrazioni PHP | 3 |
| SSoT locale | [`docs/`](docs/) e [`docs/bmad/`](docs/bmad/) |

Questa scheda è un inventario statico, non una dichiarazione di qualità. Per ogni
modifica eseguire i gate dal progetto Laravel:

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI
./vendor/bin/pest Modules/UI
```

La responsabilità del modulo, le decisioni architetturali e le opportunità sono
documentate negli artefatti BMAD sotto [`docs/bmad/`](docs/bmad/). I numeri vanno
rigenerati quando il modulo cambia; non copiarli in badge non verificati.
**Modulo** `UI` · **Laraxot ecosystem** · **Project-agnostic** · PHPStan 10 · Filament 5
**Modulo** `UI` · **Laraxot ecosystem** · **Project-agnostic** · PHPStan 10 · Filament 5

## Scheda tecnica verificata (2026-10-07)

| Voce | Valore |
|---|---|
| Nome dichiarato | `UI` |
| Namespace | `Modules\UI\` |
| File PHP (escluso vendor) | 747 |
| File PHP di test | 81 |
| Aree `app/` rilevate | Actions, Adapters, Console, Contracts, Data, Datas, Enums, Filament, Forms, Http, Livewire, Models, Providers, Rules, Services, Traits, View |
| Migrazioni PHP | 3 |
| SSoT locale | [`docs/`](docs/) e [`docs/bmad/`](docs/bmad/) |

Questa scheda è un inventario statico, non una dichiarazione di qualità. Per ogni
modifica eseguire i gate dal progetto Laravel:

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI
./vendor/bin/pest Modules/UI
```

La responsabilità del modulo, le decisioni architetturali e le opportunità sono
documentate negli artefatti BMAD sotto [`docs/bmad/`](docs/bmad/). I numeri vanno
rigenerati quando il modulo cambia; non copiarli in badge non verificati.
