# Testing DB Safety Rule

## Regola obbligatoria

Nei test del progetto è vietato usare comandi o trait distruttivi sul database.

### Vietato

- `RefreshDatabase`
- `php artisan migrate:fresh`
- `php artisan migrate --force`

### Consentito

- Setup mirato dei dati necessari al singolo test
- Isolamento non distruttivo (transazioni o fixture controllate)

## Obiettivo

Evitare reset globali dello schema, instabilità dei test e side-effect tra moduli.
