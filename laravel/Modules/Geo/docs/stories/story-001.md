---
scope: module:Geo
---

# STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore

**Epic:** CI/CD — Release Automation
**Priority:** Should Have
**Story Points:** 5
**Status:** In Progress
**Assigned To:** Unassigned
**Created:** 2026-06-03
**Sprint:** 1

---

## User Story

As a **maintainer del monorepo**
I want to **uno stack di release semantic coerente e un changelog avanzato con report/grafici per contributore**
So that **le release non si duplichino e il contributo di ciascuno sia tracciato e visibile**

---

## Description

### Background

Lo stack di **semantic versioning + auto release + changelog** è già presente in
`.github/workflows/` (creato il 2026-06-03): `release.yml`, `semantic-versioning.yml`,
`tag-version.yml`, `semantic-release.yml`, `module-release.yml`, `release-drafter.yml`,
`update-changelog.yml`, `attest-release.yml`, più `.releaserc.json`, `package.json` e
la canon wiki `docs/wiki/how-to/github-actions-semantic-release-stack.md`.

La premessa iniziale ("manca") è quindi **falsa**: lo stack esiste. Restano però:

1. **Rischio doppio-versioning**: `semantic-versioning.yml` gira su `push: ["*"]`
   (quindi anche `main`/`master`), dove però `release.yml` già esegue `semantic-release`.
   Su push a `main` si attivano due meccanismi di tag.
2. **File stale**: `semantic-release.yml.template` (residuo del 2026-05-26).
3. **Feature mancante** (richiesta esplicita): changelog avanzato con **report per
   contributore + grafici**. Nessun workflow attuale lo fornisce.

### Scope

**In scope:**

- Eliminare il rischio doppio-versioning: `semantic-versioning.yml` non deve eseguire
  il job di tag su `main`/`master` (di cui è proprietario `release.yml`).
- Rimuovere `semantic-release.yml.template`.
- Aggiungere `changelog-advanced.yml`: analytics per-contributore con grafici via
  **lowlighter/metrics** (SVG self-contained, nessun SaaS esterno).
- Aggiornare la canon wiki dello stack release.

**Out of scope:**

- Riscrivere la logica di `semantic-release` o `.releaserc.json`.
- Migrazione a strumenti SaaS esterni (RepoBeats) o cambio del generatore di CHANGELOG.
- Modifiche ai workflow di qualità/CI non legati alla release.

### User Flow

1. Merge su `main` con Conventional Commits.
2. `release.yml` esegue `semantic-release` → tag + `CHANGELOG.md` + GitHub Release.
3. `semantic-versioning.yml` su push a `main`/`master` **non** crea tag (skip via guard);
   resta operativo su altri branch e via dispatch.
4. Al completamento di `Release` (e settimanalmente via cron) `changelog-advanced.yml`
   rigenera l'SVG analytics per-contributore e lo committa in `.github/metrics/`.
5. L'SVG è embeddabile nel README per mostrare il contributo nel tempo.

---

## Acceptance Criteria

- [ ] Su push a `main`/`master` viene creato **un solo** tag/release (solo `release.yml`).
- [ ] `semantic-versioning.yml` continua a funzionare su branch non-release e via dispatch.
- [ ] `semantic-release.yml.template` rimosso dal repository.
- [ ] Esiste `.github/workflows/changelog-advanced.yml` con trigger `workflow_run` su
      "Release" (completed), `schedule` settimanale e `workflow_dispatch`.
- [ ] Il workflow genera un SVG con report/grafici per-contributore (lowlighter/metrics),
      escludendo i bot (`dependabot[bot]`, `github-actions[bot]`).
- [ ] L'SVG viene committato con messaggio `[skip ci]` per non innescare nuove release.
- [ ] La canon wiki `github-actions-semantic-release-stack.md` documenta il nuovo workflow
      e la risoluzione del doppio-versioning.
- [ ] Tutti gli YAML passano la validazione (actionlint o parsing YAML).

---

## Technical Notes

### Componenti

- **Workflows:** `release.yml` (invariato), `semantic-versioning.yml` (guard su ref),
  `changelog-advanced.yml` (nuovo), rimozione `semantic-release.yml.template`.
- **Output:** `.github/metrics/*.svg` (committato sul branch di default).
- **Docs:** `docs/wiki/how-to/github-actions-semantic-release-stack.md`.

### Risoluzione doppio-versioning

`semantic-versioning.yml` mantiene `push: ["*"]` ma il job `tag` aggiunge un guard:

```yaml
if: github.event_name != 'push' || (github.ref_name != 'main' && github.ref_name != 'master')
```

Così su push a `main`/`master` il tagging è gestito esclusivamente da `release.yml`,
mentre dispatch/altri branch restano coperti.

### changelog-advanced.yml (lowlighter/metrics)

- Action: `lowlighter/metrics@latest` (SVG self-contained, dati nel repo).
- Token: `secrets.METRICS_TOKEN` (PAT consigliato per dati più ricchi) con fallback a
  `secrets.GITHUB_TOKEN`.
- Plugin: `plugin_contributors` (grafico contributori), `plugin_lines`/charts,
  esclusione bot.
- `output_action: commit`, messaggio con `[skip ci]`.

### Security / Edge cases

- `[skip ci]` obbligatorio sui commit generati per evitare loop di release.
- `permissions: contents: write` minimo necessario per il commit dell'SVG.
- Se `METRICS_TOKEN` assente, il fallback `GITHUB_TOKEN` limita alcuni plugin: documentato.

---

## Dependencies

**Prerequisite:** stack semantic-release già presente (release.yml, .releaserc.json) ✅
**Blocked stories:** nessuna.
**External:** secret opzionale `METRICS_TOKEN` (PAT) per analytics estese.

---

## Definition of Done

- [ ] Workflow modificati/aggiunti committati su branch dedicato.
- [ ] YAML validati (actionlint).
- [ ] Acceptance criteria verificati.
- [ ] Canon wiki aggiornata e cross-linkata.
- [ ] Nessun rischio di doppia release residuo.

---

## Story Points Breakdown

- **CI/CD config (workflows):** 3 punti
- **Docs/wiki:** 1 punto
- **Verifica/validazione:** 1 punto
- **Totale:** 5 punti

**Rationale:** lavoro prevalentemente di configurazione YAML su stack esistente; nessuna
logica applicativa, ma audit dei trigger sovrapposti e integrazione di una nuova action.

---

## Additional Notes

Ricerca online (best practice 2026) per la parte analytics:

- **lowlighter/metrics** — SVG self-contained, 30+ plugin, contributori/grafici (scelto).
- mikepenz/release-changelog-builder — changelog testuale raggruppato per contributore.
- RepoBeats (axiom) — embed analytics esterno (scartato: SaaS/privacy).
- cicirello/user-statistician — card SVG statistiche.

---

## Progress Tracking

**Status History:**
- 2026-06-03: Created by Scrum Master (BMAD create-story)

**Actual Effort:** TBD

---

**This story was created using BMAD Method v6 - Phase 4 (Implementation Planning)**

## GitHub (tracciamento)

Repository letto da frontmatter `github.repository` o `git remote -v` (se assente: repo root **`laraxot/base_quaeris_fila5`**): **`laraxot/base_quaeris_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/issues |
| Discussion | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/discussions |

Il numero non e' scritto perche' non esiste ancora: `gh` non e' autenticato in questa sessione e i repo sono privati. Appena disponibile, creare con:

```bash
gh issue create --repo laraxot/base_quaeris_fila5 \
  --title "STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore" --body-file <FILE>
gh api repos/laraxot/base_quaeris_fila5/discussions -f title="STORY-001: Consolidamento stack release + changelog avanzato con analytics per-contributore" -f body="vedi la story"
```
