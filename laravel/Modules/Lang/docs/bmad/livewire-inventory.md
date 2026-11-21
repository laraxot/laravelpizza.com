---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Lang — Livewire HTTP → widget"
type: inventory
module: Lang
status: approved
track: campaign
related:
  - ./livewire-widget-conversion.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-tech-spec.md
  - ./livewire-widget-epics.md
  - ./livewire-widget-decision-log.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
  - ../../Cms/docs/bmad/livewire-inventory.md
  - ../../UI/docs/bmad/livewire-widget-project-context.md
  - ../stories/12.1.retire-lang-http-switchers.story.md
---

# Inventario: Livewire HTTP → Filament (Lang)

**Solo documentazione. Nessun PHP toccato in questo audit.**

SSoT del modulo Lang per la campagna Livewire → Filament widget; formato e metodo come [Modules/Cms/docs/bmad/livewire-inventory.md](../../Cms/docs/bmad/livewire-inventory.md).

> **Stato 2026-09-21 (post 12.1):** HTTP `Switcher`/`Change` ritirati. Header FO monta `LanguageSwitcherWidget` via FQCN. `View\Components\LanguageSwitcher` resta inerte. Story [12.1](../stories/12.1.retire-lang-http-switchers.story.md) `done`.

## Metodo (comandi eseguiti, non assunti)

```bash
find Modules/Lang/app/Http/Livewire -type f
cat Modules/Lang/app/Http/Livewire/_components.json
git status --short -- Modules/Lang                              # → M Change.php, D Switcher.php
grep -rn "livewire:lang\|lang\.change\|lang\.switcher" --include="*.blade.php" --include="*.php" .
grep -rn "LanguageSwitcherWidget" --include="*.blade.php" Modules Themes
grep -rn "renderHook\|RenderHook" Modules/*/app/Providers/Filament/*.php
```

## Le classi in gioco

### 1. `Http\Livewire\Lang\Switcher` — ritirato

File assente. Alias `lang.switcher` assente da `_components.json` (`[]`).

### 2. `Http\Livewire\Lang\Change` — ritirato

File assente. Vista HTTP `lang::livewire.lang.change` assente.

Montaggio FO: `Modules/UI/resources/views/components/headernav/simple.blade.php` usa

```blade
@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)
```

I due tag Cms headernav restano senza `lang.change` (commenti morti rimossi). Nessun render hook Lang nei PanelProvider.

### 3. `Filament\Widgets\LanguageSwitcherWidget` — unico switcher vivo

`$isDiscovered = false`. Lingue da `LaravelLocalization::getSupportedLocales()`. URL e redirect 303 da `getLocalizedURL()`. Vista `lang::filament.widgets.language-switcher`.

`Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php` (175 righe) è stato **riscritto correttamente** il 21/09/2026 (verificato via `git diff` e lettura integrale):

- `$isDiscovered = false` (riga 24): chrome tema, non card dashboard.
- `canView()` (righe 32-35) → `config('lang.language_switcher.enabled', true)`.
- `getAvailableLocales()` (righe 70-96) usa `LaravelLocalization::getSupportedLocales()` (riga 73) — il vecchio fallback fisso it/en/de non c'è più.
- `getLanguageUrl()` (righe 113-128) usa `LaravelLocalization::getLocalizedURL()` (riga 118) con fallback `'/'.$locale` (righe 119-125).
- `changeLanguage()` (righe 101-108) fa `redirect($url, 303)` — parità di comportamento con il vecchio `Change::mount()` raggiunta **nel codice**.
- Vista `lang::filament.widgets.language-switcher` (riga 27) → `Modules/Lang/resources/views/filament/widgets/language-switcher.blade.php`.

Ma il gap di **collegamento** è chiuso: headernav UI monta il FQCN.

### 4. `View\Components\LanguageSwitcher` — wrapper inerte

`Modules/Lang/app/View/Components/LanguageSwitcher.php` istanzia il widget nel costruttore (riga 28), ma la registrazione Blade resta commentata (`Modules/Lang/app/Providers/LangServiceProvider.php:42`) e `_components.json` dei View Components elenca solo `flag`. Non raggiungibile come `<x-lang::language-switcher>`.

## Verifica del montaggio: tabella repo-wide

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `<livewire:lang.*>` attivi | grep blade/php/json | zero |
| `@livewire` FQCN widget | UI headernav | `LanguageSwitcherWidget::class` |
| Render hook panel | `Modules/*/app/Providers/Filament/*.php` | Nessun hook Lang |
| Alias registrati | `_components.json` | `[]` |

## Classificazione

| Classe | Cluster | Esito |
|---|---|---|
| `Http\Livewire\Lang\Switcher` | **B** | Ritirato |
| `Http\Livewire\Lang\Change` | **B** | Ritirato; header usa il widget |
| `Filament\Widgets\LanguageSwitcherWidget` | gemello B | Montato in UI headernav via FQCN |

**Cluster A: zero candidati.** Nessun render hook Lang in alcun panel provider.

**Cluster C: zero componenti.** Nessuna pagina a tutto schermo nel modulo.

## Verdetto

Campagna Lang **chiusa** (story 12.1 `done`): un solo switcher, il widget Filament, cablato nel tema. Non creare altri switcher. Wrapper Blade resta inerte.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-conversion.md](./livewire-widget-conversion.md) — puntatore al canone
- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (2 classi HTTP + 1 widget + 1 wrapper, verificati riga per riga)
- [x] Verifica montaggio in tutto il repo (provider, blade, rotte, cache alias)
- [x] Gemello widget verificato esistente e allineato a `LaravelLocalization`
- [x] HTTP Switcher/Change ritirati; widget montato in UI headernav
- [x] Nessuna story di conversione duplicata: 12.1 `done`
