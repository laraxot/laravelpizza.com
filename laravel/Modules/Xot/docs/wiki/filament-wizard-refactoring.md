---
title: "Wizard widget Laraxot — Filament HasWizard + trait modulari Xot"
type: concept
tags: [filament, wizard, xot, haswizard-widget]
created: "2026-05-04"
updated: "2026-05-22"
canonical: true
historical_aliases:
  - ./XotBaseWizardWidget-HasWizard-refactor.md
---

# Wizard frontoffice (`XotBaseWizardWidget`): pattern attuale

## In una frase

`Modules\Xot\Filament\Widgets\XotBaseWizardWidget` usa **`Filament\Resources\Pages\Concerns\HasWizard`** per costruire lo stesso `Wizard`/`Step` delle pagine panel, poi lo **adapta**: `final getWizardComponent()` (view tema, persist query `step`, `columnSpanFull`), cancel SPA-aware, **`getSteps()`** con chiavi anche stringa per `?step=privacy`.

Helper Laraxot (non Filament-panel):

| Componente | Ruolo |
|------------|--------|
| `XotBaseWizardWidget` | `HasWizard` + `getWizardComponent()` (view tema, persist query `step`, `columnSpanFull`) — **nessun** helper di riscrittura stato dopo `$this->form->getState()` |
| `DelegatesFilamentWizardSchemaMethods` | `nextStep()`, `previousStep()`, `goToStep()` quando la Blade chiama Livewire |

## Nomenclatura (obbligatoria)

Solo **`getSteps()`** — stesso nome **`HasWizard`** e **`XotBaseResourceForm`**. **Vietato introdurre sinonimi** negli snippet, regole agente o form statici.

## Anti-pattern da non reintrodurre

**Trait monolite tipo “wizard tutto-in-uno”** che ricostruisce `Wizard::make()`, form schema, navigazione e policy in un unico file: duplica **`HasWizard`**, aumenta drift e impedisce migliorie vendor. Qui il motore è **`HasWizard`** Filament sulla catena `XotBaseWidget::form()`; dove serve ancora Blade, valutare `DelegatesFilamentWizardSchemaMethods`. **Non** reinserire sulla base helper post-`getState()` solo per appiattire wrapper: la forma del payload sta nello schema Filament/dehydrate o in logica dominio documentata nel widget concreto.

## Perché `HasWizard` qui funziona (e prima si diceva «no»)

`HasWizard::form()` chiama **`parent::form($schema)`**. Sul widget quel parent è **`XotBaseWidget::form()`**, non `CreateRecord` — otteniamo `statePath('data')` e model dove serve **prima** di sostituire i components col solo Wizard. Il trait non è riservato semanticamente alla pagina Filament Panel: dipende dalla catena **`parent::form`**.

Motivo dei doc vecchi/confusi: in passato si parlava davvero **senza `use`** (import morto) o si mescolavano snippet incompleti (manca `getFormSchema()` ⇒ classe astratta illegale).

## Default che differivano dalla bozza storica nel chat

| Aspetto | Bozza utente storica | Progetto ora |
|---------|---------------------|---------------|
| `hasSkippableSteps()` | `true` | **`false`** nella base corrente ({@see hasSkippableWizardSteps} — privacy / consensi; override modulo se serve) |
| Persist `step` in query | sempre | solo se **`queryStepOverrideAllowed()`** (local/debug modulo) |
| `getSteps()` / TicketForm | a volte `array_values(...)` perdendo chiavi URL | associative **preserve** chiavi |

## Percorsi file

- `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`
- `laravel/Modules/Xot/app/Filament/Traits/DelegatesFilamentWizardSchemaMethods.php` (facoltativo, Blade/programmatic navigation)

## Stub storico nome `HasWizard`

[`XotBaseWizardWidget-HasWizard-refactor.md`](./XotBaseWizardWidget-HasWizard-refactor.md) rimane puntatore permalink esterno → questa pagina.
