# Single Table Inheritance (STI)

## Principi Fondamentali

1. **Struttura Base**:
   - Una tabella base contiene tutti i campi comuni
   - I modelli specializzati estendono il modello base
   - Il campo `type` determina il tipo di modello

2. **Namespace e Directory**:
   - I modelli sono in `Modules\{Module}\Models`
   - I namespace sono `Modules\{Module}\Models`
   - La struttura delle directory riflette i namespace

## Implementazione

1. **Modello Base**:
   ```php
   namespace Modules\User\Models;
   
   class BaseUser extends Model
   {
       protected $connection = 'user';
       protected $childColumn = 'type';
   }
   ```

2. **Modello Specializzato**:
   ```php
   namespace Modules\Patient\Models;
   
   class User extends BaseUser
   {
       protected $childTypes = [
           'patient' => Patient::class,
           'doctor' => Doctor::class,
       ];
   }
   ```

3. **Migration**:
   - Aggiungere campi alla tabella base
   - Usare migration idempotenti
   - Documentare i campi aggiunti

## Best Practices

1. **Campi**:
   - Tutti i campi usati dai modelli specializzati devono essere nella tabella base
   - I campi specifici vanno aggiunti con migration idempotenti
   - Documentare i campi aggiunti

2. **Relazioni**:
   - Definire le relazioni nel modello appropriato
   - Usare i trait necessari
   - Documentare le relazioni complesse

3. **Validazione**:
   - Implementare le regole di validazione nel modello
   - Usare i trait di validazione quando necessario
   - Documentare le regole di business

## Errori Comuni

1. **Errore**: Namespace errato
   - ❌ `namespace Modules\Patient\App\Models;`
   - ✅ `namespace Modules\Patient\Models;`

2. **Errore**: Ereditarietà errata
   - ❌ `extends Model`
   - ✅ `extends BaseUser`

3. **Errore**: Configurazione STI mancante
   - ❌ Manca `$childColumn` e `$childTypes`
   - ✅ Configurare correttamente STI

## Collegamenti

- [Modelli Patient](../Patient/project_docs/models.md)
- [Best Practices Modelli](./models.md)
- [Convenzioni di Codice](./coding-standards.md) 
