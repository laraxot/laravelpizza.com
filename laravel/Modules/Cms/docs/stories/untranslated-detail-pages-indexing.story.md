---
title: "[STORY] Pagine di dettaglio non tradotte: lingua dichiarata, indicizzazione e hreflang"
type: story
module: Cms
status: ready-for-decision
priority: medium
created: 2026-11-12
updated: 2026-11-12
tags: [bmad, ecc, seo, head, i18n, hreflang, robots, blog, eventi, a11y, f-07]
qmd: "pagine dettaglio non tradotte blog eventi de es testo italiano lang hreflang robots noindex ResolveWrittenLocalesAction Page"
related:
  - "head-sixteen-layout-migration.story.md"
  - "head-sixteen-parity-closeout.story.md"
  - "../seo-head-architecture.md"
  - "../../../Blog/docs/stories/demo-catalog-summary-localization.story.md"
  - "../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md"
  - "../../../../Themes/Sixteen/docs/plans/front-office-hardening-plan.md"
issues: []
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/95"]
---

# [STORY] Pagine di dettaglio non tradotte: lingua dichiarata, indicizzazione e hreflang

**Discussione (decisioni e alternative scartate):** [#95](https://github.com/laraxot/theme_sixteen_fila5/discussions/95), complementare a [#93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93) (head SEO, D-1..D-7).

## Fase BMAD

**Analysis** chiusa con misura; **decisione aperta** (PO). Nessun codice scritto. Origine: difetto `F-07` dell'audit anonimo del front office
([story madre](../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md)). La story di chiusura dell'head
([head-sixteen-parity-closeout](head-sixteen-parity-closeout.story.md)) lo cita in una riga come «decisione di prodotto separata»: questa è quella decisione. ECC: `seo-specialist` come riferimento, `browser-qa` per la misura.

## Sintomo (misurato il 2026-11-12 sul dev, un articolo)

Pagina `/{lingua}/blog/piano-asfaltature-autunno`, il cui contenuto esiste solo in `it` e `en`:

| Lingua | `<html lang>` | titolo e `<h1>` | `robots` | canonical | hreflang |
|---|---|---|---|---|---|
| it | it | italiano | `index, follow, max-image-preview:large` | su `/it/...` | de, en, es, it, x-default |
| en | en | inglese | idem | su `/en/...` | idem |
| **de** | de | **italiano** | **idem (indicizzabile)** | su `/de/...` | **idem (annuncia anche de ed es)** |
| **es** | es | **italiano** | **idem (indicizzabile)** | su `/es/...` | **idem** |

Misurato su **un** articolo; estendere a tutti gli articoli e a tutti gli eventi è il primo passo dell'implementazione (stessa sonda, 4 lingue).

## Causa (verificata nel codice)

`ResolveWrittenLocalesAction::execute(Page $page)` accetta solo `Modules\Cms\Models\Page` e legge `title` e `content_blocks` grezzi per capire quali lingue sono
«scritte» (regola D-5 della #93: hreflang solo per le lingue con titolo e contenuto reali). Lo stesso vale per la politica `noindex` delle pagine non tradotte in
`ResolveRobotsPolicyAction`. Gli **articoli del blog e gli eventi non sono `Page`**: nessuna delle due regole li vede, quindi si comportano come se fossero scritti in tutte le lingue.

## Perché conta

1. **Contenuto duplicato in italiano** sotto `/de/` e `/es/`, indicizzabile, con canonical proprio.
2. **hreflang che annuncia lingue non scritte**: l'opposto di D-5.
3. **`<html lang>` non corrisponde al testo**: i lettori di schermo leggono italiano con la pronuncia tedesca o spagnola (WCAG 3.1.1, lingua della pagina).
4. Il difetto non dà errori né test rossi: è un difetto muto (vedi [piano di hardening](../../../../Themes/Sixteen/docs/plans/front-office-hardening-plan.md)).

## Opzioni

| Opzione | Cosa cambia | Pro | Contro | Sforzo |
|---|---|---|---|---|
| **A. Estendere le «lingue scritte» ai modelli traducibili** (un contratto condiviso che `Page`, `Post` ed `Event` implementano) | hreflang solo per le lingue con titolo reale; lingue non scritte con `noindex, follow` | Riusa la regola D-5, nessun contenuto inventato, vale per ogni modello futuro | Tocca `Modules/Cms/app` e il modello Blog; serve decidere cosa conta come «scritto» per un articolo (titolo? corpo?) | M |
| **B. Solo `noindex` + `lang` corretto per le lingue non scritte** | robots e attributo `lang` del contenuto | Piccola, subito efficace | hreflang resta sbagliato; due regole diverse per `Page` e modelli | S |
| **C. Tradurre i contenuti** (de/es nel catalogo demo e nei contenuti reali) | dati, non codice | Risolve il sintomo alla radice per i contenuti scritti | Non protegge dal caso successivo; i contenuti reali sono dell'ente | dipende |
| **D. Redirect delle lingue non scritte alla versione italiana** | 301/302 | Niente duplicati | Cambia l'esperienza del cittadino e il selettore lingua; più invasiva | M |

**Proposta:** **A**, con **B** come primo passo se serve chiudere prima. **C** è lavoro sui dati ([F-08](../../../Blog/docs/stories/demo-catalog-summary-localization.story.md)) e non sostituisce la regola.

## Fuori perimetro

- La D-7 (canonical/hreflang sulle pagine `noindex`): decisione separata nella [story di chiusura](head-sixteen-parity-closeout.story.md). **Le due decisioni si influenzano**: con A, le lingue non scritte diventano `noindex`, quindi la risposta alla D-7 decide se portano comunque canonical e hreflang.
- Contenuti reali dell'ente: non sono dati nostri.

## Accettazione (quando si implementa)

- [ ] Esito del PO registrato nel registro DCP-200 (riga `DEC-62` e seguenti) con data.
- [ ] Sonda a 4 lingue sull'elenco completo di articoli ed eventi: per ogni lingua non scritta `robots` coerente con la scelta e nessun hreflang verso lingue non scritte.
- [ ] Test da file nel modulo (`Modules/Cms/tests`): un modello con titolo solo `it`/`en` non produce hreflang `de`/`es`; prova al contrario (rosso se si toglie la regola).
- [ ] Rilancio del go-live gate: nessun nuovo FAIL su `LG-03`/`LG-04`.

## Come riprodurre

```bash
curl -s http://127.0.0.1:8081/de/blog/piano-asfaltature-autunno | grep -oE '<html[^>]*lang="[^"]*"|name="robots"[^>]*|hreflang="[^"]*"|<h1[^>]*>[^<]*'
```
