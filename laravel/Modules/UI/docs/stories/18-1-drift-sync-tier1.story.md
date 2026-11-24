---
qmd: "ui stories 18 1 drift sync tier1 story md"
id: story-181-drift-sync-tier1
title: Drift Sync Tier 1 — laraxot/dev fetch e merge moduli critica (UI, Job, AI, Geo, Tenant)
slug: story-181-drift-sync-tier1
status: todo
scope: module:UI
epic: 18
epic_title: Sincronizzazione Drift + Dedup Docs
---

# Drift Sync Tier 1 — laraxot/dev fetch e merge moduli critica

**Epic:** 18 - Sincronizzazione Drift + Dedup Docs  
**Story:** 18-1  
**Status:** todo

Sincronizzazione repo remoti Tier 1 (UI, Job, AI, Geo, Tenant) con `laraxot/dev`, risolvendo divergenza massima (0-1485 commit dietro) e certificando verde PHPStan/PHPMD post-merge.

## Contesto

Scoperto durante sprint PHPStan L10 (2026-09-06):
- **UI** 1485 commit dietro `laraxot/dev`
- **Job** 1258 commit dietro
- **AI** 961 commit dietro
- **Geo** 854 commit dietro
- **Tenant** 824 commit dietro

Timestamp divergenza: HEAD locale ~14:59, laraxot/dev ~19:37 (altre sessioni pushano costantemente). Lavoro precedente in sospeso: 13 commit dedup docs non pushati da sessione 2026-09-04 (da riapplicare post-merge).

**Referenza:** `docs/implementation-artifacts/18-1-sincronizzazione-drift-moduli-tier-1.md`

---

## Acceptance Criteria

### AC-1: Fetch laraxot/dev su ogni modulo Tier 1

Per ogni modulo (UI, Job, AI, Geo, Tenant):
- Eseguire `git fetch laraxot dev` senza errori
- Verificare `git rev-list --left-right --count HEAD...laraxot/dev` — atteso divergenza < 10 commit dopo fetch
- Zero commit locali pendenti prima di merge (stage tutti i file tocchi oppure scarta con `git reset --hard`)

### AC-2: Merge --allow-unrelated-histories se storici divergono

- Merge strategia `resolve` oppure `--allow-unrelated-histories` se storici non lineari
- Se conflitti: risolvibili senza modifica a file `.php` di logica (solo docs/config ammessi, oppure rimandare a story 18-2)
- Commit merge esplicito per ogni modulo (mai cherrypick unilaterale)

### AC-3: PHPStan/PHPMD post-merge verde

- PHPStan `clear-result-cache` + `analyse Modulo --no-progress` per ogni modulo Tier 1: stato baseline (mai peggio di prima)
- PHPMD `./tools/phpmd.sh Modulo/app text ../docs/phpmd.ruleset.xml`: segnalazioni pre-sync confermate
- Coverage baseline confermata (no new test debt)

### AC-4: Commit+push su tutti i remote per ogni modulo

- `git add .` / stage selettivo (vedi AC-1) per risolvere conflicts
- `git commit -m "Merge laraxot/dev: drift sync tier-1 (AC-2026-09-06)"` per ogni modulo
- `git push -u laraxot dev` per ogni modulo
- Verificare push completato: `git log --oneline -1` == remote HEAD

---

## Fasi di esecuzione

### Fase 1: Preparazione (2h)

1. Per ogni modulo Tier 1, verificare stato locale:
   - `git status --short` — committare o scartare delta non necessari
   - `git rev-list --left-right --count HEAD...laraxot/dev` — registrare baseline divergenza

2. Lettura referenza artefatti: `docs/implementation-artifacts/18-1-sincronizzazione-drift-moduli-tier-1.md`
   - Identificare commit dedup docs sospesi (13 commit, moduli elencati AC-1 della referenza)
   - Annotare trigger merge per story 18-2 (Activity/Cms con conflitti PHP)

### Fase 2: Fetch + Merge per modulo (3h)

Per ogni modulo Tier 1:

```bash
cd laravel/Modules/<Modulo>
git fetch laraxot dev
git log --oneline -5  # inspect remote HEAD
git merge --allow-unrelated-histories laraxot/dev
# If conflict: resolve per AC-2 (docs/config only, senza PHP logica)
git add .
git commit -m "Merge laraxot/dev: drift sync tier-1"
```

### Fase 3: Verifiche post-merge (2h)

Per ogni modulo Tier 1:

```bash
cd laravel/Modules/<Modulo>
php -l app/**/*.php  # lint di massa
phpstan clear-result-cache
phpstan analyse . --no-progress
./tools/phpmd.sh . text ../docs/phpmd.ruleset.xml
```

Documentare risultati in `docs/coverage.md` (baseline pre-sync vs post-sync).

### Fase 4: Push sincronizzato (1h)

Per ogni modulo Tier 1:

```bash
cd laravel/Modules/<Modulo>
git push -u laraxot dev
git log --oneline -1  # confirm pushed
```

---

## Blocchi noti e carve-out

- **Activity/Cms (Tier 2):** Conflitti PHP reali (app/Models/Activity.php, Snapshot.php, ecc.) — rimandare a story 18-2
- **Xot (Tier 3):** 12 file `.php` deletati in working tree (parte dedup) — committare PRIMA di merge
- **QMD unavailable:** Node ABI mismatch — usare grep/Read diretto per wiki se necessario

---

## Deliverables

1. **Per ogni modulo Tier 1 (UI, Job, AI, Geo, Tenant):**
   - Commit merge esplicito in laraxot/dev
   - Verifiche PHPStan/PHPMD documentate in `Modulo/docs/coverage.md`
   - Push completato

2. **Artefatto:**
   - Aggiornamento `docs/coverage.md` con baseline post-sync per ogni modulo
   - Commit consolidato di questa story in UI/docs/stories (questo file)
   - Annotazione `docs/chat/2026-09-06-drift-sync-tier-1-tracking.md` con risultati

3. **Follow-up:**
   - Story 18-2: Activity/Cms sincronizzazione con risoluzioni conflitti
   - Story 18-3: Tier 3 + riapplicazione dedup docs

---

## Note sviluppatore

- **BMAD:** Coordinamento via `docs/chat/` PRIMA di toccare i file moduli
- **Git:** `fetch laraxot dev + merge --allow-unrelated-histories + push -u` per ogni modulo — operazioni isolate, non submodule
- **Mai:** `--force`, `checkout --`, `revert` — git solo in avanti
- **Ogni modulo** ha `.git` indipendente: scope atomico per AC-3 verification
