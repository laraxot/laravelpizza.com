---
title: "Architecture: custom Livewire UI a Filament Widgets"
type: architecture
module: Xot
status: approved-ready-for-dev
created: 2026-10-20
updated: 2026-10-20
related:
  - ./livewire-to-filament-widgets-objective.md
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./livewire-to-filament-widgets-filament-blueprint.md
  - ./livewire-to-filament-widgets-inventory.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
tags: [docs, xot, bmad]
qmd: "architettura e adr xot"
---

# Architettura e ADR

## ADR-001: Classificare per responsabilità

**Decisione:** admin/dashboard interattivo → Widget; CRUD → Resource/Page/Action;
front-office pubblico → Folio/Volt/Blade oppure Widget solo se il contratto è
quello di una superficie Filament; View Component, test harness e vendor non
sono candidati automatici.

**Perché:** il nome Livewire descrive il trasporto reattivo, non lo scopo del
componente. Un rename meccanico altera routing, UX e autorizzazioni.

## ADR-002: Usare esclusivamente le basi Xot

**Decisione:** i moduli applicativi estendono la variante più specifica tra
`XotBaseWidget`, `XotBaseSchemaWidget`, `XotBaseTableWidget`,
`XotBaseChartWidget`, `XotBaseStatsOverviewWidget`,
`XotBaseInfolistWidget` e `XotBaseWizardWidget`.

**Conseguenza:** nessun `Filament\Widgets\*` diretto nei moduli applicativi;
discovery e convenzioni restano centralizzate in Xot.

## ADR-003: Separare UI e caso d'uso

**Decisione:** il Widget raccoglie stato, invoca l'Action, delega schema e
renderizza; query, mutazioni, transazioni, integrazioni e side effect vivono in
Spatie Queueable Actions o Actions di dominio già esistenti.

## ADR-004: Discovery e mount espliciti

**Decisione:** usare discovery del panel per i widget del panel e FQCN esplicito
nei partial che devono montare un widget. Gli alias stringa legacy sono ritirati
solo dopo la matrice caller.

## ADR-005: Sicurezza e stato invariati

**Decisione:** ogni conversione conserva policy, `canView`, tenant context,
guard, redirect, query string, polling e limiti di input; una differenza è una
regressione da testare, non un dettaglio del refactor.

## Matrice FR/NFR

| ID | Requisito | Design | Gate |
|---|---|---|---|
| FR-1 | Inventariare ogni custom Livewire | matrice caller/scopo | scan + review |
| FR-2 | Migrare dashboard/panel | `XotBase*Widget` | test widget + smoke |
| FR-3 | Preservare dominio | Queueable Actions | unit/feature |
| FR-4 | Rimuovere dead code | grep caller + ritiro | scan zero residui |
| NFR-1 | Tipi | PHPStan max | analyse mirata/completa |
| NFR-2 | UX/accessibilità | layout Filament, label/traduzioni, stati vuoti | smoke/UI |
| NFR-3 | Sicurezza | policy/tenant/canView invariati | test autorizzazione |
| NFR-4 | Concorrenza | ownership file e lock | report swarm |
| NFR-5 | Manutenibilità | docs per modulo/tema incrementali | indice/docs link |

## Wave e dipendenze

1. W0: baseline, inventario e matrice (read-only).
2. W1: candidati panel/dashboard ad alta confidenza.
3. W2: auth, profilo, lingua e tenant; richiede test redirect/policy.
4. W3: componenti FO con mount reale, convertiti solo se il blueprint lo
   giustifica.
5. W4: ritiri, pulizia registrazioni/test/docs e scan globale.

Ogni wave ha scope disgiunti. Gli agenti possono scegliere in ordine casuale
quale lane indipendente avviare, ma non possono randomizzare le dipendenze o i
gate globali.
