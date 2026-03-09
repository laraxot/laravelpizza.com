# Laravel Relationships Critical Rule

## Regola canonica

Nel progetto Laraxot/LaravelPizza le relazioni many-to-many applicative devono usare `belongsToManyX()`, non `belongsToMany()`.

Questa non e' una preferenza stilistica: e' una convenzione architetturale del framework locale (`RelationX`) per auto-discovery dei pivot, chiavi, namespace e comportamento coerente tra moduli.

## Regola operativa

- usare `belongsToManyX(Related::class, ...)` per le relazioni many-to-many dei modelli applicativi;
- usare `morphToManyX()` per le relazioni polimorfiche equivalenti quando previste;
- non introdurre nuove relazioni `belongsToMany()` nei moduli o nei temi senza una motivazione eccezionale e documentata;
- quando una doc legacy mostra `belongsToMany()`, trattarla come esempio storico da correggere, non come fonte canonica.

## Motivazione

- `belongsToManyX()` incapsula la convenzione Laraxot per pivot e foreign keys;
- riduce duplicazione manuale di nomi pivot e chiavi;
- mantiene coerenza con il resto del codebase e con gli helper di `Xot`;
- evita deriva architetturale tra moduli che altrimenti definirebbero relazioni simili in modi incompatibili.

## Applicazione in Meetup

Nel modulo `Meetup` questa regola vale almeno per:

- `Event -> attendees`
- `Event -> performers`
- `Event -> sponsors`
- `Performer -> events`
- `Sponsor -> events`

La UI pubblica, i block CMS e il JSON-LD devono leggere dati da queste relazioni convenzionali, non da relazioni many-to-many Eloquent plain introdotte ad hoc.

## Checklist

- [ ] Ho usato `belongsToManyX()`?
- [ ] Ho evitato `belongsToMany()`?
- [ ] Ho documentato eventuali eccezioni?
- [ ] Ho allineato test e docs locali del modulo/tema coinvolto?
