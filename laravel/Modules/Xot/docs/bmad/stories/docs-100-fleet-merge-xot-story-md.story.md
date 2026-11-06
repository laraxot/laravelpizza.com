---
title: "Xot - docs-100-fleet-merge-xot-story-md.story.md"
module: Xot
bmad: true
status: active
type: story
updated: 2026-10-23
tags: [docs, xot, bmad]
qmd: "epic   docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05) xot"
---
# Epic: Docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05)

> Status: in-progress. Owner: sessione corrente. Metodo: BMAD + second brain + ponytail.

## Decisione utente (2026-10-05)

- Limite **ricorsivo**: ogni `docs/` di moduli e temi ≤100 `.md` totali.
- Come rientrare: **unire i file, migliorare il contenuto, più sintetico**
  (union + sintesi nel survivor canonico, `git rm` degli originali fusi: la history resta in git).
- Perimetro: **tutto subito**, swarm parallelo con lock.

## Perimetro e baseline (conteggi ricorsivi, audit 2026-10-05)

| Area | Prima | Owner swarm |
| --- | --- | --- |
| Notify/docs | 444 | agente-1 (+Incentivi 101) |
| Rating/docs | 389 | agente-2 (+Lang 101) |
| IndennitaResponsabilita/docs | 370 | agente-3 (+Media 104) |
| Ptv/docs | 271 | agente-4 (+Tenant 102) |
| Sigma/docs | 264 | agente-5 (+Performance 113) |
| Zero/docs (theme) | 241 | agente-6 (+One 117) |
| Progressioni/docs | 130 | agente-7 (+Xot 129) |

Escluse (al limite, conformi): IndennitaCondizioniLavoro 100, Job 100, UI 100.

## Regole per ogni agente (vincolanti)

1. Solo `docs/` del/i modulo/i assegnato/i. Mai codice (`app/`, `tests/`, `config/`, `lang/`).
2. Lock `bashscripts/lock/lock.sh` sui file prima di edit/rm; `unlock.sh` a fine.
3. Merge per unione dei fatti + sintesi; mai perdere fatti di story `in-progress`/`review`
   (se in dubbio: conserva, linka, segnala nel report invece di fondere).
4. Kebab-case minuscolo (`README.md`, `CHANGELOG.md`, `INDEX.md` esclusi).
5. BMAD resta in `docs/bmad/` del modulo; story di questo lavoro in
   `docs/bmad/stories/docs-100-merge-20261005.story.md` del modulo.
6. Dopo ogni fusione: `rg` dei path eliminati dentro `docs/` del modulo, ripara i link interni.
7. Se un test referenzia un doc eliminato: NON toccare il test, segnala nel report.
8. Mai commit/push. Mai `qmd update` (lo fa l'orchestratore una volta sola).
9. Ponytail: niente file-redirect-stub (conterebbero nel limite), niente indici ridondanti.

## Criteri di uscita (per area)

- [ ] `find docs -iname '*.md' | wc -l` ≤ 100
- [ ] Zero collisioni case-insensitive, zero marker di merge
- [ ] Story del modulo scritta; report: prima/dopo, fusi in cosa, segnalazioni test-link

## Rischi noti

- Flapping fleet (resurrezioni da snapshot): verifica finale dei conteggi dall'orchestratore.
- `qmd` lento (timeout 120s il 2026-10-05): un solo `qmd update` finale con timeout, skip documentato se fallisce.
