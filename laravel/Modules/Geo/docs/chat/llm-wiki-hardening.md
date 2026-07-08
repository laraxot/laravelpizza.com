---
title: "LLM Wiki Hardening Coordination"
type: "agent-chat"
tags: [llm-wiki, second-brain, rules, skills, github]
created: 2026-05-19
updated: 2026-06-03
---

## LLM Wiki Hardening Coordination

Current repo resolved with `git remote -v`: `provtv/base_ptv_fila5_mono`.

GitHub context verified:

- Tracking issue: [#122](https://github.com/provtv/base_ptv_fila5_mono/issues/122)
- Default branch: `dev`
- Viewer permission via `gh`: `ADMIN`
- GitHub Wiki is disabled (`hasWikiEnabled=false`), so local `docs/wiki/` remains the operational wiki.
- Historical related issues found closed: #9 and #15.
- GitHub MCP connector currently does not expose this private repo to the installed app; use `gh` for this repo unless connector permissions change.

Work in progress:

- Harden `bashscripts/tools/prompts/llm-wiki.txt` with verified local links, best practices, bad practices, and false friends.
- Keep root `docs/wiki/rules/00-TRIGGER_MAP.md` canonical for routing.
- Keep `docs/wiki/*/INDEX.md` short and route-only.
- Add or improve skill pages only when a workflow is repeatable and verifiable.

Quality bar for agents:

1. Verify paths before adding them to "Verified Links".
2. Do not invent GitHub wiki state; it is disabled right now.
3. Do not preload large docs; use QMD with `--limit`.
4. Log reusable decisions in the nearest `docs/wiki/log.md`.
5. Refresh QMD after structural wiki edits.

## Update: FASE 6–8 (2026-05-19)

- **Memories:** 13 entry in `docs/wiki/memories/` (target 12–15 raggiunto) — tutte con path relativi, no `[[bare]]`.
- **llm-wiki.txt:** +9 false friends, +6 verified links, +2 bad practices; sezioni 18–20 già presenti.
- **Trigger map:** +2 righe (compaction recovery, property_exists memory).
- **How-to:** `wikilink-cross-reference.md` per migrazione link legacy.
- **Prossimo:** sostituire `[[...]]` orphan nei concept legacy (batch editoriale); `qmd embed` opzionale.

## Update: Chiusura #122 / #123 (2026-05-20)

- Wikilink batch su cluster canonico second-brain + `ProjectHome.md`.
- Gate 23/23 dopo rimozione `bashscripts/ai/.agents/node_modules`.
- Issue chiuse con `gh issue close` — follow-up opzionale: `qmd embed`, template `_templates/` wikilink.

## Update: HackerNoon Tip 020 (2026-05-20)

Standard minimo obbligatorio per ogni `.md` wiki: [`markdown-note-minimum-standard.md`](../wiki/concepts/markdown-note-minimum-standard.md). Allineato a [HackerNoon Tip 020](https://hackernoon.com/ai-coding-tip-020-create-a-second-brain) — YAML, atomicità, PARA mappato al monorepo, checklist agent.

## Update: Forbidden Residues

Verified absent locally:

- `laravel/Modules/Notify/.agent~HEAD`
- `laravel/Modules/Notify/.ai-context~HEAD`
- `laravel/Modules/Notify/.ai~HEAD`
- `laravel/Modules/Notify/.clauderules~HEAD`
- `laravel/Modules/Notify/.claude~HEAD`
- `laravel/Modules/Notify/.cursor~HEAD`
- `laravel/Modules/Notify/.iflow~HEAD`
- `laravel/Modules/Notify/.junie~HEAD`
- `laravel/Modules/Notify/.phive~HEAD`
- `laravel/Modules/Notify/.windsurf~HEAD`
- `laravel/Modules/Notify/.zai~HEAD`
- `laravel/Modules/Media/docs/wiki/_archive/`

General rule added to prompt: no merge residue files (`*~HEAD`, `*~BASE`, `*~LOCAL`, `*~REMOTE`, `.orig`, `.rej`) and no wiki archive folders. Use git history for the past and active wiki pages for current knowledge.

## Update: Reality Discipline

Removed unverified wording that described `docs/raw/` as immutable/read-only. Current rule: raw docs are source evidence and should be edited conservatively, but agents must verify actual file state and permissions before claiming something is read-only or immutable.

---

## Thread ITA — sync agenti (previously `cursor-sync`)

**Repo:** `git@github.com:provtv/base_ptv_fila5_mono.git` (`provtv/base_ptv_fila5_mono`)

### GitHub

- Issue aperte rilevanti: **#122** ([DOCS] Harden LLM Wiki prompt), **#123** (Second Brain FASE 3–8).
- Metadati verificati con `gh api repos/provtv/base_ptv_fila5_mono --jq .has_wiki` → **`false`** (nessun GitHub Wiki remoto da clonare).
- Per issue/PR usare sempre `gh … --repo provtv/base_ptv_fila5_mono`.

### Repo / prompt

- Aggiornato `bashscripts/tools/prompts/llm-wiki.txt`: link verificati con `test -f`, sezioni §17–§20 ripulite da path assenti in root (`mcp.json` globale non presente); aggiunti deep link Filament/context-mode; GitHub workflow esplicito.
- Gate consigliato: `bashscripts/quality-gates/verify-llm-wiki.sh`.

### Prossimi passi suggeriti

1. Chiudere o commentare #122 dopo revisione umana del prompt.
2. Allineare #123 (trigger map / skill expansion) senza path inventati — solo verifica filesystem + QMD.

## Update: Prompt + gate check (2026-05-27)

- Aggiornato `bashscripts/tools/prompts/llm-wiki.txt` per:
  - rafforzare la disciplina “domande esplicite” in issue (discussione come meccanismo qualità),
  - aggiungere bad practice su path assoluti in issue/docs,
  - aggiungere link verificati a `docs/wiki/how-to/module-theme-github-issues.md` e `docs/chat/module-theme-github-issues-manifest.md`,
  - rimuovere sezioni non portabili con “link da creare” / istruzioni non verificate.

### Gate `verify-llm-wiki.sh` (eseguito via `bash`)

- Fail: presenza `bashscripts/ai/.agents/node_modules` (forbidden).
- Warning: molte cartelle `archive/` e `backup/` rilevate (da triage; evitare naming in aree wiki e ridurre rumore).

Domanda agli altri agenti: confermate che `node_modules` in `.agents` va rimosso sempre (senza eccezioni), o ci sono casi legacy da migrare prima?

## Update: prompt compatto + gate verde (2026-06-03)

- `llm-wiki.txt`: 1031 → 123 righe; duplicati spostati in wiki on-demand.
- Rimosso `bashscripts/ai/.agents/node_modules` — gate **37/37 passed** (warning archive/backup invariati).
- Story BMAD: [story-166-second-brain-ui-mcp.md](./story-166-second-brain-ui-mcp.md) · issue [#166](https://github.com/provtv/base_ptv_fila5_mono/issues/166).
- Trigger map: riga UI/UX MCP on-demand.

— Cursor (`composer-2.5-fast`)
