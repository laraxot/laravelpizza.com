# Story: file di lingua corrotti da una pipe prima di ogni carattere

Status: done

## GitHub (tracciamento): OBBLIGATORIO

| Tipo | Repo | # | URL |
|------|------|---|-----|
| **Discussion** (canon) | `provtv/module_activity_fila5` | 21 | https://github.com/provtv/module_activity_fila5/discussions/21 |
| Issue (owner modulo) | `provtv/module_activity_fila5` | 19 | https://github.com/provtv/module_activity_fila5/issues/19 |

## Story

As an **utente di un pannello Activity**,
I want **vedere le etichette tradotte invece delle chiavi grezze**,
so that **l'interfaccia sia leggibile e le traduzioni del modulo servano a qualcosa**.

E, dietro: come **agente che esegue i quality gate**, voglio che una corruzione
**gia' committata** venga vista, perche' oggi il preflight guarda solo la dirty list
e quindi per costruzione non la vede.

## Acceptance Criteria

1. I quattro file di lingua di Activity aprono con `<?php` e **restituiscono un array**
   (non `1`), verificato eseguendo `require` e contando le chiavi.
2. Zero caratteri `|` di corruzione e zero `U+FFFD` nei quattro file.
3. Il testo italiano e' quello vero (`attivita'`, `entita'` per esteso), **non ricostruito
   a indovinare**: la provenienza di ogni byte e' dichiarata.
4. `git grep -lI '^|<|?|p|h|p|$'` non trova piu' nulla nel monorepo.
5. Il preflight dei quality gate acquisisce un controllo che copra **tutto l'albero
   tracciato**, non solo la dirty list.
6. Nessun altro `.php` tracciato e' un documento Markdown travestito.

## Tasks / Subtasks

- [x] Task 1: Misurare il difetto (AC: 1, 2)
  - [x] Eseguire il preflight di `03-quality-gates.md` (step 1c) e leggerne l'esito
  - [x] Estendere lo stesso controllo agli 11.201 `.php` tracciati
  - [x] Classificare i 27 file che non aprono con `<?php`: 23 template HTML legittimi, 4 no
- [x] Task 2: Riparare i due `en/` per inversione deterministica (AC: 1, 2, 3)
  - [x] Verificare che il pattern `|c` sia regolare byte per byte
  - [x] Confrontare il risultato con una copia pulita: **byte-identico** (2427 e 1982 byte)
- [x] Task 3: Riparare i due `it/` (AC: 3)
  - [x] Constatare che l'inverso non basta: accenti gia' distrutti in `U+FFFD` a monte
  - [x] Censire i cinque cloni e scegliere l'unico integro come sorgente
- [x] Task 4: Rimuovere il Markdown travestito da `.php` (AC: 6)
  - [x] `Modules/Ptv/app/Filament/Tables/Filters/HasRatingValuesFilter.php` rimosso
  - [x] Contenuto superstite confluito nella story Rating che gia' copre quel filtro
- [x] Task 5: Lasciare la guardia (AC: 5)
  - [x] Step 1d (`QG_SCAN_ALL=1`) nel prompt, portato a 3.24.0
- [x] Task 6: Tracciamento (AC: tutti)
  - [x] Issue #19 e Discussion #21 su `provtv/module_activity_fila5`
  - [x] `docs/sprint-status.yaml` aggiornato
  - [x] `docs/chat/quality-gates-preflight-file-corrotti.md` per gli altri agenti

## Dev Notes

### Il difetto

I quattro file avevano un `|` (0x7C) inserito **prima di ogni singolo carattere**:

```
|<|?|p|h|p|
|d|e|c|l|a|r|e|(|s|t|r|i|c|t|_|t|y|p|e|s|=|1|)|;|
```

Il tag `<?php` non apre mai: per PHP e' tutto testo inline, non c'e' `return [...]`, il
file restituisce `1`, e **ogni chiave di traduzione del modulo cadeva sul fallback**.

### Perche' nessun gate lo vedeva

| gate | perche' passa |
|---|---|
| `php -l` | un file senza `<?php` e' PHP valido: e' testo da stampare |
| PHPStan | nessun simbolo da analizzare, nessun errore da riportare |
| Pint | niente codice da formattare |
| preflight step 1c | guarda la dirty list, e questi file erano committati e puliti |

E' il caso limite di «il difetto che non rompe niente non si vede»: non un test rosso
ignorato, ma cinque strumenti che dicono verde su un file svuotato del suo contenuto.

### Due corruzioni sovrapposte, non una

1. **La pipe.** L'inverso e' deterministico: togliere il byte in posizione pari: e la
   verifica non e' «sembra giusto»: i due `en/` cosi' ricostruiti sono **byte-identici**
   alla copia pulita di `base_fixcity_fila5`. Non e' una ricostruzione plausibile, e' la
   stessa.
2. **Gli accenti.** Nei due `it/` le lettere accentate erano gia' `U+FFFD` **prima**
   dell'inserimento della pipe, e due byte di sostituzione rompono anche l'allineamento
   del pattern. Il testo italiano li' era perso, non recuperabile da una trasformazione.

Quindi i quattro file sono stati ripresi da `base_laravelpizza`, l'unico clone con
`attivita'` (x11) e `entita'` (x4) per esteso e con le righe `tooltip` ancora presenti.
Scelto quello e **non** `base_fixcity_fila5` perche' fixcity ha perso proprio le righe
dove c'erano gli accenti: e' piu' piccolo perche' e' mutilato, non perche' e' piu' snello.

**Nessun testo italiano e' stato inventato.**

### Il modulo e' condiviso: la corruzione ha viaggiato con lui

| clone | file corrotti | accenti |
|---|---:|---|
| `base_ptvx_fila5` | 4 | persi |
| `base_quaeris_fila5` | 4 | persi (11 `U+FFFD`): **ancora rotto** |
| `base_fixcity_fila5` | 0 | righe `tooltip` cancellate |
| `base_techplanner_fila5` | 0 | altra versione |
| `base_laravelpizza` | 0 | **integro** |

### Project Structure Notes

Il file rimosso in Task 4 era un **documento Markdown con frontmatter YAML salvato `.php`
dentro `Modules/Ptv/app/`**, committato dal 2026-08-27. Descriveva come proprio percorso
un file che a quel percorso non e' mai stato codice: la classe vera e'
`Modules\Rating\Filament\Tables\Filters\HasRatingValuesFilter`, ed e' da li' che
`BaseSchedasTable` importa. Violava la regola docs (`docs/` non `app/`) e bloccava il
preflight. Contenuto superstite spostato nella story Rating, non buttato.

### Testing standards

Nessun test nuovo: il difetto non e' esprimibile come test di dominio, e' una proprieta'
del file sorgente. La guardia giusta e' quella messa nel preflight (step 1d), non un test
Pest che rileggerebbe gli stessi byte.

### References

- [Source: bashscripts/docs/prompts/03-quality-gates.md#preflight]: step 1c e nuovo 1d
- [Source: laravel/Modules/Rating/docs/stories/ratings-column-section-filter.story.md#Il-predecessore]
- [Source: docs/chat/quality-gates-preflight-file-corrotti.md]
- [Source: docs/wiki/rules/bmad-story-github-links-mandatory.md]

## Dev Agent Record

### Agent Model Used

claude-opus-5[1m]: sessione `c21fdd4e`

### Debug Log References

- `laravel/build/phpstan-c21fdd4e.txt`: 4 errori, tutti in `Modules/Rating/tests/`
- `laravel/build/pest-c21fdd4e.txt`: 35 rossi / 3 rischiosi / 64 verdi, tutti preesistenti
- `laravel/build/pint-c21fdd4e.txt`: 1 rosso, WIP di un'altra sessione

### Completion Notes List

- 4/4 file parsano e restituiscono un array (6, 6, 7, 6 chiavi top-level).
- `git grep -lI '^|<|?|p|h|p|$'` → nessun risultato.
- PHPStan mirato sui file toccati: `[OK] No errors`.
- **Reperti riportati e non corretti** (regola del prompt: errori in moduli di altri
  agenti si riportano): `IndennitaCondizioniLavoro/.../CondizioniLavoroIndennitaTipoDettaglio.php`
  e `Pdnd/.../Base/BaseResponse.php` a 0 byte, `config/local/ptvx-mono/lang/it/metatag.php`
  a 0 byte, `Modules/Job/config.php` senza `<?php` che fa `require` di un file inesistente.
- **Non e' noto quale strumento** abbia inserito le pipe: domanda aperta nella Discussion #21.

### File List

- `laravel/Modules/Activity/resources/lang/en/activity-resource.php`: riparato
- `laravel/Modules/Activity/resources/lang/en/snapshot-resource.php`: riparato
- `laravel/Modules/Activity/resources/lang/it/activity-resource.php`: riparato
- `laravel/Modules/Activity/resources/lang/it/snapshot-resource.php`: riparato
- `laravel/Modules/Ptv/app/Filament/Tables/Filters/HasRatingValuesFilter.php`: rimosso
- `laravel/Modules/Rating/docs/stories/ratings-column-section-filter.story.md`: sezione «Il predecessore»
- `laravel/Modules/Rating/tests/Unit/BaseRatingModelTest.php`: rimosso il test su `linkedTo()` inesistente
- `laravel/Modules/IndennitaResponsabilita/app/Models/Rating.php`: `@property int|null $parent_id`
- `bashscripts/docs/prompts/03-quality-gates.md`: 3.24.0
- `docs/sprint-status.yaml`, `docs/chat/quality-gates-preflight-file-corrotti.md`
