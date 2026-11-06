---
title: "Forma delle chiavi di traduzione: namespace + 4 segmenti, e spostamento delle chiavi storte"
type: story
status: review
module: Lang
epic: i18n-conventions
updated: 2026-10-30
tags: [i18n, translations, rekey, pub_theme, blade, conventions]
related:
  - ../../../../../bashscripts/ai/wiki/memories/translation-protocol-memory-aid.md
  - ../../../../Themes/Two/docs/stories/container0-routes-and-pub-theme-namespace.story.md
  - ../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md
  - ../../../../Themes/Sixteen/docs/stories/pub-theme-keys-and-route-names-residuals.story.md
---

# Forma delle chiavi di traduzione e rekey

**Story ID:** i18n-conventions.key-shape-rekey
**Status:** review   <!-- backlog -> ready-for-dev -> in-progress -> review -> done -->

## Story

Come **sviluppatore che aggiunge un testo a una Blade o a una Resource**, voglio una sola forma di chiave, `<ns>::<file>.<collezione>.<chiave>.<tipo>`, che il generatore dei label (`AutoLabelAction`, `SaveTransAction`) e il gestore traduzioni leggono allo stesso modo, cosi' che nessuna chiave resti ambigua o venga mostrata grezza.

## Acceptance Criteria

<!-- LOCKED. -->

1. Ogni chiave che la campagna i18n ha aggiunto a moduli e temi ha forma namespace + 4 segmenti dopo `::` (il primo e' il file lingua, l'ultimo e' il tipo scritto: `label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`).
2. Spostare una chiave non cambia il testo: stesso valore, stessi `:parametri`, in tutte le lingue del proprietario (`it`, `en`, `de`, `es`).
3. Dopo lo spostamento nessun uso della vecchia chiave resta nel proprietario; le chiavi usate anche fuori dal proprietario non si spostano.
4. Ogni `__('ns::...')` presente nelle Blade esiste in `it`, `en`, `de`, `es` (`check-blade-keys.php`).
5. Le Blade toccate compilano e i file lingua passano `php -l`; nessuna chiave grezza compare nelle pagine pubbliche di Two.
6. `./vendor/bin/phpstan analyse Modules` (livello `max`) termina con exit 0.

## Tasks / Subtasks

- [x] Misurare la convenzione sul codice e riscrivere `translation-protocol-memory-aid.md` (AC: #1)
- [x] Strumento `lang-rekey.php` (tutto o niente, lock, copie dei file, `scope`) e `check-key-shape.py` (AC: #2, #3)
- [x] Spostare le chiavi dei moduli: 368 chiavi in 9 moduli (AC: #1, #2, #3)
- [x] Spostare le chiavi dei temi con `scope` per tema: Two 93, Meetup 26, TwentyOne 11, Sixteen 5 (AC: #1, #3)
- [x] Aggiungere a mano 5 chiavi `user::blocks.*` mancanti in de/es (AC: #4)
- [x] Verifiche statiche e PHPStan (AC: #4, #5, #6)
- [ ] Sixteen: `ui.mobile.*` (31), `accessibility.*`, `footer.documents` bloccate da file lingua con commenti: vedi la story di Sixteen (AC: #1)
- [ ] Two: `coming-soon.*` (13 chiavi, `lang/it/coming-soon.php` ha commenti) (AC: #1)
- [ ] Geo (2 chiavi, `de/coordinate-picker.php`), Employee (`widgets.time_clock.session_inactive`, `de/widgets.php`), Cms (2 chiavi: il gruppo `sections.preview` e' letto come array) (AC: #1)
- [ ] Decidere se rinominare anche le chiavi storte preesistenti (vedi Dev Notes) (AC: #1)

## Dev Notes

<!-- LOCKED. -->

- **Forma misurata:** delle foglie in `lang/it` 30.010 sono a 4 livelli (file + 3), 8.189 a 3, 2.241 a 2; delle chiavi usate in Blade/PHP 6.728 su ~9.670 hanno 4 segmenti dopo `::`. Collezioni piu' frequenti: `fields`, `actions`, `navigation`, `values`, `sections`; tipi: `label`, `description`, `tooltip`, `helper_text`, `placeholder`, `icon`. [Source: `bashscripts/ai/wiki/memories/translation-protocol-memory-aid.md`]
- **Chi genera le chiavi:** `Modules/Xot/app/Actions/Filament/AutoLabelAction.php` produce `<modulo>::<classe_snake>.fields.<campo>.label`; `Modules/Lang` salva con `SaveTransAction`. Chiamare una chiave di gruppo restituisce un array (errore `htmlspecialchars`).
- **Il traduttore ignora `['default' => ...]`** (`Modules/Lang/app/Adapters/TranslatorAdapter.php`): la voce deve esistere nei file lingua.
- **`pub_theme` e' un solo namespace per cinque temi.** Ogni tema ha il proprio `lang` ma il namespace risolve il tema attivo. `lang-rekey.php` con `"scope": ["Themes/<T>"]` riscrive gli usi solo in quel tema e lascia dove sono le chiavi usate anche altrove: senza `scope` romperebbe Sixteen e i moduli. `two::`, `sixteen::` e `theme::` non sono namespace validi per le Blade dei temi.
- **L'euristica del piano sbaglia il tipo** (`skip_to_content` letto come descrizione, `password_updated` come label): i piani si rileggono prima di applicarli.
- **Lo strumento rifiuta, per scelta,** file lingua con commenti o chiavi col punto, prefissi dinamici (`'ns::file.gruppo.'.$x`) e gruppi letti come array; ignora i file in `/tests/` quando cerca prefissi dinamici (un `not->toContain('pub_theme::footer.')` non e' un uso).
- **Misura del progresso:** `check-key-shape.py --diff` confronta con HEAD e si azzera quando altre sessioni committano; per una misura assoluta si lancia `check-key-shape.py <cartella>`. Stato dell'albero di lavoro alla chiusura: chiavi storte uniche, Moduli 598, Sixteen 559, Two 57, Meetup 42, TwentyOne 65. Sono per la maggior parte chiavi preesistenti alla campagna.
- [Inference] Rinominare in blocco le chiavi preesistenti richiede di sapere se qualche contenuto CMS (JSON o database) le richiama per nome: non verificato.

## Testing

<!-- LOCKED. -->

- **Approccio:** controlli statici ripetibili, nessun rendering.
- **Per AC:** #1 -> `python3 -I bashscripts/tools/i18n/check-key-shape.py <cartella>`; #2 -> confronto dei valori prima/dopo sulle copie dei file; #3 -> `lang-rekey.php` verifica gli usi residui e annulla se ne trova; #4 -> `php bashscripts/tools/i18n/check-blade-keys.php laravel`; #5 -> compilazione Blade dei file toccati (`Blade::compileString` + `php -l`) e scansione HTTP di Two; #6 -> PHPStan.
- **Casi limite:** file lingua con commenti, chiavi dinamiche, gruppo letto come array, namespace condiviso tra temi, locale con file mancante.

## Dependency Maps

- **Blocked by:** nessuna.
- **Blocks:** `pub-theme-keys-and-route-names-residuals` (Sixteen).
- **External:** repo privato `bashscripts/` per gli strumenti; nessun servizio esterno.

## Owned File/Module Scope

- `laravel/Modules/{Media,Xot,TechPlanner,Geo,Employee,Notify,Cms,UI,User}/lang/**` e le Blade/PHP di quegli stessi moduli che citano le chiavi spostate.
- `laravel/Themes/{Two,Meetup,TwentyOne,Sixteen}/lang/**` e le Blade dei rispettivi temi.
- `bashscripts/tools/i18n/lang-rekey.php`, `check-key-shape.py`, `check-blade-keys.php` (repo privato).
- Condiviso con altri agenti (lock `bash bashscripts/lock/check.sh <file>`): le stesse Blade e i `lang/` in lavorazione dalla campagna sui testi fissi; `Themes/Two` (layout, header, hero).

## Learnings from Previous Stories

- La campagna sui testi fissi (`blade-i18n-no-hardcoded-text`, una story per proprietario) ha creato chiavi a 2-3 segmenti dove la regola ne chiedeva 4; l'indice del wiki non aiutava, perche' la regola 008, la 003 e `translation-keys-protocol.md` dicevano cose diverse. La forma vale quella misurata nel codice.
- `folio:list` e `Route::has` vedono solo il tema attivo: un nome dichiarato da un altro tema (`tests.view`, `container0.index` di Sixteen) sembra inesistente sotto Two.
- `added_keys.json` dello scratchpad si rigenera solo con `new_keys_by_diff.py --json <file>`: senza il flag restava vecchio e dava conteggi falsi.

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|------|------|---|-----|
| Issue (owner, i18n FO) | laraxot/module_lang_fila5 | 31 | https://github.com/laraxot/module_lang_fila5/issues/31 |
| **Discussion** (canon) | laraxot/base_techplanner_fila5 | 54 | https://github.com/laraxot/base_techplanner_fila5/discussions/54 |

Nessun commento pubblicato su queste thread: i repo sono pubblici, la pubblicazione e' una decisione dell'utente.

## Dev Agent Record

**Sessione 97f16a39, 2026-10-30.** Spostate 368 chiavi nei moduli (Media 3, Xot 15, TechPlanner 7, Geo 31, Employee 26, Notify 52, Cms 56, UI 62, User 116; 5 saltate per commenti o gruppi) e 135 nei temi (Two 93 con 14 saltate, Meetup 26 con 5, TwentyOne 11 con 1, Sixteen 5 con 34). Copie dei file prima della modifica nello scratchpad della sessione.

Verifiche: tutte le Blade modificate compilano (tre Blade nuove di Meetup, non presenti in HEAD, non compilano per cause indipendenti: componente `ui.language-switcher` mancante e `@if` non chiuso in `components/layouts/navigation.blade.php`, difetto presente anche nella copia pre-rekey); tutti i file lingua passano `php -l`; chiavi distinte mancanti 337 -> 332 (nessuna nuova); scansione HTTP di Two: nessuna chiave grezza; PHPStan `Modules` exit 0 (lanciato dopo il rekey dei moduli: il rekey dei temi non tocca codice analizzato). **Non verificato:** Pest, resa a video. Nessun commit.
