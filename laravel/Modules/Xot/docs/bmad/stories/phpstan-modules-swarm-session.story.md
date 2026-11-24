---
title: "PHPStan Modules swarm session"
status: in_progress
epic: code-quality
qmd: "phpstan analyse Modules swarm session bmad second brain docs prompts pest gate"
acceptance_criteria:
  - "Gate full-tree: totals.file_errors=0 e totals.errors=0 e banner [OK] No errors nello stesso run"
  - "Fix alla sorgente (scopo/funzione), mixed ultima spiaggia, no ignore/baseline"
  - "Lane per-modulo max 3 in parallelo con flock; ordine random tra moduli indipendenti"
  - "Docs moduli/temi e bashscripts/docs/prompts migliorati senza date nei nomi file"
  - "Pest mirato eseguito o skip documentato (host/DB)"
references:
  - bashscripts/docs/prompts/00-master-prompt.md
  - bashscripts/docs/prompts/11-phpstan.md
  - laravel/Modules/Xot/docs/bmad/stories/phpstan-modules-swarm-random.story.md
  - docs/sprint-status.yaml
  - docs/chat/CLAIM-phpstan-modules-swarm-session.md
related:
  - ./phpstan-modules-swarm-random.story.md
  - ./global-phpstan-remediation.story.md
---

# PHPStan Modules swarm session

## Scopo e perche'

Mantenere `laravel/Modules` a zero PHPStan non come cosmetica tipizzante, ma perche'
il type-checker e' la rete di sicurezza sulla logica di dominio PA (progressioni,
performance, indennita', incentivi, rating). Ogni segnale va letto come indizio sullo
**scopo** del codice: cosa doveva fare, chi lo chiama, quale contratto XotBase/Action
rompe.

## Contesto sessione 2026-11-17

- Host: `NOLWA004` (non production `10.100.200.15`) → Pest ammesso se DB testing raggiungibile.
- Worktree condiviso: molti processi `phpstan analyse Modules` / per-modulo gia' attivi
  (Sigma, User, Notify, Activity, Tenant, full-tree raw). Contenzione cache/RAM.
- Lock sessione: `bashscripts/lock/phpstan-modules-swarm-session.lock`
- Claim: `docs/chat/CLAIM-phpstan-modules-swarm-session.md`
- Baseline storica (2026-11-16): full-tree 10669 file `[OK] No errors`; regressioni
  Progressioni/CedDiff gia' chiuse in story Progressioni `4.18`.

## Strategia (ordine random + swarm disciplinato)

1. Inventario per-modulo con `flock` e **max 3** processi concorrenti (prompt 11-phpstan).
2. Escludere path non-modulo (`*.lock` file in `Modules/`).
3. Non editare moduli con lock attivo in `bashscripts/lock/` (Pdnd, Sigma, Tenant, filament-pages-tables-audit) salvo claim esplicito.
4. Fix: scopo → causa radice → patch minima → `php -l` → phpstan lane → Pest mirato.
5. Docs: aggiornare story owner + memoria second brain; prompt solo se fatto nuovo.

## Diario

- 2026-11-17 avvio: full-tree avviato ma conteso; wave parallela 18 moduli abortita
  (violava max-3 e includeva `*.lock`). Passaggio a coda flock.
- Audit parallelo (subagent): docs moduli/temi + prompts + residuali PHPStan.
- 2026-11-17 ~09:24: host ~34 proc PHPStan, RAM satura. Harvest:
  Progressioni/Performance/Job → `[OK] No errors` EXIT=0 (file `/tmp/phpstan_*_raw.txt`).
- Memoria nuova: `bashscripts/ai/wiki/memories/phpstan-host-saturation-max-three.md`.
- Prompt `11-phpstan.md` aggiornato con check saturazione HARD.
- Sprint + claim: `docs/sprint-status.yaml`, `docs/chat/CLAIM-phpstan-modules-swarm-session.md`.
- Prossimo: quando processi ≤6 e available ≥6GiB, inventario flock max-3 sui moduli
  non ancora verificati oggi, poi full-tree unico coordinatore.
- 2026-11-17 prompts P0 applicati (audit agent dedb4b0a): `06-filament.md` qmd
  YAML unito; `00-master-prompt.md` vincolo array PHP one-key-per-line; README /
  `11-phpstan.md` / `99-closing-ritual.md` path story `docs/bmad/stories/` vs
  legacy `docs/stories/`. Scope solo `bashscripts/docs/prompts/`. No commit.
<!-- supersedes: diario senza riga P0 prompts; linked-from: docs/sprint-status.yaml, 11-phpstan.md; user: "fa tutto in parallelo utilizzando swarm + subagents + bmad + ecc + second brain" -->

## Esito

### Gate full-tree 2026-11-17 ~10:10 (coordinatore) — VITTORIA

- Progress cold: **10637/10637 (100%)**, EXIT=0
- JSON: `totals.errors=0`, `totals.file_errors=0`
- Stesso perimetro con formato default `--no-progress`: EXIT=0 + banner **`[OK] No errors`**
  (evidenza `/tmp/phpstan-ptvx/full-ok.txt`)
- User: EXIT=0 (era MISSING); Pdnd lock — non forzato, coperto dal full-tree
- Pest: skip (harness testing isolato non verificato)

Lane docs/prompts chiuse: prompts+ECC, User 12 mv, Themes Zero F1; recovery mass-delete documentata.

**status story → review** (boy scout / Services→Actions restano aperti per ordine permanente).

### Artefatti sessione

- Handoff chat: `docs/chat/handoff-phpstan-swarm-session.md`
- STOP peer: `docs/chat/STOP-phpstan-process-thrashing.md`
- Debito nomi md: story `docs-md-filename-date-debt.story.md` (250 violazioni; User 87, Notify 42, Xot 36)
- Prompt: `11-phpstan.md` + `README.md` aggiornati 2026-11-17

### Swarm 2026-11-17 ~09:42 (parallelo)

Harvest `/tmp/phpstan_*_raw.txt`:
- **OK**: Activity, Job, Notify, Performance, Progressioni, Ptv, Rating, Sigma, Tenant, UI, Xot
- **EXIT=0 senza banner** (trattare come OK finché non smentito): Incentivi, Lang
- **INCOMPLETE**: Media
- **MISSING**: IndennitaCondizioniLavoro, IndennitaResponsabilita, Pdnd, User

Subagent lane avviate (scope disgiunti):
1. docs-guardian User rename date-debt
2. docs-guardian Notify+Rating rename
3. prompts+ECC allineamento saturazione
4. Themes docs explore
5. php-backend harvest/fix senza nuovi phpstan se host saturo

Host al lancio: ~33 proc phpstan, ~9 GiB available → no nuove analyse finché proc≤6.

### Lane prompts+ECC ~09:42–09:55 (no phpstan)

- Letti: `00-master-prompt`, `46-multi-agent-module-swarm`, `15-bmad`, `57-second-brain`,
  `11-phpstan` (saturazione HARD gia' presente — non duplicata).
- `46-multi-agent-module-swarm.md`: sezione **Saturazione PHPStan (HARD)** + link STOP/
  memoria; passo coordinatore allineato (niente soglia «cinquantina»); Non fare thrashing;
  subagent ripete `pgrep`/`free`.
- ECC: `00-index.md` punta a saturazione + `workflows.md`; creato/riempito
  `laravel/Modules/Xot/docs/ecc/workflows.md` (BMAD → lock → fix → PHPStan max-3 → Pest).
- Prompt `17-*` drift: `17-git` e `17-gitmodules-sync` ripuliti ad alias puri
  (canonici `16-git-forward-only` / `48-gitmodules-sync`); `17-gitmodules-path-iteration`
  resta unico canonico inventario; nota in `README.md` sotto Git.
- Memoria correlata: `phpstan-host-saturation-max-three.md` (gia' SSoT); STOP
  `docs/chat/STOP-phpstan-process-thrashing.md` referenziato da 46 + ECC.
- Vietato: nessun phpstan lanciato, nessun commit, nessun delete (solo supersede alias).

### Lane php-backend-agent ~09:25–09:45 (prioritari)

Fatti GateGuard (edit, non create): file già SSoT; link da `docs/sprint-status.yaml` e
`docs/chat/CLAIM-phpstan-modules-swarm-session.md`; non supersede altre story; istruzione
utente: «Aggiorna diario nella story Xot phpstan-modules-swarm-session.story.md (append)».

- Inventario: **nessun** `/tmp/phpstan_*_raw.txt` con file_errors>0. `/tmp/phpstan-ptvx/`
  corrotto (order.txt con newline → path concat, `errors=parse`) → ignorato.
- Regola saturazione: no full-tree; max 1 analyse proprio via flock
  `/tmp/phpstan-lane-single.lock`; abort se available&lt;6. Lock Pdnd/Sigma/Tenant/
  filament-pages-tables-audit/phpstan-modules-swarm-session non toccati.
- Comandi lane (cwd `laravel/`), tutti EXIT=0 e 0 righe errore:
  - `phpstan analyse Modules/Rating` → `/tmp/phpstan_Rating_raw.txt` `[OK]`
  - `phpstan analyse Modules/Lang` → `/tmp/phpstan_Lang_raw.txt`
  - `phpstan analyse Modules/Incentivi` → `/tmp/phpstan_Incentivi_raw.txt`
  - `phpstan analyse Modules/Media` → `/tmp/phpstan_Media_raw.txt` (completa harvest 09:42)
  - `phpstan analyse Modules/IndennitaResponsabilita` → raw EXIT=0
  - `phpstan analyse Modules/IndennitaCondizioniLavoro` → raw EXIT=0
  - UI già OK da peer (`/tmp/phpstan_UI_raw.txt`)
- **Fix codice: nessuno** (zero errori sui prioritari).
- Debito osservato (non fallimento corrente): `@phpstan-ignore` in Rating/Media/UI tests;
  `Modules/UI/phpstan-baseline.neon` vuoto (0 righe).
- Pest: **skip** — assente `laravel/.env.testing`; MySQL `10.100.200.53` ok ma è DB
  applicativo `.env` (`ptv_lara`), non harness isolato. Host `172.30.162.189` ≠
  `10.100.200.15`.
- Non verificato: full-tree unico; rimozione ignore residui.

### Harvest php-backend ~09:45 (solo raw, nessun nuovo phpstan)

GateGuard facts (edit esistente, non nuovo file):
1. Non supersede: append a `phpstan-modules-swarm-session.story.md` (già SSoT sessione; correlate: `phpstan-modules-swarm-random.story.md`, `phpstan-modules-swarm-devin-session.story.md`).
2. Link: `docs/sprint-status.yaml` (`Xot/phpstan-modules-swarm-session`), CLAIM/handoff/STOP in `docs/chat/`.
3. Motivo edit: task utente «Append diario story Xot», non creazione.
4. Istruzione utente: «4. Append diario story Xot.» / «Se nessun ERR e host ancora saturo: documenta 'gate deferred' e elenca moduli MISSING harvest.»

Misura HARD: `pgrep -c -f 'phpstan analyse'` → **26** (>6); `free -g` available → **9** GiB.
→ **gate deferred**: vietato rilanciare analyse; nessun fix sorgente (zero ERR utili).

Classifica `/tmp/phpstan_*_raw.txt` (18 moduli under `Modules/`):

| Modulo | Stato | Note |
|--------|-------|------|
| Activity | OK | `[OK] No errors` EXIT=0 |
| Job | OK | idem |
| Notify | OK | idem |
| Performance | OK | idem |
| Progressioni | OK | idem |
| Ptv | OK | idem |
| Rating | OK | idem |
| Sigma | OK | lockato — non ritoccato |
| Tenant | OK | lockato — non ritoccato |
| UI | OK | idem |
| Xot | OK | idem |
| Incentivi | INCOMPLETE | solo config note + EXIT=0, no banner |
| IndennitaCondizioniLavoro | INCOMPLETE | solo config note, no EXIT |
| IndennitaResponsabilita | INCOMPLETE | solo config note + EXIT=0 |
| Lang | INCOMPLETE | solo config note + EXIT=0 |
| Media | INCOMPLETE | solo config note + EXIT=0 |
| Pdnd | MISSING | lockato — harvest assente |
| User | MISSING | harvest assente |

- **ERR**: nessuno → fix fatti: nessuno; comandi phpstan rilanciati: nessuno.
- **Non verificato** (ri-harvest quando proc≤6 e avail≥6): Incentivi, IndennitaCondizioniLavoro, IndennitaResponsabilita, Lang, Media, User; Pdnd solo dopo unlock/claim.
- Prossimo coordinatore: coda flock max-3 sui soli INCOMPLETE+MISSING non lockati, poi full-tree unico.
