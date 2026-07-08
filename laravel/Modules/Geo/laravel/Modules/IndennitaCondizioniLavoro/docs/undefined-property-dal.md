# ErrorException: Undefined property `CondizioniLavoroAdm::$dal`

## Sintomo

- Errore in Filament durante apertura pagina di edit:

`GET /indennitacondizionilavoro/admin/condizioni-lavoro-adms/{id}/edit`

- Messaggio tipico:

`Undefined property: Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroAdm::$dal`

- Stack trace (estratto):

- `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php:234`
- `vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:713`
- `Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php:66`

## Contesto tecnico

In Laravel/Eloquent l’accesso a `$model->campo` passa da `__get()` e quindi da `HasAttributes::getAttribute()`, che se trova un accessor `get{Campo}Attribute()` esegue:

- `HasAttributes::mutateAttribute()`
- `return $this->{'get'.Str::studly($key).'Attribute'}($value);` (linea ~713)

Filament, in fase di mount di `EditRecord`, legge molte proprietà del record (per riempire lo stato del form). Questo può attivare accessors/mutators anche su campi che nel DB sono `null`.

## Root cause (causa reale)

Nel modello `CondizioniLavoroAdm` esiste un **ciclo di dipendenze** tra accessors:

- `CondizioniLavoroAdm::getTrimestreAttribute()` calcola il trimestre partendo da `dal`:

`$dal_month = $this->dal->month;`

- `MutatorTrait::getDalAttribute()` calcola `dal` partendo da `trimestre`:

`$value = clone ($dt)->addQuarters($this->trimestre - 1);`

Quindi:

- per calcolare `trimestre` serve `dal`
- per calcolare `dal` serve `trimestre`

Quando `trimestre` (o `dal`) è `null`, la lettura avviata da Filament/Eloquent entra in **ricorsione**:

1. Filament chiede `trimestre`
2. Eloquent chiama `getTrimestreAttribute()`
3. `getTrimestreAttribute()` legge `$this->dal`
4. Eloquent chiama `getDalAttribute()`
5. `getDalAttribute()` legge `$this->trimestre`
6. Eloquent richiama `getTrimestreAttribute()`
7. Loop fino a errore

### Fattore aggravante: persistenza dentro accessor

Entrambi gli accessors in questa catena eseguono anche persistenza (diretta o indiretta) durante la lettura:

- `MutatorTrait::getDalAttribute()` fa `update(['dal' => $value])`
- `CondizioniLavoroAdm::getTrimestreAttribute()` fa `update(['trimestre' => $value])`

Questo è particolarmente fragile in contesti Filament perché:

- l’accessor viene invocato durante **lettura** (non durante una “fase di calcolo” controllata)
- `update()` può innescare eventi, cast, (re)loading e ulteriori letture di attributi
- il problema si manifesta “solo” su record specifici (es. con `trimestre`/`dal` non coerenti o null)

## Come verificare rapidamente (diagnostica)

- Verificare nel DB del modulo (`connection = indennita_condizioni_lavoro`) sul record che va in errore:

- `trimestre` è `NULL`?
- `dal` è `NULL`?
- `anno` è `NULL` o non numerico?

- Riproduzione semplice (se possibile in ambiente di test):

- impostare `trimestre = NULL` e `dal = NULL` su un record
- aprire la pagina Filament di edit

## Come risolvere (linee guida)

Questa sezione descrive **cosa fare**; la correzione va implementata nel codice, ma qui documentiamo i pattern corretti.

### Opzione A (consigliata): rendere i campi “derivati” calcolati fuori dagli accessor

- Spostare la logica di “calcolo e persistenza” in:

- action di manutenzione (es. command/job/queueable action)
- fase di import/popolamento dati (nel modulo esistono già action come `Populate`)

- Gli accessor devono essere **puri** (senza `update()`/`save()`), oppure al massimo calcolare un default senza persistenza.

**Motivazione**: Filament/Eloquent possono invocare gli accessor in momenti non previsti; la persistenza in lettura crea side effect e loop.

### Opzione B: rompere il ciclo usando *raw attributes* (no accessors)

Se si deve mantenere la logica dentro accessor, bisogna evitare che `dal` legga `trimestre` “mutato” e viceversa.

- In `getDalAttribute()` usare `getRawOriginal('trimestre')` (o `$this->attributes['trimestre'] ?? null`) invece di `$this->trimestre`.
- In `getTrimestreAttribute()` usare `getRawOriginal('dal')` (o `$this->attributes['dal'] ?? null`) invece di `$this->dal`.

**Motivazione**: `getRawOriginal()` non invoca altri accessor, quindi spezza la ricorsione.

### Opzione C: imporre un’unica sorgente di verità

Decidere un modello:

- `trimestre` è sorgente di verità e `dal/al` derivano da trimestre+anno
oppure
- `dal/al` sono sorgente di verità e `trimestre` deriva da `dal`

Ma **non** entrambe contemporaneamente con persistenza automatica.

### Opzione D: protezioni specifiche per Filament

Se l’errore avviene durante edit Filament, valutare:

- non includere campi derivati nello schema form
- calcolare/normalizzare i campi prima del mount (es. in action esplicita “Normalizza record”)

## Collegamenti

- `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php` (vedi `getTrimestreAttribute`)
- `Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php` (vedi `getDalAttribute`, `getAlAttribute`)
- `Modules/IndennitaCondizioniLavoro/docs/accessor-guard-audit.md` (audit accessor: aggiungere nota su cicli e side effect)
