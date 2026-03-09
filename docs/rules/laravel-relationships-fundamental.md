# Regole Fondamentali Relazioni LaravelPizza

**Priority**: critical  
**Updated**: 2026-03-09

## Regola obbligatoria

Per relazioni many-to-many nel progetto LaravelPizza:

- **SEMPRE** usare `belongsToManyX()`
- **MAI** usare `belongsToMany()`

## Pattern corretto

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function attendees(): BelongsToMany
{
    return $this->belongsToManyX(User::class, 'event_user', 'event_id', 'user_id')
        ->withTimestamps();
}
```

## Anti-pattern

```php
<?php

declare(strict_types=1);

public function attendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
}
```

## Checklist operativa

- Cercare nuove occorrenze `belongsToMany(` prima del commit.
- Convertire a `belongsToManyX(` quando compaiono.
- Aggiornare test e documentazione della relazione toccata.
- Tracciare il cambio su GitHub issue/discussion.

**Violare questa regola = rischiare crash in produzione!** ⚠️
