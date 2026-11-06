---
id: consolidate-arr-array-duplicates
title: "Consolidare le Action duplicate Arr, Array e Arrays in Xot"
type: story
status: done
priority: P2
owner: module:Xot
module: Xot
tags: [xot, actions, duplicates, arr, dead-code, tenant]
qmd: "Modules\\Xot\\Actions\\Arr Modules\\Xot\\Actions\\Array Modules\\Xot\\Actions\\Arrays SaveArrayAction SavePhpArrayAction EnsureKeysAction"
related: [remove-dead-livewire-registration]
---

# Consolidare le Action duplicate Arr, Array e Arrays

Fase BMAD: Dev (analisi duplicati, migrazione riferimenti, rimozione, verifica Pest e PHPStan).

## Richiesta
Xot contiene tre cartelle di Action con gli stessi nomi: `app/Actions/Arr/`, `app/Actions/Array/`, `app/Actions/Arrays/`. Le cartelle di test `tests/Unit/Actions/{Arr,Array,Arrays}/` sono duplicate allo stesso modo. Il namespace canonico e' `Modules\Xot\Actions\Arr`, usato da circa 39 riferimenti.

## Scopo originale
Le Action servono a due cose:
- salvare array PHP o JSON su file (`SaveArrayAction` come dispatcher per formato, `SavePhpArrayAction`, `SaveJsonArrayAction`);
- utilita' sugli array (`ArrayToRawJsAction`, `DiffAssocRecursiveAction`, `RangeIntersectAction`, `EnsureKeysAction`).

## Causa della duplicazione
Le cartelle `Array/` e `Arrays/` sono copie create in tempi diversi, con il namespace cambiato. Dopo il rinomino in `Arr` sono rimaste come residui. Verificato con `diff` su ogni file:
- `ArrayToRawJsAction`, `DiffAssocRecursiveAction`, `RangeIntersectAction`, `SaveJsonArrayAction`: identici ad `Arr` salvo il namespace.
- `SaveArrayAction`: identico ad `Arr` salvo un `use` non necessario.
- `SavePhpArrayAction` in `Array/` e `Arrays/`: e' un wrapper `@deprecated` che delega a `Arr\SavePhpArrayAction`. In `Arr/` c'e' l'implementazione completa (export con una chiave per riga). La versione canonica e' quella in `Arr`.
- I test in `Array/` e `Arrays/` coprono gli stessi casi con nomi e asserzioni diversi; `Arr/` e' la suite canonica.

## Decisione
1. Canonico: `Modules\Xot\Actions\Arr`. Le cartelle `Array/` e `Arrays/` sono state cancellate in `app/Actions` e in `tests/Unit/Actions`. Nessun riferimento a `Arrays\` esisteva.
2. Riferimenti in Tenant: i tre file `app/Actions/Json/{Create,Update,Delete}JsonFileByRecordAction.php` usavano `Modules\Xot\Actions\Array\SaveArrayAction` (con formato `json`, non `SavePhpArrayAction` come indicato nella richiesta). Ora usano `Modules\Xot\Actions\Arr\SaveArrayAction`.
3. Lock orfano `app/Actions/Arr/EnsureKeysAction.php.lock` rimosso. Verifica: lock creato il 2026-10-05 da un agente opencode (task `phpstan-modules-fix`), PID 87990 non piu' vivo, nessun processo con handle sul file, file non tracciato da git (ignorato da `*.lock`).
4. Test corretti (il codice non e' stato toccato):
   - `RangeIntersect`: l'intersezione di [1,5] e [2,7] e' [2,5]. L'aspettativa `assertFalse` era sbagliata.
   - `DiffAssocRecursive`: i due test usavano la forma `items => [lista]`, che il chiamante Sigma (`FunctionExtra`, `FunctionExtraQuery::indexedRowsToAssoc`) non passa mai. Il contratto reale e' un array associativo di righe con normalizzazione a un livello. I test sono stati allineati a questo contratto, come gia' fanno i test in `Arr/`.
   - Il test `SaveJsonArrayActionTest` in `Arr/` era gia' stato corretto in precedenza (`execute()` ritorna bool) e non e' stato modificato in questa story.

## Verifica
Pest sui percorsi esistenti, dopo le modifiche:

```
cd laravel && ./vendor/bin/pest Modules/Xot/tests/Unit/Actions/Arr Modules/Xot/tests/Unit/Actions/ArrayArrActionsTest.php
Tests:    3 risky, 20 passed (64 assertions)
Duration: 27.25s
```

Prima delle correzioni: 3 falliti (i tre test sopra), 17 passati. Restano 3 warning "risky" sui test di eccezione (ramo `catch` senza asserzioni), gia' presenti e non bloccanti. Non sono stati modificati.

PHPStan livello max:

```
analyse Modules/Xot    -> [OK] No errors
analyse Modules/Tenant -> [OK] No errors
```

## Note
- Altri agenti stavano eseguendo Pest su altri test di Xot in parallelo: nessun file fuori da questo gruppo e' stato toccato.
- Le storie esistenti in `docs/stories` non sono state cancellate ne' rinumerate.
