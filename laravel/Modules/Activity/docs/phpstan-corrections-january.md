# PHPStan Corrections - Activity Module - Gennaio 2025

**Data**: 2025-01-10  
**Modulo**: Activity  
**Errori Risolti**: 2

---

## 🔧 Correzioni Implementate

### HasEvents Trait - Missing Return Types

**File**: `Modules/Activity/app/Traits/HasEvents.php`

**Problema**: Metodi `storedEvents()` e `snapshots()` senza return type esplicito

**Errore PHPStan**:
```
Method Modules\Meetup\Models\Event::storedEvents() has no return type specified.
Method Modules\Meetup\Models\Event::snapshots() has no return type specified.
```

**Soluzione**:
```php
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Get the stored events relationship.
 *
 * @return MorphMany<StoredEvent>
 */
public function storedEvents(): MorphMany
{
    return $this->morphMany(StoredEvent::class, 'aggregate');
}

/**
 * Get the snapshots relationship.
 *
 * @return MorphMany<Snapshot>
 */
public function snapshots(): MorphMany
{
    return $this->morphMany(Snapshot::class, 'aggregate');
}
```

**Pattern Applicato**: Return type esplicito per relazioni Eloquent con generics PHPDoc

---

## 📚 Riferimenti

- [PHPStan Code Quality Guide](../../Xot/docs/phpstan_code_quality_guide.md)
- [Activity Module README](./README.md)

---

*Ultimo aggiornamento: 2025-01-10*

