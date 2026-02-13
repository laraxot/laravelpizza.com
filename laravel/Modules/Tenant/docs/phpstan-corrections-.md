# PHPStan Corrections - Tenant Module - Gennaio 2025

**Modulo**: Tenant
**Errori Risolti**: 1

---

## 🔧 Correzioni Implementate

### TenantService - Missing getConfigNames() Method

**File**: `Modules/Tenant/app/Services/TenantService.php`

**Problema**: Metodo `getConfigNames()` chiamato ma non definito in `TenantService`

**Errore PHPStan**:
```
Call to an undefined static method Modules\Tenant\Services\TenantService::getConfigNames().
```

**Soluzione**: Aggiunto metodo delegato all'Action:
```php
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;

/**
 * Ottiene i nomi di tutti i file di configurazione disponibili per il tenant corrente.
 *
 * @return array<int, array{id: int, name: string}> Array di configurazioni con id e name
 */
public static function getConfigNames(): array
{
    return app(GetTenantConfigNamesAction::class)->execute();
}
```

**Pattern Applicato**: Service Locator Pattern - TenantService delega sempre alle Actions

---

## 📚 Riferimenti

- [Tenant Configuration Documentation](./configuration.md)
- [Service Locator Pattern](../../Xot/docs/service-locator-pattern.md)

---

*Ultimo aggiornamento: 2025-01-10*
