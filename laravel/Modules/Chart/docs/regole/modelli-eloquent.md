# Regole per i Modelli Eloquent

## Regola Fondamentale dell'Ereditarietà

Ogni modello DEVE estendere il BaseModel del proprio modulo, mai direttamente Illuminate\Database\Eloquent\Model.

## Struttura Corretta

### ✅ FARE QUESTO
```php
namespace Modules\ModuleName\Models;

use Modules\ModuleName\Models\BaseModel;

class MyModel extends BaseModel
{
    // Configurazioni specifiche del modello
}
```

### ❌ NON FARE QUESTO
```php
namespace Modules\ModuleName\Models;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    // Mancano tutte le funzionalità base del modulo
}
```

## Motivazioni

1. **Funzionalità Base del Modulo**
   - Cast comuni per timestamp
   - Configurazione della connessione
   - Traits condivisi (HasFactory, Updater, etc.)
   - Funzionalità specifiche del modulo

2. **Coerenza del Sistema**
   - Tutti i modelli del modulo condividono la stessa base
   - Configurazioni centralizzate
   - Comportamento uniforme

3. **Manutenibilità**
   - Modifiche globali in un unico punto
   - Riduzione della duplicazione
   - Aggiornamenti semplificati

## Checklist di Verifica

Prima di creare un nuovo modello:

- [ ] Verificare l'esistenza di BaseModel nel modulo
- [ ] Controllare le funzionalità già presenti in BaseModel
- [ ] Non duplicare configurazioni esistenti
- [ ] Estendere il BaseModel corretto
- [ ] Importare dal namespace corretto

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura dei Modelli](../architecture/models.md)
- [Struttura dei Moduli](../architecture/modules.md)

### Collegamenti ai Moduli
- [BaseModel Notify](../../laravel/Modules/Notify/docs/base-model.md)
- [BaseModel Xot](../../laravel/Modules/Xot/docs/base-model.md)

## Note Importanti

1. Ogni modulo ha il suo BaseModel
2. BaseModel estende XotBaseModel
3. Mai estendere Model direttamente
4. Verificare sempre il namespace
5. Mantenere la documentazione aggiornata
