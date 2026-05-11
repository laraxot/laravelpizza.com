# Best Practices per Risorse Filament in Laraxot

Questo documento riassume le migliori pratiche per la creazione e gestione delle risorse Filament all'interno dell'ecosistema Laraxot. Seguire queste linee guida garantirà compatibilità e coerenza in tutto il progetto.

## Estensione delle Classi Base

### Risorse

1. **SEMPRE** estendere `Modules\Xot\Filament\Resources\XotBaseResource`:
   ```php
   // CORRETTO ✅
   class ClienteResource extends XotBaseResource
   
   // ERRATO ❌
   class ClienteResource extends Resource
   ```

2. **SEMPRE** implementare `getFormSchema()`:
   ```php
   public static function getFormSchema(): array
   {
       return [
           TextInput::make('nome')->required(),
           TextInput::make('email')->email()->required(),
       ];
   }
   ```

3. **MAI** definire `navigationIcon` se si estende `XotBaseResource`:
   ```php
   // ❌ ERRATO
   class ReportResource extends XotBaseResource
   {
       protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // GESTITO AUTOMATICAMENTE
   }
   
   // ✅ CORRETTO
   class ReportResource extends XotBaseResource
   {
       // Navigation icon gestita automaticamente da XotBaseResource
   }
   ```

4. **MAI** usare `->label()` nei form components:
   ```php
   // ❌ ERRATO
   TextInput::make('name')->label('Nome')
   
   // ✅ CORRETTO
   TextInput::make('name') // Label gestita da LangServiceProvider
   ```

### Pagine

1. **SEMPRE** estendere le classi base di Xot:
   ```php
   // CORRETTO ✅
   class ListClienti extends XotBaseListRecords
   class CreateCliente extends XotBaseCreateRecord
   class EditCliente extends XotBaseEditRecord
   class ViewCliente extends XotBaseViewRecord
   
   // ERRATO ❌
   class ListClienti extends ListRecords
   class CreateCliente extends CreateRecord
   class EditCliente extends EditRecord
   class ViewCliente extends ViewRecord
   ```

## Regole per XotBaseListRecords

### Metodo Obbligatorio: getTableColumns()

**⚠️ IMPORTANTE**: Tutte le classi che estendono `XotBaseListRecords` DEVONO implementare il metodo `getTableColumns()`:

```php
<?php

declare(strict_types=1);

namespace Modules\<nome modulo>\Filament\Resources\ReportResource\Pages;

use Modules\<nome modulo>\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> 472bd9dc (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> 3bf39332 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> cf971011 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> e7da37af (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> 6d05deed (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> 39bb163e (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
>>>>>>> 9e42a036 (.)
>>>>>>> 80bc07e81 (.)
=======
namespace Modules\<nome modulo>\Filament\Resources\ReportResource\Pages;

use Modules\<nome modulo>\Filament\Resources\ReportResource;
>>>>>>> 551c768c4 (.)
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;
use Filament\Tables;

/**
 * Pagina di elenco per i report.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseListRecords
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende ListRecords di Filament direttamente
 * ✅ IMPLEMENTA getTableColumns(): Metodo obbligatorio per XotBaseListRecords
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ CAMPI REALI: Solo campi che esistono nel modello Report
 * ✅ NO LABEL: Non uso ->label() perché gestito da LangServiceProvider
 */
class ListReports extends XotBaseListRecords
{
    protected static string $resource = ReportResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->searchable()
                ->sortable(),
            'patient_id' => Tables\Columns\TextColumn::make('patient_id')
                ->searchable()
                ->sortable(),
            'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain')
                ->boolean()
                ->sortable(),
            // Altri campi reali del modello Report...
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

### Regole per getTableColumns()

1. **Visibilità**: SEMPRE `public`
2. **Tipo di ritorno**: SEMPRE `array<string, \Filament\Tables\Columns\Column>`
3. **Struttura**: Array associativo con chiavi stringa
4. **Campi Reali**: MAI inventare campi, usare solo quelli del modello
5. **Traduzioni**: MAI usare `->label()`, gestite da LangServiceProvider
6. **Tipizzazione**: Includere PHPDoc completo

### Esempio di Implementazione Corretta

```php
/**
 * Get the table columns.
 *
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => Tables\Columns\TextColumn::make('id')
            ->searchable()
            ->sortable(),
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->searchable()
            ->sortable(),
        'status' => Tables\Columns\BadgeColumn::make('status')
            ->colors([
                'primary' => 'active',
                'danger' => 'inactive',
            ]),
        'created_at' => Tables\Columns\TextColumn::make('created_at')
            ->dateTime('d/m/Y H:i')
            ->sortable(),
    ];
}
```

## Regole per XotBaseEditRecord

### Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\<nome modulo>\Filament\Resources\AppointmentResource\Pages;

use Modules\<nome modulo>\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 472bd9dc (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 3bf39332 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> cf971011 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> e7da37af (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 6d05deed (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 39bb163e (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 9e42a036 (.)
>>>>>>> 80bc07e81 (.)
=======
namespace Modules\<nome modulo>\Filament\Resources\AppointmentResource\Pages;

use Modules\<nome modulo>\Filament\Resources\AppointmentResource;
>>>>>>> 551c768c4 (.)
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Actions;

/**
 * Pagina di modifica per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseEditRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende EditRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseEditRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class EditAppointment extends XotBaseEditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

## Regole per XotBaseCreateRecord

### Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\<nome modulo>\Filament\Resources\AppointmentResource\Pages;

use Modules\<nome modulo>\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 472bd9dc (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 3bf39332 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> cf971011 (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> e7da37af (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 6d05deed (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 39bb163e (.)
=======
=======
namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
>>>>>>> 9e42a036 (.)
>>>>>>> 80bc07e81 (.)
=======
namespace Modules\<nome modulo>\Filament\Resources\AppointmentResource\Pages;

use Modules\<nome modulo>\Filament\Resources\AppointmentResource;
>>>>>>> 551c768c4 (.)
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Pagina di creazione per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseCreateRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende CreateRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseCreateRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class CreateAppointment extends XotBaseCreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
```

## Esempi di Implementazione Corretta

### ReportResource.php - IMPLEMENTAZIONE CORRETTA

```php
<?php

declare(strict_types=1);

=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 9f193021d (.)
=======
>>>>>>> d9f43fce9 (.)
=======
>>>>>>> 80bc07e81 (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome modulo>\Filament\Resources;

use Modules\<nome modulo>\Filament\Resources\ReportResource\Pages;
use Modules\<nome progetto>\Models\Report;
use Modules\<nome progetto>\Models\Report;
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
=======
>>>>>>> 3bf39332 (.)
=======
=======
>>>>>>> cf971011 (.)
=======
=======
>>>>>>> e7da37af (.)
=======
=======
>>>>>>> 6d05deed (.)
=======
=======
>>>>>>> 39bb163e (.)
=======
=======
>>>>>>> 9e42a036 (.)
>>>>>>> 80bc07e81 (.)
namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\ReportResource\Pages;
use Modules\<nome progetto>\Models\Report;
use Modules\SaluteOra\Models\Report;
=======
>>>>>>> ab5b3a4f (.)
use Modules\<nome modulo>\Models\Report;
=======
use Modules\SaluteOra\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\SaluteOra\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\SaluteOra\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\SaluteOra\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\<nome modulo>\Models\Report;
use Modules\SaluteOra\Models\Report;
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> 472bd9dc (.)
=======
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> 3bf39332 (.)
=======
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> cf971011 (.)
=======
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> e7da37af (.)
=======
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> 6d05deed (.)
=======
=======
use Modules\<nome modulo>\Models\Report;
>>>>>>> 39bb163e (.)
=======
=======
use Modules\SaluteOra\Models\Report;
>>>>>>> 9e42a036 (.)
=======
=======
use Modules\<nome progetto>\Models\Report;
>>>>>>> 28fc70fe (.)
>>>>>>> 851793957 (.)
=======
>>>>>>> 551c768c4 (.)
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;

/**
 * Risorsa Filament per i report.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseResource
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende Resource di Filament direttamente
 * ✅ IMPLEMENTA getFormSchema(): Metodo obbligatorio per XotBaseResource
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO NAVIGATION ICON: Non definito perché gestito da XotBaseResource
 * ✅ NO FORM/TABLE: Metodi gestiti automaticamente da XotBaseResource
 * ✅ NO LABEL HARDCODED: Tutte le label gestite da LangServiceProvider
 */
class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    /**
     * Get the form schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // ✅ NO ->label(): Tutte le label gestite da LangServiceProvider
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'name')
                ->required(),
            
            Forms\Components\Toggle::make('has_mouth_or_teeth_pain'),
            Forms\Components\Toggle::make('smokes'),
            // Altri campi reali del modello Report...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
```

## Checklist di Conformità

Prima di considerare completa una risorsa Filament, verificare:

### ✅ Estensione Base
- [ ] Estende `XotBaseResource` invece di `Resource`
- [ ] Estende `XotBaseListRecords` invece di `ListRecords`
- [ ] Estende `XotBaseEditRecord` invece di `EditRecord`
- [ ] Estende `XotBaseCreateRecord` invece di `CreateRecord`

### ✅ Traduzioni
- [ ] NESSUN `->label()` hardcoded nei form components
- [ ] NESSUN `->placeholder()` hardcoded
- [ ] NESSUN `->helperText()` hardcoded
- [ ] Tutte le traduzioni nei file di lingua del modulo

### ✅ Campi Reali
- [ ] Tutti i campi della tabella esistono nel modello
- [ ] Tutti i campi del form esistono nel modello
- [ ] Campi presi dalla migrazione, non inventati
- [ ] Verificato con `$fillable` del modello

### ✅ Metodi Obbligatori
- [ ] `getFormSchema()` implementato in XotBaseResource
- [ ] `getTableColumns()` implementato in XotBaseListRecords
- [ ] Nessun override di metodi già gestiti da XotBaseResource

### ✅ Documentazione
- [ ] PHPDoc completo per tutte le classi e metodi
- [ ] Commenti che spiegano le scelte implementative
- [ ] Documentazione aggiornata nel modulo e nella root

## Violazioni Gravi da Evitare

1. **Estendere classi Filament direttamente**
2. **Usare `->label()` nei form components**
3. **Inventare campi che non esistono nel modello**
4. **Definire `navigationIcon` se si estende `XotBaseResource`**
5. **Non implementare metodi obbligatori come `getFormSchema()`**

## File Corretti

### ✅ ReportResource
- `ReportResource.php` - Estende `XotBaseResource`
- `ListReports.php` - Estende `XotBaseListRecords`
- `CreateReport.php` - Estende `XotBaseCreateRecord`
- `EditReport.php` - Estende `XotBaseEditRecord`

### ✅ AppointmentResource
- `AppointmentResource.php` - Estende `XotBaseResource`
- `ListAppointments.php` - Estende `XotBaseListRecords`
- `CreateAppointment.php` - Estende `XotBaseCreateRecord`
- `EditAppointment.php` - Estende `XotBaseEditRecord`

*Ultimo aggiornamento: gennaio 2025 - Correzioni per campi reali e rimozione label hardcoded*
1. **ESATTA SEQUENZA** di campi da mantenere:
   - **Dati anagrafici**: titolo_id, nome, cognome, sesso, data_nascita, etc.
   - **Classificazione professionale**: tipologia_cliente_id, stato_id, etc.
   - **Informazioni professionali**: data_iscrizione_albo, is_socio_andi, etc.
   - **Indirizzo e contatti**: via, cap, regione_id, provincia_id, etc.
   - **Dati bancari**: iban, intestatario, banca, filiale
   - **Modalità di ricezione**: Lista di modalità selezionabili
