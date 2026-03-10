# Meetup: Profile Contract In DocBlocks

## Regola

Nei PHPDoc dei model `Meetup`, le relazioni trasversali come `creator`, `updater`, `deleter` devono usare:

`@property-read \Modules\Xot\Contracts\ProfileContract|null ...`

e non:

`@property-read \Modules\Meetup\Models\Profile|null ...`

## Perche'

- il codice dipende dal contratto, non dall'implementazione concreta;
- ide-helper puo' generare un tipo troppo stretto;
- il contratto mantiene stabile il significato anche se cambia il model concreto risolto a runtime.
