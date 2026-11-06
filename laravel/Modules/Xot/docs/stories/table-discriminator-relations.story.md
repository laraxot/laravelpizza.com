# BMAD Story: Relazioni con discriminatore di tabella

## Problema
Alcune relazioni leggono un log condiviso con due colonne: `id_tbl` (chiave del padre) e `tbl` (nome della tabella del padre). La forma era scritta a mano e ripetuta:
`return $this->hasMany(MyLog::class, 'id_tbl', 'id')->where('tbl', $this->getTable())`.

## Scopo (perche')
Esprimere una relazione polimorfica per tabella con un nome unico. Il codice diventa leggibile e la regola vive in un solo punto (DRY).

## Decisione
- Richiesta iniziale: sostituire con `morphToManyX(MyLog::class)`. Non e' applicabile: `morphToManyX` richiede `$name` e cerca un model pivot `MyLogMorph`, che non esiste. `MyLog` e' una tabella di log, non un pivot.
- `morphMany` cambierebbe la semantica: salva il morph class e non il nome della tabella, e dipende dalla morph map (per tenant).
- Soluzione: helper `tableMorphMany(string $related, string $typeColumn = 'tbl', string $idColumn = 'id_tbl')` nel trait `Xot/app/Models/Traits/RelationX.php`, sotto test.

## Acceptance criteria
- [x] AC1: helper `tableMorphMany` implementato, test rosso poi verde (Xot/tests/Unit/Models/Traits/TableMorphManyTest.php, 2 test passano).
- [x] AC2: cinque relazioni convertite: IR RelationshipTrait, IR LettI, IR LettF, Performance RelationshipTrait, Performance OrganizzativaRelationship. Lint OK.
- [x] AC3: nessuna chiamata grezza `hasMany(MyLog::class, 'id_tbl'` rimasta.
- [ ] AC4: Pest dei moduli IR e Performance su queste relazioni. Bloccato dal fatal in User (BaseUserRelations, vedi accessor-twin-enforcement).
- [ ] AC5: regola 2 applicata a LettI/LettF: relazioni nel trait (Traits/Relationships).

## Coordinamento
Lock per file usato per ogni modifica. Il trait RelationX e' condiviso: la modifica e' additiva (nessun metodo esistente cambiato).
