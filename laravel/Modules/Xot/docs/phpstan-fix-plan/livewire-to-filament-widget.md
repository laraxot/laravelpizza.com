---
initiative: Migrazione da Livewire a Filament Widget
status: active
created: 2026-10-20
title: "BMAD: Perché Filament Widget (non più Livewire Componenti)"
type: note
updated: 2026-10-20
tags: [docs, xot, phpstan-fix-plan]
qmd: "bmad   perché filament widget (non più livewire componenti) xot"
---

# BMAD: Perché Filament Widget (non più Livewire Componenti)

## 1. Brainstorming: Scopo e Perché

**Scopo attuale nel codice:**
Il progetto utilizza `filament/filament` v5.8.4 come framework admin/panel. Esistono già `Filament/Widgets/` in moduli come `Gdpr`, `Lang`, `Job`. I componenti `Livewire` erano utilizzati per interfacce reattive, ma la gestione separata di Livewire + Filament crea duplicazione di pattern, duplicazione di stili CSS, duplicazione di logica di stato.

**Perché convertire tutto in Filament Widget:**
1. **Unico framework:** Filament v5 include già il supporto per widget (`Filament\Widgets\*`). Non serve mantenere due sistemi di componenti (Livewire standalone + Filament widget).
2. **Consistenza dell'architettura:** I moduli (`Gdpr`, `Lang`, `Job`) già hanno `app/Filament/Widgets/`. I componenti Livewire esistenti (`Activities`, `CanPaginate`) sono in realtà pagine/azioni Filament, non componenti Livewire autonomi.
3. **Manutenzione ridotta:** Un solo set di regole CSS (Tailwind via Filament), un solo set di componenti blade, un solo pattern di stato.
4. **Integrazione con il pannello:** I widget Filament si integrano direttamente nel pannello (`Modules/` panel) tramite `Filament/Widgets` con config JSON (`theme.json`), senza bisogno di registrare componenti Livewire separati.
5. **Performance e caching:** I widget Filament supportano caching dell'output (`cached`) e possono essere resi queueable se necessario (vedi conversione Queueable Actions).

**Perché NON è una cancellazione ma una migrazione:**
I componenti Livewire non vengono cancellati: la loro funzionalità (visualizzazione, paginazione, azioni) viene spostata in widget Filament equivalenti (`LanguageSwitcherWidget`, `QueueListenWidget`, `ScheduleStatusWidget`, `ClockWidget`, `JobStatusWidget`, `ScheduleCrudWidget`). Il codice business (`Actions`, `Services`) rimane intatto.

## 2. Methodology: BMAD Step

- **B (Brainstorm):** Fatto sopra. Scopo = coerenza architetturale, riduzione duplicazione, integrazione pannello.
- **M (Methodology):** Per ogni modulo con componenti Livewire (es. `CanPaginate` in Activity, `ListLogActivities` in Activity):
  a. Identificare la funzionalità (paginizazione, lista log, visualizzazione).
  b. Trovare o creare il widget Filament corrispondente (`Filament/Widgets/` o `Filament/Pages/`).
  c. Spostare la logica nel widget (`execute()` o `render()`).
  d. Rimuovere il componente Livewire standalone se non più usato.
  e. Aggiornare `docs/` con la mappa della migrazione.
- **A (Architecture):** La struttura finale: `app/Filament/Widgets/` per widget pannello, `app/Filament/Pages/` per pagine, `app/Filament/Actions/` per azioni. Nessun `Livewire/` standalone.
- **D (Documentation):** Per ogni modulo: `docs/livewire-to-filament-widget-plan.md` con inventario, decisioni, stato.

## 3. Filament Blueprint

Il `theme.json` (`Themes/Zero/theme.json`) definisce il pannello. Ogni modulo deve registrare i propri widget nel pannello tramite `Filament/Widgets/` e configurazione nel modulo (non nel tema). I widget devono usare:
- `Filament\Widgets\Widget` come base
- `render()` per il blade
- `execute()` se il widget ha una logica di coda (vedi Queueable Actions)

Il pattern `CanPaginate` in Activity è in realtà una `Page` (`ListLogActivities.php`), non un componente Livewire autonomo. Quindi non serve migrazione per quello.

## 4. Second Brain / Hindsight Note

> 🧠 **From Hindsight memory (AGENTS.md + docs)**: Il modulo `DbForge` usa `Spatie\QueueableAction\QueueableAction`; il modulo `Notify` ha `NotificationManager` convertito; il modulo `AI` ha `ClassifyTicketAction` e `SuggestSolutionsAction`. I componenti Livewire (`CanPaginate`) sono in realtà pagine Filament (`ListLogActivities`). La conversione non richiede cancellazione ma spostamento della logica nel pattern corretto.
