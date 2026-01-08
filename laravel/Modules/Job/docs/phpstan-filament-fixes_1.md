# Correzioni PHPStan per Risorse Filament nel Modulo Job

Questo documento traccia gli errori PHPStan identificati nelle risorse Filament del modulo Job e le relative soluzioni implementate.

## Errori Identificati

### 1. Tipo di ritorno errato in `getFormSchema()`

```
Method Modules\Job\Filament\Resources\ExportResource::getFormSchema() should return array<string, Filament\Forms\Components\Component> but returns array<int, Component>.
```

```
Method Modules\Job\Filament\Resources\FailedImportRowResource::getFormSchema() should return array<string, Filament\Forms\Components\Component> but returns array<int, Component>.
```

**Problema**: I metodi `getFormSchema()` nelle risorse Filament (ad esempio `ExportResource`, `FailedImportRowResource`, `ImportResource`) restituivano un array indicizzato numericamente `array<int, Component>` mentre il tipo atteso è un array associativo con chiavi di tipo stringa `array<string, Component>`.

**Soluzione**:
1. Modificato il formato di ritorno in tutti i metodi `getFormSchema()` delle risorse per utilizzare chiavi di tipo stringa:
   ```php
   // Da
   return [
       \Filament\Forms\Components\TextInput::make('name')
           ->required(),
       // altri componenti...
   ];
   
   // A
   return [
       'name' => \Filament\Forms\Components\TextInput::make('name')
           ->required(),
       // altri componenti...
   ];
   ```

2. Questa modifica è stata applicata alle seguenti classi:
   - `Modules\Job\Filament\Resources\ExportResource`
   - `Modules\Job\Filament\Resources\FailedImportRowResource`
   - `Modules\Job\Filament\Resources\ImportResource`

### 2. Metodo `getPages()` ridondante

**Problema**: Molte risorse Filament definivano il metodo `getPages()` con la stessa implementazione standard che è già fornita dalla classe base `XotBaseResource`.

**Soluzione**:
1. Il metodo `getPages()` è stato rimosso quando:
   - Definiva solo le tre pagine standard (index, create, edit)
   - Utilizzava gli stessi pattern di route standard ('/', '/create', '/{record}/edit')

2. Questa modifica è stata applicata alle seguenti classi:
   - `Modules\Job\Filament\Resources\ExportResource`
   - `Modules\Job\Filament\Resources\FailedImportRowResource`
   - `Modules\Job\Filament\Resources\ImportResource`

3. Il metodo è stato mantenuto nelle seguenti classi:
   - `Modules\Job\Filament\Resources\ScheduleResource` (ha una pagina 'view' personalizzata)
   - `Modules\Job\Filament\Resources\JobResource` (ha una pagina 'board' personalizzata)
   - `Modules\Job\Filament\Resources\JobBatchResource` (ha solo la pagina 'index')
   - `Modules\Job\Filament\Resources\FailedJobResource` (ha solo la pagina 'index')

## Principi Applicati

1. **Tipo di ritorno corretto**: Assicurato che il tipo di ritorno dei metodi corrisponda a quanto atteso dalle interfacce e classi base.
2. **Rimozione di codice ridondante**: Eliminato il codice ripetitivo che duplica funzionalità già presenti nelle classi base.
3. **Coerenza del codice**: Mantenuto un approccio coerente in tutte le risorse Filament del modulo.
4. **DRY (Don't Repeat Yourself)**: Evitato di ripetere codice già presente nella classe base.

## Linee Guida per il Futuro

Quando si crea una nuova risorsa Filament:

1. Per il metodo `getFormSchema()`:
   - Usare un array associativo con chiavi di tipo stringa
   - Ogni componente del form deve avere una chiave univoca

2. Per il metodo `getPages()`:
   - Non includere il metodo se si utilizzano solo le pagine standard (index, create, edit) con le route standard
   - Includere il metodo solo se si hanno pagine personalizzate o configurazioni non standard

3. Per il tipo di ritorno:
   - Essere consapevoli del tipo di ritorno atteso dai metodi
   - Utilizzare PHPStan per verificare la correttezza dei tipi 