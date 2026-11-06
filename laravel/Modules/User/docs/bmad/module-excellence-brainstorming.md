---
title: "Brainstorming: User module: findings grezzi (5 fork paralleli)"
type: brainstorming
module: User
status: approved
version: "1.0"
related:
  - ./module-excellence-product-brief.md
  - ./module-excellence-prd.md
  - ./module-excellence-architecture.md
  - ./epics.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "brainstorming: user module   findings grezzi user"
---

# Brainstorming: User module: findings grezzi

Findings raccolti da 5 ricerche parallele (sola lettura, `Agent
subagent_type: fork`, 2026-09-22), prima della prioritizzazione in
[epics.md](./epics.md). Ordinati per fork, non per priorita'.

## Fork 1: Docs hygiene

- 3377 file `.md` in `docs/`; 1532 al primo livello.
- Cluster di 270 file `*phpstan*.md`, molti chiaramente corrotti
  (`phpstanes.md`, `phpstanebate.md`, `phpstanry-kiss-improvements.md`,
  `phpstan-fixes.md`, `phpstan-level10es.md`). Root cause: uno script
  di generazione slug ha rimosso le sottostringhe `-fix` e `-d` dai nomi
  file derivati dai titoli, eseguito almeno due volte nella stessa
  giornata (cluster di mtime alle 08:28 e 09:35). Originali e corrotti
  **coesistono** (non rinominati: rigenerati), con dimensioni byte
  leggermente diverse: contenuto rigenerato, non solo il nome.
- `docs/index.md`: 3424 righe, elenco piatto auto-generato. Verificati
  tutti i 3138 link unici: 942 rotti (30.0%).
- `docs/permissions.md`: 107 righe, ma e' contenuto copiato da un altro
  modulo: dominio "Moderazione Medici" (Patient/Gdpr), frontmatter
  `issues`/`discussions` che punta a `provtv/base_ptv_fila5` (repo
  sbagliata), link interni a `./00-index.md`, `./2fa-guide.md` che non
  hanno nulla a che fare col modulo User.
- 6+ cartelle con lo stesso concetto: `archive/`, `_archive/`,
  `wiki-archive/`, `fixes/`, `bug-fixes/`, `bugfix/`, `bugs/`,
  `bug-tracking/`: 1090+ file totali, nessuna relazione dichiarata.
- `docs/.gitignore` linee 8-9: pattern bare `archive`/`legacy` (nessuno
  slash): `git check-ignore -v` conferma che qualunque nuovo file sotto
  `docs/archive/` o `docs/legacy/` viene ignorato silenziosamente da ora
  in poi. Story root gia' esistente: `5.37-gitignore-archive-legacy-bug-user`.
  Il `.gitignore` di root modulo (500 righe) ha lo stesso blocco
  duplicato letteralmente due volte in punti diversi del file.
- `purpose.md` e `scopo.md`: stesso contenuto, due lingue, mai
  dichiarato quale sia la fonte di verita'.

## Fork 2: Codice/architettura/PHPStan

- `./vendor/bin/phpstan analyse Modules/User --memory-limit=-1`: **0
  errori** a livello `max`. I doc storici che citano N errori residui
  sono tutti obsoleti.
- 0/30 classi `*Table.php` con `protected static ?string $model`
  esplicito: in contraddizione diretta con issue #91 ("audit gia'
  fatto, $model presente su tutti" per 13 file). Nessuna delle due fonti
  assunta vera senza riverifica.
- `OauthClientResource` referenzia il modello Passport vanilla, non il
  modello custom del modulo (coerente con issue #90).
- 57 Actions totali, 54 usano `QueueableAction`+`execute()`; le 3
  eccezioni sono classi di supporto (resolver/hasher), non violazioni
  della regola no-services.
- 26 Widget (non 20 come dichiarato in `purpose.md`).
- 27 Filament Resource, 30 Table class.
- 3 occorrenze di `mixed` in tutto `app/`.
- 0 array PHP multi-chiave su riga singola trovati con l'euristica usata
  (verifica indicativa, non esaustiva).
- 2 marker di conflitto Git residui su 114 originari (issue #47),
  entrambi in file non-PHP (non autoloaded, nessun rischio runtime).

## Fork 3: Copertura test

- Host verificato: non e' `10.100.200.15` (hostname `NOLWA004`): via
  libera per eseguire Pest secondo la regola dati sacri.
- ~1054 casi Pest dichiarati nell'albero `tests/`.
- Bootstrap anomalmente lento: 3-9 secondi per un'asserzione banale
  ("puo' essere istanziato"). Suite intera mai eseguita per intero da
  nessuno; stima seriale 85-90 minuti.
- Campione eseguito: alcuni test passano, alcuni falliscono, alcuni
  warning: non rappresentativo abbastanza per un numero di coverage
  affidabile senza prima risolvere il bootstrap lento.
- 25 Filament Resource: 3 con test dedicato (12%) -> 22 scoperte (88%).
- 22 Widget: 7 con test dedicato (32%) -> 15 scoperti (68%).
- `tests/Playwright/`: 1 solo file, 50 righe, un solo flusso
  (registrazione): scaffold, non suite E2E.
- Issue #31 ("coverage circa 0%, target 100%") resta pienamente attuale.

## Fork 4: Catalogo GitHub

- `laraxot/module_user_fila5`: 27 issue aperte, 13 discussion aperte.
- `provtv/module_user_fila5`: 9 issue aperte, 4 discussion aperte -
  **tracker separato e divergente**, non uno specchio del remote
  laraxot (numerazione diversa, contenuti diversi). Decisione di
  governance su quale remote e' canone: non presa, da documentare
  (FR-14.8).
- Issue rilevanti non ancora riflesse nei doc BMAD esistenti: #102 (lang
  stub svuotati), #98/#85/#99 (bottoni Passport dashboard regrediti),
  #97 (associazione OAuth client<->user incompleta), #93/#94 (README
  frontmatter/QMD), #91/#90 (audit XotBaseResourceTable, vedi Fork 2),
  #44 (contratti Fortify/Jetstream), #43 (RenderHook socialite morto),
  #46 (discussion: trait su BaseUser), #42 (discussion: routing Google
  FO).
- Cluster di issue duplicate/da consolidare: PHPStan storiche
  (#29/#28/#27/#25/#20/#19/#11, tutte superate dal riscontro 0 errori
  del Fork 2) e coverage (#31/#30/#32, tre issue per lo stesso tema).

## Fork 5: Dominio/sicurezza (verifica delle 5 azioni di `purpose.md`)

1. README badge falsi: **FALSO/STALE**. Il README e' gia' stato
   corretto il 2026-09-02 (stesso giorno di `purpose.md`) con badge
   reali (PHP ^8.3, Laravel ^13.0, Filament ^5.0, PHPStan max/0 errori)
   e nota esplicita "misurati il 2026-09-02". `purpose.md` e' cio' che
   e' rimasto stale, non il README.
2. Mappa docs a 6 voci: **PARZIALE**. `docs/index.md` esiste ma e' un
   elenco piatto auto-generato con 30% di link rotti (vedi Fork 1), non
   la mappa curata richiesta.
3. Matrice permessi come contratto: **NON FATTO, gap confermato in modo
   indipendente**. `docs/permissions.md` e' contenuto di un altro
   modulo (Fork 1); l'analisi diretta di seeder/policy (Fork 5) conferma
   in modo indipendente lo stesso gap: solo 33 permessi reali, ~30
   Policy senza permesso corrispondente.
4. Confine Team vs Tenant: **verificato empiricamente dal codice, mai
   scritto in un doc**. Tenant = query-scope dati (global scope via
   `TenantScope.php`); Team = raggruppamento organizzativo/ability check,
   nessuno scope query.
5. AuthenticationLog/Device "nessuno li legge": **FALSO/STALE**.
   Esistono gia' `AuthenticationLogResource`, `RecentLoginsWidget`,
   `DeviceResource` che mostrano questi dati. Il gap reale e' piu'
   stretto: manca solo l'euristica di anomalia (nuovo dispositivo,
   orario inusuale), non la superficie UI.

## Contraddizioni da non risolvere unilateralmente (richiedono riaudit)

- Issue #91 ("XotBaseResourceTable audit gia' fatto") vs grep diretto
  (0/30 classi con `$model` esplicito): FR-13.1.
- `purpose.md` azione #1 (badge falsi) vs README gia' corretto: risolto
  nella sintesi correggendo `purpose.md`, non il README.
- `purpose.md` azione #5 (nessuno legge auth log) vs UI gia' esistente -
  risolto restringendo il gap alla sola euristica di anomalia.
