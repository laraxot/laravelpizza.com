---
id: module-notify-readme
title: "Notify — Consegna delle Comunicazioni Applicative"
type: module-readme
category: module-documentation
module: Notify
status: active
tags: [notify, notifications, channels, templates]
created: 2026-09-14
updated: 2026-09-14
qmd: "notify notifications mail push sms templates queue module documentation"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/68"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/69"
related:
  - "./docs/"
sources: []
---

# 📬 Notify

> **Consegna delle comunicazioni applicative.**

Trasporti e template; la decisione di notificare resta nel dominio.

## Cosa offre

- **template**
- **canali**
- **queue/retry**
- **eventi e stati**

## Confini architetturali

Questo modulo possiede le responsabilità elencate sopra e pubblica contratti riusabili agli altri moduli. La logica applicativa vive in Actions del modulo; l’interfaccia amministrativa segue le basi Laraxot/XotBase. Le dipendenze verso altri moduli devono restare esplicite e orientate verso contratti stabili.

## Integrazione rapida

Il modulo è caricato dall’architettura modulare Laraxot. Per verificarne lo stato:

````bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Notify
````

Per i test e le convenzioni operative, consultare la documentazione locale prima di introdurre nuove integrazioni.

## Documentazione

La mappa tecnica è in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Le modifiche devono mantenere `declare(strict_types=1);` nel codice PHP, rispettare PHPStan configurato dal progetto e aggiornare la documentazione tecnica quando cambiano contratti, dipendenze o flussi. Le story BMAD restano accanto al codice del modulo per conservare ownership e contesto.

---

**Modulo** `notify` · **Laraxot ecosystem** · **Project-agnostic**
