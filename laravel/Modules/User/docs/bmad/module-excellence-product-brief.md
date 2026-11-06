---
title: "Product brief: User module: percorso verso la perfezione assoluta"
type: product-brief
module: User
status: approved
version: "1.0"
related:
  - ./module-excellence-prd.md
  - ./module-excellence-architecture.md
  - ./module-excellence-brainstorming.md
  - ./epics.md
  - ./decision-log.md
  - ../purpose.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "product brief: user module   percorso verso la perfezione assoluta user"
---

# Product brief: User module: percorso verso la perfezione assoluta

## 1. Executive summary

Questo documento apre una campagna BMAD **additiva** a quella gia' in corso
(Epic 9 SuperAdmin + Epic 10 resto inventario Livewire->widget, vedi
[epics.md](./epics.md)). Non la sostituisce e non ne tocca gli artefatti.

Studio a fondo del modulo (5 ricerche parallele, sola lettura, 2026-09-22) su
docs, codice/PHPStan, test, GitHub, dominio/sicurezza. Risultato: il modulo
e' **funzionalmente solido** (PHPStan livello `max` a 0 errori, convenzioni
Actions/no-services rispettate, `mixed` quasi assente) ma ha **tre debiti
concreti e misurati** che separano lo stato attuale dalla "perfezione
assoluta":

1. **Documentazione**: 3377 file `.md` in `docs/`, di cui una parte
   rilevante e' rumore duplicato o contenuto sbagliato (vedi §Problem
   statement).
2. **Test**: l'88% delle Filament Resource e il 68% dei widget non hanno
   alcun test dedicato; la suite Pest e' cosi' lenta da non essere mai stata
   eseguita per intero.
3. **Permessi**: circa 30 classi Policy verificano permessi che non esistono
   nel seeder: un bug di sicurezza silenzioso (nega sempre, nessun errore).

## 2. Problem statement

### 2.1 Documentazione: rumore che nasconde il segnale

- `docs/index.md` (3424 righe, auto-generato) ha **942 link rotti su 3138
  (30%)**: non e' navigabile.
- `docs/permissions.md`, che dovrebbe essere la matrice permessi del modulo
  User, contiene invece il dominio "Moderazione Medici" di un altro modulo
  (Patient/Gdpr): copiato e mai adattato.
- 270 file nominati "phpstan" in `docs/`, molti prodotti da uno script di
  generazione filename bacato che ha rimosso le sottostringhe `-fix` e `-d`
  dai nomi (es. `phpstan-fixes.md` -> `phpstanes.md`,
  `phpstan-furious-debate.md` -> `phpstan-furiousebate.md`), eseguito almeno
  due volte nella stessa giornata, moltiplicando i duplicati senza mai
  sovrascrivere l'originale.
- 6 cartelle diverse (`archive/`, `_archive/`, `wiki-archive/`, `fixes/`,
  `bug-fixes/`, `bugfix/`, `bugs/`, `bug-tracking/`) coprono lo stesso
  concetto senza relazione dichiarata tra loro (1090+ file totali).
- `docs/.gitignore` ha pattern bare `archive`/`legacy` (senza slash) che
  ignorano silenziosamente qualunque nuovo file scritto li' da ora in poi
  (bug gia' noto, story `5.37` in root `sprint-status.yaml`, mai risolto in
  questo modulo).
- `docs/purpose.md` e `docs/scopo.md` sono un duplicato bilingue dello
  stesso contenuto, e `purpose.md` stesso e' obsoleto su un punto (i badge
  README che dichiara falsi sono in realta' gia' corretti dal 2026-09-02).

### 2.2 Test: l'88% delle Resource non ha nessun test

- 25 Filament Resource, solo 3 hanno un test dedicato (UserResource,
  OauthAccessTokenResource, parziale TenantUserResource) = **22 su 25
  scoperte**.
- 22 Widget, solo 7 con test = **15 su 22 scoperti (68%)**.
- ~1054 casi Pest dichiarati nel modulo, ma la suite intera non e' mai
  stata eseguita: bootstrap anomalmente lento (3-9 secondi per un'asserzione
  banale come "puo' essere istanziato"), stima seriale 85-90 minuti.
  L'issue GitHub #31 ("coverage circa 0%, target 100%") resta pienamente
  attuale: con la causa pratica ora documentata.
- `tests/Playwright/` ha un solo file (50 righe, un solo flusso: la
  registrazione): non e' una suite E2E, e' uno scaffold.

### 2.3 Permessi: il gap piu' grave, un bug di sicurezza silenzioso

- `database/seeders/PermissionSeeder.php` definisce **33 permessi**, di cui
  28 coprono solo `authentication-log.*` e i 3 tipi OAuth, e **5 sono
  permessi "doctors" estranei** (boilerplate di un altro dominio mai
  ripulito).
- Esistono **~30 classi Policy** (Team, User, Profile, Role, Device,
  Feature, SocialProvider, Tenant, TeamInvitation, TeamPermission,
  Membership, Extra, Notification, PasswordReset...) che verificano
  permessi in convenzione `{resource}.{ability}`: **nessuno di questi
  permessi esiste nel seeder**. Ogni `can()`/`authorize()` su queste
  risorse nega sempre, in silenzio: sembra una scelta di sicurezza, e' un
  bug.
- Seeder duplicati e morti: `PermissionSeeder.php` vs `PermissionsSeeder.php`
  (quasi identici), `RoleSeeder.php` vs `RolesSeeder.php` (`RolesSeeder` non
  referenziato da nessuno). `module.json` registra solo `RoleSeeder` nel
  ciclo standard; `PermissionSeeder` gira solo se invocato manualmente da
  `UserDatabaseSeeder`.

## 3. Cosa NON e' un problema (verificato, non presunto)

- PHPStan livello `max`: **0 errori** (i tanti doc storici che parlano di
  N errori residui sono obsoleti).
- Nessuna cartella `Services/` o classe `*Service.php`: la regola
  no-services e' rispettata.
- 54 delle 57 Actions usano `QueueableAction` + `execute()`; le 3
  eccezioni sono classi di supporto (resolver/hasher), non violazioni.
- Solo 3 occorrenze di `mixed` in tutto `app/`; 0 array PHP multi-chiave
  su riga singola trovati con l'euristica usata.
- `AuthenticationLog` e `Device` **hanno gia'** una UI dedicata
  (`AuthenticationLogResource`, `RecentLoginsWidget`, `DeviceResource`):
  `purpose.md` sottostimava questo punto, dicendo che nessuno li legge.
- Team (ability/ownership check) e Tenant (query scope via global scope)
  **non si sovrappongono nel codice attuale**: solo non era mai stato
  scritto da nessuna parte.
- I marker di conflitto Git committati (issue #47, 114 originari) sono
  **quasi tutti risolti**: ne restano 2, entrambi file non-`.php` non
  autoloaded.

## 4. Utenti e beneficiari

- Sviluppatori/agenti AI che lavorano sul modulo User (riducono tempo di
  orientamento, evitano di fidarsi di doc obsoleti o file nel modulo
  sbagliato).
- Maintainer del panel Filament (permessi corretti = meno bug di
  autorizzazione silenziosi).
- Chi audita sicurezza/compliance (matrice permessi reale, audit log
  utilizzabile).

## 5. Metriche di successo (per una futura fase di esecuzione: non in
   questa sessione, solo documentazione)

- `docs/index.md`: 0 link rotti, sostituito da mappa curata a 6 voci.
- `docs/permissions.md`: contenuto del modulo User, non di un altro modulo.
- Ogni Policy ha almeno un permesso corrispondente nel seeder.
- Ogni Filament Resource/Widget ha almeno un test Pest dedicato.
- Suite Pest del modulo eseguibile per intero in tempi ragionevoli
  (root cause bootstrap-lento diagnosticata e risolta).
