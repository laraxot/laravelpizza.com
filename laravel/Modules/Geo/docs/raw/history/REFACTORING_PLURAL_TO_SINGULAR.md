# Refactoring Modelli Plurali → Singolari

## Panoramica
Seguendo la convenzione Laravel che richiede nomi di modelli al singolare, sono stati refactorizzati i seguenti modelli:

## Moduli Interessati

### 1. Progressioni
| Prima | Dopo |
|-------|------|
| `Schede.php` | `Scheda.php` |
| `Assenze.php` | `Assenza.php` |
| `SchedeFactory` | `SchedaFactory` |
| `AssenzeFactory` | `AssenzaFactory` |
| `SchedePolicy` | `SchedaPolicy` |

### 2. IndennitaCondizioniLavoro
| Prima | Dopo |
|-------|------|
| `Opzioni.php` | `Opzione.php` |

## Motivazione

**Perché il Singolare?**
- In Laravel/Eloquent, un modello rappresenta una singola entità/record
- Convenzione framework: **Modello = Singolare**, **Tabella = Plurale**
- Esempi: `User` → `users`, `Post` → `posts`, `Scheda` → `schede`
- In italiano: `Assenza` (modello) → `assenze` (tabella)

## Impatto

### Statistiche
- **Moduli modificati**: 2 (Progressioni, IndennitaCondizioniLavoro)
- **Modelli refactorizzati**: 3 (Schede, Assenze, Opzioni)
- **File coinvolti**: ~150+ file
- **Sostituzioni totali**: ~700+ match

### Cambiamenti
1. **Nomi file**: plurali → singolari
2. **Nomi classi**: plurali → singolari
3. **PHPDoc**: `@property Collection<int, Model>` aggiornati
4. **Use statements**: `use Modules\X\Models\Model;` aggiornati
5. **Class references**: `Model::method()` aggiornati
6. **Factories**: nomi e riferimenti aggiornati
7. **Policies**: nomi e riferimenti aggiornati

## Migration Guide

### Per Sviluppatori

```php
// Codice Vecchio (ERRATO)
use Modules\Progressioni\Models\Schede;
use Modules\Progressioni\Models\Assenze;
use Modules\IndennitaCondizioniLavoro\Models\Opzioni;

$scheda = Schede::find(1);
$assenza = Assenze::find(1);
$opzione = Opzioni::find(1);

// Codice Nuovo (CORRETTO)
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\Assenza;
use Modules\IndennitaCondizioniLavoro\Models\Opzione;

$scheda = Scheda::find(1);
$assenza = Assenza::find(1);
$opzione = Opzione::find(1);
```

## Documentazione Correlata

- [Model Naming Convention](../../docs/MODEL_NAMING_CONVENTION.md)
- [.windsurf/rules/model-naming-singular.md](../../.windsurf/rules/model-naming-singular.md)
- [.cursor/rules/model-naming-singular.md](../../.cursor/rules/model-naming-singular.md)
- [Progressioni: Schede → Scheda](./rename-schede-to-scheda.md)

## Verifica

- ✅ PHPStan Level 10: Nessun errore
- ✅ Tutti i `use` statements aggiornati
- ✅ Tutte le class references aggiornate
- ✅ Tutti i PHPDoc aggiornati
- ✅ Factories e Policies rinominati

---
**Data**: 2026-03-10  
**Tipo**: Breaking Change  
**Priorità**: Alta
