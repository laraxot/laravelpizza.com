---
title: "Base <nome progetto> Fila5: project.md"
type: concept
tags: [project]
created: 2026-07-14
updated: 2026-07-14
qmd: "project base <nome progetto> fila5: project.md"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "../../../00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "../../../acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Base <nome progetto> Fila5: project.md

## Context
Laravel + Filament v5 modular monolith (Laraxot architecture).
Theme: Sixteen (Bootstrap Italia → Tailwind parity).
Frontend wizard: Ticket creation wizard via `CreateTicketWizardWidget` (Filament v5 Schemas).

## Current Milestone
**M0: <nome progetto> Ticket Wizard: Visual & HTML Parity** ✅ DONE

Target: `segnalazione-crea` wizard page → 90%+ parity with Design Comuni `segnalazione-02-dati.html`

### Phase Results
- **Phase 1**: Filament Schemas correction ✅
  - Replaced non-existent `Text::make()` with `Placeholder` (HTML) + `TextEntry` (data)
  - Verified: `Filament\Schemas\Components\Text` does NOT exist
- **Phase 2**: Filament CSS Visual Parity ✅
  - Created `filament-wizard-parity.css` with scoped overrides
  - Added `app-test.css` as Vite entry point (841KB build)
  - Added Filament `.fi-*` classes to Tailwind safelist
  - Updated `test.blade.php` to use `app-test.css`
- **Phase 3**: Bootstrap Italia section structure ✅
  - 3 sections: Luogo, Disservizio, Autore
  - Grid 3-col for author data (name, fiscal code, phone)
  - TextEntry with icons for read-only author info
- **Phase 4**: Responsive parity: pending
- **Phase 5**: Multilingual verification: IT/EN translations verified

## Rules
- Filament Schemas = unified system (v5). Forms + Infolists coexist.
- Widget → NO model binding (`getFormModel() → null`)
- CSS scoped overrides → never mutate Filament markup
- Multilingual: all strings via `__('<nome progetto>::ticket.*')`

---

<!-- Merged from PROJECT.md, which collided with this file on case-insensitive filesystems. -->

# Base App Fila5: PROJECT.md
# Base <nome progetto> Fila5: PROJECT.md

## Context
Laravel + Filament v5 modular monolith (Laraxot architecture).
Theme: Sixteen (Bootstrap Italia → Tailwind parity).
Frontend wizard: Ticket creation wizard via `CreateTicketWizardWidget` (Filament v5 Schemas).

## Current Milestone
**M0: App Ticket Wizard: Visual & HTML Parity** ✅ DONE
**M0: <nome progetto> Ticket Wizard: Visual & HTML Parity** ✅ DONE

Target: `segnalazione-crea` wizard page → 90%+ parity with Design Comuni `segnalazione-02-dati.html`

### Phase Results
- **Phase 1**: Filament Schemas correction ✅
  - Replaced non-existent `Text::make()` with `Placeholder` (HTML) + `TextEntry` (data)
  - Verified: `Filament\Schemas\Components\Text` does NOT exist
- **Phase 2**: Filament CSS Visual Parity ✅
  - Created `filament-wizard-parity.css` with scoped overrides
  - Added `app-test.css` as Vite entry point (841KB build)
  - Added Filament `.fi-*` classes to Tailwind safelist
  - Updated `test.blade.php` to use `app-test.css`
- **Phase 3**: Bootstrap Italia section structure ✅
  - 3 sections: Luogo, Disservizio, Autore
  - Grid 3-col for author data (name, fiscal code, phone)
  - TextEntry with icons for read-only author info
- **Phase 4**: Responsive parity: pending
- **Phase 5**: Multilingual verification: IT/EN translations verified

## Rules
- Filament Schemas = unified system (v5). Forms + Infolists coexist.
- Widget → NO model binding (`getFormModel() → null`)
- CSS scoped overrides → never mutate Filament markup
- Multilingual: all strings via `__('laraxot::ticket.*')`
- Multilingual: all strings via `__('<nome progetto>::ticket.*')`
