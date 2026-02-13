# PHPStan Level 10 Fixes Roadmap - Modulo User

**Data Creazione**: 2025-01-27  
**Errori Totali**: 0 errori  
**Status**: ✅ Completato

## Panoramica

Il modulo User ha errori PHPStan che devono essere risolti per raggiungere la conformità Level 10. Gli errori sono concentrati principalmente in `OauthClientResource.php` e `SsoProviderResource.php`.

## Errori Dettagliati

### File: `app/Filament/Resources/OauthClientResource.php`

#### Problema: Classi Section e Grid non trovate
**Errore**: `Call to static method make() on an unknown class Filament\Forms\Components\Section`  
**Errore**: `Call to static method make() on an unknown class Filament\Forms\Components\Grid`

**Causa**: Le classi `Section` e `Grid` non esistono in `Filament\Forms\Components`. Secondo le regole del progetto, `getFormSchema()` deve restituire `array<string, Field>` senza usare Section o Grid.

**Soluzione**: Rimuovere Section e Grid, restituire direttamente i campi:
```php
/**
 * @return array<string, Field>
 */
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')
            ->required()
            ->maxLength(255),
        'user_id' => Select::make('user_id')
            ->relationship('user', 'name')
            ->searchable(),
        // ... altri campi senza Section/Grid
    ];
}
```

#### Problema: Return Type
**Errore**: `Method getFormSchema() should return array<string, Filament\Forms\Components\Field> but returns array<string, mixed>`

**Causa**: I componenti Section/Grid non sono di tipo `Field`

**Soluzione**: Rimuovere Section/Grid come sopra

### File: `app/Filament/Resources/SsoProviderResource.php`

#### Problema: Return Type getTableActions
**Errore**: `Method getTableActions() has invalid return type Filament\Tables\Actions\Action`  
**Errore**: `Method getTableActions() should return array<string, Filament\Tables\Actions\Action> but returns array<string, Filament\Actions\DeleteAction|Filament\Actions\EditAction>`

**Causa**: Il PHPDoc dichiara `Filament\Tables\Actions\Action` ma dovrebbe essere `Filament\Actions\Action` o il namespace corretto

**Soluzione**:
```php
/**
 * @return array<string, \Filament\Actions\EditAction|\Filament\Actions\DeleteAction>
 */
public static function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

**Alternativa**: Verificare il namespace corretto delle Actions in Filament 4

## Piano di Implementazione

### Fase 1: OauthClientResource (Priorità Alta) ✅
- [x] Rimuovere Section e Grid da `getFormSchema()`
- [x] Restituire array diretto di Field components
- [x] Rimuovere tutti i `->label()` hardcoded (violano regole progetto)
- [x] Verificare PHPStan Level 10

### Fase 2: SsoProviderResource (Priorità Alta) ✅
- [x] Correggere PHPDoc di `getTableActions()`
- [x] Verificare namespace corretto delle Actions
- [x] Verificare PHPStan Level 10

### Fase 3: Verifica Completa ✅
- [x] Eseguire PHPStan Level 10 su tutto il modulo User
- [x] Verificare che non ci siano regressioni
- [x] Testare funzionalità Filament dopo le modifiche

### Fase 4: Documentazione ✅
- [x] Aggiornare questa roadmap con status ✅
- [x] Documentare pattern utilizzati

## Risultato Finale

**Data Completamento**: 2025-01-27  
**Errori Risolti**: 2 errori in OauthClientResource.php, 2 errori in SsoProviderResource.php  
**PHPStan Level 10**: ✅ PASS (0 errori)

## Note Tecniche

- **Regola Critica**: `getFormSchema()` deve restituire `array<string, Field>` senza Section/Grid
- **Regola Critica**: Mai usare `->label()`, `->placeholder()`, `->helperText()` - le traduzioni sono automatiche
- Verificare namespace corretti per Filament 4/Laraxot

## Riferimenti

- [Regole Filament Resources](../../../.cursor/rules/filament-relation-managers.mdc)
- [Regole No Labels](../../../.cursor/rules/no-filament-labels.mdc)
- [PHPStan Fixes User Module - 2026-01-05](./phpstan-fix-plan-2026-01-05.md)
>>>>>>> fa4b6559 (.)
