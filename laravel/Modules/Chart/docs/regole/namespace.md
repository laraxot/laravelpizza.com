# Regole per i Namespace

## Regola Fondamentale

Il namespace di una classe NON deve includere il segmento `app` anche se il file si trova fisicamente nella cartella `app`.

### Esempio Corretto

```php
// File: laravel/Modules/Notify/app/Models/NotificationTemplate.php
namespace Modules\Notify\Models;

class NotificationTemplate extends BaseModel
{
    // ...
}
```

### Esempio Errato

```php
// ❌ NON FARE QUESTO
namespace Modules\Notify\app\Models;

class NotificationTemplate extends BaseModel
{
    // ...
}
```

## Motivazione

1. **Separazione tra Struttura Fisica e Logica**
   - La struttura fisica dei file è indipendente dal namespace
   - Il namespace riflette la struttura logica del codice
   - La cartella `app` è una convenzione di Laravel, non parte della logica

2. **Coerenza con il Sistema**
   - Tutti i moduli seguono questa convenzione
   - Facilita l'autoloading e la navigazione
   - Mantiene il codice pulito e organizzato

3. **Manutenibilità**
   - Namespace più corti e leggibili
   - Meno dipendenza dalla struttura fisica
   - Più facile spostare i file se necessario

## Best Practices

1. **Struttura dei Namespace**
   ```
   Modules\ModuleName\
   ├── Models\
   ├── Controllers\
   ├── Providers\
   └── ...
   ```

2. **Importazione di Classi**
   ```php
   // ✅ FARE QUESTO
   use Modules\Notify\Models\BaseModel;

   // ❌ NON FARE QUESTO
   use Modules\Notify\app\Models\BaseModel;
   ```

3. **Estensione di Classi Base**
   ```php
   // ✅ FARE QUESTO
   namespace Modules\Notify\Models;

   class NotificationTemplate extends BaseModel
   {
       // La classe BaseModel è nello stesso namespace
   }
   ```

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura dei Moduli](../architecture/modules.md)
- [Convenzioni di Codice](../standards/coding-standards.md)

### Collegamenti ai Moduli
- [Struttura Xot](../../laravel/Modules/Xot/docs/structure.md)
- [Struttura Notify](../../laravel/Modules/Notify/docs/structure.md)

## Note Importanti

1. Il namespace NON include mai il segmento `app`
2. La struttura fisica può differire dal namespace
3. Mantenere la coerenza in tutto il progetto
4. Documentare ogni eccezione alla regola
5. Seguire le convenzioni PSR-4 
## Collegamenti tra versioni di namespace.md
* [namespace.md](../../laravel/Modules/Reporting/docs/namespace.md)
* [namespace.md](../../laravel/Modules/Dental/docs/namespace.md)

