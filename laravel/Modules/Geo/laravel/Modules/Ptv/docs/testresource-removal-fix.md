# Fix: Rimozione TestResource con modello App\Models\Test inesistente

## Data Intervento
**2025-01-22** - Rimozione Resource di test non funzionante

## Problema Identificato

Errore: `Class "App\Models\Test" not found` quando si accede alla route `/ptv/admin/tests`.

### Causa Radice

La Resource `TestResource` nel modulo Ptv stava cercando di utilizzare il modello `App\Models\Test` che non esiste:

```php
// ❌ ERRATO
namespace Modules\Ptv\Filament\Resources\Tests;

use App\Models\Test;  // ← Classe non esiste!

class TestResource extends Resource
{
    protected static ?string $model = Test::class;  // ← Errore qui
}
```

### Stack Trace

L'errore si verificava in:
- `vendor/filament/filament/src/Resources/Resource.php:69`
- Durante il discovery automatico delle Resources da Filament
- Quando Filament cercava di istanziare il modello per la Resource

## Soluzione Implementata

### Rimozione Completa della Resource

La Resource `TestResource` e tutte le sue dipendenze sono state completamente rimosse:

1. **Resource principale**: `Modules/Ptv/app/Filament/Resources/Tests/TestResource.php`
2. **Pages**: 
   - `ListTests.php`
   - `CreateTest.php`
   - `EditTest.php`
3. **Schemas**: `TestForm.php`
4. **Tables**: `TestsTable.php`
5. **Cartella completa**: `Modules/Ptv/app/Filament/Resources/Tests/`

### Pulizia Cache

Dopo la rimozione, è stata eseguita la pulizia completa della cache:

```bash
php artisan optimize:clear
rm -rf bootstrap/cache/filament/panels/ptv*admin.php
```

## Analisi Pre-Rimozione

### Tentativo di Disabilitazione Navigation

Inizialmente si è tentato di disabilitare la navigation della Resource:

```php
// Tentativo iniziale (non funzionante)
class TestResource extends XotBaseResource
{
    protected static ?string $model = null;
    protected static bool $shouldRegisterNavigation = false;
    
    public static function getFormSchema(): array
    {
        return [];
    }
}
```

**Problema**: Anche con navigation disabilitata, Filament cercava comunque di caricare il modello durante il discovery, causando l'errore.

### Problema con Metodi Final

`XotBaseResource` ha il metodo `form()` dichiarato come `final`, quindi non può essere sovrascritto. Questo ha reso impossibile mantenere la Resource con metodi `form()` e `table()` personalizzati.

## Decisione Finale

Dato che:
1. Il modello `App\Models\Test` non esiste e non deve esistere
2. La Resource è stata probabilmente generata per errore
3. Non ci sono riferimenti funzionali alla Resource nel codice
4. Disabilitare la navigation non risolveva il problema del discovery

**Soluzione**: Rimozione completa della Resource e di tutte le sue dipendenze.

## File Rimossi

```
Modules/Ptv/app/Filament/Resources/Tests/
├── TestResource.php          ← Rimosso
├── Pages/
│   ├── ListTests.php         ← Rimosso
│   ├── CreateTest.php        ← Rimosso
│   └── EditTest.php          ← Rimosso
├── Schemas/
│   └── TestForm.php          ← Rimosso
└── Tables/
    └── TestsTable.php        ← Rimosso
```

## Verifica Post-Rimozione

### Comandi di Verifica

```bash
# Verifica che la Resource non sia più scoperta
php artisan filament:list | grep -i test

# Verifica che la route non esista più
php artisan route:list | grep tests

# Verifica che non ci siano riferimenti nel codice
grep -r "TestResource" Modules/Ptv/
```

### Risultati Attesi

- ✅ Nessuna Resource "Test" nella lista Filament
- ✅ Nessuna route `/ptv/admin/tests`
- ✅ Nessun riferimento a `TestResource` nel codice
- ✅ Nessun errore durante il discovery di Filament

## Prevenzione Futura

### Regole per Generazione Resources

Quando si genera una nuova Resource Filament:

1. **Verificare che il modello esista** prima di generare la Resource
2. **Usare sempre modelli del modulo corretto**: `Modules\{Module}\Models\{Model}`
3. **Mai usare modelli da `App\Models\`** in Resources di moduli
4. **Verificare namespace corretto** dopo la generazione

### Comando Corretto per Generazione

```bash
# ✅ CORRETTO: Specificare il modello corretto
php artisan make:filament-resource Modules\\Ptv\\Models\\MyModel

# ❌ ERRATO: Generare senza modello o con modello errato
php artisan make:filament-resource Test  # ← Cerca App\Models\Test
```

## Collegamenti

- [Filament Resource Creation](../../Xot/docs/filament-resource-creation-fix.md)
- [XotBaseResource Rules](../../Xot/docs/filament/resource-rules.md)
- [Errori Comuni Traduzione](../../Lang/docs/errori-comuni-traduzione.md)

## Note Tecniche

- La Resource è stata probabilmente generata durante test o sviluppo
- Il modello `App\Models\Test` non esiste nel progetto
- Filament discovery automatico cerca tutte le Resources nella cartella `app/Filament/Resources`
- Anche con navigation disabilitata, Filament cerca comunque di caricare il modello durante il discovery

*Intervento completato il: 2025-01-22*
*Problema risolto: Resource rimossa completamente*

