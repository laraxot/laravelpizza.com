---
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
title: "Contratti del modulo Lang"
type: index
tags: [contracts, actions, interfaces, lang, translations]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Lang

>>>>>>> laraxot/dev
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

<<<<<<< HEAD
Ogni invariante ha un ID stabile nel formato `LANG-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

>>>>>>> laraxot/dev
Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
=======
Ogni invariante ha un ID stabile, nel formato `LANG-INV-N` o, per operazione, `LANG-<OPERAZIONE>-INV-<N>` (il language
switcher usa `LANG-SWITCHER-NNN`); il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve
contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di Lang che **scrivono file di lingua** o decidono il testo di ogni componente Filament: sono
le uniche del modulo che possono rompere la produzione (un file di lingua con errore di sintassi = 500 su ogni pagina che
lo carica) o sporcare l'albero dei sorgenti. La superficie pubblica include anche il language switcher, che è un
contratto di presentazione e non di Action.

Leggili prima di chiamare o modificare una di queste Action. Le invarianti con group si verificano con
`cd laravel && vendor/bin/pest Modules/Lang/tests --group=<ID>`; `—` è debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).
>>>>>>> laraxot/dev

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

<<<<<<< HEAD
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
=======
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

## Contratti delle Action
>>>>>>> laraxot/dev

- [AutoLabelAction](auto-label-action.md) — etichette e testi di ogni componente Filament dal file di lingua del modulo chiamante; salva solo le etichette mancanti.
- [SaveTransAction](save-trans-action.md) — scrive una chiave nel file di lingua: `execute()` solo dove l'interruttore lo permette, `persist()` sempre (pannello).
- [CleanPlaceholderTranslationsAction](clean-placeholder-translations-action.md) — toglie dai file «solo dati» i segnaposto uguali al nome del campo; cancella i file `.php` senza nome.
<<<<<<< HEAD
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======

## Language switcher

Tre documenti sullo stesso componente (`LanguageSwitcher` e `LanguageSwitcherWidget`), con invarianti `LANG-SWITCHER-001..003`:

- [LanguageSwitcher component](language-switcher-component.md) — view Blade stateless con URL preparati dal widget.
- [Language switcher view data](language-switcher-view-data.md) — cosa restituisce `LanguageSwitcherWidget::getAvailableLocales()` (codice, nomi, bandiera, URL già localizzato) e che la vista non dipende da Livewire.
- [Language switcher presentation contract](language-switcher.md) — in inglese: ogni lingua è un'ancora normale, link dall'URL localizzato del widget, lingua corrente con `aria-current="page"`.

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; censisce solo i tre documenti del language switcher.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
>>>>>>> laraxot/dev
=======
title: "Contratti — Lang"
type: index
owner: Lang
updated: 2026-11-24
qmd: "Lang contract language switcher presentation-contract localizzazione invarianti LANG-SWITCHER"
---

# Contratti — Lang

Un contract descrive una superficie del modulo Lang con comportamento promesso. Oggi sono tutti contract di presentazione del language switcher (nessuna Action di scrittura ha un contract). Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Formato

Contract di Action: frontmatter `type: contract` e `action: "Modules\\Lang\\Actions\\..."`, sezioni `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`. Contract non-Action: `type: presentation-contract` e `contract: <FQCN>`, senza obbligo delle sei sezioni. Invarianti con ID stabile e test Pest con `->group('<ID>')`. Registro: [INDEX.md](INDEX.md).

## File presenti

- [language-switcher](language-switcher.md) (presentation-contract; definisce `LANG-SWITCHER-001..003`, in inglese)
- [language-switcher-component](language-switcher-component.md) (presentation-contract per `Modules\Lang\View\Components\LanguageSwitcher`)
- [language-switcher-view-data](language-switcher-view-data.md) (`type: contract` ma senza `action` né sei sezioni complete: descrive i dati prodotti da `LanguageSwitcherWidget`)
- Template: [_template](_template.md)

I tre file si sovrappongono parzialmente (stesso componente, stessi ID); consolidarli è lavoro futuro: non sono stati riscritti.
>>>>>>> laraxot/dev
