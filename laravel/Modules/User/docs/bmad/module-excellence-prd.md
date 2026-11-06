---
title: "PRD: User module: percorso verso la perfezione assoluta"
type: prd
module: User
status: approved
version: "1.0"
related:
  - ./module-excellence-product-brief.md
  - ./module-excellence-architecture.md
  - ./epics.md
  - ./decision-log.md
  - ../purpose.md
  - ../permissions.md
  - ../index.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "prd: user module   percorso verso la perfezione assoluta user"
---

# PRD: User module: percorso verso la perfezione assoluta

> Scope: Enterprise (3 epic, 24 story, tocca doc/test/dominio). Additiva
> alla campagna Quick Flow Epic 9/10 (SuperAdmin widget), non la sostituisce.

## 1. Obiettivo

Catalogare, con citazione alla fonte, ogni gap verificato tra lo stato
attuale del modulo User e uno stato "perfezione assoluta" (0 debito doc,
0 permesso Policy scoperto, copertura test completa sulle superfici
pubbliche Filament). Questo PRD **non implementa**: definisce FR/NFR che
le story di Epic 12/13/14 devono soddisfare quando qualcuno le
eseguira'.

## 2. Requisiti funzionali

### Epic 12: Docs hygiene & consolidamento SSoT

- **FR-12.1** Il cluster di file `docs/*phpstan*.md` (270 file, prodotti da
  uno script di rename bacato che ha strippato le sottostringhe `-fix`/`-d`
  dai filename, eseguito almeno due volte lo stesso giorno) va consolidato
  in un unico `docs/phpstan-status.md`; gli originali corrotti vanno
  elencati come candidati a cancellazione in una story di pulizia futura
  (non eseguita qui).
- **FR-12.2** `docs/.gitignore` non deve piu' contenere pattern bare
  `archive`/`legacy` (linee 8-9, story root `5.37`): vanno riscritti con
  prefisso esplicito (`docs/archive/`, `docs/legacy/`) per non ignorare
  silenziosamente file futuri.
- **FR-12.3** Le 6+ cartelle `archive/`, `_archive/`, `wiki-archive/`,
  `fixes/`, `bug-fixes/`, `bugfix/`, `bugs/`, `bug-tracking/` vanno
  ricondotte a una convenzione unica dichiarata (quale sopravvive, quale
  e' alias).
- **FR-12.4** `docs/index.md` (3424 righe, 942/3138 link rotti = 30%) va
  sostituito da una mappa curata a 6 voci (login, ruoli/permessi, team,
  profilo, OAuth, feature flag), come gia' richiesto da `purpose.md`
  azione #2.
- **FR-12.5** `docs/permissions.md` (oggi contenuto del modulo
  Patient/Gdpr, dominio "moderazione medici", frontmatter che punta a
  `provtv/base_ptv_fila5`) va sostituito con la vera matrice
  ruolo->permesso del modulo User (collegato a FR-14.1).
- **FR-12.6** `docs/purpose.md` e `docs/scopo.md` (duplicato bilingue) vanno
  unificati; `purpose.md` va corretto dove stale (badge README gia'
  corretti dal 2026-09-02; conteggio widget 26 non 20; AuthenticationLog/
  Device gia' parzialmente in UI).
- **FR-12.7** Le issue GitHub storiche su PHPStan/coverage duplicate
  (cluster #29/#28/#27/#25/#20/#19/#11 e #31/#30/#32) vanno segnalate come
  candidate a consolidamento in un'unica issue viva, senza chiuderle in
  questa sessione.

### Epic 13: Code quality, architettura Filament, test coverage

- **FR-13.1** Riverificare la discrepanza tra issue #91 ("XotBaseResourceTable
  audit gia' fatto, $model presente su tutti") e il riscontro diretto
  (0/30 classi `*Table.php` con `protected static ?string $model` esplicito)
 : nessuna delle due fonti va assunta vera senza un nuovo audit puntuale.
- **FR-13.2** `OauthClientResource` punta al modello Passport vanilla
  invece del modello custom del modulo: va allineato (issue #90).
- **FR-13.3** Completare la story bloccata 10.4: rimuovere
  `Http/Livewire/Profile/DeleteAccount.php`, `TermsOfService.php`,
  `PrivacyPolicy.php` una volta confermato che i widget sostitutivi
  coprono lo stesso comportamento.
- **FR-13.4** Chiarire se `LoginWidget`/`LogoutWidget` e i loro
  equivalenti in `Auth/` sono duplicati vivi o dead code da rimuovere.
- **FR-13.5** Ogni Filament Resource (22/25 oggi senza test) e ogni Widget
  (15/22 oggi senza test) deve avere almeno un test Pest dedicato; la causa
  del bootstrap lento (3-9s per asserzione banale, suite mai eseguita per
  intero, stima 85-90 min seriali) va diagnosticata prima di aggiungere
  altri test (consolida issue #31/#30/#32).
- **FR-13.6** `tests/Playwright/` (oggi 1 file/50 righe) necessita di un
  piano di suite E2E reale sui flussi critici (login, cambio team, gestione
  OAuth client).
- **FR-13.7** I ~25 contratti Fortify/Jetstream mai bindati e le ~15 policy
  stub vuote vanno auditate (issue #44).
- **FR-13.8** Il RenderHook `socialite.buttons` (dead code, 3 cause
  tecniche gia' individuate) va risolto o rimosso (issue #43).
- **FR-13.9** La proliferazione di trait su `BaseUser` (auth log, team,
  shield, passport) necessita una decisione di design esplicita
  (discussion #46).

### Epic 14: Completezza dominio: permessi, team/tenant, OAuth, audit log

- **FR-14.1** Ogni classe Policy (~30) deve avere almeno un permesso
  corrispondente registrato nel seeder (oggi 28/33 permessi coprono solo
  authentication-log + oauth, 5 sono residui "doctors" estranei); i seeder
  duplicati `PermissionSeeder`/`PermissionsSeeder` e `RoleSeeder`/
  `RolesSeeder` vanno consolidati; `PermissionSeeder` va registrato nel
  ciclo standard di `module.json` (oggi gira solo se invocato a mano).
- **FR-14.2** Il confine Team (ability/ownership check, nessun query scope)
  vs Tenant (query scope dati via global scope) va scritto esplicitamente
  in un documento di dominio: oggi verificato solo leggendo il codice.
- **FR-14.3** `AuthenticationLog`/`Device` (gia' visibili via
  `AuthenticationLogResource`, `RecentLoginsWidget`, `DeviceResource`)
  necessitano di un'euristica di anomalia (nuovo dispositivo, orario
  inusuale): il gap reale non e' la UI (gia' presente) ma la logica.
- **FR-14.4** I bottoni Passport dashboard mancanti (nuove credenziali,
  nuovo client OAuth) vanno ripristinati, regressione da un refactor di
  massa AI (issue #98/#85/#99).
- **FR-14.5** L'associazione OAuth client<->user (`owner_id`/`type`) va
  resa strutturalmente completa, con un'azione dedicata di rimozione
  (issue #97).
- **FR-14.6** Il routing del login Google per i cittadini FO necessita una
  decisione di design esplicita (discussion #42).
- **FR-14.7** Va verificato se il commit sospetto che ha svuotato 4 file
  `lang/it` ha colpito altri file mai controllati (issue #102).
- **FR-14.8** La divergenza tra i due remote GitHub (`laraxot/
  module_user_fila5` vs `provtv/module_user_fila5`, tracker issue/
  discussion separati e non sincronizzati) necessita una decisione di
  governance esplicita su quale remote e' canone.

## 3. Requisiti non funzionali

- **NFR-1** Nessuna modifica di codice o cancellazione di file in questa
  fase: ogni FR sopra produce solo documentazione/story, mai un fix
  diretto (vincolo esplicito della richiesta utente).
- **NFR-2** Nessuna story rinumera o cancella story esistenti (9.x/10.x/
  11.1 restano intatte).
- **NFR-3** Ogni nuova story cita una fonte verificabile (issue GitHub,
  file, comando eseguito): mai un'affermazione senza citazione, per
  rispettare la regola "verifica sul codice batte la documentazione".
- **NFR-4** Ogni story linka o crea un'issue/discussion GitHub sul remote
  `laraxot/module_user_fila5` (convenzione gia' in uso, vedi #100/#101).
- **NFR-5** Nessuna azione distruttiva su DB; nessun test Pest eseguito su
  host `10.100.200.15`.

## 4. Fuori scope (di questo PRD)

- Sigma (dati di servizio), moduli di valutazione (evaluations), infra
  Filament condivisa (Xot), notifiche (Notify): questi restano fuori dal
  perimetro User, coerente con `purpose.md` §Confini.
- La campagna Livewire->widget Epic 9/10 (in corso, non toccata da questo
  documento).
