## phpstan fixes per modulo activity

### listlogactivities (filament page)

- **Problemi rilevati**:
  - `getTitle()` dichiarato `string` ma PHPStan vedeva `mixed` (Htmlable|string).
  - `createFieldLabelMap()` usava `mapWithKeys()` su una collection non tipizzata, producendo template `*NEVER*`.
  - `Notification::title()` riceveva valori non tipizzati (`array|string|null`) generando errori `argument.type` e `cast.string`.

- **Soluzioni applicate**:
  - Normalizzazione di `getTitle()` con cast esplicito a `string` dopo gestione `Htmlable` → `string`.
  - Tipizzazione esplicita di `createFieldLabelMap()` come `Collection<string, string>` e normalizzazione degli array figli con `array_values()` prima di `merge()` per rispettare i generics di Laravel Collection.
  - Uso di `->title(fn (): string => (string) __('...'))` nelle notifiche, in modo che `Notification::title()` riceva sempre una `Closure<string>` sicura.

### activity (modello spatie activitylog)

- **Problemi rilevati**:
  - Vari errori `return.type` su metodi statici wrapper del query builder (`query, selectRaw, latest, limit, with, count, clone, where*`) che creavano unioni di tipi incompatibili con il builder generico atteso da PHPStan.

- **Soluzioni applicate**:
  - Rimozione di tutti i wrapper statici superflui che delegavano semplicemente a `static::query()...`.
  - Mantenimento delle sole annotazioni `@method` nella PHPDoc, affidando il contratto di tipo alla classe base `Spatie\Activitylog\Models\Activity` e ai suoi stub PHPStan.

### activitymassseeder (seeder di massa)

- **Problemi rilevati**:
  - `method.notFound` e `method.nonObject` su `Snapshot::count()` e `StoredEvent::where(...)->count()` a causa di unioni di tipo sui builder generici.

- **Soluzioni applicate**:
  - Introduzione di variabili builder tipizzate:
    - `/** @var \Illuminate\Database\Eloquent\Builder<Snapshot> $snapshotQuery */ $snapshotQuery = Snapshot::query();`
    - `/** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<StoredEvent> $storedEventQuery */ $storedEventQuery = StoredEvent::query();`
  - Tutte le chiamate a `count()` e `where()` avvengono ora su variabili con tipo noto, eliminando le ambiguità per PHPStan.

### pattern riutilizzabili

- **Non duplicare il query builder statico**: per modelli che estendono classi base Spatie o Laravel già supportate da PHPStan, evitare override statici dei metodi fluent e affidarsi a `@method` nella PHPDoc.
- **Collection tipizzate**: quando si usa `mapWithKeys()` o `merge()` su componenti Filament, tipizzare chiaramente `Collection<int, Component>` → `Collection<string, string>` e normalizzare gli array con `array_values()`.
- **Builder specializzati**: per builder custom (es. `EloquentStoredEventQueryBuilder`), assegnare sempre a una variabile annotata prima di invocare `count()/where()`.

Queste regole vanno seguite per tutte le future modifiche al modulo Activity e aggiornate in questa doc quando emergono nuovi pattern di correzione.

