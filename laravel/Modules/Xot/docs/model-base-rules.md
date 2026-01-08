# Regole di Estensione dei Modelli Laraxot

## Regola Fondamentale di Ereditarietà

I modelli devono estendere **SOLO** il `BaseModel` del proprio modulo, **MAI** direttamente `Illuminate\Database\Eloquent\Model` o `Modules\Xot\Models\XotBaseModel`.

### Pattern Corretto

```php
namespace Modules\IndennitaCondizioniLavoro\Models;

class CondizioniLavoro extends BaseModel
{
    // Implementazione modello
}
```

### Anti-Pattern (da evitare)

```php
// ❌ ERRATO: Estensione diretta di Model
namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Model;

class CondizioniLavoro extends Model
{
    // Implementazione modello
}

// ❌ ERRATO: Estensione di XotBaseModel
namespace Modules\IndennitaCondizioniLavoro\Models;

use Modules\Xot\Models\XotBaseModel;

class CondizioniLavoro extends XotBaseModel
{
    // Implementazione modello
}
```

## Modelli Aggregati e di Totali

I modelli aggregati e di totali (es. `OrganizzativaTotValutatoreId` del modulo Performance) devono estendere il `BaseModel` del loro modulo specifico, **NON** `Modules\Xot\Models\BaseModel`.

### Motivazione

1. **Isolamento**: Ogni modulo può personalizzare il proprio BaseModel
2. **Override locale**: Funzionalità specifiche del modulo possono essere implementate a livello locale
3. **Compliance PHPStan**: Necessario per il livello 10
4. **Coerenza**: Uniformità di comportamento all'interno di ciascun modulo
5. **Personalizzazione**: Compatibilità con logiche specifiche del modulo

### Memoria Storica

Rollback della regola precedente (2025-05-14) effettuato il 2025-05-15, documentato in Performance/docs/organizzativa-models.md. La regola precedente è stata annullata per esigenze di override e compatibilità.

## Eccezioni

Non esistono eccezioni a questa regola. Tutti i modelli concreti devono seguirla.

> ⚠️ **Warning**: Estendere direttamente Model o XotBaseModel può causare override indesiderati, perdita di flessibilità e problemi di compatibilità con logiche locali.

## Implementazione del BaseModel

Ogni modulo deve avere il proprio `BaseModel` che estende `Modules\Xot\Models\XotBaseModel`:

```php
namespace Modules\NomeModulo\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    // Personalizzazioni specifiche del modulo
}
```

## Validazione e Controlli

- Eseguire PHPStan livello 9+ per verificare la corretta ereditarietà
- Documentare qualsiasi eccezione con motivazione dettagliata
- Aggiornare la documentazione sia nel modulo che nella root

## Backlink e Riferimenti

- [modules/xot/docs/model_base_rules.md](model_base_rules.md)
- [docs/MODULE_NAMESPACE_RULES.md](../../docs/MODULE_NAMESPACE_RULES.md)
- [modules/performance/docs/organizzativa-models.md](../Performance/docs/organizzativa-models.md)

*Ultimo aggiornamento: maggio 2025* 