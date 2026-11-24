---
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
title: "ADR del modulo Lang"
type: index
status: active
>>>>>>> laraxot/dev
tags: [adr, decisioni, lang, translations]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Lang

Il **perché** di come Lang porta i testi nel pannello Filament: le etichette nascono dai file di lingua del modulo che
usa il componente (non da `->label()` nel codice), e le chiavi mancanti diventano scritture su file solo in ambiente
locale, perché un file di lingua riscritto a runtime può mandare in 500 la produzione e sporcare l'albero sotto test.

Leggili prima di: scrivere etichette in una Resource, toccare `AutoLabelAction`, `SaveTransAction` o
<<<<<<< HEAD
`LangServiceProvider::registerFilamentLabel()`, o cambiare la configurazione `lang.save_missing_translations`.

Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).
=======
`LangServiceProvider::registerFilamentLabel()`, cambiare la configurazione `lang.save_missing_translations`, o
modificare il selettore di lingua.

Questo README è l'unico indice della cartella: ogni ADR vi compare come `[titolo](file.md)`.
Un ADR registra una scelta difficile da invertire o sorprendente, con un trade-off reale; una decisione nuova ne
supera una vecchia (`status: superseded` con link alla nuova), non ne riscrive la storia. Non si scrive un ADR per un
dettaglio locale o un'ipotesi non verificata. Standard condivisi: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato

Un file per decisione, nome in kebab-case che dice l'argomento, **senza numero e senza data** (la data sta nella
frontmatter). Frontmatter con `type: decision` e `status: proposed | accepted | superseded | deprecated`.
Sezioni, nell'ordine:

1. `## Contesto`
2. `## Decisione`
3. `## Alternative scartate`
4. `## Conseguenze`
5. `## Verifica` — comandi o test che esistono; i path `Modules/...php` citati devono esistere.

Un ADR sostanziale aggiunge `## Driver` (o `## Driver della decisione`) e `## Conferma`.
Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md), controllate da
`laravel/Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.

Scheletro per un nuovo ADR:

```markdown
---
title: "Titolo"
type: decision
status: proposed
created: AAAA-MM-GG
---

# Titolo

## Contesto
## Decisione
## Alternative scartate
## Conseguenze
## Verifica
```
>>>>>>> laraxot/dev

## Indice

- [Le etichette Filament vengono dai file di lingua del modulo](filament-labels-from-module-translation-files.md) — `configureUsing` + `AutoLabelAction` su ogni componente; niente `->label()` nelle Resource.
- [Le chiavi mancanti si scrivono nei file solo in locale](missing-translations-written-only-in-local.md) — `execute()` dietro l'interruttore (default `isLocal()`), `persist()` per il pannello; mai segnaposto ausiliari.
<<<<<<< HEAD
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- [La vista lingua è standalone e riceve URL precomputati](language-switcher-standalone-view.md) — link HTML ordinari, nessun `$this` nella vista.
- [Cambio lingua con URL localizzato](cambio-lingua-con-url-localizzato.md) — `LanguageSwitcherWidget` con `getLocalizedURL()` e solo locali supportati.
- [Lang possiede i dati di localizzazione](lang-owns-localization-data.md) — selezione e dati di traduzione stanno in Lang; i moduli owner forniscono le chiavi.
>>>>>>> laraxot/dev
=======
title: "ADR — Lang"
type: index
owner: Lang
updated: 2026-11-24
qmd: "Lang ADR architecture decision record MADR formato localizzazione etichette traduzioni"
---

# ADR — Lang

Un ADR del modulo Lang registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale su localizzazione, traduzioni e cambio lingua. Ogni affermazione ha un file di prova. Template condiviso: [0000-template](../../../Xot/docs/adr/0000-template.md); standard: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato MADR

Frontmatter (`title`, `type: decision`, `status`, `created`, `updated`, `decision-makers`, `module`, `qmd`) e sezioni nell'ordine: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Nome file in kebab-case; il file storico `0001-cambio-lingua-con-url-localizzato.md` mantiene il numero.

## ADR presenti

Elenco con stato: [INDEX.md](INDEX.md). Ultimo aggiunto: [filament-labels-are-autoconfigured-by-lang-provider](filament-labels-are-autoconfigured-by-lang-provider.md).

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
>>>>>>> laraxot/dev
