---
title: "Topic register-widget"
type: digest
status: active
qmd: "digest ceiling 100 register-widget"
---

# Topic register-widget

Sintesi automatica di 4 documenti (chiave `register-widget`).

## RegisterWidget: cosa possiede il modulo e cosa il tema

_Fonte: `register-widget-copy-ownership.md`_

# RegisterWidget: cosa possiede il modulo e cosa il tema

Il modulo Gdpr e' condiviso tra progetti (repo `laraxot/module_gdpr_fila5`). Possiede il **modulo di registrazione**
(campi, consensi, validazione, salvataggio), non la **pagina** che lo ospita. Titoli, sottotitoli, vantaggi, numeri,
link al login e meta SEO sono del progetto ospite e stanno nel suo tema o nelle sue traduzioni.

## Quale vista viene resa

`Filament\Widgets\Widget::render()` usa `$this->view`. `XotBaseWidget::resolveView()` la riempie con il primo nome
esistente fra:

1. `pub_theme::filament.widgets.auth.register` — la vista del tema attivo (es. `Themes/Sixteen`);
2. `gdpr::filament.widgets.auth.register` — la vista di riserva del modulo.

`RegisterWidget` non ridefinisce `getView()`: lo faceva restituendo `filament.widgets.auth.register` senza
namespace, metodo che nessuno chiamava e che funzionava solo perche' la cartella del tema e' nel percorso viste di
default.

## Il contratto che ogni vista rispetta

Tema o modulo, la vista del widget deve rendere:

| Elemento | Valore |
|---|---|
| form | `wire:submit="submit"` |
| campi | `wire:model` su `first_name`, `last_name`, `email`, `password`, `password_confirmation` |
| etichette dei campi | `gdpr::register.fields.<campo>.label` — le stesse di `RegisterWidget::validationAttributes()` |
| consensi | `wire:model` su `privacy_accepted`, `terms_accepted`, `marketing_consent` |
| testi dei consensi | `gdpr::register.consents.privacy_policy_label` / `terms_l

## RegisterWidget Fix - 13 Febbraio 2026

_Fonte: `register-widget-fix-2.md`_

# RegisterWidget Fix - 13 Febbraio 2026

## Problema Risolto

La pagina di registrazione `/it/auth/register` non funzionava correttamente:
- Form non renderizzato (Internal Server Error)
- Layout a una colonna invece di due
- Traduzioni mancanti

## Cause Identificate

### 1. Conflitto tra Filament Schema e Custom Blade View

Il RegisterWidget aveva sia:
- `getFormSchema()` con componenti Filament (TextInput, Grid, etc.)
- Un blade view custom con form HTML diretto

Questo creava conflitti perché Filament aspettava di renderizzare lo schema del form, ma il blade view cercava di renderizzare un form HTML completamente diverso.

### 2. Errore di Access Level

Il metodo `getFormSchema()` era definito come `protected` nella classe padre `XotBaseWidget`, ma era stato sovrascritto senza mantenere lo stesso access level. Questo causava l'errore:

```
Access level to Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::getFormSchema() must be public
```

### 3. Errore di Dichiarazione Proprietà Statica

## RegisterWidget Fix - 13 Febbraio 2026

_Fonte: `register-widget-fix.md`_

# RegisterWidget Fix - 13 Febbraio 2026

> **Superato (2026-11-19).** I testi di registrazione descritti qui venivano da un altro progetto e sono stati tolti dal modulo, che e' condiviso e deve restare neutro. Cosa possiede il modulo e cosa il tema: [register-widget-copy-ownership.md](register-widget-copy-ownership.md). Storia: [stories/register-copy-project-agnostic.story.md](stories/register-copy-project-agnostic.story.md).


## Problema Risolto

La pagina di registrazione `/it/auth/register` non funzionava correttamente:
- Form non renderizzato (Internal Server Error)
- Layout a una colonna invece di due
- Traduzioni mancanti

## Cause Identificate

### 1. Conflitto tra Filament Schema e Custom Blade View

Il RegisterWidget aveva sia:
- `getFormSchema()` con componenti Filament (TextInput, Grid, etc.)
- Un blade view custom con form HTML diretto

Questo creava conflitti perché Filament aspettava di renderizzare lo schema del form, ma il blade view cercava di renderizzare un form HTML completamente diverso.

### 2. Errore di Access Level

Il metodo `getFormSchema()` era definito come `protected` nella classe padre `XotBaseWidget`, ma era stato sovrascritto senza mantenere lo stesso access level. Questo causava l'errore:

```
Access level to Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::getFormSchema() must be public
```

## RegisterWidget — GDPR-Compliant Registration

_Fonte: `register-widget.md`_

# RegisterWidget — GDPR-Compliant Registration

> **Philosophy**: A high-conversion, flat-form registration logic that centralizes GDPR consent management within the `Gdpr` module, decoupled from standard `User` logic but perfectly integrated.

## Technical Architecture

The `RegisterWidget` uses custom Livewire public properties for consents instead of Filament's `Checkbox` components to allow full HTML flexibility in the Blade view (for localized links to legal documents).

### Consent Properties
- `$privacy_accepted`: Mandatory. Linked to `privacy_policy` treatment.
- `$terms_accepted`: Mandatory. Linked to `terms_conditions` treatment.
- `$marketing_consent`: Optional. Linked to `marketing_consent` treatment.

### Custom Component Path
- Vista del tema attivo: `pub_theme::filament.widgets.auth.register` (es. `Themes/Sixteen/resources/views/filament/widgets/auth/register.blade.php`)
- Vista di riserva del modulo: `gdpr::filament.widgets.auth.register`
- Contratto comune e proprieta' dei testi: [register-widget-copy-ownership.md](register-widget-copy-ownership.md)

## Integration Pattern

Always use the GDPR widget for public registration to ensure all consents are recorded in the `gdpr_consents` table.

```blade
{{-- CORRECT --}}
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
```

## GDPR Persistence
