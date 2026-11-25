---
status: accepted
date: 2026-11-25
decision-makers: [Xot]
title: "ADR — I nomi delle Queueable Action non iniziano con Resolve"
type: decision
module: Xot
qmd: "ADR 0016 action naming Get not Resolve QueueableAction convention"
related:
  - ../bmad/stories/action-names-resolve-to-get.story.md
  - ../../Progressioni/docs/adr/0011-action-names-get-not-resolve.md
  - ../../Ptv/docs/adr/0003-get-not-resolve-naming.md
  - ../../Ptv/docs/bmad/stories/5.249-rename-resolvescategori-ecocoloader-to-get.story.md
  - ../../Sigma/docs/adr/0001-action-names-get-not-resolve.md
  - ../../../../../bashscripts/ai/wiki/memories/action-names-get-not-resolve.md
---

<!-- Fact-gate: edit ADR esistente; related cross-link Progressioni/Sigma/memoria;
     user: Action Get non Resolve + docs/adr. -->

# I nomi delle Queueable Action non iniziano con `Resolve`

## Contesto

Nel codebase esistevano decine di `Resolve*Action`. Il verbo **Resolve** e'
ambiguo (routing CMS, DI, path) e non allinea la convenzione gia' dominante
delle Action di lettura (`Get*Action`, `Count*Action`, `List*Action`).

## Driver

- Convenzione unica e ricercabile: lettura/derivazione → **`Get*`**
- Evitare falsi positivi di naming e drift tra moduli
- Allineamento a Spatie Queueable Action + Laraxot (`actions-over-services`)

## Alternative scartate

- Tenere `Resolve*` per "calcolo/derivazione" e `Get*` per "fetch" — troppa
  soggettivita', viola la regola utente
- Prefissi `Fetch*` / `Lookup*` — meno presenti nel repo

## Decisione

1. **Vietato** creare nuove classi `*Action` il cui nome inizia con `Resolve`.
2. Le Action di lettura/derivazione usano **`Get*`** (es.
   `GetCategoriaEcoByProproAction`, `GetLastEsperienzaAtAction`).
3. **Stessa regola sui Concern/trait Filament** di lettura: mai `Resolve*` /
   `Resolves*` (es. `GetCategoriaEcoColumn`, non `ResolvesCategoriaEcoColumn`)
   — [Ptv 0003](../../Ptv/docs/adr/0003-get-not-resolve-naming.md).
4. Altri verbi restano ammessi quando descrivono l'effetto: `Update*`,
   `Refresh*`, `Count*`, `List*`, `Send*`, `Build*`, …
5. I file contratto kebab-case seguono il nome classe:
   `get-categoria-eco-by-propro-action.md` (non `resolve-…`).

## Conseguenze

- Positivo: naming prevedibile; grep `Resolve*Action` deve restare vuoto in
  `Modules/*/app/Actions`.
- Negativo: rename ampia (26 classi Modules, 2026-11-25); riferimenti docs
  storici possono citare ancora il vecchio nome in audit/wiki — aggiornare
  al tocco.

## Conferma

```bash
find laravel/Modules -path '*/app/Actions/*' -name 'Resolve*Action.php'
# atteso: vuoto
rg -n 'class Resolve\w+Action' laravel/Modules --glob '*Action.php'
# atteso: vuoto
test ! -f laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/Concerns/ResolvesCategoriaEcoColumn.php
# atteso: assente (SSoT = GetCategoriaEcoColumn)
```
