---
title: "Archiviazione Contracts orfani e backup lang (ponytail audit)"
type: decision
tags: [user, ponytail, contracts, lang, archive, audit]
created: 2026-06-30
updated: 2026-06-30
qmd: "User module Contracts ModelContract PassportHasApiTokensContract lang backup archive ponytail audit"
related:
  - ../../00-INDEX.md
---

# Archiviazione Contracts orfani e backup lang (ponytail audit)

## Contesto

L'audit ponytail (`docs/audit/ponytail-audit.md`) segnalava in `Modules/User/`:
1. `app/Contracts/`: 7 file contratto senza implementatori nel repo.
2. `lang/`: 281 file `*.backup_*` ridondanti (backup di traduzioni già storicizzate in git).

Regola d'oro applicata: nessun contratto è stato rimosso senza prima tracciare TUTTI i
chiamanti/implementatori con `rg` sull'intero repository (non solo `Modules/User`).

## Cosa è stato verificato (contratti)

| Contratto | Implementatori/usi reali | Esito |
|---|---|---|
| `HasAuthentications` | `BaseUser implements HasAuthentications` | **Mantenuto** |
| `HasShieldPermissions` | usato dinamicamente in `Modules/User/app/Support/Utils.php` via `class_implements($resourceClass)` | **Mantenuto** |
| `TeamContract` | `BaseTeam implements TeamContract`, ~100 riferimenti repo-wide | **Mantenuto** |
| `TenantContract` | `BaseTenant implements TenantContract` | **Mantenuto** |
| `UserContract` | alias tipizzato verso `Modules\Xot\Contracts\UserContract` (SSoT), ~900 riferimenti | **Mantenuto** |
| `ModelContract` | interfaccia vuota, dichiarata "deprecata" nel proprio docblock; zero `implements` e zero riferimenti a `Modules\User\Contracts\ModelContract` nel repo (i due `implements ModelContract` trovati nei test Xot usano la versione `Modules\Xot\Contracts\ModelContract`, non quella di User) | **Archiviato** → `ModelContract.php.bak` |
| `PassportHasApiTokensContract` | duplicato quasi identico di `Modules\Xot\Contracts\PassportHasApiTokensContract` (la versione canonica, citata nella documentazione storica di risoluzione PHPStan livello 10). Zero `implements` e zero import della versione `Modules\User\Contracts\PassportHasApiTokensContract` nel repo | **Archiviato** → `PassportHasApiTokensContract.php.bak` |

In più è stato trovato un file orfano non conteggiato tra i 7 contratti perché privo di
estensione `.php` (quindi mai autoloaded): `app/Contracts/UserContract.php.to_xot`
(117 righe, bozza di migrazione verso Xot mai completata, zero riferimenti nel codice).
Archiviato anch'esso → `UserContract.php.to_xot.bak`.

Tutti gli archivi sono stati fatti con `git mv` (rename tracciato, reversibile via
`git restore --staged` / `git mv` inverso), **mai** `git rm`.

## Cosa è stato verificato e corretto (backup lang)

I 281 file `lang/**/*.backup_*` erano già stati rimossi da git in un commit precedente
(`4901f3525`) e fisicamente spostati in `Modules/User/lang/archive.bak/` (cartella
ignorata da git tramite la regola `*.bak` presente in tutti i `.gitignore` di modulo).

**Difetto riscontrato durante questa sessione**: lo spostamento in `archive.bak/`
aveva appiattito la struttura per-locale (`lang/{locale}/{file}.backup_{timestamp}`)
in un'unica cartella piatta, causando collisioni di nome tra locale diverse con lo
stesso nome file e timestamp (es. `filament-shield.php.backup_20260216_092227`
esisteva in 4 locale diverse) → solo 194 dei 281 file erano sopravvissuti in
`archive.bak/`, gli altri 87 erano stati sovrascritti silenziosamente. Per recuperarli
senza perdite sono stati ripristinati dalla history git
(`git show 4901f3525~1:<path>`) in una struttura per-locale temporanea, confermando
tutti e 281 i file recuperabili.

**Stato finale (convergenza con lavoro parallelo su questo stesso modulo)**: nel
frattempo un altro agente ha applicato la convenzione canonica del progetto —
niente cartelle `archive.bak/`/`Legacy`/`Old` sotto `lang/` (anti-pattern, vedi
`docs/wiki/concepts/no-legacy-folders-code.md`) — spostando i 281 backup **in-place**
come `lang/{locale}/nome.php.bak` (stesso path del file attivo, solo suffisso `.bak`).
Questa è la struttura finale attualmente sul disco; vedi dettagli e comando di verifica
in
[`wiki/concepts/lang-backup-in-place.md`](../concepts/lang-backup-in-place.md).
Nessuna perdita di dati: tutti e 281 i file sono presenti come `*.php.bak` per locale.

Verificato con `rg` che nessun file PHP del repo referenzia path `*.backup_*` o
cartelle `archive.bak`.

## Esito quality gate

- **PHPStan** (`Modules/User`, livello da `phpstan.neon`): nessun errore.
- **PHPMD** (`Modules/User`, ruleset modulo): zero violazioni nella directory
  `app/Contracts/` (sia prima che dopo, dato che i file rinominati `.bak` non sono più
  scansionati in quanto privi di estensione `.php`). Il modulo intero ha violazioni
  pre-esistenti non correlate a questo intervento (debito tecnico fuori scope).
- **PHPInsights**: bloccato da un problema ambientale pre-esistente
  ("composer.lock not found" durante il check di sicurezza, nonostante il file esista),
  aggravato da spazio disco quasi esaurito sulla VM (partizione root al 100%,
  pochi MB liberi e fluttuanti). Non eseguibile in modo affidabile in questa sessione.
- **Pest** (`Modules/User/tests`): 1013/1015 test falliti per causa ambientale
  pre-esistente e non correlata: manca il file
  `database/predict_user_test.sqlite` (esistono solo `database.sqlite`,
  `database_test.sqlite`, `predict_user.sqlite`). Nessun fallimento menziona
  `ModelContract`, `PassportHasApiTokensContract` o `UserContract.php.to_xot`.

## Blocchi ambientali (non correlati al codice)

1. Spazio disco quasi esaurito sulla partizione root (`/`, 460G al 100%, pochi MB
   liberi, fluttuanti) — ha causato fallimenti intermittenti di comandi con output
   ampio durante questa sessione.
2. Manca `database/predict_user_test.sqlite` per i test Pest del modulo User.
3. PHPInsights non trova `composer.lock` nonostante sia presente in `laravel/`.

Questi tre punti sono pre-esistenti all'intervento e vanno segnalati/risolti a livello
di infrastruttura, non di codice del modulo User.
