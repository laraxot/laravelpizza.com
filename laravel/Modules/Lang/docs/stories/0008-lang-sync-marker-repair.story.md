---
qmd: "lang sync marker repair story"
issues: []
discussions: []
title: "Lang: marcatori di conflitto committati dal sync nel codice"
type: story
scope: module:Lang
module: Lang
story_id: "LANG-SYNC-MARKERS"
slug: lang-sync-marker-repair
status: review
created: 2026-11-24
updated: 2026-11-24
tags: [sync, git, conflitti, phpstan]
related:
  - "../conflict-resolution.md"
  - "../../../Xot/docs/lessons/module-sync-merge-conflicts.md"
---
# Lang: marcatori di conflitto committati dal sync nel codice

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Obiettivo

`phpstan analyse Modules` non parte se un file PHP contiene `<<<<<<<` / `=======` / `>>>>>>>`. `merge_remote_repo_2.sh` li ha committati (`commit -am .`),
anche annidati, in 11 file PHP e 1 vista Blade di Lang. Obiettivo: per ogni file capire a cosa serve e lasciare un file coerente con quello scopo, non
scegliere un lato a caso.

## Perimetro

Solo `laravel/Modules/Lang` (php e blade; i `.md` seguono altre lane). Nessun file fuori dal modulo toccato per il codice.

## File, scopo e risoluzione

| File | Scopo | Risoluzione | Righe scartate |
|---|---|---|---|
| `app/Actions/CleanPlaceholderTranslationsAction.php` | togliere dai file di lingua i segnaposto uguali al nome del campo | unito: `@contract` (guardia `ActionContractsAreCompleteTest`) + `@see` | solo righe di marcatore |
| `app/Actions/Filament/AutoLabelAction.php` | etichette/testi d'aiuto Filament dai file di lingua del modulo del chiamante | unito: lati identici salvo stile; `$type === 'label'`, `@return` a uno spazio; `@see` su classe, `findCallerFrame()`, `execute()` (+ docblock di `execute()`) | `'label' === $type` e `@return` a due spazi (stesso significato) |
| `app/Actions/GetAllTranslationAction.php`, `GetAllModuleTranslationAction.php` | elenco file di lingua dei moduli (corpo identico, vedi contratti) | unito: descrizione, `@see`, `@contract` | solo righe di marcatore |
| `app/Actions/SaveTransAction.php`, `WriteTranslationFileAction.php` | scrittura di una chiave / scrittura sicura del file di lingua | unito: `@see` + `@contract` | solo righe di marcatore |
| `app/Models/Post.php` | modello `lang.posts` | `use Illuminate\Support\Str` tolto: mai usato nel file | 1 `use` inutilizzato |
| `resources/views/components/language-switcher.blade.php` | dropdown lingue del componente `LanguageSwitcher` | tenuta la vista con `$locale['url']` (URL gia' risolti dal widget); `@see` nel commento di testa | variante con `$this->getLanguageUrl()`, `wire:click` e funzione globale `getLanguageUrl()` nella vista: vietati dal contratto e da `LangCoverageBoostTest` (nessun `$this` nell'HTML) |
| `tests/Pest.php` | helper dei test del modulo | forma con FQCN, uguale al riferimento buono; `@see` su `makeLangServiceProvider()` | `use` di `LangServiceProvider`/`TestCase` (l'altro lato) |
| `tests/Support/Ensure.php` | catena di asserzioni PHPStan-safe | `@param` in forma Pint; `@see` su classe, `toHaveKeys()`, `throws()` | `@param` a spazio singolo |
| `tests/Feature/AutoLabelActionContractTest.php` | contratto di `AutoLabelAction` | `new X` senza parentesi (forma Pint) | `new X()` |

## Nota di processo

All'avvio della lane i marcatori risultavano gia' tolti nel working tree (file modificati tra le 20:59:21 e le 21:00:15 del 24/11/2026 da un'altra
passata, prima di qualsiasi scrittura di questa lane; `git diff HEAD` mostrava solo cancellazioni, cioe' il primo lato di ogni blocco). Questa lane non ha
sovrascritto quel lavoro: ha verificato **ogni file** contro lo scopo (chiamanti, test, contratto) e contro il riferimento buono (commit root `6e32612c`),
poi ha completato cio' che mancava (docblock `@see` nel formato di progetto, documentazione, verifica). Backup dello stato di partenza
prima delle scritture: archivio nello scratchpad della sessione (18 file). Lo stato con i marcatori resta leggibile con `git show 6291f121d:<percorso>`.

## Verifica

- `grep -rlE '^(<<<<<<<|>>>>>>>|=======$)' Modules/Lang --include='*.php'`: 0 file (prima 11 + 1 blade).
- `php -l` su tutti i file PHP toccati: nessun errore. La vista Blade: il commento di testa viene tolto dal compilatore Blade.
- Pest: `AutoLabelActionContractTest`, `LangCoverageBoostTest` (comprende il rendering del language switcher senza `$this`), `GetAllTranslationActionTest`,
  `SaveTransActionTest`: tutti verdi (con `DB_DATABASE_USER=` vuoto).
- Controllo `@see` di `bashscripts/docs/prompts/php-architecture.md`: ogni file toccato fuori da `tests/` ha `@see Modules/Lang/docs/...` verso un file esistente.
- Pint `--test`: pulito su tutti i file toccati tranne `app/Models/Post.php` (`HasXotFactory` non usato, allineamento `@property`) e `tests/Pest.php`: scarti di stile che ci sono
  gia' nel riferimento buono `6e32612c`, quindi non causati dalla riparazione e non toccati.

## Residui fuori perimetro

- I contratti `docs/contracts/{auto-label-action,clean-placeholder-translations-action,save-trans-action}.md` hanno ancora marcatori/sezioni doppie:
  `ActionContractsAreCompleteTest` li segnala. Spetta alla lane docs.
- Il repository del modulo (`laraxot/module_lang_fila5`, `dev`) ha gli stessi marcatori in `Pest.php`, `Ensure.php`, `AutoLabelActionContractTest.php`
  e nella vista: il prossimo sync li riporta qui.
- `GetAllTranslationAction` e `GetAllModuleTranslationAction` hanno corpo identico (duplicazione nota, descritta nei contratti).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- `grep -rlE '^(<<<<<<<|>>>>>>>|=======$)' Modules/Lang --include='*.php'`: 0 file (prima 11 + 1 blade).
- `php -l` su tutti i file PHP toccati: nessun errore. La vista Blade: il commento di testa viene tolto dal compilatore Blade.
- Pest: `AutoLabelActionContractTest`, `LangCoverageBoostTest` (comprende il rendering del language switcher senza `$this`), `GetAllTranslationActionTest`,
  `SaveTransActionTest`: tutti verdi (con `DB_DATABASE_USER=` vuoto).
- Controllo `@see` di `bashscripts/docs/prompts/php-architecture.md`: ogni file toccato fuori da `tests/` ha `@see Modules/Lang/docs/...` verso un file esistente.
- Pint `--test`: pulito su tutti i file toccati tranne `app/Models/Post.php` (`HasXotFactory` non usato, allineamento `@property`) e `tests/Pest.php`: scarti di stile che ci sono
  gia' nel riferimento buono `6e32612c`, quindi non causati dalla riparazione e non toccati.
