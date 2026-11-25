---
title: "ADR del modulo Lang"
type: index
status: active
tags: [adr, decisioni, lang, translations]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Lang

Il **perché** di come Lang porta i testi nel pannello Filament: le etichette nascono dai file di lingua del modulo che
usa il componente (non da `->label()` nel codice), e le chiavi mancanti diventano scritture su file solo in ambiente
locale, perché un file di lingua riscritto a runtime può mandare in 500 la produzione e sporcare l'albero sotto test.

Leggili prima di: scrivere etichette in una Resource, toccare `AutoLabelAction`, `SaveTransAction` o
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

## Indice

- [Le etichette Filament vengono dai file di lingua del modulo](filament-labels-from-module-translation-files.md) — `configureUsing` + `AutoLabelAction` su ogni componente; niente `->label()` nelle Resource.
- [Le chiavi mancanti si scrivono nei file solo in locale](missing-translations-written-only-in-local.md) — `execute()` dietro l'interruttore (default `isLocal()`), `persist()` per il pannello; mai segnaposto ausiliari.
- [La vista lingua è standalone e riceve URL precomputati](language-switcher-standalone-view.md) — link HTML ordinari, nessun `$this` nella vista.
- [Cambio lingua con URL localizzato](cambio-lingua-con-url-localizzato.md) — `LanguageSwitcherWidget` con `getLocalizedURL()` e solo locali supportati.
- [Lang possiede i dati di localizzazione](lang-owns-localization-data.md) — selezione e dati di traduzione stanno in Lang; i moduli owner forniscono le chiavi.
