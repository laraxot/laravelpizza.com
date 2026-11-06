---
qmd: "no consolidated"
issues: []
discussions: []
title: "no: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# no: Consolidated Documentation

Consolidated from **35** individual files.

## Table of Contents

- [---](#no-ai-tool-scaffold-dirs)
- [NO Hardcoded Language: La Religione i18n](#no-hardcoded-language-religion)
- [No HTTP controllers in any module](#no-http-controllers)
- [Notify Rule: No NotificationTrackingController](#no-notification-tracking-controller-rule)
- [Notify: no NotificationTrackingController](#no-notification-tracking-controller)
- [No Orphan Http Controllers](#no-orphan-http-controllers)
- [---](#notebooklm-installation-summary)
- [---](#notebooklm-integration)
- [Note Finali sul Modulo Notify](#notes)
- [---](#notification-behavior-1)
- [Notification System Behavior](#notification-behavior)
- [Implementation of Notification Bulk Action in Client Resource](#notification-bulk-action-implementation)
- [Implementazione dei Canali di Notifica](#notification-channels-implementation-1)
- [---](#notification-channels-implementation-2)
- [Implementazione dei Canali di Notifica ](#notification-channels-implementation)
- [---](#notification-errors-1)
- [Errori Comuni nelle Notifiche](#notification-errors)
- [Notification System Implementation Plan](#notification-implementation)
- [Guida Completa ai Provider di Notifiche](#notification-providers-guide-1)
- [---](#notification-providers-guide-2)
- [Guida Completa ai Provider di Notifiche ](#notification-providers-guide)
- [Guida Completa ai Provider di Notifiche ](#notification-providers)
- [Notification System](#notification-system)
- [Notification System Behavior](#notification_behavior)
- [<<<<<<< HEAD](#notification_channels_implementation)
- [Errori Comuni nelle Notifiche](#notification_errors)
- [<<<<<<< HEAD](#notification_providers_guide)
- [Sistema di Notifiche](#notifications-system)
- [https://medium.com/@peterhrobar/push-notifications-with-laravel-61049ab9aec6](#notifications)
- [Sistemazione e Miglioramenti File Traduzione send_email.php - Modulo Notify](#notify-send-email-translations-improvements)
- [Guida alle Traduzioni nel Modulo Notify](#notify-translation-guide-1)
- [---](#notify-translation-guide-2)
- [Guida alle Traduzioni nel Modulo Notify](#notify-translation-guide)
- [Guida alle Traduzioni nel Modulo Notify](#notify-translation)
- [Guida alle Traduzioni nel Modulo Notify](#notify_translation_guide)

---

## no-ai-tool-scaffold-dirs

*Consolidated from: `no-ai-tool-scaffold-dirs.md`*

title: No AI/tool scaffold directories in module tree
---

# Perché queste cartelle non devono esistere qui

Regola canonica: [module-theme-root-cleanup.md: Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).
Regola canonica: [module-theme-root-cleanup.md: Rule 5](../../../../../../docs/wiki/rules/module-theme-root-cleanup.md).

Rimosse in questo modulo: `_docs/`, `scripts/`, `bashscripts/`, `docs/archive|archived|legacy|workbench/`, `.circleci/`, `.claude-audit/`, `tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`, `.kilocode/`, `.kiro/`, `.ralph/` (dove presenti) e aggiunte al `.gitignore` di questo modulo.

**Perché**: questo modulo vive anche come repo Git indipendente (multi-repo); ogni agente/tool AI o pipeline CI che gira in quella root scrive lì la propria cache/scaffold locale (skill `.kiro/`, output `_bmad-output/`, stato `.ralph/`, audit `.claude-audit/`, log `test-results/`), ignorando che quella root è in realtà un sotto-albero del monorepo con le proprie convenzioni: `docs/` unica per la conoscenza riusabile, `bashscripts/` unica alla root del monorepo, `build/` unico per gli artefatti generati. Un secondo posto per la stessa categoria di contenuto è entropia, non struttura: se il tool lo rigenera, il `.gitignore` aggiornato lo tiene fuori dal tracking invece di doverlo ripulire ogni sessione.

---

## no-hardcoded-language-religion

*Consolidated from: `no-hardcoded-language-religion.md`*


**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / i18n  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA

**NON scriverai MAI parole in italiano (o qualsiasi lingua) nel codice PHP.**

**MAI.**  
**Senza eccezioni.**  
**Senza scuse.**  
**SENZA DISCUSSIONE.**

**Il sito e' multilingua.**  
**Ogni stringa hardcoded in italiano e un insulto agli utenti non italiani.**

---

## Perche Succede (Il Problema Profondo)

### 1. Pigrizia dello Sviluppatore

**Il problema**:
```php
// ❌ SBAGLIATO: sviluppatore pigro
Section::make('Riepilogo Segnalazione')
```

**La causa**:
- "E solo una label, chi se ne frega"
- "Tradurro' dopo" (MAI)
- "Funziona cosi, va bene"

**La realta**:
- "Dopo" non arriva mai
- Ogni stringa hardcoded diventa debt tecnico
- 100 stringhe hardcoded = 100 fix manuali

---

### 2. Ignoranza di i18n

**Il problema**:
```php
// ❌ SBAGLIATO: sviluppatore non sa i18n
->description('Verifica i dati prima dell\'invio')
```

**La causa**:
- Non sa che esistono translation keys
- Non conosce il pattern `__('key')`
- Pensa che "funzionare" = "mostrare testo"

**La realta**:
- Sito multilingua ≠ hardcoded italiano
- Ogni utente vede nella SUA lingua
- Testo hardcoded = solo italiani vedono, altri vedono errore

---

### 3. Amnesia dell'AI

**Il problema**:
```
Sessione 1: AI impara regola → "NO hardcoded language"
Sessione 2: AI dimentica → Usa italiano nel codice
Sessione 3: Utente corregge → AI impara di nuovo
Sessione 4: AI dimentica → Ciclo infinito
```

**La causa**:
- AI non ha memoria persistente
- Regole sono nei docs ma NON controllate automaticamente
- Nessun pre-commit hook

---

## I Danni (Perche e un Insulto)

### 1. Utente Francese

```php
// ❌ Codice con italiano hardcoded
Section::make('Riepilogo Segnalazione')
```

**Utente francese vede**:
- "Riepilogo Segnalazione" → ❌ Non capisce
- "Verifica i dati" → ❌ Non capisce
- **Risultato**: Abbandona il sito

---

### 2. Utente Tedesco

```php
// ❌ Codice con italiano hardcoded
->limitMessage('E altre :count immagini')
```

**Utente tedesco vede**:
- "E altre immagini" → ❌ Non capisce
- **Risultato**: Pensa il sito e rotto

---

### 3. Utente Inglese

```php
// ❌ Codice con italiano hardcoded
'Nessuna immagine caricata'
```

**Utente inglese vede**:
- "Nessuna immagine caricata" → ❌ Non capisce
- **Risultato**: Pensa il sito e in beta

---

## La Soluzione Definitiva

### 1. Translation Keys

```php
// ✅ CORRETTO: usa chiavi traduzione
Section::make(__('laraxot::create_ticket_wizard.sections.summary.label'))
    ->description(__('laraxot::create_ticket_wizard.sections.summary.description'))
```

**File traduzione**: `Modules/App/resources/lang/en/create_ticket_wizard.php`
Section::make(__('<nome progetto>::create_ticket_wizard.sections.summary.label'))
    ->description(__('<nome progetto>::create_ticket_wizard.sections.summary.description'))
```

**File traduzione**: `Modules/<nome progetto>/resources/lang/en/create_ticket_wizard.php`
```php
return [
    'sections' => [
        'summary' => [
            'label' => 'Report Summary',
            'description' => 'Verify your data before submission',
        ],
    ],
];
```

**File traduzione**: `Modules/App/resources/lang/it/create_ticket_wizard.php`
**File traduzione**: `Modules/<nome progetto>/resources/lang/it/create_ticket_wizard.php`
```php
return [
    'sections' => [
        'summary' => [
            'label' => 'Riepilogo Segnalazione',
            'description' => 'Verifica i dati prima dell\'invio',
        ],
    ],
];
```

**Risultato**:
- Italiano → "Riepilogo Segnalazione" ✅
- Inglese → "Report Summary" ✅
- Francese → "Résumé du rapport" ✅
- Tedesco → "Berichtszusammenfassung" ✅

---

### 2. Stringhe Dinamiche con Pluralizzazione

```php
// ❌ SBAGLIATO: hardcoded con variabile
->description(fn (Get $get): string =>
    count($get('images')) . ' immagini caricate'
)

// ✅ CORRETTO: translation key con pluralizzazione
->description(fn (Get $get): string =>
    trans_choice(
        'laraxot::create_ticket_wizard.sections.images.description',
        '<nome progetto>::create_ticket_wizard.sections.images.description',
        count($get('images') ?? [])
    )
)
```

**File traduzione**:
```php
'images' => [
    'description' => '{0} No images uploaded|{1} :count image uploaded|[2,*] :count images uploaded',
],
```

**Risultato**:
- Italiano: "Nessuna immagine caricata" / "1 immagine caricata" / "5 immagini caricate"
- Inglese: "No images uploaded" / "1 image uploaded" / "5 images uploaded"

---

### 3. LimitMessage con Traduzione

```php
// ❌ SBAGLIATO
->limitMessage('E altre :count immagini')

// ✅ CORRETTO
->limitMessage(__('laraxot::create_ticket_wizard.sections.images.limit_message'))
->limitMessage(__('<nome progetto>::create_ticket_wizard.sections.images.limit_message'))
```

---

## I Comandamenti i18n

### 1. NON scriverai MAI italiano nel codice PHP

```php
// ❌ SBAGLIATO
Section::make('Riepilogo Segnalazione')

// ✅ CORRETTO
Section::make(__('laraxot::create_ticket_wizard.sections.summary.label'))
Section::make(__('<nome progetto>::create_ticket_wizard.sections.summary.label'))
```

---

### 2. NON scriverai MAI italiano nelle description

```php
// ❌ SBAGLIATO
->description('Verifica i dati prima dell\'invio')

// ✅ CORRETTO
->description(__('laraxot::create_ticket_wizard.sections.summary.description'))
->description(__('<nome progetto>::create_ticket_wizard.sections.summary.description'))
```

---

### 3. NON scriverai MAI italiano nei placeholder

```php
// ❌ SBAGLIATO (anche se placeholder e auto-applicato, se lo scrivi)
->placeholder('Inserisci il tuo nome')

// ✅ CORRETTO
// Niente placeholder, LangServiceProvider applica automaticamente
```

---

### 4. NON scriverai MAI italiano nei messaggi di errore

```php
// ❌ SBAGLIATO
$this->addError('data.submit', 'Si è verificato un errore')

// ✅ CORRETTO
$this->addError('data.submit', __('laraxot::create_ticket_wizard.notifications.submit_failed.body'))
$this->addError('data.submit', __('<nome progetto>::create_ticket_wizard.notifications.submit_failed.body'))
```

---

### 5. NON scriverai MAI italiano nelle conferme

```php
// ❌ SBAGLIATO
Notification::make()
    ->title('Operazione completata')
    ->body('I dati sono stati salvati correttamente')

// ✅ CORRETTO
Notification::make()
    ->title(__('laraxot::create_ticket_wizard.notifications.success.title'))
    ->body(__('laraxot::create_ticket_wizard.notifications.success.body'))
    ->title(__('<nome progetto>::create_ticket_wizard.notifications.success.title'))
    ->body(__('<nome progetto>::create_ticket_wizard.notifications.success.body'))
```

---

### 6. USERAI trans_choice per plurali

```php
// ❌ SBAGLIATO
echo count($items) . ' elementi trovati'

// ✅ CORRETTO
echo trans_choice('laraxot::messages.items_found', count($items))
echo trans_choice('<nome progetto>::messages.items_found', count($items))
```

---

### 7. NON mescolerai lingue nel codice

```php
// ❌ SBAGLIATO: misto italiano/inglese
Section::make('Riepilogo Segnalazione')
    ->description('Verify your data')  // MISTO!

// ✅ CORRETTO: tutto via translation keys
Section::make(__('laraxot::sections.summary.label'))
    ->description(__('laraxot::sections.summary.description'))
Section::make(__('<nome progetto>::sections.summary.label'))
    ->description(__('<nome progetto>::sections.summary.description'))
```

---

### 8. CREERAI file traduzione per ogni lingua supportata

```
Modules/App/resources/lang/
Modules/<nome progetto>/resources/lang/
├── en/
│   └── create_ticket_wizard.php
├── it/
│   └── create_ticket_wizard.php
├── fr/
│   └── create_ticket_wizard.php
├── de/
│   └── create_ticket_wizard.php
└── es/
    └── create_ticket_wizard.php
```

---

### 9. AGGIORNERAI i file traduzione quando aggiungi nuove stringhe

```php
// Aggiungi nuova UI
Section::make(__('laraxot::new_section.label'))
Section::make(__('<nome progetto>::new_section.label'))

// IMMEDIATAMENTE aggiungi a TUTTI i file lang:
// en/create_ticket_wizard.php → 'new_section' => ['label' => 'New Section']
// it/create_ticket_wizard.php → 'new_section' => ['label' => 'Nuova Sezione']
// fr/create_ticket_wizard.php → 'new_section' => ['label' => 'Nouvelle Section']
```

---

### 10. VERIFICHERAI con pre-commit hook

Script: `bashscripts/check-hardcoded-language.sh`

```bash
#!/bin/bash
# Controlla italiano hardcoded nel codice PHP

echo "🔍 Checking for hardcoded Italian in PHP files..."

VIOLATIONS=$(grep -rE \
    "make\(['\"][A-ZÀ-Ž][a-zà-ž]+ [A-ZÀ-Ž]|['\"][A-ZÀ-Ž][a-zà-ž]+[ '\"]" \
    laravel/Modules/*/app/Filament/ \
    --include="*.php" \
    2>/dev/null | \
    grep -v "__(" | \
    grep -v "->label\|->placeholder" || true)

if [ -n "$VIOLATIONS" ]; then
    echo "❌ HARDCODED ITALIAN FOUND:"
    echo "$VIOLATIONS"
    echo ""
    echo "📖 Leggi: docs/no-hardcoded-language-religion.md"
    exit 1
fi

echo "✅ No hardcoded Italian found"
exit 0
```

---

## Come Correggere (Guida Rapida)

### 1. Trova Violazioni

```bash
# Cerca italiano hardcoded in Filament
grep -rE "make\(['\"][A-ZÀ]" Modules/App/app/Filament/ --include="*.php"
grep -rE "description\(['\"][A-ZÀ]" Modules/App/app/Filament/ --include="*.php"
grep -rE "make\(['\"][A-ZÀ]" Modules/<nome progetto>/app/Filament/ --include="*.php"
grep -rE "description\(['\"][A-ZÀ]" Modules/<nome progetto>/app/Filament/ --include="*.php"
```

---

### 2. Crea Translation Keys

Per ogni violazione:
- Identifica la stringa italiana
- Crea chiave: `laraxot::create_ticket_wizard.sections.xxx.label`
- Crea chiave: `<nome progetto>::create_ticket_wizard.sections.xxx.label`
- Aggiungi a TUTTI i file lang (en, it, fr, de, es)

---

### 3. Sostituisci nel Codice

```php
// PRIMA
Section::make('Riepilogo Segnalazione')
    ->description('Verifica i dati prima dell\'invio')

// DOPO
Section::make(__('laraxot::create_ticket_wizard.sections.summary.label'))
    ->description(__('laraxot::create_ticket_wizard.sections.summary.description'))
Section::make(__('<nome progetto>::create_ticket_wizard.sections.summary.label'))
    ->description(__('<nome progetto>::create_ticket_wizard.sections.summary.description'))
```

---

### 4. Verifica

```bash
# Controlla che non ci siano piu violazioni
bash bashscripts/check-hardcoded-language.sh
```

---

## La Filosofia (Perche Profondo)

### i18n non e Feature, e Rispetto

**Quando hardcodi italiano**:
- Dici agli utenti non italiani: "Non mi importa se capisci"
- Tratti il sito come se fosse solo per italiani
- Ignori il 99% degli utenti potenziali

**Quando usi translation keys**:
- Rispetti OGNI utente nella sua lingua
- Il sito e globale per design
- Scalabilita automatica (aggiungi lingua = 1 file)

---

### Il Costo Reale

**Hardcoded italiano**:
- 100 stringhe hardcoded × 5 lingue × 5 min = 2500 min = 41 ore
- Ogni aggiunta lingua = 41 ore di nuovo
- **Totale per 10 lingue**: 410 ore

**Translation keys**:
- 100 stringhe × 1 chiave ciascuna = 100 chiavi
- 100 chiavi × 5 lingue × 1 min = 500 min = 8 ore
- Ogni aggiunta lingua = 8 ore di nuovo
- **Totale per 10 lingue**: 80 ore

**Risparmiato**: 330 ore = 41 giorni di lavoro

---

### La Scalabilita

**Hardcoded**:
- Aggiungi lingua → trovi tutte le stringhe hardcoded → traduci manualmente
- Processo: settimane

**Translation keys**:
- Aggiungi lingua → duplica 1 file lang → traduci chiavi
- Processo: ore

---

## La Religione

### Il Credo

> "Codice in inglese, UI nella lingua dell'utente.  
> Mai hardcoded, sempre translation keys.  
> i18n non e optional, e rispetto."

### La Preghiera

```
Concedimi la disciplina di scrivere codice in inglese,
La saggezza di usare translation keys,
E il rispetto per ogni utente nella sua lingua.

Amen.
```

---

## Riferimenti

- [Laravel Localization Docs](https://laravel.com/docs/localization)
- [LangServiceProvider](../../Lang/app/Providers/LangServiceProvider.php)
- [Translation Files](../../Modules/App/resources/lang/)
- [Translation Files](../../Modules/<nome progetto>/resources/lang/)
- [Pre-Commit Hook](../../bashscripts/check-hardcoded-language.sh)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI SCRIVERE QUALSIASI UI**

---

## no-http-controllers

*Consolidated from: `no-http-controllers.md`*


## Rule

No module may contain HTTP controllers. The architecture is Folio + Volt (front office) and Filament (admin) exclusively.

This applies to every module: Notify, User, Meetup, Cms, Gdpr, Geo, Lang, Tenant, Xot, and all others.

## Violation found and removed

**File**: `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php`

This controller handled email open/click tracking via HTTP GET requests. It was deleted entirely.

## Why controllers violate the architecture

### Architecture contract

The project's CLAUDE.md defines the only valid patterns for HTTP request handling:

| Use case | Correct mechanism |
|---|---|
| Public pages | Folio catch-all `[slug].blade.php` + JSON page content |
| Authenticated front office | Volt components inside Folio pages |
| Admin panel | Filament resources, pages, and widgets |
| Background work | Queued Jobs and Actions |

There is no slot for a traditional controller.

### What happens when controllers are added

- They create implicit routing that bypasses the Folio/Localization middleware stack
- They cannot use `LaravelLocalization::localizeUrl()` for redirects correctly
- They bypass the `pub_theme::` namespace resolution
- They undermine the CMS-driven page model: the page has no JSON definition
- They introduce a parallel routing system that conflicts with Folio's file-based routing

### The Notify module specifically

The `Notify` module is responsible for:
- Queuing and sending notifications (email, SMS, push, etc.)
- Providing Filament admin UI for notification management
- Defining Notification classes and their channels

It is not responsible for handling inbound HTTP tracking pixels or link redirects. That concern belongs to either:
- A Folio page in the theme (`Themes/Meetup/resources/views/pages/track/[token].blade.php`)
- A Livewire Volt component that performs the tracking and redirects

## Correct approach for email tracking

If email open/click tracking is needed:

1. Create a Folio page in the theme:
   ```
   Themes/Meetup/resources/views/pages/track/[token].blade.php
   ```

2. Inside that Folio page, use a Volt component or inline PHP to:
   - Decode the token
   - Record the tracking event (via an Action)
   - Redirect to the final destination

3. The tracking Action lives in `Modules/Notify/app/Actions/TrackNotificationOpenAction.php`.

This keeps the HTTP surface in Folio (the correct location) while the business logic stays in the Notify module where it belongs.

## What to do if you find a controller

1. Delete the controller file.
2. Identify the route it served.
3. Create a Folio page for that route.
4. Move business logic to an Action in the appropriate module.
5. Document the change in this file.

## Related

- CLAUDE.md rule 1: "NEVER use traditional controllers or routes in web.php/api.php for front office"
- `laravel/CLAUDE.md` rule 2: Architecture frontend: NO Controller, NO Routes in web.php
- Folio routing docs: `Themes/Meetup/docs/folio-pages-json-only-rule.md`

---

## no-notification-tracking-controller-rule

*Consolidated from: `no-notification-tracking-controller-rule.md`*


Nel modulo Notify non deve esistere `app/Http/Controllers/NotificationTrackingController.php`.

Motivazione:
- il tracking notifiche va gestito tramite Actions/Channels dedicati,
- evitare controller legacy non allineati alla struttura corrente,
- ridurre superfici HTTP non governate dal flusso modulo.

Conseguenza operativa:
- rimuovere il file controller dal runtime,
- mantenere eventuale tracking dentro action class testabili e servizi di canale,
- non spostare questa responsabilita' nel tema o nei file Folio/Blade.

---

## no-notification-tracking-controller

*Consolidated from: `no-notification-tracking-controller.md`*


## Regola

`Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` non deve stare nel modulo.

## Perche'

- mescola transport HTTP, tracking, mutazione stato e redirect in un punto unico;
- sposta nel boundary web una responsabilita' che deve restare nel dominio `Notify`;
- rende il tracking meno riusabile, meno testabile e piu' facile da duplicare nei temi.

## Approccio corretto

- action dedicate per open/click tracking;
- route sottili, se davvero necessarie, che delegano subito al dominio;
- niente controller monolitici o orfani per tracking notifiche;
- nessuna logica di tracking nel tema.

## Nota di governance

La sua ricomparsa va trattata come regressione architetturale, non come semplice refactor incompleto.

---

## no-orphan-http-controllers

*Consolidated from: `no-orphan-http-controllers.md`*


## Regola

Nel modulo `Notify` non devono esistere controller HTTP orfani, cioe' file sotto `app/Http/Controllers` senza route effettive o senza un ruolo architetturale chiaro nel boundary web.

## Caso concreto

`NotificationTrackingController.php` non deve stare nel modulo:

- non risultano route collegate;
- incapsula tracking open/click come controller legacy;
- il tracking delle notifiche e' dominio applicativo e va gestito tramite action/service dedicati oppure introdotto solo quando esiste davvero un boundary HTTP dichiarato.

## Regola operativa

1. se un comportamento non ha route vive, il controller non va tenuto nel modulo;
2. se il tracking serve davvero, prima si definisce il contratto architetturale in docs;
3. poi si implementa nel punto corretto, evitando file HTTP morti o non integrati.

---

## notebooklm-installation-summary

*Consolidated from: `notebooklm-installation-summary.md`*

title: "NotebookLM Skill - Installation & Integration Summary"
type: concept
tags: [notebooklm, installation, summary]
created: 2026-07-14
updated: 2026-07-14
qmd: "notebooklm-installation-summary notebooklm skill - installation & integration summary"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# NotebookLM Skill - Installation & Integration Summary

**Date**: 2026-03-30  
**Status**: ✅ Installed & Integrated  
**Workflow**: BMAD + GSD + Ralph + OpenViking + NotebookLM

## Installation Summary

### ✅ Already Installed

```bash
Location: ~/.claude/skills/notebooklm/
Branch: master (up to date)
Dependencies: Auto-managed (.venv)
Status: Ready for use
```

### Verification

```bash
# Check installation
ls -la ~/.claude/skills/notebooklm/

# Output shows:
# - SKILL.md (main documentation)
# - scripts/ (automation scripts)
# - data/ (authentication + library)
# - requirements.txt
# - README.md, changelog.md, LICENSE
```

## What is NotebookLM Skill?

**Google NotebookLM integration for Claude Code** that provides:

- ✅ **Source-grounded answers** - Only from uploaded documents
- ✅ **Citation-backed responses** - From Gemini AI
- ✅ **Browser automation** - Query NotebookLM programmatically
- ✅ **Library management** - Save and organize notebooks
- ✅ **Persistent authentication** - One-time Google login
- ✅ **Reduced hallucinations** - Document-only responses

**Key Benefit**: Eliminates copy-paste between NotebookLM browser and editor. Claude asks questions directly and receives answers in CLI.

## Integration with Existing Workflow

### Complete AI Tool Stack

```
┌─────────────────────────────────────────────────────────┐
│              AI Tool Stack - Notify                    │
│              AI Tool Stack - <nome progetto>                    │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  📚 NotebookLM Skill                                    │
│     - Source-grounded research                          │
│     - Technical documentation queries                   │
│     - Citation-backed answers                           │
│                                                          │
│  🧠 BMAD                                                │
│     - Requirements (PRD)                                │
│     - Architecture                                      │
│     - Epics & Stories                                   │
│                                                          │
│  📋 GSD                                                 │
│     - Phase planning                                    │
│     - Execution                                         │
│     - Verification                                      │
│                                                          │
│  🤖 Ralph Loop                                          │
│     - Autonomous implementation                         │
│     - Iterative development                             │
│     - Checkpoint management                             │
│                                                          │
│  💾 OpenViking                                          │
│     - Context preservation                              │
│     - Knowledge base                                    │
│     - Cross-session memory                              │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### Enhanced Workflow

```
BMAD (Requirements & Architecture)
    ↓
├─ Research with NotebookLM
│  ├─ Query technical docs
│  ├─ Verify architecture patterns
│  └─ Get citation-backed answers
    ↓
├─ Store insights in OpenViking
    ↓
GSD (Planning & Execution)
    ↓
├─ Plan with NotebookLM context
│  ├─ Reference uploaded specs
│  └─ Check implementation details
    ↓
├─ Verify with NotebookLM
    ↓
Ralph Loop (Implementation)
    ↓
├─ Implement with NotebookLM verification
│  ├─ Verify code against docs
│  └─ Check API references
    ↓
├─ Store outcomes in OpenViking
    ↓
OpenViking (Context Preservation)
    ↓
└─ Complete project knowledge base
```

## Quick Start Guide

### 1. Check Authentication

```bash
cd ~/.claude/skills/notebooklm
python scripts/run.py auth_manager.py status
```

### 2. Authenticate (One-Time)

```bash
# Browser will open for Google login
python scripts/run.py auth_manager.py setup
```

**Important**: Browser is VISIBLE for manual Google login.

### 3. Add Notebook to Library

**Smart Add** (Recommended):
```bash
# Query notebook to discover content
python scripts/run.py ask_question.py \
  --question "What is the content of this notebook? Provide overview" \
  --notebook-url "https://notebooklm.google.com/notebook/YOUR-ID"

# Then add with discovered info
python scripts/run.py notebook_manager.py add \
  --url "https://notebooklm.google.com/notebook/YOUR-ID" \
  --name "Discovered Name" \
  --description "From discovered content" \
  --topics "topic1,topic2"
```

### 4. Query Notebook

```bash
# List notebooks
python scripts/run.py notebook_manager.py list

# Ask question
python scripts/run.py ask_question.py \
  --question "What does the docs say about [topic]?"
```

## Usage Examples for Notify
## Usage Examples for <nome progetto>

### Example 1: Technical Research (BMAD)

```bash
# Research Laravel patterns
python scripts/run.py ask_question.py \
  --question "What are Laravel 12 best practices for service architecture?"

# Research Filament v5
python scripts/run.py ask_question.py \
  --question "How to create Filament v5 resources with XotBase extension?"

# Store in OpenViking
openviking add-memory \
  --title="Laravel Architecture Best Practices" \
  --content="[NotebookLM answer with citations]"
```

### Example 2: Implementation Verification (GSD)

```bash
# Verify implementation approach
python scripts/run.py ask_question.py \
  --question "Check the Laraxot documentation: should I use Actions or Services?"

# Verify code patterns
python scripts/run.py ask_question.py \
  --question "What is the correct pattern for Filament table actions?"
```

### Example 3: Quick Reference (Ralph Loop)

```bash
# Quick reference during implementation
python scripts/run.py ask_question.py \
  --question "What is the container0/slug0 pattern in Laraxot?"

# API reference
python scripts/run.py ask_question.py \
  --question "How to use Spatie QueueableAction with Laravel?"
```

## Critical: Follow-Up Mechanism

Every NotebookLM answer ends with: **"Is that ALL you need to know?"**

**Required Workflow**:
1. **STOP** - Don't respond immediately
2. **ANALYZE** - Check if answer is complete
3. **ASK FOLLOW-UP** - If gaps exist:
   ```bash
   python scripts/run.py ask_question.py \
     --question "Follow-up: [specific gap] with context from previous answer"
   ```
4. **REPEAT** - Until information is complete
5. **SYNTHESIZE** - Combine all answers before responding

## Recommended Notebooks for Notify
## Recommended Notebooks for <nome progetto>

Create these NotebookLM notebooks:

### 1. Laraxot Framework Docs
- **Upload**: Laraxot documentation, agents.md, .windsurfrules
- **Topics**: laravel, architecture, modules, filament, xot
- **Use**: Technical research, implementation verification

### 2. PHP Best Practices
- **Upload**: PHP 8.3+ docs, PSR standards, SOLID principles
- **Topics**: php, patterns, quality, testing, phpstan
- **Use**: Code quality, architecture decisions

### 3. Filament v5 Documentation
- **Upload**: Filament docs, examples, tutorials
- **Topics**: filament, admin, resources, forms, tables, widgets
- **Use**: Admin panel development

### 4. Project Documentation
- **Upload**: Notify docs, module docs, theme docs
- **Topics**: laraxot, project, conventions, documentation
- **Upload**: <nome progetto> docs, module docs, theme docs
- **Topics**: <nome progetto>, project, conventions, documentation
- **Use**: Project-specific queries

## Files Created/Updated

### Created
1. ✅ `docs/project/notebooklm-integration.md` - Complete integration guide
2. ✅ `docs/notebooklm-installation-summary.md` - This summary

### Updated
1. ✅ `.windsurfrules` - Added AI Tools Integration section

## Command Reference

### Always Use run.py Wrapper

```bash
# ✅ CORRECT - Always use run.py:
python scripts/run.py auth_manager.py status
python scripts/run.py notebook_manager.py list
python scripts/run.py ask_question.py --question "..."

# ❌ WRONG - Never call directly:
python scripts/auth_manager.py status  # Fails without venv!
```

### Core Commands

```bash
# Authentication
python scripts/run.py auth_manager.py status
python scripts/run.py auth_manager.py setup
python scripts/run.py auth_manager.py clear

# Notebook Management
python scripts/run.py notebook_manager.py list
python scripts/run.py notebook_manager.py add --url URL --name NAME --description DESC --topics TOPICS
python scripts/run.py notebook_manager.py activate --id ID
python scripts/run.py notebook_manager.py search --query QUERY

# Ask Questions
python scripts/run.py ask_question.py --question "..." [--notebook-id ID] [--notebook-url URL]
```

## Configuration

### Environment (.env)

Create `~/.claude/skills/notebooklm/.env`:

```bash
# Browser configuration
HEADLESS=false           # Show browser for debugging
SHOW_BROWSER=false       # Default: hidden for queries
STEALTH_ENABLED=true     # Human-like behavior

# Typing speed (human-like)
TYPING_WPM_MIN=160
TYPING_WPM_MAX=240

# Default notebook (Notify docs)
DEFAULT_NOTEBOOK_ID=laraxot-project-docs
# Default notebook (<nome progetto> docs)
DEFAULT_NOTEBOOK_ID=<nome progetto>-project-docs
```

### Data Storage

```
~/.claude/skills/notebooklm/data/
├── library.json       # Your notebook library
├── auth_info.json     # Authentication status
└── browser_state/     # Browser cookies and session
```

**Security**: Protected by `.gitignore`, never commit.

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Not authenticated | `python scripts/run.py auth_manager.py setup` |
| ModuleNotFoundError | Always use `run.py` wrapper |
| Rate limit (50/day) | Wait or use different Google account |
| Browser crashes | `python scripts/run.py cleanup_manager.py --preserve-library` |
| Notebook not found | Check with `notebook_manager.py list` |

## Best Practices

1. ✅ **Always use run.py** - Handles environment automatically
2. ✅ **Check auth first** - Before any operations
3. ✅ **Follow-up questions** - Don't stop at first answer
4. ✅ **Include context** - Each question is independent
5. ✅ **Synthesize answers** - Combine multiple responses
6. ✅ **Store in OpenViking** - Preserve insights for future

## Next Steps

1. ✅ Skill installed and verified
2. ⏳ Authenticate with Google account
3. ⏳ Create Notify NotebookLM notebooks
3. ⏳ Create <nome progetto> NotebookLM notebooks
4. ⏳ Upload project documentation
5. ⏳ Integrate with BMAD workflow
6. ⏳ Store insights in OpenViking

## Resources

- **Skill Location**: `~/.claude/skills/notebooklm/`
- **Documentation**: `~/.claude/skills/notebooklm/SKILL.md`
- **Integration Guide**: `docs/project/notebooklm-integration.md`
- **Scripts**: `~/.claude/skills/notebooklm/scripts/`
- **GitHub**: https://github.com/PleasePrompto/notebooklm-skill

---

**Status**: ✅ Ready for authentication and notebook creation  
**Last Updated**: 2026-03-30  
**Integrated By**: AI Agent (BMAD + GSD + Ralph Workflow)

---

## notebooklm-integration

*Consolidated from: `notebooklm-integration.md`*

title: "NotebookLM Integration"
type: concept
tags: [notebooklm, integration]
created: 2026-07-14
updated: 2026-07-14
qmd: "notebooklm-integration notebooklm integration"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# NotebookLM Integration

## Overview

This project integrates **Google NotebookLM** with Claude Code/OpenCode for source-grounded research and documentation assistance.

## What is NotebookLM?

NotebookLM is Google's AI-powered research assistant that lets you:
- Upload documents (PDF, Markdown, Google Docs, URLs, YouTube)
- Chat with your sources using Gemini 2.5
- Generate podcasts (Audio Overview), videos, quizzes, flashcards, and more

## Installation

### 1. Install notebooklm-py

```bash
pipx install notebooklm-py
pipx inject notebooklm-py "notebooklm-py[browser]"
```

### 2. Install Claude Code Skill

```bash
notebooklm skill install
```

This installs the skill to `~/.claude/skills/notebooklm/`

### 3. Authenticate

```bash
notebooklm login
```

This opens a browser window. Complete the Google login and press ENTER to save.

### 4. Verify Authentication

```bash
notebooklm auth check --test
```

## Usage

### CLI Commands

```bash
# List notebooks
notebooklm list

# Create a notebook
notebooklm create "Notify Research"
notebooklm create "<nome progetto> Research"

# Add sources
notebooklm use <notebook_id>
notebooklm source add "https://laravel.com/docs/11.x"
notebooklm source add "./docs/architecture.md"

# Chat with sources
notebooklm ask "How does the XotBase pattern work?"

# Generate audio overview (podcast)
notebooklm generate audio "explain this like a podcast"
notebooklm download audio ./podcast.mp3
```

### Claude Code Integration

Once authenticated, you can ask Claude Code to:

```
"NotebookLM: Create a podcast about Laravel Actions patterns"
"NotebookLM: What's in my Notify Research notebook?"
"NotebookLM: Generate a quiz about Filament Forms"
```

## Notify-Specific Notebooks

Recommended notebooks to create:

1. **Notify Architecture** - agents.md, docs/architecture/*
2. **Notify Modules** - laravel/Modules/*/docs/README.md
3. **Notify API** - API documentation, Swagger specs
"NotebookLM: What's in my <nome progetto> Research notebook?"
"NotebookLM: Generate a quiz about Filament Forms"
```

## <nome progetto>-Specific Notebooks

Recommended notebooks to create:

1. **<nome progetto> Architecture** - agents.md, docs/architecture/*
2. **<nome progetto> Modules** - laravel/Modules/*/docs/README.md
3. **<nome progetto> API** - API documentation, Swagger specs

## Configuration

The skill is installed at: `~/.claude/skills/notebooklm/`

Key files:
- `SKILL.md` - Claude Code skill definition
- `AUTHENTICATION.md` - Authentication architecture
- `README.md` - Full documentation

## Troubleshooting

### Login Failed

```bash
# Re-run login
notebooklm login
```

### Authentication Issues

```bash
# Check auth status
notebooklm auth check --test

# Reset authentication
rm ~/.notebooklm/storage_state.json
notebooklm login
```

### Browser Issues

If login fails with browser errors, ensure Playwright browsers are installed:

```bash
pipx run notebooklm-py playwright install chromium
```

## Quick Reference

| Command | Description |
|---------|-------------|
| `notebooklm login` | Authenticate with Google |
| `notebooklm list` | List notebooks |
| `notebooklm create "Name"` | Create notebook |
| `notebooklm use <id>` | Switch notebook |
| `notebooklm source add <url>` | Add source |
| `notebooklm ask "?"` | Ask question |
| `notebooklm generate audio` | Generate podcast |

## Files

- **Installed**: `~/.claude/skills/notebooklm/`
- **Storage**: `~/.notebooklm/`
- **Config**: `~/.notebooklm/config.json`

---

## notes

*Consolidated from: `notes.md`*


## Architettura

### Queueable Actions
- Utilizzo di `spatie/laravel-queueable-action` per gestire le operazioni asincrone
- Ogni azione è una classe dedicata che estende `QueueableAction`
- Le azioni sono testabili e mantenibili
- Supporto nativo per code e retry

### Componenti Blade
- Utilizzo dei componenti Blade di Filament come prima scelta
- Componenti riutilizzabili e personalizzabili
- Integrazione nativa con il sistema di temi di Filament
- Supporto per dark mode e responsive design

## Best Practices

### Queueable Actions
1. Mantenere le azioni atomiche e focalizzate
2. Utilizzare type hints e return types
3. Gestire correttamente le eccezioni
4. Implementare logging appropriato
5. Aggiungere test unitari

### Template
1. Utilizzare MJML per email responsive
2. Implementare versioning dei template
3. Validare il contenuto prima del salvataggio
4. Supportare multi-lingua
5. Mantenere la cache dei template compilati

### Performance
1. Utilizzare indici appropriati nel database
2. Implementare caching strategico
3. Monitorare le code e le performance
4. Ottimizzare le query
5. Utilizzare eager loading quando necessario

## Considerazioni Future

### Miglioramenti Pianificati
1. Supporto per più canali di notifica
2. Integrazione con servizi di terze parti
3. Dashboard analytics avanzata
4. Sistema di A/B testing
5. API RESTful per integrazioni

### Scalabilità
1. Sharding del database per grandi volumi
2. Implementazione di code dedicate per canale
3. Caching distribuito
4. Load balancing per le code
5. Monitoraggio distribuito

## Troubleshooting

### Problemi Comuni
1. Code bloccate
   - Verificare i worker
   - Controllare i log
   - Ripulire i job falliti

2. Template non compilati
   - Verificare la sintassi MJML
   - Controllare le variabili
   - Validare il contenuto

3. Performance degradate
   - Ottimizzare le query
   - Aggiungere indici
   - Implementare caching

### Soluzioni
1. Monitoraggio proattivo
2. Logging dettagliato
3. Health checks regolari
4. Backup automatici
5. Procedure di recovery

## Manutenzione

### Routine
1. Pulizia giornaliera dei log
2. Backup settimanale
3. Analisi mensile delle performance
4. Aggiornamento trimestrale delle dipendenze
5. Revisione annuale dell'architettura

### Ottimizzazione
1. Monitoraggio continuo
2. Analisi delle performance
3. Ottimizzazione delle query
4. Gestione della cache
5. Manutenzione del database

## Sicurezza

### Best Practices
1. Validazione input
2. Sanitizzazione output
3. Rate limiting
4. Autenticazione e autorizzazione
5. Logging degli eventi di sicurezza

### Vulnerabilità
1. XSS prevention
2. CSRF protection
3. SQL injection prevention
4. Rate limiting
5. Input validation

## Documentazione

### Manutenzione
1. Aggiornare la documentazione con le modifiche
2. Mantenere esempi di codice aggiornati
3. Documentare le decisioni architetturali
4. Mantenere un changelog
5. Aggiornare le API docs

### Struttura
1. README principale
2. Documentazione architetturale
3. Guide di utilizzo
4. API reference
5. Troubleshooting guide

## Conclusione

Il modulo Notify è stato progettato per essere:
- Scalabile
- Manutenibile
- Performante
- Sicuro
- Facile da integrare

L'utilizzo di Queueable Actions e componenti Blade di Filament garantisce:
- Codice pulito e testabile
- Operazioni asincrone efficienti
- UI/UX moderna e responsive
- Integrazione nativa con Filament
- Facilità di manutenzione 

---

## notification-behavior-1

*Consolidated from: `notification-behavior.md`*

title: "Notification System Behavior"
type: concept
tags: [notification, behavior]
created: 2026-07-14
updated: 2026-07-14
qmd: "notification-behavior-1 notification system behavior"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Notification System Behavior

## Notification Channels Behavior

### Issue: Unexpected SMS Channel Execution

When sending a notification with multiple channels (e.g., mail and SMS), Laravel will attempt to send through all specified channels in the `via()` method, even if not all channels are used in the notification call.

**Example from `RegisterAction.php`:**
```php
Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

**Problem:**
Even though only the mail channel is explicitly routed, the `toSms()` method is still called because:

1. The `via()` method in `RecordNotification` returns both `['mail', SmsChannel::class]`
2. Laravel's notification system will attempt to send through all channels specified in `via()`
3. If a channel is not properly routed (like SMS in this case), it will cause errors

### Solution 1: Route All Required Channels

```php
Notification::route('mail', $data['email'])
    ->route('sms', $data['phone'])  // Add phone number if available
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

### Solution 2: Make SMS Optional

Modify the `toSms()` method to handle cases where the recipient doesn't have a phone number:

```php
public function toSms($notifiable)
{
    if (empty($notifiable->routeNotificationFor('sms'))) {
        return null;
    }
    
    return SmsData::from([
        'from' => config('app.name'),
        'to' => $notifiable->routeNotificationFor('sms'),
        'body' => 'Your notification message here'
    ]);
}
```

### Solution 3: Dynamic Channel Selection

Modify the `via()` method to only return channels that are properly routed:

```php
public function via($notifiable)
{
    $channels = [];
    
    if ($notifiable->routeNotificationFor('mail')) {
        $channels[] = 'mail';
    }
    
    if ($notifiable->routeNotificationFor('sms')) {
        $channels[] = SmsChannel::class;
    }
    
    return $channels;
}
```

## Best Practices

1. **Always check if a channel is properly routed** before attempting to use it
2. **Make notification channels optional** when possible
3. **Validate recipient information** before sending notifications
4. **Use queueable notifications** for better performance
5. **Log notification failures** for debugging purposes

## Related Documentation

- [Laravel Notification Channels](https://laravel.com/docs/notifications#specifying-delivery-channels)
- [Laravel Notification Routing](https://laravel.com/docs/notifications#routing-notifications)
- [Notification Best Practices](best-practices.md)
- [Notification Best Practices](../../best-practices.md)

---

## notification-behavior

*Consolidated from: `notification-behavior.md`*


## Notification Channels Behavior

### Issue: Unexpected SMS Channel Execution

When sending a notification with multiple channels (e.g., mail and SMS), Laravel will attempt to send through all specified channels in the `via()` method, even if not all channels are used in the notification call.

**Example from `RegisterAction.php`:**
```php
Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

**Problem:**
Even though only the mail channel is explicitly routed, the `toSms()` method is still called because:

1. The `via()` method in `RecordNotification` returns both `['mail', SmsChannel::class]`
2. Laravel's notification system will attempt to send through all channels specified in `via()`
3. If a channel is not properly routed (like SMS in this case), it will cause errors

### Solution 1: Route All Required Channels

```php
Notification::route('mail', $data['email'])
    ->route('sms', $data['phone'])  // Add phone number if available
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

### Solution 2: Make SMS Optional

Modify the `toSms()` method to handle cases where the recipient doesn't have a phone number:

```php
public function toSms($notifiable)
{
    if (empty($notifiable->routeNotificationFor('sms'))) {
        return null;
    }
    
    return SmsData::from([
        'from' => config('app.name'),
        'to' => $notifiable->routeNotificationFor('sms'),
        'body' => 'Your notification message here'
    ]);
}
```

### Solution 3: Dynamic Channel Selection

Modify the `via()` method to only return channels that are properly routed:

```php
public function via($notifiable)
{
    $channels = [];
    
    if ($notifiable->routeNotificationFor('mail')) {
        $channels[] = 'mail';
    }
    
    if ($notifiable->routeNotificationFor('sms')) {
        $channels[] = SmsChannel::class;
    }
    
    return $channels;
}
```

## Best Practices

1. **Always check if a channel is properly routed** before attempting to use it
2. **Make notification channels optional** when possible
3. **Validate recipient information** before sending notifications
4. **Use queueable notifications** for better performance
5. **Log notification failures** for debugging purposes

## Related Documentation

- [Laravel Notification Channels](https://laravel.com/docs/notifications#specifying-delivery-channels)
- [Laravel Notification Routing](https://laravel.com/docs/notifications#routing-notifications)
- [Notification Best Practices](best-practices.md)
- [Notification Best Practices](../../best-practices.md)

---

## notification-bulk-action-implementation

*Consolidated from: `notification-bulk-action-implementation.md`*


**Date**: 18 Dicembre 2025  
**Status**: ✅ Completed  
**Module**: App → Notify  
**Module**: TechPlanner → Notify  
**Implementation Type**: Feature Addition

## Overview

Successfully implemented the notification bulk action functionality in the ClientResource as requested. The implementation allows users to send notifications to multiple client records using various communication channels (mail, SMS, WhatsApp) with pre-defined MailTemplate slugs.

## Implementation Details

### Components Integrated

The implementation leverages existing architecture components:

1. **QueueableAction**: `Modules\Notify\Actions\SendRecordsNotificationBulkAction`
   - Contains the core business logic for sending notifications
   - Handles multiple channels (mail, SMS, WhatsApp)
   - Provides comprehensive error handling and logging
   - Uses proper phone number normalization

2. **FilamentAction**: `Modules\Notify\Filament\Actions\SendNotificationBulkAction`  
   - Provides the UI modal with template selection
   - Offers channel selection via checkboxes
   - Handles form validation and user notifications
   - Follows XotBase extension pattern

3. **MailTemplate Model**: `Modules\Notify\Models\MailTemplate`
   - Provides template selection based on slugs
   - Supports multi-language translations
   - Stores HTML, text, and SMS templates

### ClientResource Integration

Updated `Modules\App/app/Filament/Resources/ClientResource/Pages/ListClients.php`:
Updated `Modules\TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php`:
- Added import for `SendNotificationBulkAction`
- Integrated the action into `getTableBulkActions()` method
- Maintained both existing coordinate update action and new notification action

## Features Implemented

### Modal Form Components

1. **Template Selection**
   - Select field populated with MailTemplate names and slugs
   - Searchable and preloaded for better UX
   - Required field validation

2. **Channel Selection**
   - CheckboxList with mail, SMS, and WhatsApp options
   - Multi-selection capability
   - 3-column layout for better visibility
   - Required field validation (at least one channel)

### Channel Support

1. **Mail Channel**
   - Automatically detects email fields (email, pec, contact_email)
   - Uses RecordNotification with Notification::route('mail', $email)

2. **SMS Channel**
   - Automatically detects phone fields (mobile, phone, telephone, contact_phone)
   - Normalizes phone numbers using NormalizePhoneNumberAction
   - Uses RecordNotification with Notification::route('sms', $normalized_phone)

3. **WhatsApp Channel**
   - Detects WhatsApp field, falls back to phone fields
   - Extracts text content from template using SpatieEmail::buildSms()
   - Uses WhatsAppNotification with Notification::route('whatsapp', $normalized_whatsapp)

## Architecture Compliance

This implementation aligns with:
- **Laraxot Philosophy**: Proper separation of concerns
- **Clean Code Principles**: Single responsibility, reusability
- **DRY + KISS**: Leveraged existing components
- **Spatie QueueableAction Pattern**: Proper business logic implementation
- **Filament Best Practices**: XotBase extension pattern

## Code Quality Verification

✅ **PHPStan Level 10**: All files pass static analysis  
✅ **Type Safety**: Proper return types and parameter validation  
✅ **Architecture Compliance**: Follows XotBase extension rules  
✅ **Documentation**: Updated with new implementation details  

## Usage Pattern

After implementation, users can:
1. Select multiple client records in the table
2. Click the "Send notifications" bulk action
3. Choose a MailTemplate from the dropdown
4. Select one or more channels (mail, SMS, WhatsApp)
5. Submit the form to send notifications

## Benefits Achieved

### 1. **Enhanced Functionality**
- Clients can now receive notifications via multiple channels
- Template-based approach ensures consistency
- Bulk processing improves efficiency

### 2. **User Experience**
- Intuitive modal interface
- Clear form validation
- Comprehensive feedback notifications

### 3. **Maintainability**
- Leverages existing, well-tested components
- Consistent with project architecture
- Easy to extend or modify

### 4. **Scalability**
- Supports multiple communication channels
- Proper error handling for large operations
- Follows established architectural patterns

## Files Modified/Added

### Added:
- `Modules/Notify/docs/bulk-notification-action.md` - Documentation for bulk notification action
- `Modules/Notify/docs/00-index.md` - Documentation index for Notify module

### Modified:
- `app/Filament/Resources/ClientResource/Pages/ListClients.php` - Integrated notification bulk action
- `Modules/TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php` - Integrated notification bulk action

## Future Considerations

- Additional channel support (Telegram, Slack, etc.)
- Advanced template personalization options
- Scheduling capabilities for notifications
- Enhanced reporting and analytics for sent notifications

---

*Documento conforme agli standard Laraxot - DRY + KISS + SOLID*
---

## notification-channels-implementation-1

*Consolidated from: `notification-channels-implementation.md`*


Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto <nome progetto>, con particolare attenzione al pattern Factory utilizzato.

## Architettura Generale

L'architettura dei canali di notifica segue un pattern coerente per tutti i tipi di comunicazione (SMS, WhatsApp, Telegram):

1. **Interfaccia comune**: Ogni tipo di comunicazione ha un'interfaccia dedicata
2. **DTO specifico**: Ogni tipo ha un DTO dedicato per i dati del messaggio
3. **Factory dedicata**: Ogni tipo ha una factory per la creazione delle azioni
4. **Canale di notifica**: Ogni tipo ha un canale per l'integrazione con Laravel
5. **Implementazioni per provider**: Ogni provider ha un'implementazione specifica

## Componenti per Tipo di Comunicazione

### SMS

- **Interfaccia**: `SmsActionInterface`
- **DTO**: `SmsData`
- **Factory**: `SmsActionFactory`
- **Canale**: `SmsChannel`
- **Azioni**: `SendSmsFactorSMSAction`, `SendTwilioSMSAction`, ecc.

### WhatsApp

- **Interfaccia**: `WhatsAppProviderActionInterface`
- **DTO**: `WhatsAppData`
- **Factory**: `WhatsAppActionFactory`
- **Canale**: `WhatsAppChannel`
- **Azioni**: `SendTwilioWhatsAppAction`, `SendFacebookWhatsAppAction`, ecc.

### Telegram

- **Interfaccia**: `TelegramProviderActionInterface`
- **DTO**: `TelegramData`
- **Factory**: `TelegramActionFactory`
- **Canale**: `TelegramChannel`
- **Azioni**: `SendOfficialTelegramAction`, `SendBotmanTelegramAction`, ecc.

## Pattern Factory

Il pattern Factory è stato implementato per centralizzare la logica di selezione del driver e la creazione delle azioni:

```php
// SmsActionFactory.php
public function create(?string $driver = null): SmsActionInterface
{
    $driver = $driver ?? Config::get('sms.default', 'smsfactor');

    return match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
}
```

Questo pattern offre diversi vantaggi:
- **Separazione delle responsabilità**: Ogni componente ha una responsabilità chiara
- **Riutilizzabilità**: La factory può essere utilizzata in qualsiasi punto dell'applicazione
- **Testabilità**: I componenti possono essere testati isolatamente
- **Flessibilità**: È possibile selezionare dinamicamente il driver
- **Estensibilità**: Nuovi driver possono essere aggiunti facilmente

## Utilizzo dei Canali di Notifica

### Definizione della Notifica

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return new SmsData(
            from: config('sms.from'),
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento domani alle 15:00"
        );
    }
}
```

### Invio della Notifica

```php
$user->notify(new AppointmentReminder());
```

### Utilizzo Diretto delle Factory

```php
// In un controller
public function sendManualSms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create();
    return $action->execute($smsData);
}

// Con override del driver
public function sendEmergencySms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create('twilio'); // Usa sempre Twilio per messaggi urgenti
    return $action->execute($smsData);
}
```

## Principi di Design

L'implementazione segue i principi SOLID:

1. **Single Responsibility Principle**: Ogni classe ha una sola responsabilità
2. **Open/Closed Principle**: Il sistema è aperto all'estensione ma chiuso alla modifica
3. **Liskov Substitution Principle**: Le implementazioni sono intercambiabili
4. **Interface Segregation Principle**: Le interfacce sono specifiche per ogni tipo
5. **Dependency Inversion Principle**: Le dipendenze sono verso astrazioni, non implementazioni

## Considerazioni sulla Manutenibilità

L'architettura implementata facilita la manutenibilità:

1. **Coerenza**: Tutti i tipi di comunicazione seguono lo stesso pattern
2. **Modularità**: I componenti possono essere modificati indipendentemente
3. **Estensibilità**: Nuovi provider possono essere aggiunti facilmente
4. **Testabilità**: I componenti possono essere testati isolatamente

## Regole per Future Implementazioni

1. **Interfacce**: Posizionare le interfacce in `Modules/Notify/app/Contracts/`
2. **DTO**: Posizionare i DTO in `Modules/Notify/app/Datas/`
3. **Factory**: Posizionare le factory in `Modules/Notify/app/Factories/`
4. **Canali**: Posizionare i canali in `Modules/Notify/app/Channels/`
5. **Azioni**: Posizionare le azioni in `Modules/Notify/app/Actions/{Tipo}/`
6. **Configurazioni**: Posizionare le configurazioni in `Modules/Notify/config/`

## Conclusione

L'implementazione dei canali di notifica  segue un'architettura coerente e ben strutturata, basata sul pattern Factory. Questo approccio garantisce separazione delle responsabilità, riutilizzabilità, testabilità e manutenibilità, facilitando l'estensione del sistema con nuovi provider e tipi di comunicazione.

## Collegamenti a Documentazione Correlata
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./ARCHITECTURE.md)
- [Modelli di Email](./EMAIL_TEMPLATES.md)
- [Implementazione SMS](./SMS_IMPLEMENTATION.md)
- [Modelli di Email](../../email_templates.md)
- [Implementazione SMS](../../sms_implementation.md)
- [Risoluzione dei Problemi](./TROUBLESHOOTING.md)

---

## notification-channels-implementation-2

*Consolidated from: `notification-channels-implementation.md`*

title: "Implementazione dei Canali di Notifica"
type: concept
tags: [notification, channels, implementation]
created: 2026-07-14
updated: 2026-07-14
qmd: "notification-channels-implementation-2 implementazione dei canali di notifica"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Implementazione dei Canali di Notifica 

Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto App, con particolare attenzione al pattern Factory utilizzato.

## Architettura Generale

L'architettura dei canali di notifica segue un pattern coerente per tutti i tipi di comunicazione (SMS, WhatsApp, Telegram):

1. **Interfaccia comune**: Ogni tipo di comunicazione ha un'interfaccia dedicata
2. **DTO specifico**: Ogni tipo ha un DTO dedicato per i dati del messaggio
3. **Factory dedicata**: Ogni tipo ha una factory per la creazione delle azioni
4. **Canale di notifica**: Ogni tipo ha un canale per l'integrazione con Laravel
5. **Implementazioni per provider**: Ogni provider ha un'implementazione specifica

## Componenti per Tipo di Comunicazione

### SMS

- **Interfaccia**: `SmsActionInterface`
- **DTO**: `SmsData`
- **Factory**: `SmsActionFactory`
- **Canale**: `SmsChannel`
- **Azioni**: `SendSmsFactorSMSAction`, `SendTwilioSMSAction`, ecc.

### WhatsApp

- **Interfaccia**: `WhatsAppProviderActionInterface`
- **DTO**: `WhatsAppData`
- **Factory**: `WhatsAppActionFactory`
- **Canale**: `WhatsAppChannel`
- **Azioni**: `SendTwilioWhatsAppAction`, `SendFacebookWhatsAppAction`, ecc.

### Telegram

- **Interfaccia**: `TelegramProviderActionInterface`
- **DTO**: `TelegramData`
- **Factory**: `TelegramActionFactory`
- **Canale**: `TelegramChannel`
- **Azioni**: `SendOfficialTelegramAction`, `SendBotmanTelegramAction`, ecc.

## Pattern Factory

Il pattern Factory è stato implementato per centralizzare la logica di selezione del driver e la creazione delle azioni:

```php
// SmsActionFactory.php
public function create(?string $driver = null): SmsActionInterface
{
    $driver = $driver ?? Config::get('sms.default', 'smsfactor');
    
    return match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
}
```

Questo pattern offre diversi vantaggi:
- **Separazione delle responsabilità**: Ogni componente ha una responsabilità chiara
- **Riutilizzabilità**: La factory può essere utilizzata in qualsiasi punto dell'applicazione
- **Testabilità**: I componenti possono essere testati isolatamente
- **Flessibilità**: È possibile selezionare dinamicamente il driver
- **Estensibilità**: Nuovi driver possono essere aggiunti facilmente

## Utilizzo dei Canali di Notifica

### Definizione della Notifica

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }
    
    public function toSms($notifiable)
    {
        return new SmsData(
            from: config('sms.from'),
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento domani alle 15:00"
        );
    }
}
```

### Invio della Notifica

```php
$user->notify(new AppointmentReminder());
```

### Utilizzo Diretto delle Factory

```php
// In un controller
public function sendManualSms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create();
    return $action->execute($smsData);
}

// Con override del driver
public function sendEmergencySms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create('twilio'); // Usa sempre Twilio per messaggi urgenti
    return $action->execute($smsData);
}
```

## Principi di Design

L'implementazione segue i principi SOLID:

1. **Single Responsibility Principle**: Ogni classe ha una sola responsabilità
2. **Open/Closed Principle**: Il sistema è aperto all'estensione ma chiuso alla modifica
3. **Liskov Substitution Principle**: Le implementazioni sono intercambiabili
4. **Interface Segregation Principle**: Le interfacce sono specifiche per ogni tipo
5. **Dependency Inversion Principle**: Le dipendenze sono verso astrazioni, non implementazioni

## Considerazioni sulla Manutenibilità

L'architettura implementata facilita la manutenibilità:

1. **Coerenza**: Tutti i tipi di comunicazione seguono lo stesso pattern
2. **Modularità**: I componenti possono essere modificati indipendentemente
3. **Estensibilità**: Nuovi provider possono essere aggiunti facilmente
4. **Testabilità**: I componenti possono essere testati isolatamente

## Regole per Future Implementazioni

1. **Interfacce**: Posizionare le interfacce in `Modules/Notify/app/Contracts/`
2. **DTO**: Posizionare i DTO in `Modules/Notify/app/Datas/`
3. **Factory**: Posizionare le factory in `Modules/Notify/app/Factories/`
4. **Canali**: Posizionare i canali in `Modules/Notify/app/Channels/`
5. **Azioni**: Posizionare le azioni in `Modules/Notify/app/Actions/{Tipo}/`
6. **Configurazioni**: Posizionare le configurazioni in `Modules/Notify/config/`

## Conclusione

L'implementazione dei canali di notifica  segue un'architettura coerente e ben strutturata, basata sul pattern Factory. Questo approccio garantisce separazione delle responsabilità, riutilizzabilità, testabilità e manutenibilità, facilitando l'estensione del sistema con nuovi provider e tipi di comunicazione.


## Collegamenti a Documentazione Correlata
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./architecture.md)
- [Modelli di Email](./email-templates.md)
- [Modelli di Email](../../email-templates.md)
- [Implementazione SMS](./sms-implementation.md)
- [Risoluzione dei Problemi](./troubleshooting.md)
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./architecture.md)
- [Modelli di Email](./email-templates.md)
- [Implementazione SMS](./sms-implementation.md)
- [Modelli di Email](../../email-templates.md)
- [Implementazione SMS](../../sms-implementation.md)
- [Risoluzione dei Problemi](./troubleshooting.md)
---

## notification-channels-implementation

*Consolidated from: `notification-channels-implementation.md`*


Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto , con particolare attenzione al pattern Factory utilizzato.
Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto <nome progetto>, con particolare attenzione al pattern Factory utilizzato.

## Architettura Generale

L'architettura dei canali di notifica segue un pattern coerente per tutti i tipi di comunicazione (SMS, WhatsApp, Telegram):

1. **Interfaccia comune**: Ogni tipo di comunicazione ha un'interfaccia dedicata
2. **DTO specifico**: Ogni tipo ha un DTO dedicato per i dati del messaggio
3. **Factory dedicata**: Ogni tipo ha una factory per la creazione delle azioni
4. **Canale di notifica**: Ogni tipo ha un canale per l'integrazione con Laravel
5. **Implementazioni per provider**: Ogni provider ha un'implementazione specifica

## Componenti per Tipo di Comunicazione

### SMS

- **Interfaccia**: `SmsActionInterface`
- **DTO**: `SmsData`
- **Factory**: `SmsActionFactory`
- **Canale**: `SmsChannel`
- **Azioni**: `SendSmsFactorSMSAction`, `SendTwilioSMSAction`, ecc.

### WhatsApp

- **Interfaccia**: `WhatsAppProviderActionInterface`
- **DTO**: `WhatsAppData`
- **Factory**: `WhatsAppActionFactory`
- **Canale**: `WhatsAppChannel`
- **Azioni**: `SendTwilioWhatsAppAction`, `SendFacebookWhatsAppAction`, ecc.

### Telegram

- **Interfaccia**: `TelegramProviderActionInterface`
- **DTO**: `TelegramData`
- **Factory**: `TelegramActionFactory`
- **Canale**: `TelegramChannel`
- **Azioni**: `SendOfficialTelegramAction`, `SendBotmanTelegramAction`, ecc.

## Pattern Factory

Il pattern Factory è stato implementato per centralizzare la logica di selezione del driver e la creazione delle azioni:

```php
// SmsActionFactory.php
public function create(?string $driver = null): SmsActionInterface
{
    $driver = $driver ?? Config::get('sms.default', 'smsfactor');
    
    return match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
}
```

Questo pattern offre diversi vantaggi:
- **Separazione delle responsabilità**: Ogni componente ha una responsabilità chiara
- **Riutilizzabilità**: La factory può essere utilizzata in qualsiasi punto dell'applicazione
- **Testabilità**: I componenti possono essere testati isolatamente
- **Flessibilità**: È possibile selezionare dinamicamente il driver
- **Estensibilità**: Nuovi driver possono essere aggiunti facilmente

## Utilizzo dei Canali di Notifica

### Definizione della Notifica

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }
    
    public function toSms($notifiable)
    {
        return new SmsData(
            from: config('sms.from'),
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento domani alle 15:00"
        );
    }
}
```

### Invio della Notifica

```php
$user->notify(new AppointmentReminder());
```

### Utilizzo Diretto delle Factory

```php
// In un controller
public function sendManualSms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create();
    return $action->execute($smsData);
}

// Con override del driver
public function sendEmergencySms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create('twilio'); // Usa sempre Twilio per messaggi urgenti
    return $action->execute($smsData);
}
```

## Principi di Design

L'implementazione segue i principi SOLID:

1. **Single Responsibility Principle**: Ogni classe ha una sola responsabilità
2. **Open/Closed Principle**: Il sistema è aperto all'estensione ma chiuso alla modifica
3. **Liskov Substitution Principle**: Le implementazioni sono intercambiabili
4. **Interface Segregation Principle**: Le interfacce sono specifiche per ogni tipo
5. **Dependency Inversion Principle**: Le dipendenze sono verso astrazioni, non implementazioni

## Considerazioni sulla Manutenibilità

L'architettura implementata facilita la manutenibilità:

1. **Coerenza**: Tutti i tipi di comunicazione seguono lo stesso pattern
2. **Modularità**: I componenti possono essere modificati indipendentemente
3. **Estensibilità**: Nuovi provider possono essere aggiunti facilmente
4. **Testabilità**: I componenti possono essere testati isolatamente

## Regole per Future Implementazioni

1. **Interfacce**: Posizionare le interfacce in `Modules/Notify/app/Contracts/`
2. **DTO**: Posizionare i DTO in `Modules/Notify/app/Datas/`
3. **Factory**: Posizionare le factory in `Modules/Notify/app/Factories/`
4. **Canali**: Posizionare i canali in `Modules/Notify/app/Channels/`
5. **Azioni**: Posizionare le azioni in `Modules/Notify/app/Actions/{Tipo}/`
6. **Configurazioni**: Posizionare le configurazioni in `Modules/Notify/config/`

## Conclusione

L'implementazione dei canali di notifica  segue un'architettura coerente e ben strutturata, basata sul pattern Factory. Questo approccio garantisce separazione delle responsabilità, riutilizzabilità, testabilità e manutenibilità, facilitando l'estensione del sistema con nuovi provider e tipi di comunicazione.


## Collegamenti a Documentazione Correlata
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./architecture.md)
- [Modelli di Email](./email_templates.md)
- [Implementazione SMS](./sms_implementation.md)
- [Modelli di Email](../../email_templates.md)
- [Implementazione SMS](../../sms_implementation.md)
- [Risoluzione dei Problemi](./troubleshooting.md)


---

## notification-errors-1

*Consolidated from: `notification-errors.md`*

title: "Errori Comuni nelle Notifiche"
type: concept
tags: [notification, errors]
created: 2026-07-14
updated: 2026-07-14
qmd: "notification-errors-1 errori comuni nelle notifiche"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Errori Comuni nelle Notifiche

## 1. Errore Destinatario Mancante

### Errore
```
Symfony\Component\Mime\Exception\LogicException
An email must have a "To", "Cc", or "Bcc" header.
```

### Causa
- Destinatario non specificato o null
- Dati non validati prima dell'invio
- Problemi con il routing delle notifiche

### Soluzione
1. **Validazione Dati**:
   ```php
   if (empty($data['to']) || !filter_var($data['to'], FILTER_VALIDATE_EMAIL)) {
       throw new \InvalidArgumentException('Indirizzo email non valido');
   }
   ```

2. **Routing Corretto con Queueable Action**:
   ```php
   // Definizione dell'Action
   class SendNotificationAction
   {
       use QueueableAction;

       public function __construct(
           protected string $to,
           protected array $data
       ) {}

       public function execute()
       {
           Notification::route('mail', $this->to)
               ->notify(new YourNotification($this->data));
       }
   }

   // Utilizzo dell'Action
   SendNotificationAction::make($data['to'], $data)
       ->onQueue('notifications')
       ->execute();
   ```

3. **Gestione Errori**:
   ```php
   try {
       SendNotificationAction::make($data['to'], $data)
           ->onQueue('notifications')
           ->execute();
   } catch (\Exception $e) {
       Log::error('Errore invio notifica: ' . $e->getMessage());
       throw $e;
   }
   ```

## 2. Best Practices

### Validazione
- Validare sempre i dati in ingresso
- Usare le regole di validazione Laravel
- Verificare i tipi di dati

### Queueable Actions
- Usare Actions per la logica di business
- Separare la logica in Actions riutilizzabili
- Utilizzare le code per operazioni pesanti

### Gestione Errori
- Usare try/catch
- Loggare gli errori
- Fornire feedback appropriato

## 3. Struttura Corretta

### Action
```php
class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        protected string $to,
        protected array $data
    ) {}

    public function execute()
    {
        $this->validate();
        
        Notification::route('mail', $this->to)
            ->notify(new YourNotification($this->data));
    }

    protected function validate()
    {
        if (empty($this->to) || !filter_var($this->to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Indirizzo email non valido');
        }
    }
}
```

### Controller
```php
public function sendNotification(Request $request)
{
    $validated = $request->validate([
        'to' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string'
    ]);

    try {
        SendNotificationAction::make($validated['to'], $validated)
            ->onQueue('notifications')
            ->execute();
    } catch (\Exception $e) {
        Log::error('Errore invio notifica: ' . $e->getMessage());
        return back()->with('error', 'Errore nell\'invio della notifica');
    }
}
```

### Notification Class
```php
class YourNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['subject'])
            ->line($this->data['body']);
    }
}
```

## 4. Debugging

### Log
- Abilitare il logging delle notifiche
- Controllare i log per errori
- Verificare le configurazioni

### Test
- Testare con dati validi
- Verificare su vari canali
- Controllare i limiti

## 5. Collegamenti Utili

- [Documentazione Laravel Notifications](https://laravel.com/docs/notifications)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Best Practices Email](https://www.campaignmonitor.com/dev-resources/guides/coding-html-emails/) 
---

## notification-errors

*Consolidated from: `notification-errors.md`*


## 1. Errore Destinatario Mancante

### Errore
```
Symfony\Component\Mime\Exception\LogicException
An email must have a "To", "Cc", or "Bcc" header.
```

### Causa
- Destinatario non specificato o null
- Dati non validati prima dell'invio
- Problemi con il routing delle notifiche

### Soluzione
1. **Validazione Dati**:
   ```php
   if (empty($data['to']) || !filter_var($data['to'], FILTER_VALIDATE_EMAIL)) {
       throw new \InvalidArgumentException('Indirizzo email non valido');
   }
   ```

2. **Routing Corretto con Queueable Action**:
   ```php
   // Definizione dell'Action
   class SendNotificationAction
   {
       use QueueableAction;

       public function __construct(
           protected string $to,
           protected array $data
       ) {}

       public function execute()
       {
           Notification::route('mail', $this->to)
               ->notify(new YourNotification($this->data));
       }
   }

   // Utilizzo dell'Action
   SendNotificationAction::make($data['to'], $data)
       ->onQueue('notifications')
       ->execute();
   ```

3. **Gestione Errori**:
   ```php
   try {
       SendNotificationAction::make($data['to'], $data)
           ->onQueue('notifications')
           ->execute();
   } catch (\Exception $e) {
       Log::error('Errore invio notifica: ' . $e->getMessage());
       throw $e;
   }
   ```

## 2. Best Practices

### Validazione
- Validare sempre i dati in ingresso
- Usare le regole di validazione Laravel
- Verificare i tipi di dati

### Queueable Actions
- Usare Actions per la logica di business
- Separare la logica in Actions riutilizzabili
- Utilizzare le code per operazioni pesanti

### Gestione Errori
- Usare try/catch
- Loggare gli errori
- Fornire feedback appropriato

## 3. Struttura Corretta

### Action
```php
class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        protected string $to,
        protected array $data
    ) {}

    public function execute()
    {
        $this->validate();
        
        Notification::route('mail', $this->to)
            ->notify(new YourNotification($this->data));
    }

    protected function validate()
    {
        if (empty($this->to) || !filter_var($this->to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Indirizzo email non valido');
        }
    }
}
```

### Controller
```php
public function sendNotification(Request $request)
{
    $validated = $request->validate([
        'to' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string'
    ]);

    try {
        SendNotificationAction::make($validated['to'], $validated)
            ->onQueue('notifications')
            ->execute();
    } catch (\Exception $e) {
        Log::error('Errore invio notifica: ' . $e->getMessage());
        return back()->with('error', 'Errore nell\'invio della notifica');
    }
}
```

### Notification Class
```php
class YourNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['subject'])
            ->line($this->data['body']);
    }
}
```

## 4. Debugging

### Log
- Abilitare il logging delle notifiche
- Controllare i log per errori
- Verificare le configurazioni

### Test
- Testare con dati validi
- Verificare su vari canali
- Controllare i limiti

## 5. Collegamenti Utili

- [Documentazione Laravel Notifications](https://laravel.com/docs/notifications)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Best Practices Email](https://www.campaignmonitor.com/dev-resources/guides/coding-html-emails/) 
---

## notification-implementation

*Consolidated from: `notification-implementation.md`*


## Overview
We are adding a bulk action to trigger notifications using `RecordNotification`.

## Components

### 1. Spatie Queueable Action
- **Path**: `Modules/Notify/app/Actions/SendRecordNotificationAction.php`
- **Responsibility**: Execute the notification sending logic.
- **Inputs**: `Model $record`, `string $slug`, `array $channels`.

### 2. Filament Bulk Action
- **Path**: `Modules/Notify/app/Filament/Actions/SendNotificationBulkAction.php`
- **Responsibility**: UI for user input (Template, Channels).
- **Inputs**: Selection of records.

### 3. Integration
- Integrated into `app/Filament/Resources/ClientResource/Pages/ListClients.php`.
- Integrated into `Modules/TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php`.

## Data Flow
Customer List -> Bulk Action -> Modal (Select Template + Channels) -> Submit -> Loop Records -> SendRecordNotificationAction -> Notification::route -> RecordNotification

## Validation
- phpstan (level 10/max)
- phpmd
- phpinsights

## Refactoring Notes

### Composizione Actions (DRY Pattern)

- **SendRecordsNotificationBulkAction**: Composes `SendRecordNotificationAction` instead of duplicating logic (DRY pattern).
- **SendRecordsNotificationBulkAction (Renaming & Delegation)**:
    - **Renaming**: Changed to plural `SendRecords...` to clearly indicate it handles a collection of records.
    - **Delegation**: Now delegates the per-record logic to `SendRecordNotificationAction`.
    - **Reasoning**: Applies DRY and KISS. The logic to send to *one* record exists in `SendRecordNotificationAction`. The Bulk action should only care about iteration and result aggregation, not the sending implementation details.

Vedi: [DRY Composition Pattern](./dry-composition-pattern.md)
Vedi: [DRY Composition Pattern](../../dry-composition-pattern.md)

### Estrazione Attributi Contatti (DRY Pattern)

- **SendRecordNotificationAction**: Refactored `getRecordEmail()`, `getRecordPhone()`, `getRecordWhatsApp()` per eliminare duplicazione.
    - **Prima**: ~45 righe di codice duplicato (stesso pattern: offsetExists, getAttribute, validazione)
    - **Dopo**: Metodo generico `extractRecordAttribute()` (~25 righe) + 3 wrapper semplici (~15 righe totali)
    - **Risparmio**: ~30 righe di codice duplicato eliminate
    - **Pattern**: Metodo generico con validator opzionale per validazione custom (es. email validation)
    - **Reasoning**: DRY + KISS. Logica di estrazione centralizzata in un metodo, wrapper mantengono semantica chiara.

Vedi: [Contact Extraction Pattern](./contact-extraction-pattern.md)
Vedi: [Contact Extraction Pattern](../../contact-extraction-pattern.md)

### Dependency Resolution (Runtime Service Resolution)

- **SendRecordNotificationAction**: Uses `app(NormalizePhoneNumberAction::class)->execute()` for phone normalization (no constructor injection).
    - **Reasoning**: Spatie Queueable Actions are serialized when queued. Constructor dependencies can cause serialization issues or unnecessary overhead. Using `app()` inside methods ensures lazy loading and cleaner serialization.
    - **Philosophy**: Keep Actions simple, stateless, and serialization-friendly.

Vedi: [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md)
Vedi: [Actions Calling Actions Pattern](../../actions-calling-actions-pattern.md)


---

## notification-providers-guide-1

*Consolidated from: `notification-providers-guide.md`*


Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di <nome progetto>.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;

    // Costruttore con configurazione

    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),

    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],

    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_ARCHITECTURE.md](./PROVIDER_ACTIONS_ARCHITECTURE.md)
- [SMS_ACTIONS_PATTERN.md](./SMS_ACTIONS_PATTERN.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](./WHATSAPP_PROVIDER_ARCHITECTURE.md)
- [PROVIDER_ACTIONS_ARCHITECTURE.md](../../provider_actions_architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms_actions_pattern.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](../../whatsapp_provider_architecture.md)

---

## notification-providers-guide-2

*Consolidated from: `notification-providers-guide.md`*

title: "Guida Completa ai Provider di Notifiche"
type: guide
tags: [notification, providers, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "notification-providers-guide-2 guida completa ai provider di notifiche"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida Completa ai Provider di Notifiche

Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di <nome progetto>.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;

    // Costruttore con configurazione

    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),

    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],

    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_architecture.md](./provider-actions-architecture.md)
- [SMS_ACTIONS_PATTERN.md](./sms-actions-pattern.md)
- [WHATSAPP_PROVIDER_architecture.md](./whatsapp-provider-architecture.md)
- [PROVIDER_ACTIONS_architecture.md](./provider-actions-architecture.md)
- [SMS_ACTIONS_PATTERN.md](./sms-actions-pattern.md)
- [WHATSAPP_PROVIDER_architecture.md](./whatsapp-provider-architecture.md)
- [PROVIDER_ACTIONS_architecture.md](../../provider-actions-architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms-actions-pattern.md)
- [WHATSAPP_PROVIDER_architecture.md](../../whatsapp-provider-architecture.md)
- [PROVIDER_ACTIONS_architecture.md](../../provider-actions-architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms-actions-pattern.md)
- [WHATSAPP_PROVIDER_architecture.md](../../whatsapp-provider-architecture.md)

---

## notification-providers-guide

*Consolidated from: `notification-providers-guide.md`*


Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di .
Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di <nome progetto>.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;
    
    // Costruttore con configurazione
    
    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),
    
    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],
    
    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_ARCHITECTURE.md](./PROVIDER_ACTIONS_ARCHITECTURE.md)
- [SMS_ACTIONS_PATTERN.md](./SMS_ACTIONS_PATTERN.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](./WHATSAPP_PROVIDER_ARCHITECTURE.md)
- [PROVIDER_ACTIONS_ARCHITECTURE.md](../../provider_actions_architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms_actions_pattern.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](../../whatsapp_provider_architecture.md)

---

## notification-providers

*Consolidated from: `notification-providers.md`*


Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di App.
Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di Quaeris.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;
    
    // Costruttore con configurazione
    
    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),
    
    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],
    
    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_ARCHITECTURE.md](./provider_actions_architecture.md)
- [SMS_ACTIONS_PATTERN.md](./sms_actions_pattern.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](./whatsapp_provider_architecture.md)
- [PROVIDER_ACTIONS_ARCHITECTURE.md](../../provider_actions_architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms_actions_pattern.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](../../whatsapp_provider_architecture.md)

---

## notification-system

*Consolidated from: `notification-system.md`*


---

## notification_behavior

*Consolidated from: `notification_behavior.md`*


## Notification Channels Behavior

### Issue: Unexpected SMS Channel Execution

When sending a notification with multiple channels (e.g., mail and SMS), Laravel will attempt to send through all specified channels in the `via()` method, even if not all channels are used in the notification call.

**Example from `RegisterAction.php`:**
```php
Notification::route('mail', $data['email'])
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

**Problem:**
Even though only the mail channel is explicitly routed, the `toSms()` method is still called because:

1. The `via()` method in `RecordNotification` returns both `['mail', SmsChannel::class]`
2. Laravel's notification system will attempt to send through all channels specified in `via()`
3. If a channel is not properly routed (like SMS in this case), it will cause errors

### Solution 1: Route All Required Channels

```php
Notification::route('mail', $data['email'])
    ->route('sms', $data['phone'])  // Add phone number if available
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```

### Solution 2: Make SMS Optional

Modify the `toSms()` method to handle cases where the recipient doesn't have a phone number:

```php
public function toSms($notifiable)
{
    if (empty($notifiable->routeNotificationFor('sms'))) {
        return null;
    }
    
    return SmsData::from([
        'from' => config('app.name'),
        'to' => $notifiable->routeNotificationFor('sms'),
        'body' => 'Your notification message here'
    ]);
}
```

### Solution 3: Dynamic Channel Selection

Modify the `via()` method to only return channels that are properly routed:

```php
public function via($notifiable)
{
    $channels = [];
    
    if ($notifiable->routeNotificationFor('mail')) {
        $channels[] = 'mail';
    }
    
    if ($notifiable->routeNotificationFor('sms')) {
        $channels[] = SmsChannel::class;
    }
    
    return $channels;
}
```

## Best Practices

1. **Always check if a channel is properly routed** before attempting to use it
2. **Make notification channels optional** when possible
3. **Validate recipient information** before sending notifications
4. **Use queueable notifications** for better performance
5. **Log notification failures** for debugging purposes

## Related Documentation

- [Laravel Notification Channels](https://laravel.com/docs/notifications#specifying-delivery-channels)
- [Laravel Notification Routing](https://laravel.com/docs/notifications#routing-notifications)
- [Notification Best Practices](best-practices.md)
- [Notification Best Practices](../../best-practices.md)

---

## notification_channels_implementation

*Consolidated from: `notification_channels_implementation.md`*

# Implementazione dei Canali di Notifica

Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto <nome progetto>, con particolare attenzione al pattern Factory utilizzato.
# Implementazione dei Canali di Notifica 

Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto SaluteOra, con particolare attenzione al pattern Factory utilizzato.

## Architettura Generale

L'architettura dei canali di notifica segue un pattern coerente per tutti i tipi di comunicazione (SMS, WhatsApp, Telegram):

1. **Interfaccia comune**: Ogni tipo di comunicazione ha un'interfaccia dedicata
2. **DTO specifico**: Ogni tipo ha un DTO dedicato per i dati del messaggio
3. **Factory dedicata**: Ogni tipo ha una factory per la creazione delle azioni
4. **Canale di notifica**: Ogni tipo ha un canale per l'integrazione con Laravel
5. **Implementazioni per provider**: Ogni provider ha un'implementazione specifica

## Componenti per Tipo di Comunicazione

### SMS

- **Interfaccia**: `SmsActionInterface`
- **DTO**: `SmsData`
- **Factory**: `SmsActionFactory`
- **Canale**: `SmsChannel`
- **Azioni**: `SendSmsFactorSMSAction`, `SendTwilioSMSAction`, ecc.

### WhatsApp

- **Interfaccia**: `WhatsAppProviderActionInterface`
- **DTO**: `WhatsAppData`
- **Factory**: `WhatsAppActionFactory`
- **Canale**: `WhatsAppChannel`
- **Azioni**: `SendTwilioWhatsAppAction`, `SendFacebookWhatsAppAction`, ecc.

### Telegram

- **Interfaccia**: `TelegramProviderActionInterface`
- **DTO**: `TelegramData`
- **Factory**: `TelegramActionFactory`
- **Canale**: `TelegramChannel`
- **Azioni**: `SendOfficialTelegramAction`, `SendBotmanTelegramAction`, ecc.

## Pattern Factory

Il pattern Factory è stato implementato per centralizzare la logica di selezione del driver e la creazione delle azioni:

```php
// SmsActionFactory.php
public function create(?string $driver = null): SmsActionInterface
{
    $driver = $driver ?? Config::get('sms.default', 'smsfactor');

    
    return match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
}
```

Questo pattern offre diversi vantaggi:
- **Separazione delle responsabilità**: Ogni componente ha una responsabilità chiara
- **Riutilizzabilità**: La factory può essere utilizzata in qualsiasi punto dell'applicazione
- **Testabilità**: I componenti possono essere testati isolatamente
- **Flessibilità**: È possibile selezionare dinamicamente il driver
- **Estensibilità**: Nuovi driver possono essere aggiunti facilmente

## Utilizzo dei Canali di Notifica

### Definizione della Notifica

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    
    public function toSms($notifiable)
    {
        return new SmsData(
            from: config('sms.from'),
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento domani alle 15:00"
        );
    }
}
```

### Invio della Notifica

```php
$user->notify(new AppointmentReminder());
```

### Utilizzo Diretto delle Factory

```php
// In un controller
public function sendManualSms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create();
    return $action->execute($smsData);
}

// Con override del driver
public function sendEmergencySms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create('twilio'); // Usa sempre Twilio per messaggi urgenti
    return $action->execute($smsData);
}
```

## Principi di Design

L'implementazione segue i principi SOLID:

1. **Single Responsibility Principle**: Ogni classe ha una sola responsabilità
2. **Open/Closed Principle**: Il sistema è aperto all'estensione ma chiuso alla modifica
3. **Liskov Substitution Principle**: Le implementazioni sono intercambiabili
4. **Interface Segregation Principle**: Le interfacce sono specifiche per ogni tipo
5. **Dependency Inversion Principle**: Le dipendenze sono verso astrazioni, non implementazioni

## Considerazioni sulla Manutenibilità

L'architettura implementata facilita la manutenibilità:

1. **Coerenza**: Tutti i tipi di comunicazione seguono lo stesso pattern
2. **Modularità**: I componenti possono essere modificati indipendentemente
3. **Estensibilità**: Nuovi provider possono essere aggiunti facilmente
4. **Testabilità**: I componenti possono essere testati isolatamente

## Regole per Future Implementazioni

1. **Interfacce**: Posizionare le interfacce in `Modules/Notify/app/Contracts/`
2. **DTO**: Posizionare i DTO in `Modules/Notify/app/Datas/`
3. **Factory**: Posizionare le factory in `Modules/Notify/app/Factories/`
4. **Canali**: Posizionare i canali in `Modules/Notify/app/Channels/`
5. **Azioni**: Posizionare le azioni in `Modules/Notify/app/Actions/{Tipo}/`
6. **Configurazioni**: Posizionare le configurazioni in `Modules/Notify/config/`

## Conclusione

L'implementazione dei canali di notifica  segue un'architettura coerente e ben strutturata, basata sul pattern Factory. Questo approccio garantisce separazione delle responsabilità, riutilizzabilità, testabilità e manutenibilità, facilitando l'estensione del sistema con nuovi provider e tipi di comunicazione.


## Collegamenti a Documentazione Correlata
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./ARCHITECTURE.md)
- [Modelli di Email](./EMAIL_TEMPLATES.md)
- [Implementazione SMS](./SMS_IMPLEMENTATION.md)
- [Modelli di Email](../../email_templates.md)
- [Implementazione SMS](../../sms_implementation.md)
- [Risoluzione dei Problemi](./TROUBLESHOOTING.md)


---

## notification_errors

*Consolidated from: `notification_errors.md`*


## 1. Errore Destinatario Mancante

### Errore
```
Symfony\Component\Mime\Exception\LogicException
An email must have a "To", "Cc", or "Bcc" header.
```

### Causa
- Destinatario non specificato o null
- Dati non validati prima dell'invio
- Problemi con il routing delle notifiche

### Soluzione
1. **Validazione Dati**:
   ```php
   if (empty($data['to']) || !filter_var($data['to'], FILTER_VALIDATE_EMAIL)) {
       throw new \InvalidArgumentException('Indirizzo email non valido');
   }
   ```

2. **Routing Corretto con Queueable Action**:
   ```php
   // Definizione dell'Action
   class SendNotificationAction
   {
       use QueueableAction;

       public function __construct(
           protected string $to,
           protected array $data
       ) {}

       public function execute()
       {
           Notification::route('mail', $this->to)
               ->notify(new YourNotification($this->data));
       }
   }

   // Utilizzo dell'Action
   SendNotificationAction::make($data['to'], $data)
       ->onQueue('notifications')
       ->execute();
   ```

3. **Gestione Errori**:
   ```php
   try {
       SendNotificationAction::make($data['to'], $data)
           ->onQueue('notifications')
           ->execute();
   } catch (\Exception $e) {
       Log::error('Errore invio notifica: ' . $e->getMessage());
       throw $e;
   }
   ```

## 2. Best Practices

### Validazione
- Validare sempre i dati in ingresso
- Usare le regole di validazione Laravel
- Verificare i tipi di dati

### Queueable Actions
- Usare Actions per la logica di business
- Separare la logica in Actions riutilizzabili
- Utilizzare le code per operazioni pesanti

### Gestione Errori
- Usare try/catch
- Loggare gli errori
- Fornire feedback appropriato

## 3. Struttura Corretta

### Action
```php
class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        protected string $to,
        protected array $data
    ) {}

    public function execute()
    {
        $this->validate();
        
        Notification::route('mail', $this->to)
            ->notify(new YourNotification($this->data));
    }

    protected function validate()
    {
        if (empty($this->to) || !filter_var($this->to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Indirizzo email non valido');
        }
    }
}
```

### Controller
```php
public function sendNotification(Request $request)
{
    $validated = $request->validate([
        'to' => 'required|email',
        'subject' => 'required|string',
        'body' => 'required|string'
    ]);

    try {
        SendNotificationAction::make($validated['to'], $validated)
            ->onQueue('notifications')
            ->execute();
    } catch (\Exception $e) {
        Log::error('Errore invio notifica: ' . $e->getMessage());
        return back()->with('error', 'Errore nell\'invio della notifica');
    }
}
```

### Notification Class
```php
class YourNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['subject'])
            ->line($this->data['body']);
    }
}
```

## 4. Debugging

### Log
- Abilitare il logging delle notifiche
- Controllare i log per errori
- Verificare le configurazioni

### Test
- Testare con dati validi
- Verificare su vari canali
- Controllare i limiti

## 5. Collegamenti Utili

- [Documentazione Laravel Notifications](https://laravel.com/docs/notifications)
- [Documentazione Laravel Mail](https://laravel.com/docs/mail)
- [Documentazione Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Best Practices Email](https://www.campaignmonitor.com/dev-resources/guides/coding-html-emails/) 
---

## notification_providers_guide

*Consolidated from: `notification_providers_guide.md`*

# Guida Completa ai Provider di Notifiche

Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di <nome progetto>.
# Guida Completa ai Provider di Notifiche 

Questo documento fornisce una panoramica completa dell'architettura standardizzata per tutti i provider di notifiche supportati nel modulo Notify di SaluteOra.

## Principi Architetturali per Tutti i Provider

I seguenti principi si applicano a **tutti** i provider di notifiche (SMS, Email, WhatsApp):

1. **Struttura Directory Standardizzata**:
   - Interfacce: `/app/Contracts/`
   - Implementazioni: `/app/Actions/{Type}/`
   - Data Transfer Objects: `/app/Datas/`
   - Configurazioni: `/config/{type}.php`

2. **Nomenclatura Coerente**:
   - Interfacce: `{Type}ProviderActionInterface`
   - Azioni: `Send{Provider}{Type}Action`
   - DTO: `{Type}Data`

3. **Implementazione Interfacce**:
   - Ogni provider DEVE implementare l'interfaccia specifica
   - Ogni provider DEVE accettare il DTO appropriato nel metodo `execute()`

## Panoramica dei Provider Supportati

| Tipo di Provider | Interfaccia | Directory Azioni | DTO |
|------------------|-------------|-----------------|-----|
| SMS | `SmsProviderActionInterface` | `/app/Actions/SMS/` | `SmsData` |
| Email | `EmailProviderActionInterface` | `/app/Actions/Email/` | `EmailData` |
| WhatsApp | `WhatsAppProviderActionInterface` | `/app/Actions/WhatsApp/` | `WhatsAppData` |

## Implementazione Standardizzata

### 1. Definizione dell'Interfaccia Provider

```php
// app/Contracts/{Type}ProviderActionInterface.php
namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\{Type}Data;

interface {Type}ProviderActionInterface
{
    public function execute({Type}Data $data): array;
}
```

### 2. Implementazione Provider

```php
// app/Actions/{Type}/Send{Provider}{Type}Action.php
namespace Modules\Notify\Actions\{Type};

use Modules\Notify\Contracts\{Type}ProviderActionInterface;
use Modules\Notify\Datas\{Type}Data;
use Spatie\QueueableAction\QueueableAction;

final class Send{Provider}{Type}Action implements {Type}ProviderActionInterface
{
    use QueueableAction;

    // Costruttore con configurazione

    
    // Costruttore con configurazione
    
    // Metodo execute standardizzato
    public function execute({Type}Data $data): array
    {
        // Implementazione specifica del provider
    }
}
```

### 3. Configurazione Provider

```php
// config/{type}.php
return [
    'default' => env('{TYPE}_PROVIDER', 'default_provider'),

    
    'providers' => [
        'provider1' => [
            // Configurazione specifica
        ],
        'provider2' => [
            // Configurazione specifica
        ],
    ],

    
    // Parametri globali
    'from' => env('{TYPE}_FROM'),
    'debug' => (bool) env('{TYPE}_DEBUG', false),
    'timeout' => (int) env('{TYPE}_TIMEOUT', 30),
];
```

### 4. Canale di Notifica Laravel

```php
// app/Channels/{Type}Channel.php
namespace Modules\Notify\Channels;

use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\{Type}Data;

class {Type}Channel
{
    public function send($notifiable, Notification $notification): ?array
    {
        // Recupero provider dalla configurazione
        // Esecuzione azione appropriata
    }
}
```

## Flusso di Implementazione per Nuovi Provider

Quando si implementa un nuovo provider (es. WhatsApp, Push, ecc.):

1. **Creare l'Interfaccia** in `/app/Contracts/`
2. **Creare il DTO** in `/app/Datas/`
3. **Creare le Azioni Provider** in `/app/Actions/{Type}/`
4. **Creare la Configurazione** in `/config/{type}.php`
5. **Creare il Canale** in `/app/Channels/`
6. **Documentare** in `/docs/`

## Conclusioni e Migliori Pratiche

1. **Consistenza Architetturale**: Mantenere la stessa struttura per tutti i provider
2. **Single Responsibility**: Ogni classe ha una responsabilità specifica
3. **Dependency Injection**: Utilizzare DI per configurazioni e dipendenze
4. **Testing**: Creare test per ogni provider e canale
5. **Documentazione**: Mantenere aggiornata la documentazione con nuovi provider

Per implementazioni specifiche, vedere i documenti:
- [PROVIDER_ACTIONS_ARCHITECTURE.md](./PROVIDER_ACTIONS_ARCHITECTURE.md)
- [SMS_ACTIONS_PATTERN.md](./SMS_ACTIONS_PATTERN.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](./WHATSAPP_PROVIDER_ARCHITECTURE.md)
- [PROVIDER_ACTIONS_ARCHITECTURE.md](../../provider_actions_architecture.md)
- [SMS_ACTIONS_PATTERN.md](../../sms_actions_pattern.md)
- [WHATSAPP_PROVIDER_ARCHITECTURE.md](../../whatsapp_provider_architecture.md)

---

## notifications-system

*Consolidated from: `notifications-system.md`*


## Panoramica
Il sistema di notifiche utilizza `RecordNotification` come classe base per gestire tutte le notifiche dell'applicazione.

## RecordNotification

### Struttura Base
```php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;

class RecordNotification extends Notification
{
    protected $record;
    protected $type;
    protected $data;

    public function __construct($record, string $type, array $data = [])
    {
        $this->record = $record;
        $this->type = $type;
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->view($this->getView(), $this->getViewData());
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
            'record' => $this->record,
        ];
    }
}
```

## Implementazione

### Creazione Notifica
```php
// ❌ NON FARE
class DoctorRegistrationNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Registrazione Odontoiatra')
            ->view('emails.doctor.registration');
    }
}

// ✅ FARE
$notification = new RecordNotification(
    $doctor,
    'doctor.registration',
    [
        'subject' => 'Registrazione Odontoiatra',
        'view' => 'emails.doctor.registration',
    ]
);
```

### Template Email
```php
// resources/views/emails/doctor/registration.blade.php
@component('mail::message')

# {{ __('doctor.registration.title') }}

{{ __('doctor.registration.message') }}

@component('mail::button', ['url' => $url])
{{ __('doctor.registration.button') }}
@endcomponent

{{ __('doctor.registration.footer') }}
@endcomponent
```

### Traduzioni
```php
// lang/it/doctor.php
return [
    'registration' => [
        'title' => 'Registrazione Odontoiatra',
        'message' => 'La tua registrazione è stata ricevuta.',
        'button' => 'Vai al Profilo',
        'footer' => 'Grazie per esserti registrato.',
    ],
];
```

## Best Practices

### Tipi di Notifica
- Usare chiavi di traduzione per i tipi
- Mantenere i tipi consistenti
- Documentare i tipi disponibili

### Dati
- Includere solo dati necessari
- Validare i dati prima dell'invio
- Sanitizzare i dati sensibili

### Template
- Usare componenti Blade
- Mantenere il design consistente
- Supportare il tema scuro

## Metriche

### Performance
- Tempo di invio: <1s
- Tasso di consegna: >99%
- Tasso di apertura: >50%

### Monitoraggio
- Log delle notifiche
- Statistiche di invio
- Errori e retry

## Collegamenti
- [Documentazione API](./api.md)
- [Template Email](./templates.md)
- [Template Email](../../templates.md)
- [Guida Contribuzione](./contributing.md)

## Note
- Testare le notifiche in ambiente di sviluppo
- Monitorare i tassi di consegna
- Aggiornare i template regolarmente
- Mantenere le traduzioni aggiornate 

---

## notifications

*Consolidated from: `notifications.md`*


---

## notify-send-email-translations-improvements

*Consolidated from: `notify-send-email-translations-improvements.md`*


## Introduzione

Documento che descrive la sistemazione completa dei file di traduzione per la funzionalità `send_email.php` del modulo Notify, con risoluzione di problemi critici e implementazione di best practices.

## Collegamenti correlati
- [Documentazione Modulo Notify](/laravel/Modules/Notify/docs/index.md)
- [Best Practices Traduzioni](/docs/translation-system-rules.md)
- [Convenzioni PHP](/docs/php-best-practices.md)
- [Regole Qualità Codice](/docs/code-quality-rules.md)
- [Documentazione Sistema Notifiche](/laravel/Modules/Notify/docs/notification-system.md)

## Problemi Identificati e Risolti

### 🚨 Problemi Critici Risolti

#### 1. Conflitto di Merge Git Non Risolto
**File:** `/laravel/Modules/Notify/lang/en/send_email.php`

**Problema:**
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio Email',
        // ... contenuto italiano ...
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Send Email',
        // ... contenuto inglese ...
```

**Soluzione:**
- ✅ Risolto conflitto di merge completamente
- ✅ Mantenuto contenuto inglese corretto
- ✅ Aggiunto `declare(strict_types=1)` per best practices

#### 2. File Tedesco con Traduzioni Errate
**File:** `/laravel/Modules/Notify/lang/de/send_email.php`

**Problema:**
- Conteneva traduzioni italiane invece che tedesche
- Struttura incompleta (solo 120 righe vs 387 del file completo)

**Soluzione:**
- ✅ Sostituito completamente con traduzioni professionali tedesche
- ✅ Implementata struttura completa con tutte le sezioni
- ✅ Aggiunto `declare(strict_types=1)`

#### 3. Incompletezza File Inglese
**Problema:**
- Mancanza del 70% delle chiavi di traduzione
- Struttura limitata rispetto al file italiano di riferimento

**Soluzione:**
- ✅ Completato file inglese con tutte le sezioni mancanti:
  - `sections` (6 sezioni)
  - Campi aggiuntivi: `from_email`, `from_name`, `scheduled_at`, `category`, `tracking_enabled`
  - `status` (10 stati)
  - `priority_labels`
  - `email_components`
  - `tracking`
  - `categories`
  - `placeholders`
  - Validazioni dettagliate (25 regole)
  - Messaggi completi (16 messaggi)

## Struttura Finale Implementata

### Sezioni Principali

```php
return [
    'navigation' => [...],      // Navigazione interfaccia
    'sections' => [...],        // Sezioni UI organizzazione
    'fields' => [...],          // Campi form (15 campi)
    'actions' => [...],         // Azioni disponibili (6 azioni)
    'messages' => [...],        // Messaggi sistema (16 messaggi)
    'validation' => [...],      // Regole validazione (25 regole)
    'status' => [...],          // Stati email (10 stati)
    'priority_labels' => [...], // Etichette priorità
    'email_components' => [...],// Componenti email
    'tracking' => [...],        // Tracking engagement
    'categories' => [...],      // Categorie organizzazione
    'placeholders' => [...],    // Placeholder esempi
];
```

### Campi Completi Implementati

| Campo | Descrizione | Tipo |
|-------|-------------|------|
| `subject` | Oggetto email | String |
| `template_id` | Template predefinito | Select |
| `to` | Destinatario principale | Email |
| `cc` | Copia conoscenza | Email multiple |
| `bcc` | Copia nascosta | Email multiple |
| `from_email` | Email mittente custom | Email |
| `from_name` | Nome mittente custom | String |
| `content` | Contenuto testuale | Textarea |
| `body_html` | Contenuto HTML | HTML Editor |
| `parameters` | Parametri template | JSON |
| `attachments` | File allegati | File Upload |
| `priority` | Priorità invio | Enum |
| `scheduled_at` | Data programmazione | DateTime |
| `category` | Categoria email | Enum |
| `tracking_enabled` | Tracking abilitato | Boolean |

## Best Practices Applicate

### 1. Coding Standards PHP
```php
<?php

declare(strict_types=1);  // ✅ Type safety enforcement

return [                  // ✅ Modern array syntax (EN/DE)
    // oppure
return array (            // ✅ Legacy syntax mantenuta (IT)
```

### 2. Struttura Coerente
- ✅ Stessa organizzazione in tutte le lingue
- ✅ Stesse chiavi di traduzione in tutti i file
- ✅ Coerenza nei valori enum e opzioni

### 3. Completezza Traduzioni
- ✅ **Italiano**: 387 righe, struttura completa
- ✅ **Inglese**: 387 righe, traduzione professionale
- ✅ **Tedesco**: 387 righe, traduzione professionale

### 4. Convenzioni Denominazione
```php
// ✅ Convenzioni coerenti
'navigation' => [          // Navigazione principale
'fields' => [             // Campi form
'actions' => [            // Azioni utente  
'messages' => [           // Messaggi sistema
'validation' => [         // Regole validazione
```

## Funzionalità Avanzate Implementate

### 1. Sistema Sezioni UI
```php
'sections' => [
    'email_details' => [/* Dettagli principali */],
    'recipients' => [/* Configurazione destinatari */],
    'content' => [/* Contenuto e template */],
    'attachments' => [/* Gestione allegati */],
    'scheduling' => [/* Programmazione invio */],
    'advanced' => [/* Opzioni avanzate */],
],
```

### 2. Azioni Complete con Modal
```php
'actions' => [
    'send' => [
        'modal' => [
            'heading' => 'Confirm Email Sending',
            'confirm' => 'Send Email',
            'cancel' => 'Cancel',
        ],
    ],
    // ... altre azioni con modal
],
```

### 3. Validazioni Dettagliate
```php
'validation' => [
    'subject_required' => 'Email subject is required',
    'subject_max' => 'Subject cannot exceed 255 characters',
    'attachments_max' => 'Maximum number of attachments allowed: :max',
    'file_size_max' => 'Maximum file size: :max_size',
    // ... 25 regole totali
],
```

### 4. Sistema Tracking
```php
'tracking' => [
    'opened' => 'Email opened',
    'clicked' => 'Link clicked', 
    'device' => 'Device',
    'location' => 'Location',
    'open_count' => 'Times opened',
],
```

## Controllo Qualità

### Metriche Finali
- **Righe di codice**: 387 per file (vs 120-235 originali)
- **Chiavi traduzione**: 100+ per lingua
- **Sezioni implementate**: 11 sezioni complete
- **Copertura lingue**: 100% IT/EN/DE

### Verifiche Effettuate
- ✅ Sintassi PHP corretta in tutti i file
- ✅ Struttura array coerente
- ✅ Chiavi traduzione complete
- ✅ Traduzioni professionali per ogni lingua
- ✅ Best practices PHP applicate
- ✅ Nessun conflitto di merge residuo

## Impatto e Benefici

### 1. Stabilità Sistema
- ✅ Risolto conflitto di merge che causava errori
- ✅ Eliminati errori di traduzione mancanti
- ✅ Coerenza tra lingue garantita

### 2. Esperienza Utente
- ✅ Interfaccia completamente localizzata
- ✅ Messaggi di errore dettagliati
- ✅ Funzionalità avanzate disponibili in tutte le lingue

### 3. Manutenibilità
- ✅ Struttura standardizzata facilita aggiornamenti
- ✅ Best practices PHP applicate
- ✅ Documentazione completa per future modifiche

## Linee Guida per Sviluppi Futuri

### 1. Aggiunta Nuove Chiavi
```php
// ✅ Sempre aggiungere in tutte e 3 le lingue
'new_feature' => [
    'label' => 'EN: New Feature',      // en/send_email.php
    'label' => 'IT: Nuova Funzione',   // it/send_email.php  
    'label' => 'DE: Neue Funktion',    // de/send_email.php
],
```

### 2. Manutenzione Coerenza
- Verificare sempre che le modifiche siano applicate in tutte le lingue
- Mantenere la stessa struttura di chiavi
- Testare la funzionalità in tutte le lingue

### 3. Standard di Qualità
- Applicare sempre `declare(strict_types=1)`
- Utilizzare traduzioni professionali
- Documentare ogni modifica significativa

## Conclusioni

La sistemazione del file `send_email.php` ha risolto problemi critici e implementato un sistema di traduzioni robusto e completo. L'applicazione di best practices e la standardizzazione della struttura garantiscono un'esperienza utente coerente e facilita la manutenzione futura del sistema.

**Risultato**: Sistema di invio email completamente localizzato e funzionale in italiano, inglese e tedesco con oltre 100 chiavi di traduzione per ogni lingua e funzionalità avanzate per tracking, programmazione e gestione allegati. 
---

## notify-translation-guide-1

*Consolidated from: `notify-translation-guide.md`*


## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di <nome progetto>. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di <nome progetto>.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di <nome progetto>. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standard per le Traduzioni ](./TRANSLATION_STANDARDS.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
- [Standard per le Traduzioni ](../../translation_standards.md)

---

## notify-translation-guide-2

*Consolidated from: `notify-translation-guide.md`*

title: "Guida alle Traduzioni nel Modulo Notify"
type: guide
tags: [notify, translation, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "notify-translation-guide-2 guida alle traduzioni nel modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida alle Traduzioni nel Modulo Notify

## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di App. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di App.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di App. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](./translation-conventions-clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../lang/docs/translation-keys-rules.md)
- [Best Practices per le Chiavi di Traduzione](../../lang/docs/translation-keys-best-practices.md)
- [Standard per le Traduzioni ](./translation-standards.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](./translation-conventions-clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standard per le Traduzioni ](./translation-standards.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
- [Standard per le Traduzioni ](../../translation-standards.md)
---

## notify-translation-guide

*Consolidated from: `notify-translation-guide.md`*


## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di . Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di .
Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di <nome progetto>. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di <nome progetto>.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di . Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.
È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di <nome progetto>. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standard per le Traduzioni ](./TRANSLATION_STANDARDS.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
- [Standard per le Traduzioni ](../../translation_standards.md)

---

## notify-translation

*Consolidated from: `notify-translation.md`*


## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di . Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di .
Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di <nome progetto>. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di <nome progetto>.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di . Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.
È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di <nome progetto>. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](./translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../lang/docs/translation-keys-best-practices.md)
- [Standard per le Traduzioni ](./translation_standards.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation-keys-best-practices.md)
- [Standard per le Traduzioni ](../../translation_standards.md)

---

## notify_translation_guide

*Consolidated from: `notify_translation_guide.md`*


## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di <nome progetto>. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di <nome progetto>.
Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di SaluteOra. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di SaluteOra.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di <nome progetto>. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.
È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di SaluteOra. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standard per le Traduzioni ](./TRANSLATION_STANDARDS.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
- [Standard per le Traduzioni ](../../translation_standards.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04