# PHPStan Fixes - Modulo User

## OauthClientResource.php

### Errore
`Method Modules\User\Filament\Resources\OauthClientResource::getFormSchema() should return array<string, Filament\Support\Components\Component> but returns array<int, Filament\Schemas\Components\Section>.`

### Soluzione
Il metodo `getFormSchema()` deve restituire un array associativo con chiavi stringa, come richiesto dalle regole Filament di Laraxot per garantire la compatibilità con PHPStan Level 10.

```php
// ✅ CORRETTO
public static function getFormSchema(): array
{
    return [
        'main_section' => Section::make('OAuth Client Information')
            ->schema([
                // ...
            ]),
    ];
}
```

### Verifica
- PHPStan Level 10: PASS
- PHPMD: PASS
- PHP Insights: PASS
