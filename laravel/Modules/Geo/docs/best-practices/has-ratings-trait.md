# HasRatingsTrait – Best Practice Cross-Modulo

## Regola

- La logica **generica** sulle ratings (query, regole di validazione,
  etichette) appartiene al **modulo Rating**.
- I modelli di altri moduli (es. IndennitaResponsabilita, Performance,
  PTV, ecc.) devono usare `Modules\Rating\Models\Traits\HasRatingsTrait`
  invece di implementare metodi propri `getRatings*()`.

## Pattern Corretto

```php
// Nel modulo consumer
use Modules\Rating\Models\Traits\HasRatingsTrait;

class IndennitaResponsabilita extends BaseScheda
{
    use HasRatingsTrait; // ✅ eredita ratings(), getRatingsRules(), getRatingsValidationAttributes()
}

// Nel codice Filament
$rules = $record->getRatingsRules('form_data.ratings.', '.pivot.value');
$attrs = $record->getRatingsValidationAttributes('form_data.ratings.', '.pivot.value');
```

## Anti‑Pattern

```php
// ❌ WRONG – Metodo Rating-specifico dentro FunctionTrait del modulo IndennitaResponsabilita
trait FunctionTrait
{
    public function getRatings(): Collection
    {
        return Rating::withExtraAttributes('anno', $this->anno)->get();
    }
}
```

- Sposta questi metodi in `HasRatingsTrait` nel modulo Rating.
- Lascia in `FunctionTrait` **solo** funzioni specifiche del modulo
  (es. `msg()`, `criterioRoot()`).

## Documentazione da Consultare

- `laravel/Modules/Rating/docs/has-ratings-trait.md`
- `laravel/Modules/IndennitaResponsabilita/docs/trait-responsibility-violation.md`
- `docs/claude/solid-principles.md`
- `docs/claude/dry-kiss-patterns.md`

---

*Ultimo aggiornamento: Gennaio 2026*
