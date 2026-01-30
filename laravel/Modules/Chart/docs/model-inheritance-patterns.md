# Pattern di Ereditarietà dei Modelli in <nome progetto>

## Panoramica

Questo documento descrive i pattern di ereditarietà utilizzati per i modelli in <nome progetto>, fornendo linee guida e best practice per l'implementazione corretta dell'ereditarietà nei vari moduli.

## Pattern di Ereditarietà Principali

### 1. Single Table Inheritance (STI)

<nome progetto> utilizza principalmente il pattern Single Table Inheritance tramite il pacchetto `spatie/laravel-model-states` per gestire diversi tipi di entità che condividono la stessa tabella di base.

#### Implementazione nei Moduli

- **Modulo Patient**: Implementa STI per `Doctor` e `Patient` che estendono `User`. [Documentazione dettagliata](/laravel/Modules/Patient/docs/MODEL_INHERITANCE_PATTERN.md)
- **Modulo User**: Fornisce la classe base `BaseUser` per l'ereditarietà degli utenti
- **Altri Moduli**: Seguono pattern simili per le loro entità specifiche

### 2. Ereditarietà con Classi Base Personalizzate

Ogni modulo in <nome progetto> definisce le proprie classi base che estendono le classi standard di Laravel:

- `BaseModel` in ciascun modulo estende `Illuminate\Database\Eloquent\Model`
- `XotBaseResource` estende `Filament\Resources\Resource`
- `XotBaseServiceProvider` estende `Illuminate\Foundation\Support\Providers\RouteServiceProvider`

## Best Practices

### Regola Fondamentale

**Mai estendere direttamente le classi Laravel**. Utilizzare sempre le classi base appropriate del modulo:

```php
// ❌ ERRATO
use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    // ...
}

// ✅ CORRETTO
use Modules\MyModule\Models\BaseModel;

class MyModel extends BaseModel
{
    // ...
}
```

### Ereditarietà nei Modelli Utente

Per i modelli che rappresentano tipi specifici di utenti:

1. **Estendere la Classe User Appropriata**:
   ```php
   use Modules\Patient\Models\User;
   
   class Doctor extends User
   {
       // ...
   }
   ```

2. **Utilizzare il Trait HasParent**:
   ```php
   use Parental\HasParent;
   
   class Doctor extends User
   {
       use HasParent;
       // ...
   }
   ```

3. **Utilizzare il Metodo casts() invece della Proprietà $casts**:
   ```php
   protected function casts(): array
   {
       return array_merge(parent::casts(), [
           'my_field' => 'array',
       ]);
   }
   ```

## Vantaggi dell'Approccio

1. **Centralizzazione della Configurazione**: Le configurazioni comuni sono definite nelle classi base
2. **Manutenibilità**: Facilita gli aggiornamenti e le modifiche globali
3. **Coerenza**: Garantisce un comportamento uniforme in tutta l'applicazione
4. **Estensibilità**: Permette di estendere facilmente le funzionalità esistenti

## Errori Comuni da Evitare

1. **Estensione Diretta delle Classi Laravel**: Causa inconsistenze e difficoltà nella manutenzione
2. **Mancanza del Trait HasParent**: Compromette il funzionamento dell'ereditarietà STI
3. **Uso di Proprietà Deprecate**: Come `$casts` invece del metodo `casts()`
4. **Duplicazione di Codice**: Reimplementare funzionalità già presenti nelle classi base

## Documentazione Specifica per Modulo

- [Pattern di Ereditarietà nel Modulo Patient](/laravel/Modules/Patient/docs/MODEL_INHERITANCE_PATTERN.md)
- [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md)
- [Classi Base nel Modulo Xot](/laravel/Modules/Xot/docs/BASE_CLASSES.md)
- [Risorse Filament e Ereditarietà](/laravel/Modules/Xot/docs/FILAMENT_RESOURCE_RULES.md)

## Riferimenti Esterni

- [Documentazione Laravel sull'Ereditarietà dei Modelli](https://laravel.com/docs/eloquent)
- [Pacchetto Parental per Laravel](https://github.com/calebporzio/parental)
- [Spatie Laravel Model States](https://github.com/spatie/laravel-model-states)
