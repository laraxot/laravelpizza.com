---
title: "Epic: Docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05)"
type: story
module: Xot
bmad: true
status: in-progress
updated: 2026-10-09
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

## Misura del 2026-10-22 (worklog del giorno, prompt 98, Passo 7)

Misura in sola lettura (`docs-organizer.py audit --out`), nessuna correzione: le story di consolidamento docs sono aperte. Moduli con commit il 2026-10-22.

| Modulo | md | link | rotti | collisioni maiuscole | nomi con data | doppioni | stub |
|---|---:|---:|---:|---:|---:|---:|---:|
| AI | 266 | 257 | 18 | 23 | 0 | 12 | 61 |
| Activity | 812 | 697 | 187 | 0 | 4 | 6 | 154 |
| Cms | 983 | 1355 | 465 | 31 | 0 | 25 | 202 |
| Gdpr | 430 | 245 | 10 | 14 | 0 | 32 | 172 |
| Geo | 2102 | 382 | 128 | 80 | 12 | 185 | 357 |
| Job | 527 | 116 | 42 | 0 | 3 | 8 | 200 |
| Lang | 1023 | 461 | 104 | 96 | 2 | 11 | 68 |
| Media | 582 | 462 | 127 | 45 | 2 | 14 | 102 |
| Notify | 3889 | 1055 | 426 | 602 | 14 | 41 | 129 |
| Quaeris | 208 | 85 | 14 | 0 | 12 | 0 | 1 |
| UI | 443 | 132 | 98 | 0 | 0 | 0 | 290 |
| User | 2641 | 6704 | 3297 | 97 | 13 | 29 | 174 |
| Xot | 1618 | 637 | 346 | 13 | 1 | 10 | 1002 |
| **Totale** | 15524 | 12588 | 5262 | 1001 | 63 | 373 | 2912 |

Lo stesso giorno, in Notify, i 719 link riscritti verso i nomi senza data (commit `42f1b0d010`) erano validi 47 prima e 55 dopo le rinomine: il resto puntava gia' a file inesistenti. Dettaglio in `docs/worklog/2026/10/22/`.

## Misura del 2026-10-29 (worklog del giorno, prompt 98, Passo 7)

Misura in sola lettura (`docs-organizer.py audit --out`), nessuna correzione: le story di consolidamento docs sono ancora aperte. Moduli con commit propri il 2026-10-29 (il riallineamento della radice tocca anche AI, Cms, Gdpr, Job, Lang e Zero, ma senza commit di quel giorno nei loro repo).

| Modulo | md | link | rotti | collisioni maiuscole | nomi con data | doppioni | stub |
|---|---:|---:|---:|---:|---:|---:|---:|
| Activity | 710 | 231 | 87 | 0 | 0 | 1 | 130 |
| Chart | 671 | 733 | 585 | 0 | 1 | 8 | 33 |
| Geo | 2048 | 341 | 121 | 19 | 12 | 47 | 345 |
| Limesurvey | 71 | 39 | 3 | 0 | 2 | 0 | 13 |
| Media | 556 | 204 | 26 | 32 | 0 | 2 | 112 |
| Notify | 3633 | 672 | 241 | 536 | 0 | 0 | 144 |
| Quaeris | 209 | 85 | 14 | 0 | 12 | 0 | 1 |
| Tenant | 529 | 185 | 70 | 0 | 0 | 0 | 134 |
| UI | 454 | 359 | 304 | 3 | 0 | 1 | 56 |
| User | 2136 | 301 | 134 | 82 | 0 | 2 | 144 |
| Xot | 1568 | 606 | 380 | 2 | 0 | 0 | 340 |
| **Totale** | 12585 | 3756 | 1965 | 674 | 27 | 61 | 1452 |

Confronto con il 2026-10-22 sui moduli presenti in tutte e due le misure: i link rotti scendono in User (da 3297 a 134), Notify (da 426 a 241), Activity (da 187 a 87), Media (da 127 a 26) e Geo (da 128 a 121); salgono in UI (da 98 a 304) e Xot (da 346 a 380); restano 14 in Quaeris. Gli stub di Xot scendono da 1002 a 340. Le variazioni vengono dai commit di modulo registrati fra le due misure (dettaglio in `docs/worklog/2026/10/29/`), non da correzioni del Passo 7.


## Misura del 2026-11-03 (worklog del giorno, prompt 98, Passo 7)

Misura in sola lettura (`docs-organizer.py audit --out`), nessuna correzione: questa story e' ancora `in-progress`. Moduli e temi con commit propri il 2026-11-03 (il riallineamento della radice tocca anche AI, Cms, Gdpr, Job, Lang, Media e UI, ma senza commit di quel giorno nei loro repo).

| Perimetro | md | link | rotti | collisioni maiuscole | nomi con data | doppioni | stub |
|---|---:|---:|---:|---:|---:|---:|---:|
| Activity | 712 | 231 | 87 | 0 | 0 | 1 | 130 |
| Geo | 2050 | 343 | 122 | 19 | 12 | 47 | 345 |
| Notify | 3635 | 673 | 241 | 536 | 0 | 0 | 144 |
| Quaeris | 211 | 85 | 14 | 0 | 12 | 0 | 1 |
| Tenant | 532 | 186 | 70 | 0 | 0 | 0 | 133 |
| User | 2140 | 303 | 134 | 82 | 0 | 2 | 144 |
| Xot | 1576 | 609 | 380 | 2 | 1 | 0 | 340 |
| Zero (tema) | 234 | 281 | 34 | 4 | 0 | 0 | 6 |
| **Totale** | 11090 | 2711 | 1082 | 643 | 25 | 50 | 1243 |

Confronto con il 2026-10-29 sui sette moduli misurati in tutte e due le date: link rotti invariati in Activity (87), Notify (241), Quaeris (14), Tenant (70), User (134) e Xot (380), +1 in Geo (da 121 a 122). In Xot compare un nome con data, `bmad/stories/phpstan-analyse-modules.story.md`: aggiunto il 2026-09-24 da Marco Sottana e arrivato con il pull, non creato oggi. Zero non era nella misura del 2026-10-29. Le variazioni vengono dai commit di modulo fra le due misure (dettaglio in `docs/worklog/2026/11/03/`), non da correzioni del Passo 7.

## Misura del 2026-11-12 (worklog del giorno, prompt 98, Passo 7)

Fonte: `docs-organizer.py audit` (sola lettura) sui 14 moduli con commit propri il 2026-11-12 (colonna 4 di `#repo` del
registro), raccolta alle 18:38 CET. Nessuna correzione: la story e' `in-progress`, quindi il Passo 7 si ferma alla
misura. Worklog: `docs/worklog/2026/11/12/index.md`.

| Perimetro | n_md | links | broken_n | case_collisions | dated_names | dup_extra | stubs |
|---|---:|---:|---:|---:|---:|---:|---:|
| AI | 260 | 261 | 21 | 0 | 1 | 1 | 60 |
| Chart | 671 | 733 | 585 | 0 | 1 | 8 | 33 |
| Cms | 948 | 1382 | 349 | 0 | 1 | 2 | 190 |
| Gdpr | 422 | 94 | 40 | 0 | 0 | 4 | 156 |
| Geo | 1873 | 344 | 148 | 19 | 12 | 45 | 337 |
| Job | 453 | 97 | 18 | 0 | 0 | 0 | 176 |
| Media | 548 | 205 | 35 | 32 | 0 | 3 | 112 |
| Notify | 3492 | 651 | 233 | 536 | 1 | 1 | 133 |
| Quaeris | 227 | 108 | 14 | 0 | 15 | 0 | 1 |
| Setting | 96 | 33 | 4 | 1 | 3 | 1 | 48 |
| Tenant | 531 | 318 | 182 | 0 | 0 | 0 | 124 |
| UI | 458 | 362 | 304 | 3 | 1 | 2 | 55 |
| User | 2209 | 329 | 134 | 82 | 4 | 5 | 114 |
| Xot | 1096 | 588 | 390 | 2 | 1 | 0 | 252 |
| **Totale** | 13284 | 5505 | 2457 | 675 | 40 | 72 | 1791 |

Confronto con il 2026-11-03 sui sei moduli misurati in tutte e due le date: link rotti invariati in Quaeris (14) e User
(134), scesi in Notify (241 -> 233), saliti in Geo (122 -> 148), Tenant (70 -> 182) e Xot (380 -> 390); stub scesi in
Xot (340 -> 252), User (144 -> 114), Notify (144 -> 133), Tenant (133 -> 124), Geo (345 -> 337). File Markdown di Xot
da 1576 a 1096 e di Geo da 2050 a 1873: coerente con lo spostamento delle note da `app/` a `docs/` e con il
riallineamento della radice dell'11-12 novembre, non verificato file per file. L'aumento dei link rotti in Tenant
(+112) e' da indagare prima di qualsiasi `links --fix`.
