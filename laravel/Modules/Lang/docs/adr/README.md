---
<<<<<<< HEAD
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-18
=======
<<<<<<< HEAD
title: "Lang — Architecture Decision Records"
type: index
status: active
updated: 2026-11-23
>>>>>>> laraxot/dev
---

# Architecture Decision Records

<<<<<<< HEAD
Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Decisioni

=======
- [La vista lingua è standalone e riceve URL precomputati](language-switcher-standalone-view.md)
=======
title: "ADR del modulo Lang"
type: index
tags: [adr, decisioni, lang, translations]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Lang

Il **perché** di come Lang porta i testi nel pannello Filament: le etichette nascono dai file di lingua del modulo che
usa il componente (non da `->label()` nel codice), e le chiavi mancanti diventano scritture su file solo in ambiente
locale, perché un file di lingua riscritto a runtime può mandare in 500 la produzione e sporcare l'albero sotto test.

Leggili prima di: scrivere etichette in una Resource, toccare `AutoLabelAction`, `SaveTransAction` o
`LangServiceProvider::registerFilamentLabel()`, o cambiare la configurazione `lang.save_missing_translations`.

Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Indice

- [Le etichette Filament vengono dai file di lingua del modulo](filament-labels-from-module-translation-files.md) — `configureUsing` + `AutoLabelAction` su ogni componente; niente `->label()` nelle Resource.
- [Le chiavi mancanti si scrivono nei file solo in locale](missing-translations-written-only-in-local.md) — `execute()` dietro l'interruttore (default `isLocal()`), `persist()` per il pannello; mai segnaposto ausiliari.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
