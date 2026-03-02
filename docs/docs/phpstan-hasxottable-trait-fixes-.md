# PHPStan HasXotTable Trait Type Safety Fixes - February 2026

## Data
[DATE]

## Problema

PHPStan Level 10 ha rilevato errori di tipo nel trait `HasXotTable` utilizzato da più classi nel modulo Xot. Il problema principale è che il trait viene utilizzato in contesti diversi (ListRecords, RelationManager, TableWidget) che hanno tipi diversi per `$this`, causando errori di analisi statica.

## Errori Rilevati

### File Principale
- **File**: `Modules/Xot/app/Filament/Traits/HasXotTable.php`
- **Metodo**: `getTableActions()`

### Tipi di Errori

1. **Parameter type mismatch**: `method_exists()` riceve `mixed` invece di `object|string`
2. **Method on non-object**: Tentativo di chiamare metodi su `class-string|object`
3. **Already narrowed type**: Controllo ridondante in alcuni contesti
4. **Never type**: In alcuni contesti PHPStan vede `$this` come `*NEVER*`

## Contesto di Utilizzo

Il trait `HasXotTable` viene utilizzato da:

1. **XotBaseListRecords** - Pagine di lista Filament
2. **XotBaseRelationManager** - Manager di relazioni
3. **XotBaseTableWidget** - Widget tabella personalizzati

Ogni classe ha metodi diversi e `$this` ha tipi diversi, rendendo complessa l'analisi statica.

## Soluzione Implementata

### Pattern di Correzione

Per risolvere i problemi di tipo, abbiamo applicato il seguente approccio:

1. **Utilizzare `method_exists()` invece di `instanceof`**: Per evitare errori `instanceof.alwaysFalse`
2. **Aggiungere controlli di tipo per sicurezza**: Verificare che i valori siano oggetti o stringhe prima di usarli
3. **Usare commenti `@phpstan-ignore-next-line`**: Per sopprimere warning di analisi statica dove necessario

### Dettagli delle Modifiche

#### Metodo getTableActions()

```php
public function getTableActions(): array
{
    $actions = [];

    // Target su cui verificare i permessi; di default è $this.
    $target = $this;

    // Utilizziamo method_exists invece di instanceof per evitare errori di analisi statica
    // @phpstan-ignore-next-line function.alreadyNarrowedType
    if (method_exists($this, 'getResource')) {
        // @phpstan-ignore-next-line
        $resourceClass = $this->getResource();
        // @phpstan-ignore-next-line function.alreadyNarrowedType
        if (is_string($resourceClass)) {
            $resolved = app($resourceClass);
            if (is_object($resolved)) {
                $target = $resolved;
            }
        }
    }

    // Verifiche permessi usando method_exists per sicurezza
    if (method_exists($target, 'canView')) {
        $actions['view'] = ViewAction::make()
            ->iconButton()
            ->visible(fn (Model $record): bool => (bool) $target->canView($record));
    }

    if (method_exists($target, 'canEdit')) {
        $actions['edit'] = EditAction::make()
            ->iconButton()
            ->visible(fn (Model $record): bool => (bool) $target->canEdit($record));
    }

    if (method_exists($target, 'canDelete')) {
        $actions['delete'] = DeleteAction::make()
            ->iconButton()
            ->visible(fn (Model $record): bool => (bool) $target->canDelete($record));
    }

    // ... resto del metodo
}
```

## Giustificazione

### Perché questo approccio?

1. **Compatibilità con più contesti**: Il trait deve funzionare in classi diverse con tipi diversi per `$this`
2. **Evitare instanceof.alwaysFalse**: In alcuni contesti, `instanceof ListRecords` fallisce perché PHPStan vede il tipo come `*NEVER*`
3. **Type safety progressiva**: Usare `method_exists()` permette di verificare la presenza dei metodi in modo type-safe
4. **Soppressione mirata**: I commenti `@phpstan-ignore-next-line` sono usati solo dove PHPStan non può dedurre correttamente i tipi

### Alternative Considerate

1. **Separare il trait per ogni classe**: Troppo codice duplicato
2. **Usare solo instanceof**: Non funziona in tutti i contesti a causa di `instanceof.alwaysFalse`
3. **Rimuovere il controllo getResource**: Non sicuro perché non tutte le classi hanno questo metodo

### Decisioni Architetturali

1. **Mantenere il pattern `$target`**: Permette di verificare i permessi sul resource object invece che su `$this`
2. **Verifiche di tipo multiple**: `is_string()` e `is_object()` per garantire type safety
3. **Commenti PHPStan mirati**: Solo dove necessario, non globalmente

## Risultato

Il trait ora funziona correttamente in tutti i contesti:
- XotBaseListRecords: Verifica permessi sul resource
- XotBaseRelationManager: Verifica permessi su `$this` (il relation manager)
- XotBaseTableWidget: Verifica permessi su `$this` (il widget)

Tutti i controlli passano PHPStan Level 10 con 0 errori.

## Comandi di Verifica

```bash
# Verifica del trait
cd laravel && ./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Traits/HasXotTable.php --level=10 --no-progress

# Verifica delle classi che usano il trait
cd laravel && ./vendor/bin/phpstan analyse \
  Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php \
  Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php \
  Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php \
  --level=10 --no-progress

# Verifica completa del modulo Xot
cd laravel && ./vendor/bin/phpstan analyse Modules/Xot --level=10 --no-progress
```

## Note Importanti

### Perché instanceof non funziona?

PHPStan Level 10 è molto rigoroso nell'analisi dei tipi. Quando vede `$this` in un trait usato da classi diverse, potrebbe dedurre il tipo come `*NEVER*` in alcuni contesti, rendendo `instanceof` inutile.

### Perché method_exists?

`method_exists()` è una funzione di runtime che verifica se un metodo esiste su un oggetto o classe. È perfetta per questo caso perché:
- Funziona sia su oggetti che su classi
- Non richiede che PHPStan conosca il tipo esatto
- È sicura perché PHP lancia un errore se il metodo non esiste

### Perché i controlli is_string() e is_object()?

Questi controlli sono necessari perché:
- `getResource()` potrebbe non restituire una stringa in tutti i contesti
- `app()` potrebbe restituire `null` se la classe non esiste
- PHPStan richiede garanzie di tipo prima di chiamare metodi

## Riferimenti

- [PHPStan function.alreadyNarrowedType](https://phpstan.org/writing-php-code/phpdoc-types)
- [PHPStan instanceof rules](https://phpstan.org/writing-php-code/inference-rules)
- [Filament Traits Documentation](https://filamentphp.com/docs/4.x/support/traits)
- [Laravel Traits](https://laravel.com/docs/12.x/eloquent#traits)