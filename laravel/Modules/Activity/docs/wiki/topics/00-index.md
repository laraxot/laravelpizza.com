---
title: "Topic 00-index"
type: digest
status: active
qmd: "digest ceiling 100 00-index"
---

# Topic 00-index

Sintesi automatica di 3 documenti (chiave `00-index`).

## Indice BMAD — Activity

_Fonte: `bmad/00-index.md`_

# Indice BMAD — Activity

Entry point del pack. Indice storico/legacy: [index.md](./index.md).

| Documento | Ruolo |
|---|---|
| [purpose.md](./purpose.md) | perché esiste il modulo |
| [architecture.md](./architecture.md) | mappa reale del codice |
| [decision-log.md](./decision-log.md) | decisioni (D-0…D-4) |
| [epics.md](./epics.md) | epic E1–E5 dai finding |
| [brainstorming.md](./brainstorming.md) | opzioni aperte |
| [audit.md](./audit.md) | sintesi + gate |
| [audits/activity-audit.md](./audits/activity-audit.md) | **audit profondo** (SSoT dei finding) |
| [piano-miglioramento.md](./piano-miglioramento.md) | piano P1/P2 |
| [stories/module-bmad-audit.story.md](./stories/module-bmad-audit.story.md) | story dell'audit |
| [ECC](../ecc/00-index.md) | checklist e stato controlli |
| [purpose.md (root docs)](../purpose.md) | scopo del modulo nella documentazione generale |
| [purpose.md (root docs)](../purpose.md) | scopo del modulo nella documentazione generale |
| [purpose.md (root docs)](../purpose.md) | scopo del modulo nella documentazione generale |

## 📚 **Indice Documentazione Modulo Activity**

_Fonte: `wiki/00-index.md`_

# 📚 **Indice Documentazione Modulo Activity**
---
title: Activity Module - Documentation Index
type: index
tags: [activity, audit-log, event-sourcing, phpstan]
created: 2025-12-13
updated: 2026-07-23
---

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa e Quick Start.
1. [README.md](./readme.md) - Panoramica completa e Quick Start.
1. [README.md](./README.md) - Panoramica completa e Quick Start.
2. [roadmap.md](./roadmap.md) - Visione evolutiva e task aperti.
3. [philosophy-3.md](../../../Lang/docs/philosophy-3.md) - I principi dell'Audit Trail e dell'Event Sourcing.

## 🏗️ **Architettura e Pattern**
- 🧩 **[Core Structure](./structure.md)** - Organizzazione interna del modulo.
- 🎯 **[Event Sourcing](./event-sourcing.md)** - Dettagli sull'implementazione degli eventi di dominio.
- 🔧 **[Actions Calling Actions](./actions-calling-actions-pattern.md)** - Pattern per la composizione delle azioni di logging.

## 📊 **Filament & UI**
- 📈 **[Filament Resources](../filament-resources-3.md)** - Gestione Log e Analytics nell'Admin Panel.
- 📉 **[Analytics Widgets](./dual-label-chart-widget-implementation.md)** - Implementazione dei grafici e delle statistiche.
- 🧭 **[Nested Resources](./filament-5-nested-resources-complete-guide.md)** - Guida alle risorse nidificate in Filament v5.

## Topic 00-index

_Fonte: `wiki/topics/00-index.md`_

# Topic 00-index

Sintesi automatica di 4 documenti (chiave `00-index`).

## 📦 Pacchetti Composer

_Fonte: `00-index.md`_

> Nota 2026-10-14 (docs-audit): Copia con contenuto raddoppiato di 00-index.md (varianti di sola maiuscola) con link a file inesistenti; l'indice canonico e' 00-index.md. Contenuto non riscritto, verificare prima di usarlo.

app(LogActivityAction::class)->execute(
    type: 'user.login',
    user: $user,
    subject: $record,
    properties: ['ip' => request()->ip()],
    description: 'User logged in successfully'
);
```

## 📦 Pacchetti Composer
- [Riferimento composer packages](../../../../bashscripts/ai/wiki/memories/migrations-composer-modules.md#composer-packages-reference)
## 📦 Pacchetti Composer
- [Riferimento composer packages](../../../../bashscripts/ai/wiki/memories/migrations-composer-modules.md#composer-packages-reference)
- `spatie/laravel-activitylog` - Audit trail
- `spatie/laravel-event-sourcing` - Event sourcing, CQRS

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Core framework.
- [Tenant](../../Tenant/docs/README.md) - Isolamento dati per tenant.
