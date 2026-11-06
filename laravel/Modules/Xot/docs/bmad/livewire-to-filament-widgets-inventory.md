---
title: "Inventario fleet: custom Livewire e destinazioni"
type: inventory
module: Xot
status: baseline-2026-10-20-pm
created: 2026-10-20
updated: 2026-10-20
qmd: "inventario livewire filament widgets migrate reuse keep retire gemelli termsofservice privacy"
related:
  - ./livewire-to-filament-widgets-objective.md
  - ./livewire-to-filament-widgets-filament-blueprint.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
  - ../../../../../bashscripts/docs/prompts/05-livewire-to-filament-widgets.md
tags: [docs, xot, bmad]
---

# Baseline (rimisurata 2026-10-20 pomeriggio)

Scope: solo `app/Http/Livewire/**` e `app/Livewire/**` sotto `Modules/` (nessun
tema con custom Livewire). **Esclusi** View Components Blade, Volt, Filament
Forms Components, test, vendor.

Conteggio applicativo: **28 classi** custom Livewire (+ 2 test sotto
`User/tests/.../Livewire`). Il prompt 05 citava 63: includeva rumore da
`extends Component` sui View Components. Controprova:
`find Modules \( -path '*/Http/Livewire/*.php' -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'`.

Widget Filament già presenti: **~168** file sotto `*/Filament/Widgets/` -
spesso il gemello esiste già (`REUSE`).

> Nota 2026-10-20 sera: i numeri 28 e ~168 sono superati (oggi 23 classi e 143
> file) e i verdetti `KEEP` sono smentiti dai fatti (nessun uso reale). Le righe
> sono lasciate com'erano e marcate; il dettaglio e' nella sezione "Rimisura
> 2026-10-20 sera" in fondo.

## Matrice classificazione (source of truth)

Stati: `MIGRATE` | `REUSE` | `KEEP` | `RETIRE`.

| Modulo | Componente | Scopo | Gemello Filament | Verdetto | Wave |
|--------|------------|-------|------------------|----------|------|
| UI | `DarkModeSwitcher` | toggle tema UI chrome | `DarkModeSwitcherWidget` | **DONE** ritirato HTTP; SSoT widget | W0 ✓ |
| UI | `Toast` | feedback flash non-panel |: (chrome FO) | `KEEP` o View/Blade **[superata 2026-10-20 sera: `ToastWidget` e' gia' montato nel layout UI, quindi REUSE+RETIRE]** | W0 |
| Lang | `Lang\Switcher`, `Lang\Change` | cambio locale | `LanguageSwitcherWidget` | **DONE** ritirati HTTP+view; SSoT widget | W0 ✓ |
| Job | `Job\Status`, `Schedule\Status`, `Schedule\Crud`, `Broad` | stato code/schedule admin | `JobStatusWidget`, `ScheduleStatusWidget`, `ScheduleCrudWidget` | `REUSE`/`MIGRATE` | W1 |
| User | `Auth\Login\|Register\|Logout\|Verify\|Passwords\*` | auth FO/panel twin | `LoginWidget`, `RegisterWidget`, `LogoutWidget`, … | `MIGRATE`/`REUSE` + test auth | W1–W2 |
| User | `AuthLogout`, `Livewire\Logout` | logout | `AuthLogoutWidget` / `LogoutWidget` | `REUSE` | W1 |
| User | `Profile\*`, `Team\Change`, `Socialite\Buttons` | profilo/team/OAuth | widget parziali + Actions | `MIGRATE` o Folio | W2 |
| User | `TermsOfService`, `PrivacyPolicy` | testo legale (config) in UI | `TermsOfServiceWidget`, `PrivacyPolicyWidget` | **DONE** ritirati HTTP+view+alias; SSoT widget | W0 ✓ |
| Cms | `Page\Show` | render pagina CMS |: | `KEEP` FO Folio **[superata 2026-10-20 sera: zero chiamanti, RETIRE]** | W2 |
| Geo | `FormSearchAddressCategories`, `Test` | ricerca indirizzo / stub |: | `KEEP` FO / `RETIRE` Test **[KEEP superata 2026-10-20 sera: stub orfano, RETIRE]** | W2 |
| Media | `Card\Video\Clip` | clip video card |: | `KEEP` o Action+Blade **[superata 2026-10-20 sera: zero chiamanti e vista mancante, RETIRE]** | W2 |
| Xot | `XotBaseComponent` (+ registrazione legacy) | base/registrazione |: | `RETIRE` solo a foglie chiuse | W3 |
| Themes |: | mount FQCN widget |: | `KEEP` mount FQCN | W0 |

## Caller da verificare prima di ogni ritiro

Class-name, FQCN, alias stringa, `<livewire:...>`, `@livewire(...)`, provider,
route, config, CMS, test. Mount dinamici verso **Widget Filament FQCN** sono
validi (non sono residui). Docs che dicono “zero” non battono il working tree.

## Note

- Livewire **vendor/interno a Filament** resta: non si elimina il runtime Livewire.
- Nuovi custom sotto `app/Http/Livewire` per il **panel** sono vietati.

## Rimisura 2026-10-20 sera

Misure su working tree con `rg -P` e `find`, con controprova; sono volatili
(piu' sessioni editano il repo). Interpretazione e fonti:
[decision-log](./livewire-widget-decision-log.md), voce "Allineamento al canone
2026-05". Classificazione per classe: nota di verifica in
[story](./stories/livewire-to-filament-widgets-fleet.story.md).

| Misura | Le docs dicono | Live | Come |
|---|---|---|---|
| Classi custom Livewire | 28 | **23** | `find Modules \( -path '*/Http/Livewire/*.php' -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'`; senza il filtro 25 (2 test in `User/tests/Unit/Http/Livewire`) |
| Cartelle `app/Http/Livewire` | 0 (AC di lw2fw-01) | **19** | `find Modules -type d -path '*/app/Http/Livewire'` |
| Cartelle `UI/app/Livewire`, `User/app/Livewire` | 0 | **2** | idem; User ha `Logout.php`, UI solo `Components/Map/InteractiveMap.php.old` |
| Di quelle 19, con solo `.gitkeep` e `_components.json` | n/d | **12** | `ls -A` per cartella |
| File di scarto (`.no`, `.old`, `.test`, `.wip`, `.to_widget`, `.need_wire_modal`, file senza estensione) | n/d | **14** | `find ... ! -name '*.php'` escluse cache e `.gitkeep` |
| Chiamanti di produzione per FQCN | n/d | **0** | `rg -P` su `Modules Themes routes app config`; le sole hit sono le dichiarazioni `namespace` (controprova) |
| Tag per alias | n/d | **1** reale, `<livewire:toast />` | `User/resources/views/components/layouts/main.blade.php:48` |
| File in `*/Filament/Widgets` | ~168 | **143** | `find Modules -path '*/Filament/Widgets/*.php'` senza `tests` |
| Classi Volt | 7 | **7** Cms + **1** User | `use Livewire\Volt\Component` in `app/` |
| Pagine Folio con Volt | non contate | **15** | `use Livewire\Volt\Component` in `User/resources/views/pages`; 0 fuori da User |

Righe marcate come superate (testo originale conservato nella matrice):

- `KEEP` di Toast: il gemello `ToastWidget` e' gia' montato; REUSE+RETIRE.
- `KEEP` di Cms `Page\Show`, Geo `FormSearchAddressCategories`, Media
  `Card\Video\Clip`: zero chiamanti; RETIRE.
- Le righe `DONE` (UI `DarkModeSwitcher`, Lang `Switcher`/`Change`, User
  `TermsOfService`/`PrivacyPolicy`) sono **confermate** per classi e view
  (cancellate, commit `e9f84faa1`), ma non per le cartelle, che esistono ancora.
- La colonna "Wave" della matrice segue la numerazione vecchia; l'ordine
  corrente (W1 stabilizzare, W2 ritiri a basso rischio, W3 auth, W4 Volt/Folio,
  W5 guardia) e' nella nota di verifica della story.

Controllo a livello di cartella (stato finale = 0), da lanciare dalla root:

```bash
find laravel/Modules -type d \( -path '*/app/Http/Livewire' -o -path '*/app/Livewire' \)   # oggi 21
find laravel/Modules -type d -path '*/app/Http' | wc -l                                      # controprova: il find vede le cartelle
```
