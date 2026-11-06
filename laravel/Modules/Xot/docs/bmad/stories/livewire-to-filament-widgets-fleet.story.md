---
type: story
id: Xot/livewire-to-filament-widgets-fleet
title: "Migrare i custom Livewire UI a Filament Widgets"
module: Xot
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
qmd: "fleet livewire filament widgets wave reuse migrate keep retire termsofservice planning"
related:
  - ../livewire-to-filament-widgets-objective.md
  - ../livewire-to-filament-widgets-architecture.md
  - ../livewire-to-filament-widgets-filament-blueprint.md
  - ../livewire-to-filament-widgets-inventory.md
  - ../livewire-to-filament-widgets-brainstorming.md
  - ../livewire-widget-parallelization-plan.md
  - ../livewire-widget-advantages.md
  - ../livewire-widget-decision-log.md
tags: [docs, xot, bmad]
---

# Story fleet

Baseline: **28** custom Livewire applicativi; ~168 Filament Widgets.
Classificazione: [inventory](../livewire-to-filament-widgets-inventory.md).
Blueprint destinazioni: [filament-blueprint](../livewire-to-filament-widgets-filament-blueprint.md).
Parallel lanes: [parallelization-plan](../livewire-widget-parallelization-plan.md).

## Acceptance criteria

- [x] baseline e inventario riproducibili (rimisurati 2026-10-20 pm);
- [x] ogni classe custom ha classificazione, caller e destinazione (matrice inventory);
- [ ] nessun candidato panel resta senza widget/resource/page/action;
- [ ] ogni widget nuovo/migrato usa una base Xot appropriata;
- [ ] dominio, auth, tenancy, redirect e traduzioni sono coperti da test;
- [ ] nessun vecchio alias/tag/file viene ritirato finché esiste un caller;
- [ ] scan finale non trova custom Livewire residui non giustificati;
- [ ] PHPStan Modules è a zero errori e i gate mirati sono verdi;
- [ ] docs di modulo/tema aggiornati in lotti piccoli con link bidirezionali.

## Piano di esecuzione (ready-for-dev)

Religione (perché): **panel-first**: niente nuovi custom `Http/Livewire` per UI
di panel; sostituto = `XotBase*Widget` + Action. Livewire runtime Filament resta.
FO (Folio/Volt/Blade) resta se lo scopo non e' una card di panel.

| Wave | Scope | Esito | Note |
|------|-------|-------|------|
| W0 | UI `DarkModeSwitcher`; Lang `Switcher`/`Change`; User `TermsOfService`/`PrivacyPolicy` | **DONE** `REUSE` + ritiro HTTP (2026-10-20) | Toast = `KEEP` FO; alias User solo `profile.delete-account`; arch allowlist TermsOfService svuotata |
| W1 | Job Status/Schedule/Crud/Broad | `REUSE`/`MIGRATE` verso widget esistenti | capability `.env`/Artisan → allowlist |
| W1–W2 | User Auth* + Logout | `REUSE` Auth widgets + test auth | non cambiare policy/redirect |
| W2 | User Profile/Team/Socialite; Cms Page; Geo; Media | `MIGRATE` solo se contratto widget, altrimenti `KEEP` FO | Volt/Cms boundary FO; legal gia' in W0 |
| W3 | Xot `XotBaseComponent` + RegisterLivewire | `RETIRE` dopo foglie chiuse | seriale |
| W4 | ritiro alias, ratchet anti-Http/Livewire panel, PHPStan, smoke | zero residui non giustificati | solo coordinatore |

Dentro una wave le lane disgiunte possono partire in ordine casuale; dipendenze
e gate restano ordinati. **Questa sessione = brainstorm + planning** (artefatti
BMAD aggiornati); l'implementazione parte solo aprendo esplicitamente una wave.

Hub: [brainstorming](../livewire-to-filament-widgets-brainstorming.md),
[filament-blueprint](../livewire-to-filament-widgets-filament-blueprint.md),
[decision-log](../livewire-widget-decision-log.md).

## Nota di verifica 2026-10-20 sera

Fase BMAD: Document. Misure rifatte sul disco con `rg -P` e `find`, con
controprova; i numeri sono volatili (piu' sessioni editano il repo). Interpretazione
e fonti: [decision-log](../livewire-widget-decision-log.md), voce "Allineamento
al canone 2026-05". Sintesi: la direttiva ripete il canone del 2026-05-28 (niente
Livewire puro, solo dentro widget Filament, FO incluso); la lettura "FO resta
KEEP" scritta sopra e' piu' debole del canone e non e' sostenuta da nessun uso.

### Stato reale contro gli acceptance criteria

- Baseline: **23** classi vive, non 28; **143** file in `*/Filament/Widgets`, non
  ~168. Le 5 classi di W0 sono cancellate e committate (`e9f84faa1`).
  Il criterio "baseline riproducibile" regge, i numeri vanno aggiornati.
- "Ogni classe ha classificazione": la matrice dell'inventory raggruppa le classi
  e tiene 4 `KEEP` senza uso (Toast, Cms `Page\Show`, Geo `FormSearchAddressCategories`,
  Media `Card\Video\Clip`). La tabella qui sotto classifica per classe e li
  sostituisce.
- W0 `DONE` regge per le classi, non per le cartelle: restano **21** cartelle
  (19 `app/Http/Livewire`, `UI/app/Livewire`, `User/app/Livewire`), 12 delle 19
  con solo `.gitkeep` e `_components.json`.
- Aperti tutti gli altri criteri; "scan finale senza custom Livewire residui" e'
  falso finche' esistono le 23 classi e le 21 cartelle.

### Classificazione per classe (23)

Zero chiamanti di produzione per FQCN. Unico tag per alias: `<livewire:toast />`
in `User/resources/views/components/layouts/main.blade.php:48`.

| Componente | Gemello widget | Stato proposto | Rischio |
|---|---|---|---|
| UI `Toast` | `UI\ToastWidget`, gia' montato nel layout UI | REUSE+RETIRE (chiudere il tag User) | basso |
| Cms `Page\Show` | nessuno | RETIRE (orfano) | basso |
| Geo `FormSearchAddressCategories` | `LocationWidget` parziale | RETIRE (stub orfano); MIGRATE solo se il prodotto vuole address search FO | medio (decisione prodotto) |
| Geo `Test` | `Xot\TestWidget`, `UI\TestWidget` | RETIRE | basso |
| Job `Broad` | nessuno | RETIRE | basso |
| Job `Job\Status` | `JobStatusWidget` | REUSE+RETIRE | basso |
| Job `Schedule\Crud` | `ScheduleCrudWidget` | REUSE+RETIRE | basso |
| Job `Schedule\Status` | `ScheduleStatusWidget` | REUSE+RETIRE | basso |
| Media `Card\Video\Clip` | nessuno (vista mancante) | RETIRE | basso |
| User `Auth\Login` | `Auth\LoginWidget` | REUSE+RETIRE | medio: il redirect per ruolo (`getRedirectUrl`) non ha equivalente nei widget |
| User `Auth\Register` | `Auth\RegisterWidget` | REUSE+RETIRE | basso |
| User `Auth\Logout` | `Auth\LogoutWidget` | REUSE+RETIRE | basso |
| User `Auth\AuthLogout` | `Auth\AuthLogoutWidget` | REUSE+RETIRE | basso |
| User `Auth\Passwords\Confirm` | nessuno (`PasswordResetConfirmWidget` ha altro scopo) | RETIRE o MIGRATE (decisione) | medio |
| User `Auth\Passwords\Email` | `Auth\ForgotPasswordWidget` | REUSE+RETIRE | basso |
| User `Auth\Passwords\Reset` | `Auth\ResetPasswordWidget` | REUSE+RETIRE | basso |
| User `Auth\Verify` | nessuno | MIGRATE (nuovo `XotBaseWidget`) o RETIRE | medio |
| User `Profile\DeleteAccount` | `Profile\DeleteAccountWidget`, non montato | REUSE+RETIRE, dopo averlo montato e testato | medio (azione distruttiva) |
| User `Profile\SuperAdmin` | `Profile\SuperAdminWidget` | REUSE+RETIRE | basso |
| User `Socialite\Buttons` | `Auth\SocialLoginWidget` | REUSE+RETIRE | basso |
| User `Team\Change` | `Team\TeamChangeWidget` | REUSE+RETIRE | basso |
| User `Livewire\Logout` | `LogoutWidget` | REUSE+RETIRE | basso |
| Xot `XotBaseComponent` | n/a | RETIRE (zero sottoclassi, ultimo) | basso |

Totali: 15 REUSE+RETIRE, 6 RETIRE, 2 da decidere (Confirm, Verify). `KEEP`: 0.

### Ordine delle wave aggiornato

Dentro una wave le lane disgiunte partono in ordine casuale; dipendenze e gate
restano ordinati. Nessuna wave e' aperta da questa nota. Questa numerazione
sostituisce quella della tabella "Piano di esecuzione" sopra (dove Job era W1 e
Cms/Geo/Media W2); il [piano di parallelizzazione](../livewire-widget-parallelization-plan.md)
la richiama nella nota in testa.

1. **W1 stabilizzare:** chiudere gli eventuali merge aperti e capire perche' i
   pull riportano i file ritirati (D e A alternati per Team\Change, Geo Test, Job
   Status). Senza questo, ogni ritiro puo' essere annullato da un pull.
2. **W2 ritiri a rischio basso:** lane disgiunte per modulo (UI Toast, Cms,
   Geo Test, Job, Media, User Register/Logout/AuthLogout/Email/Reset/SuperAdmin/
   Buttons/Team, Geo FormSearch dopo la decisione di prodotto). Xot
   `XotBaseComponent` per ultimo e in seriale.
3. **W3 auth a rischio medio (seriale):** `Verify`, `Passwords\Confirm`, redirect
   per ruolo del `Login` portato nel widget, `DeleteAccountWidget` da montare e
   testare prima di ritirare `Profile\DeleteAccount`.
4. **W4 Volt/Folio:** il solo confine aperto. 7 classi Cms Volt e
   `ProfileEditVoltComponent` (RETIRE), 15 pagine Folio in
   `User/resources/views/pages`, `profile/edit` (714 righe) verso tre
   `XotBaseSchemaWidget`. Richiede una decisione dell'utente sul confine.
5. **W5 guardia:** cartelle assenti, `RegisterLivewireComponentsAction` ritirata,
   test `NoLivewireDirectoriesInModulesTest` esteso a `UI/app/Livewire` e coerente
   con i test di ritiro (Geo, Job, User, UI) che oggi pretendono presenza o assenza
   opposte. `GetComponentsAction` ricrea la cartella sotto `Modules/` se manca
   (righe 41-45): tenerlo lontano da questi path.

### Stato finale

Nessuna cartella `app/Http/Livewire` ne' `app/Livewire` sotto `laravel/Modules`,
`.gitkeep` e `_components.json` compresi. Stessa forma della regola sui Service
([epic-services-to-queueable-actions](../../../../../../bmad-output/epic-services-to-queueable-actions.md)).

```bash
find laravel/Modules -type d \( -path '*/app/Http/Livewire' -o -path '*/app/Livewire' \)   # oggi 21, atteso 0
find laravel/Modules -type d -path '*/app/Http' | wc -l                                      # controprova: il find vede le cartelle
```
