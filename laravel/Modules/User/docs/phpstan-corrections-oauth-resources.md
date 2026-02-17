# PHPStan Corrections - OAuth Resources

**Data**: 2025-01-22
**Status**: In Progress
**Versione**: 1.0.0

## Correzioni Applicate

### OauthAccessTokenResource.php

#### Correzioni Namespace Filament 4
- `Forms\Components\Section` → `Schemas\Components\Section`
- `Forms\Components\Grid` → `Schemas\Components\Grid`
- Rimossi tutti i `->label()` hardcoded

#### Correzioni Type Safety
- Tipizzato `$record` come `OauthAccessToken` invece di `mixed`
- Corretto accesso a `$user->exists` con `method_exists()` check
- Tipizzato `$state` in `formatStateUsing` per `Carbon`
- Usato `Safe\json_encode` per sicurezza

### OauthAuthCodeResource.php

#### Correzioni Namespace Filament 4
- Aggiunti import corretti: `Filament\Actions\*`
- Rimossi tutti i `->label()` hardcoded

#### Correzioni Type Safety
- Tipizzato `$state` in `formatStateUsing` per `Str::limit()`
- Corretto `json_encode` unsafe usage con `Safe\json_encode`

### OauthRefreshTokenResource.php

#### Correzioni Namespace Filament 4
- `Filament\Tables\Actions\*` → `Filament\Actions\*`
- Rimossi tutti i `->label()` hardcoded
- Rimosso `->helperText()` hardcoded

### OauthClientResource.php

#### Correzione Type di `$navigationIcon`
- Problema: PHP 8.3 richiede che il tipo di `$navigationIcon` nella resource sia compatibile con `Filament\Resources\Resource`, che in Filament 4 usa `BackedEnum|string|null`.
- Correzione prevista: aggiornare la property in `OauthClientResource` per usare il tipo `BackedEnum|string|null`, mantenendo il valore stringa esistente (`'heroicon-o-key'`).
- Motivazione: allineare la firma al contratto Filament 4 e garantire compatibilità futura con possibili enum di icone, senza cambiare la UI.

### ListOauthClients.php

#### Correzioni Type Safety & Firma Metodo
- Problema: `getHeaderActions()` dichiarato come `array<int, ActionInterface>` con ritorno numerico, non compatibile con `XotBaseListRecords::getHeaderActions()`.
- Correzione: usare firma e tipo compatibili con la classe base, restituendo **array associativi con chiavi stringa** e azioni concrete.
- Esempio applicato:

```php
/**
 * @return array<string, \Filament\Actions\Action>
 */
protected function getHeaderActions(): array
{
    return [
        'create' => CreateAction::make(),
    ];
}
```

## 🎯 Pattern Applicati

### Pattern 1: Namespace Filament 4
```php
// ❌ ERRATO - Filament 3
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\DeleteAction;

// ✅ CORRETTO - Filament 4
use Filament\Schemas\Components\Section;
use Filament\Actions\DeleteAction;
```

### Pattern 2: Rimozione Label Hardcoded
```php
// ❌ ERRATO
TextColumn::make('name')->label('Name')

// ✅ CORRETTO
TextColumn::make('name')
```

### Pattern 3: Type Safety per Record
```php
// ❌ ERRATO
->url(function (mixed $record): ?string {
    $user = $record->user;
})

// ✅ CORRETTO
->url(function (mixed $record): ?string {
    if (! $record instanceof OauthAccessToken) {
        return null;
    }
    $user = $record->user;
})
```

## 📚 Riferimenti

- [Filament 4 Migration Guide](../../Xot/docs/filament-4-migration-guide.md)
- [PHPStan Errors Philosophy](./phpstan-errors-philosophy.md)
- [Filament 4 Actions Namespace](./filament-4-actions-namespace.md)

---

*Ultimo aggiornamento: 2025-01-22*
