---
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

<<<<<<< HEAD
=======
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `LANG-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

>>>>>>> laraxot/dev
Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

<<<<<<< HEAD
=======
- [LanguageSwitcher component](language-switcher-component.md) — view Blade
  stateless con URL preparati dal widget.

- [Language switcher view data](language-switcher-view-data.md)

=======
title: "Contratti del modulo Lang"
type: index
tags: [contracts, actions, lang, translations]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Lang

Cosa promettono le Action di Lang che **scrivono file di lingua** o decidono il testo di ogni componente Filament: sono
le uniche del modulo che possono rompere la produzione (un file di lingua con errore di sintassi = 500 su ogni pagina che
lo carica) o sporcare l'albero dei sorgenti.

Leggili prima di chiamare o modificare una di queste Action. Le invarianti con group si verificano con
`cd laravel && vendor/bin/pest Modules/Lang/tests --group=<ID>`; `—` è debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Indice

- [AutoLabelAction](auto-label-action.md) — etichette e testi di ogni componente Filament dal file di lingua del modulo chiamante; salva solo le etichette mancanti.
- [SaveTransAction](save-trans-action.md) — scrive una chiave nel file di lingua: `execute()` solo dove l'interruttore lo permette, `persist()` sempre (pannello).
- [CleanPlaceholderTranslationsAction](clean-placeholder-translations-action.md) — toglie dai file «solo dati» i segnaposto uguali al nome del campo; cancella i file `.php` senza nome.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
