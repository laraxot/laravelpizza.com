# belongsToManyX Governance

## Regola

Nel modulo `Meetup`, e piu' in generale nel progetto, le relazioni many-to-many devono usare `belongsToManyX()`.

`belongsToMany()` va considerato una deviazione architetturale.

## Motivo

- `RelationX` conosce il pattern Laraxot delle pivot.
- riduce configurazione manuale e ripetuta;
- abilita auto-discovery di pivot, fillable e timestamps;
- mantiene compatibilita' con scenari cross-database.

## Esempio corretto

```php
public function attendees(): BelongsToMany
{
    return $this->belongsToManyX(User::class);
}
```

## Esempio da evitare

```php
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
}
```

## Stato

- `Event::attendees()` e' riallineato a `belongsToManyX()`.
- `Performer::events()` e `Sponsor::events()` erano gia' sul pattern corretto.
