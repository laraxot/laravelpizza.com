---
title: "ADR — bashscripts e .claude non si versionano nel root"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: Xot
decision-makers: [utente]
issues: [252]
tags: [adr, git, gitignore, bashscripts, claude, symlink, sync]
qmd: "bashscripts claude gitignore symlink git rm cached repo annidato bashscripts_fila5 gitmodules.ini sync indice working tree typechange"
related:
  - ./0018-agent-harness.md
  - ../stories/root-untrack-bashscripts-and-claude.story.md
  - ../../tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
---

# `bashscripts` e `.claude` non si versionano nel repo root

## Contesto

`bashscripts/` è un repository a sé: ha il suo `.git` e il remote `git@github.com:laraxot/bashscripts_fila5.git`, che
`gitmodules.ini` (nel root) dichiara come percorso `bashscripts`. `.claude` è un symlink a `bashscripts/ai/.agents`.

Misurato il 24/11:

- L'indice del root conteneva **una sola voce** `bashscripts`, di tipo symlink (modo `120000`) verso
  `../base_ptvx_fila5/bashscripts/`, cioè verso la cartella di un **altro progetto**. Sul disco `bashscripts` è invece una
  cartella vera col proprio `.git`: indice e working tree non coincidevano, e ogni commit di sync (`.`) ritoccava la voce
  (l'ultimo, 35 minuti prima della misura).
- `.gitignore` aveva solo `bashscripts/`. Per git un symlink è un file e un pattern con la barra finale vale solo per le
  cartelle, quindi la regola non copriva proprio la voce tracciata. La convenzione del repo (vedi `.github/workflows/guard.yml`)
  è di scrivere **due righe per nome**: `nome/` e `nome`.
- `.claude` non aveva nessun file nell'indice ed era già coperto dalla regola `.claude`.
- Una riga del `.gitignore` (`laravel/bootstrap/cache/*bashscripts/`) era la fusione di due pattern senza a capo e non
  ignorava nulla: la cache di bootstrap è già coperta dal suo `.gitignore` con `*`.

## Driver della decisione

- Un solo proprietario per file: `bashscripts` ha già il suo repo; tracciarlo anche nel root crea due storie per lo stesso
  contenuto e fa ricadere i marker di conflitto di una sull'altra.
- Il root non deve puntare fuori dal progetto: un symlink verso `../base_ptvx_fila5/` rompe su qualunque macchina dove
  quel progetto non è accanto a questo.
- Indice e working tree devono coincidere: la differenza di tipo (symlink contro cartella) è rumore permanente nei commit
  automatici.

## Alternative scartate

- **Tenere il symlink tracciato**: lascia la dipendenza da un altro progetto e la differenza di tipo, e la sync continua
  a ricommitarlo.
- **Sottomodulo git** (voce gitlink): `gitmodules.ini` non è un `.gitmodules` e il modello di sync di questo progetto
  usa cloni indipendenti che seguono `dev`, non un commit fissato.
- **Tracciare i file di `bashscripts` nel root**: duplica il repo `bashscripts_fila5` e porta nel root i marker che
  l'altro repo, condiviso tra più progetti, riceve dal remoto.

## Decisione

Scelta: **il root non versiona né `bashscripts` né `.claude`**.

- `.gitignore` ha `bashscripts/` e `bashscripts` (cartella e symlink) e `.claude`.
- La voce `bashscripts` è tolta dall'indice con `git rm --cached bashscripts`: il disco non cambia, il repo annidato resta
  com'è.
- `.claude` resta un symlink locale a `bashscripts/ai/.agents`, fuori dal versionamento.

## Conseguenze

- Buono: un solo repo per `bashscripts`, nessun typechange nei commit automatici, nessun rimando a un altro progetto.
- Buono: la CI non cambia, perché `.github/workflows` non cita `bashscripts`.
- Cattivo: un clone nuovo del root non contiene `bashscripts` né `.claude`. Va clonato `bashscripts_fila5` in
  `bashscripts/` e ricreato il symlink `.claude` (`ln -s bashscripts/ai/.agents .claude`). Gli hook `pre-commit` e i
  comandi citati nelle docs funzionano solo dove `bashscripts` è presente.
- Cattivo: su una macchina dove `bashscripts` è ancora il symlink tracciato, il primo `git pull` della decisione lo
  toglie; se quella macchina lo usa va ricreato a mano.

## Verifica

```bash
git ls-files -s bashscripts | wc -l                 # 0
git ls-files .claude | wc -l                        # 0
git check-ignore -v bashscripts .claude             # entrambi coperti
git ls-files -c -i --exclude-standard | grep -E '^(bashscripts|\.claude)(/|$)'   # vuoto
```

- `Modules/Tenant/tests/Unit/TenantConfigTrackedTest.php` applica lo stesso criterio ai file di configurazione per tenant:
  nessun file tracciato è coperto da una regola ignore.
