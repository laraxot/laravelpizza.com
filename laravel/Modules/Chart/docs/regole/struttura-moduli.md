# Regola Fondamentale: Struttura dei Namespace nei Moduli

> **NOTA**: Questo documento è stato spostato nel modulo Xot per centralizzare la documentazione tecnica. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sulla struttura dei moduli](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/MODULE_STRUCTURE.md)
- [Convenzioni di naming](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/NAMING_CONVENTIONS.md)
- [Architettura Folio + Volt + Filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/FOLIO_VOLT_ARCHITECTURE.md)

## Sommario

Nel progetto Base, ogni modulo segue una struttura di namespace specifica e standardizzata:

### Regola Fondamentale
È **fondamentale** comprendere la distinzione tra struttura fisica dei file e namespace logico nei moduli:

```php
// ✅ CORRETTO
namespace Modules\User\Models;
namespace Modules\Patient\Filament\Resources;

// ❌ ERRATO
namespace Modules\User\app\Models;
namespace Modules\Patient\app\Filament\Resources;
```

Anche se i file sono fisicamente nella cartella `app/`, il namespace **non** deve includere il segmento `app`.

Consulta la documentazione completa nel modulo Xot per maggiori dettagli, esempi di implementazione e best practice.
