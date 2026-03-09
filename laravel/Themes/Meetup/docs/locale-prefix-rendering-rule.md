# Theme Meetup Locale Prefix Rendering Rule

## Regola

Nel tema `Meetup`, una URL come `/de` deve rendere il documento come tedesco.

Segnale minimo verificabile:

- `<html lang="de">`

## Conseguenza

La locale non puo' dipendere solo da logica inline nei singoli Blade.

Deve essere gia' risolta a livello middleware / routing prima che il layout principale venga renderizzato.

Questa regola e' coerente con `mcamara/laravel-localization`: il Blade puo' consumare la locale corrente, non deve diventare il posto in cui la locale viene "riparata".

## Test richiesto

Le homepage localizzate devono essere verificate almeno su:

- `/it`
- `/en`
- `/de`

e ciascuna deve restituire il `lang` coerente col prefisso richiesto.
