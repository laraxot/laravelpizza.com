---
title: "BMAD Brainstorming — Cms"
type: bmad-brainstorming
status: synthesized
module: Cms
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, brainstorming, scamper, starbursting, second-brain, cms]
qmd: "bmad brainstorming cms perche insight rischi"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-planning.md
  - ./bmad/filament-blueprint.md
---

# Domanda guida

Come evitare che i blocchi CMS diventino una seconda homepage hardcoded nel tema?

## 5 Whys (sintesi)

1. L'utente sente frizione o opacita sul valore di **Cms**.
2. La frizione nasce da confini poco chiari tra owner e consumer.
3. I confini si offuscano quando UI, persistenza e policy vivono nello stesso file "comodo".
4. Senza contratto, ogni fix locale crea una seconda verita.
5. Serve planning BMAD + blueprint Filament + docs owner come unica memoria operativa.

## Starbursting

- **Chi:** editor CMS, guest, tenant admin
- **Cosa:** Far gestire a ogni comune pagine, menu, blocchi e contenuti di servizio localizzati.
- **Quando:** a ogni incremento che tocca questo owner; decisioni in decision-log.
- **Dove:** `laravel/Modules/Cms/docs/` (+ `docs/bmad/`).
- **Perché:** parallelismo sicuro, DRY, auditabilita, nessun `bmad-output/`.
- **Come:** track `bmad-method` -> planning -> (architecture/UX se serve) -> stories ready-for-dev.

## SCAMPER

| Leva | Idea | Impatto | Fattibilita |
|---|---|---:|---:|
| Substitute | Servizi ad-hoc -> Actions + XotBase Filament in Cms | H | H |
| Combine | Planning BMAD + second brain docs owner + blueprint Filament | H | H |
| Adapt | Pattern Fixcity (policy, ledger, tenant) dove il modulo tocca dati civici | H | M |
| Modify | Ridurre superficie API pubblica ai contratti consumer | H | M |
| Eliminate | Duplicazioni di verita (second store, Livewire legacy, Controllers) | H | H |
| Reverse | Progettare dai failure mode privacy/authz prima delle feature | H | H |

## Reverse brainstorming — come romperlo

- Copiare planning Ticket in questo owner (gia successo: stub da correggere).
- Mettere business rules nel tema o Controllers.
- Inventare store paralleli (es. timeline duplicata).
- Estendere Filament core invece di `XotBase*`.
- Scrivere docs in `bmad-output/`.

## Insight selezionati

1. Lo scopo di **Cms** e: Far gestire a ogni comune pagine, menu, blocchi e contenuti di servizio localizzati.
2. Tutto cio che e in **Out** va linkato all'owner vero, non reimplementato.
3. Filament e chrome/admin o widget FO montato: non e il dominio.
4. Il second brain vive accanto al codice owner; QMD trova, non possiede.

## Prossimo step BMAD

Vedi [bmad-planning.md](./bmad-planning.md) — eseguire la Wave 1 e aggiornare il decision-log owner.

## Iniziativa Head Sixteen

Per l'adozione del componente Head Cms nel tema Sixteen, il brainstorming multi-tecnica e' nel report owner del tema: [front-office-readiness-brainstorming.md](../../../Themes/Sixteen/docs/bmad/front-office-readiness-brainstorming.md). Le decisioni approvate e la D-7 ancora aperta sono raccolte nella [GitHub discussion #93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93) e nel [piano di adozione Head](./bmad/head-component-adoption-plan.md).

## Sessione 85: D-7 e pagine non tradotte (2026-11-12)

Evidenze: diff dell'head su 128 URL in [head-sixteen-layout-migration](./stories/head-sixteen-layout-migration.story.md); misura sul blog in [untranslated-detail-pages-indexing](./stories/untranslated-detail-pages-indexing.story.md). Decisioni e alternative scartate: [discussion #95](https://github.com/laraxot/theme_sixteen_fila5/discussions/95). Le due decisioni **si influenzano** e vanno prese insieme.

### Matrice delle opzioni (1 = peggio, 3 = meglio)

| Criterio | D-7 (a) canonical + hreflang anche su `noindex` | D-7 (b) restringere `LG-03`/`LG-04` | F-07 (A) lingue «scritte» ai modelli traducibili | F-07 (B) solo `noindex` + `lang` | F-07 (D) redirect all'italiano |
|---|---|---|---|---|---|
| Parita' con il vecchio head | 3 | 1 | n/a | n/a | n/a |
| Rischio SEO | 2 | 2 | 3 | 2 | 2 |
| Accessibilita' (lingua dichiarata) | n/a | n/a | 3 | 2 | 3 |
| Sforzo | 2 | 3 | 1 | 3 | 1 |
| Reversibilita' | 3 | 3 | 2 | 3 | 1 |
| Effetto sul gate go-live | chiude `LG-03`/`LG-04` | chiude per ridefinizione | nessuno diretto | nessuno diretto | nessuno diretto |

Lettura: D-7 (a) + F-07 (A) e' la coppia coerente (la regola «scritto o no» decide quali pagine sono `noindex`, e la D-7 decide se anche quelle portano canonical e hreflang). D-7 (b) + F-07 (B) e' la coppia veloce, con due regole diverse per `Page` e modelli.

### Reverse brainstorming: come rompere di nuovo la parita'

1. Aggiungere un nuovo modello pubblico (evento, servizio) senza passarlo dal contratto delle lingue «scritte».
2. Cambiare `noindex_paths` nel tenant senza rilanciare lo sweep.
3. Aggiornare `laravel/head` senza un diff su 128 URL.
4. Spostare il controllo `LG-03`/`LG-04` sulle sole pagine indicizzabili e scordare che le pagine `noindex` erano il motivo.

Prevenzione: test da file nel modulo che confronta le lingue «scritte» di ogni modello pubblico, e lo sweep dell'head come strumento versionato ([piano di hardening](../../../Themes/Sixteen/docs/plans/front-office-hardening-plan.md), onda 3).
