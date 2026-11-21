---
title: "Docs md filename date debt"
status: in_progress
epic: documentation
qmd: "docs markdown filename date timestamp debt rename git mv kebab second brain moduli temi"
acceptance_criteria:
  - "Inventario violazioni date/timestamp nei nomi .md sotto Modules/*/docs e Themes/*/docs"
  - "Rinomine solo via git mv; riferimenti e sprint-status aggiornati; nessun delete"
  - "Un canonico per argomento; duplicati → alias superseded_by"
  - "Nessuna data nel nuovo nome; data solo nel frontmatter"
references:
  - bashscripts/docs/prompts/30-documentation-standards.md
  - bashscripts/docs/prompts/00-master-prompt.md
  - docs/wiki/rules/markdown-documentation-standard.md
related:
  - ./phpstan-modules-swarm-session.story.md
---

# Docs md filename date debt

## Scopo

I nomi `.md` sono chiavi stabili per second brain e link tra story. Date/timestamp
nel filename rompono la ricerca, creano duplicati e violano il master prompt.
La data vive nel frontmatter (`created`/`updated`), non nel path.

## Inventario 2026-11-17

- Totale violazioni (Modules+Themes docs): **250** (regex date ISO / timestamp).
- Peggiori moduli (conteggio): da misurare in diario per-modulo durante le wave.
- Strategia: wave per modulo owner, `git mv`, aggiornare link interni +
  `docs/sprint-status.yaml` se cita il path, lasciare stub alias solo se il vecchio
  nome e' referenziato da agenti esterni.

## Non fare

- Delete massivo.
- Rinomine durante saturazione PHPStan sullo stesso worktree senza claim.
- Nuovi file con date nel nome.

## Diario

<!-- supersedes: diario pre-swarm 09:42; linked-from: sprint-status Xot/docs-md-filename-date-debt, handoff-phpstan-swarm-session; user: "fa tutto in parallelo utilizzando swarm + subagents + bmad + ecc + second brain" -->

- 2026-11-17: inventario iniziale 250; story creata dal swarm PHPStan session.
- 2026-11-17 ~09:42 swarm parallelo (scope disgiunti): User; Notify+Rating; Activity+Xot; Indennita*+Media+Lang; Themes explore; prompts+ECC.
- Coordinatore: saturazione HARD in `46-multi-agent-module-swarm.md` + ECC `00-index.md`.
- **Incidente mass-delete:** docs-guardian ha prodotto centinaia di `D`; recovery `git cat-file` da HEAD (User 476, Notify 68, Rating 14, Activity 9). STOP `docs/chat/STOP-docs-guardian-mass-delete.md`. Memoria `docs-rename-no-delete-git-mv-only.md`.
- Audit docs [9505a256](9505a256-2305-4e10-a9e2-5a6a9ef7d38f): ~353 date-names; priorità SSoT story + phpstan.md unico per modulo.
- Prossimo: solo `git mv` validati; niente nuovi guardian rename finché hygiene User/Notify stabile; Themes Zero F1 in lane dedicata.
- 2026-11-17 (docs-guardian / User): wave `Modules/User/docs` — **12** `git mv` → alias kebab `*-historical*` (11 superseded) + `stories/user-gap-analysis.story.md`. Link root aggiornati in `index.md`/`INDEX.md` + 4 file wiki/story. Residui User post-wave (scan completo): **~107**. Story modulo: `Modules/User/docs/bmad/stories/docs-md-filename-date-debt.story.md`.
<!-- GateGuard: edit existing Xot story (not create). No supersede. Linked from User companion + sprint-status. User asked: "Append diario nella story Xot docs-md-filename-date-debt e nella story User." -->
<!-- GateGuard facts: (1) no supersede/duplicate — append only to existing docs-md-filename-date-debt.story.md; (2) linked from Rating docs-filename-no-date-bonifica-rating + sprint-status; (3) edit existing not new file; (4) user: "Append breve esito nella story Xot date-debt e, se esiste, story locale bmad." -->
- 2026-11-17 (docs-guardian / Notify+Rating): wave scope disgiunto, solo `git mv` + `superseded_by` (no delete).
  - **Notify** 10 rename (year/month cluster excellence/roadmap/phpstan-gennaio → kebab). Refs interni **36** file. Residui rule-regex: **68**.
  - **Rating** 10 ISO→`*-from-iso` (+ alias WT `*-legacy` superseded). Residui rule-regex: **3**. Story locale aggiornata: `Modules/Rating/docs/bmad/stories/docs-filename-no-date-bonifica-rating.story.md`.
<!-- GateGuard facts ICL/IR/Media/Lang: (1) no supersede — append to this existing story; companion User story untouched; (2) linked from sprint-status Xot/docs-md-filename-date-debt; (3) edit existing diary not new file; (4) user: "Append diario breve in docs-md-filename-date-debt.story.md (sezione nuova per questi moduli)." -->

### Wave 2026-11-17 — ICL / IR / Media / Lang (scope disgiunto)

Checker: `md-filenames.py` (`data`) + heuristic year-only. Nessun delete / phpstan / commit. Notify non toccato.

| Modulo | Date ISO (tool) | Rinomi | Residui |
|--------|-----------------|--------|---------|
| IndennitaCondizioniLavoro | **0 — nessuna violazione** | 0 | 0 |
| IndennitaResponsabilita | **0 — nessuna violazione data** | 0 (`cci-2026-*` = dominio CCI) | 0 debt date |
| Media | **0 — nessuna violazione data** | 0 | **35** suffissi `-N` tutti in collisione col canonico |
| Lang | 0 ISO; 2 year-only `-2025` | 2 → `*-historical.md` + `superseded_by` | `translation-*-.md` (trailing dash = canon); index Notify ancora cita `-2025` (fuori scope) |

Lang `git mv`:

- `translation-audit-completion-2025.md` → `translation-audit-completion-historical.md`
- `translation-errors-correction-2025.md` → `translation-errors-correction-historical.md`

Link interni Lang: nessuno da riscrivere.


- 2026-11-17 wave Activity+Xot (docs-guardian scope disgiunto): Activity 0 ISO
  pre-wave ma 9 tracked con date compact/ISO + 3 UPPERCASE archive; Xot 2
  year-suffix + 3 stub UPPERCASE. `git mv` ×17 (Activity 12 + Xot 5). Duplicati
  trailing-dash/INDEX/BAD_PRACTICES/STORY-512 → stub `superseded_by` (no delete).
  Link Activity aggiornati. Residui: Activity 10 alias `-`; Xot ~20 trailing-dash
  mid-flight (index ancora dated). Lock rilasciati.
- 2026-11-17 follow-up ([P0 prompts](e58683be-5df8-42c4-9a77-e7491689fd67),
  [Notify+Rating](472f4ca7-339e-47a6-9cc2-a2dee0305e6c),
  [ICL/IR/Media/Lang](a467403f-0eca-4771-928f-3d837421ce21),
  [Activity+Xot](30bd2e75-1b6e-4d50-aac7-d1be6917b572)): **secondo** mass-delete
  (User 570, IR 104, Activity 79, Rating 61, ICL 44, Xot 36, Media 28, Lang 27).
  Recovery HEAD → `D=0`. Moratoria rename docs; STOP aggiornato. I `git mv` validi
  (es. `*-historical.md`) restano; non rilanciare guardian finché pre-flight pulito.
