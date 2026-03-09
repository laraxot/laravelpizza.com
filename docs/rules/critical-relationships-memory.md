# Memory Rule: belongsToManyX Mandatory

**Type**: critical-memory  
**Updated**: 2026-03-09

## Cosa ricordare sempre

- In LaravelPizza, per relazioni many-to-many, usare `belongsToManyX(...)`.
- `belongsToMany(...)` e' da considerare non conforme alle regole di progetto.

## Snippet standard

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function performers(): BelongsToMany
{
    return $this->belongsToManyX(Performer::class, 'event_performer')
        ->withPivot(['role', 'order'])
        ->withTimestamps();
}
```

## DoD per modifiche relazionali

- relazione implementata con `belongsToManyX(...)`
- test Pest aggiornati o aggiunti
- issue/discussion aggiornata con motivazione tecnica
