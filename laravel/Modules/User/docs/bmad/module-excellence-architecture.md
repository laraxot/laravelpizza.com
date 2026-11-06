---
title: "Architecture: User module: stato attuale vs perfezione assoluta"
type: architecture
module: User
status: approved
version: "1.0"
related:
  - ./module-excellence-product-brief.md
  - ./module-excellence-prd.md
  - ./epics.md
  - ../purpose.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "architecture: user module   stato attuale vs target user"
---

# Architecture: User module: stato attuale vs target

Questo documento confronta lo stato verificato (2026-09-22, ricerca a 5
fork paralleli, sola lettura) con il target implicito dal PRD
[module-excellence-prd.md](./module-excellence-prd.md). Non propone un
redesign: il modulo e' architetturalmente sano, il gap e' su
documentazione, copertura test, e completezza del dominio permessi.

## 1. Stato attuale: cosa e' gia' conforme

| Area | Stato | Evidenza |
|---|---|---|
| PHPStan | livello `max`, 0 errori | `./vendor/bin/phpstan analyse Modules/User --memory-limit=-1` |
| No-services rule | rispettata | nessuna cartella `Services/`, nessuna classe `*Service.php` |
| Actions pattern | 54/57 Actions usano `QueueableAction`+`execute()` | audit diretto `app/Actions/**` |
| `mixed` | quasi assente | 3 occorrenze in tutto `app/` |
| Marker di conflitto Git | quasi risolti | 2 residui su 114 originari (issue #47), entrambi non-PHP |
| Team vs Tenant | separati nel codice | Tenant = global query scope; Team = ability check, nessuno scope |
| AuthenticationLog/Device | hanno gia' UI | `AuthenticationLogResource`, `RecentLoginsWidget`, `DeviceResource` |

## 2. Gap architetturali verificati

### 2.1 Filament Resources/Table: audit `$model` inconcludente

Issue #91 dichiara l'audit XotBaseResourceTable "gia' fatto" per un lotto
di 13 file. Il grep diretto su tutte le 30 classi `*Table.php` del modulo
non trova **nessuna** dichiarazione esplicita `protected static ?string
$model`. Le due fonti si contraddicono: non si assume ne' l'una ne'
l'altra come vera (regola "verifica batte doc"), si apre FR-13.1 per un
riaudit puntuale.

### 2.2 Permessi: il gap piu' grave

```
app/Policies/*.php        ~30 classi, convenzione {resource}.{ability}
database/seeders/PermissionSeeder.php   33 permessi totali
  -> 28 coprono solo authentication-log.* e i 3 tipi OAuth
  -> 5 sono permessi "doctors" estranei (boilerplate di altro dominio)
  -> 0 permessi per Team/User/Profile/Role/Device/Feature/SocialProvider/
     Tenant/TeamInvitation/TeamPermission/Membership/...
```

Ogni `can()`/`authorize()` su queste ~30 risorse nega sempre, senza
errore visibile: e' indistinguibile da "funziona ma nega per policy",
finche' qualcuno non prova ad autorizzare un'azione legittima e scopre
che e' sempre negata. Seeder duplicati (`PermissionSeeder` vs
`PermissionsSeeder`, `RoleSeeder` vs `RolesSeeder`) aggravano la
confusione su quale sia la fonte di verita'. `module.json` registra solo
`RoleSeeder` nel ciclo standard: `PermissionSeeder` va lanciato a mano.

### 2.3 Test: piramide capovolta

```
Filament Resources: 25 totali,  3 testate (12%) -> 22 scoperte (88%)
Widgets:            22 totali,  7 testati (32%) -> 15 scoperti (68%)
Pest test cases:    ~1054 dichiarati, mai eseguiti per intero
  bootstrap: 3-9s per asserzione banale
  stima seriale: 85-90 minuti
Playwright:          1 file, 50 righe (solo registrazione)
```

La causa del bootstrap lento non e' stata diagnosticata in questa sessione
(solo lettura): e' FR-13.5, prerequisito per qualunque nuova story di
copertura test (altrimenti si aggiungono test che nessuno esegue).

### 2.4 Documentazione: struttura vs rumore

```
docs/            3377 file .md totali
  index.md       3424 righe, 3138 link unici, 942 rotti (30%)
  permissions.md contenuto Patient/Gdpr (modulo sbagliato)
  *phpstan*.md   270 file, cluster corrotto da rename-script bacato
  archive/ + _archive/ + wiki-archive/ + fixes/ + bug-fixes/ +
  bugfix/ + bugs/ + bug-tracking/   6+ cartelle sovrapposte, 1090+ file
  purpose.md + scopo.md   duplicato bilingue, purpose.md parzialmente stale
```

Il modulo ha piu' file di documentazione (3377) che file PHP applicativi
(666): la sproporzione stessa e' un segnale architetturale: la
governance dei doc non ha mai avuto un ciclo di consolidamento, solo
accumulo.

## 3. Target architetturale (per esecuzione futura, non in questa sessione)

- `docs/index.md` sostituito da mappa curata a 6 voci, 0 link rotti.
- `docs/permissions.md` = matrice reale ruolo->permesso del modulo User.
- Ogni Policy ha un permesso registrato; seeder duplicati rimossi;
  `PermissionSeeder` nel ciclo standard `module.json`.
- Ogni Resource/Widget pubblico ha almeno un test Pest; causa del
  bootstrap lento risolta; suite eseguibile per intero in CI.
- Un solo cluster doc per argomento (niente `phpstan-*` duplicati, niente
  `archive` multipli); `docs/.gitignore` senza pattern bare pericolosi.

## 4. Confini (invariati da `purpose.md`)

Sigma (dati di servizio), moduli di valutazione, infra Filament condivisa
(Xot), notifiche (Notify) restano fuori dal perimetro User.
