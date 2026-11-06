---
title: PHPStan analizza i file PHP di docs-archive-2026 arrivati con il pull
status: done
owner: Xot
created: 2026-10-29
related:
  - ../../../../../bashscripts/ai/wiki/rules/no-rm-no-archive-use-old-suffix.md
  - ../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md
  - ../bmad/stories/5.260-phpstan-modules-current-remediation.story.md
---

# PHPStan analizza i file PHP di docs-archive-2026 arrivati con il pull

## Fase BMAD

Dev, correzione di errori PHPStan dopo il pull dei sottomoduli.

## Problema

Il pull del 2026-10-29 porta Xot da `6e361d8e37` a `8e8d8aa231`. Tra i file nuovi c'e'
la cartella `docs-archive-2026/` (commit upstream `195186e6a8`, 2026-10-06). Contiene
6 file `.php` in `root-uppercase-folders/`: copie delle vecchie cartelle maiuscole della
root del modulo.

`laravel/phpstan.neon` esclude `./*/docs/*`, ma non `docs-archive-2026`. Quindi PHPStan
analizza questi file come codice. Risultato: 3 dei 57 errori del progetto.

| File | Errore |
|------|--------|
| `filament/forms/-components/-xot-base-placeholder.php:9` | `class.extendsDeprecatedClass` (estende `Placeholder`) |
| `helpers/helper.php:4` | `requireOnce.fileNotFound` (`../helpers/Helper.php` non esiste) |
| `helpers/xot.seed.helper.php:6` | `declareStrictTypes.notFirst` (due `declare`) |

## Analisi

I 6 file sono versioni superate di codice che esiste gia' in `app/`:

| File archiviato | Codice vivo |
|-----------------|-------------|
| `-xot-base-placeholder.php` | `app/Filament/Forms/Components/XotBasePlaceholder.php` (gia' passato a `TextEntry`) |
| `-xot-base-main-panel-provider.php` | `app/Providers/Filament/XotBaseMainPanelProvider.php` |
| `services/array-service.php` (classe `ArrayAction`) | `app/Actions/ArrayAction.php` |
| `helpers/xot.seed.helper.php` | `app/Helpers/xot.seed.helper.php` |
| `datas/xot-data.php` | stub vuoto, il vero e' `app/Datas/XotData.php` |
| `helpers/helper.php` | `require_once` verso un file che non esiste |

Tre file dichiarano la stessa classe (stesso FQCN) di una classe viva. PHPStan vede quindi
due definizioni della stessa classe. Correggere il contenuto dell'archivio non ha senso:
e' una fotografia del passato, non codice.

## Decisione

Regola [no-rm-no-archive-use-old-suffix](../../../../../bashscripts/ai/wiki/rules/no-rm-no-archive-use-old-suffix.md):
un file dismesso si rinomina sul posto con suffisso `.old`. Resta leggibile, ma non viene
caricato come PHP.

- I 6 file `*.php` diventano `*.php.old`, nella stessa cartella. Contenuto invariato.
- `phpstan.neon` non si tocca: e' dell'utente.
- La cartella `docs-archive-2026/` non si cancella. Va contro
  [no-docs-archive-rule](../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md),
  ma cancellarla e' una scelta dell'utente o dell'upstream. Il 2026-10-07 l'upstream l'ha
  tolta da 8 moduli (Activity, AI, Cms, Gdpr, Geo, Notify, User, Media), non da Xot.

## Rischio al prossimo pull

Se l'upstream cancella questi file, git puo' segnalare un conflitto rename/delete. Si risolve
accettando la cancellazione: i file sono comunque nella storia git.

## Verifica

- Prima: `./vendor/bin/phpstan analyse` (da `laravel/`) da' 57 errori, 3 in `Modules/Xot/`.
- Dopo: vedi sezione Esito.

## Esito

- 6 file rinominati con `mv` (non `git mv`: lo staging lo fa l'utente). Lock presi prima e
  rilasciati dopo, nessun lock residuo.
- `./vendor/bin/phpstan analyse` (da `laravel/`, 2026-10-29): **54 errori, 0 in `Modules/Xot/`**
  (Geo 20, Limesurvey 1, Media 1, Tenant 32).
- `php -l`, PHPMD e PHPInsights non si applicano: nessun file PHP e' stato modificato. I file
  ora sono `.php.old` e non vengono caricati come PHP.

## Effetto su git del primo passo

`laravel/Modules/Xot/.gitignore:109` ignora `*.old`. Per git il rename era gia' la
cancellazione dei 6 `.php`: i `.php.old` restavano solo in locale.

## Secondo passo: cartella rimossa (2026-10-29)

La cartella va contro le regole: [no-docs-archive-folders](../../../../../bashscripts/ai/wiki/memories/no-docs-archive-folders.md)
(«MAI creare o mantenere cartelle docs/archive»: valutare, consolidare se utile, eliminare)
e [no-docs-archive-rule](../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md).
L'utente ha confermato di procedere.

Valutazione dei 24 file, nessuno da consolidare:

| Tipo | Quanti | Contenuto |
|------|--------|-----------|
| `.gitkeep` in `raw/` | 11 | Tutti uguali: rimando a `Themes/docs/shared-components/.gitkeep-Modules` |
| `.gitignore` | 5 | Nomi di report PHPStan 2025 assenti; le cartelle non contenevano altro |
| `components.json`, `-components.json` | 2 | `[]` |
| `.php` (poi `.php.old`) | 6 | Copie superate di codice in `app/`, vedi Analisi |

Nessun file del modulo citava la cartella. Rimossa con `rm -r` (non `git rm`: lo staging lo
fa l'utente). Git vede 24 file cancellati; il contenuto resta nel commit `195186e6a8`.
Lock sulla cartella preso prima e rilasciato dopo.

Verifica: `./vendor/bin/phpstan analyse` da `laravel/` da' ancora **54 errori, 0 in Xot**,
stesso elenco di dopo il primo passo.

## Aperto

- `Modules/Media/docs-archive-2026/` e `Modules/UI/docs-archive/` hanno lo stesso schema.
  Vanno valutate file per file prima di toglierle (Media ne ha di piu', con un `config.php`).
- Se l'upstream modifica file della cartella, al prossimo pull git segnala un conflitto
  modify/delete: si risolve confermando la cancellazione.

## Fuori scope

Gli altri 54 errori sono in Geo, Limesurvey, Media e Tenant.
