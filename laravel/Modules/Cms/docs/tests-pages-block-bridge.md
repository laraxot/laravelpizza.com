# Tests Pages Block Bridge

## Problema risolto

Le pagine `tests.*` del CMS non erano realmente assenti in termini di slug JSON. Il problema era più sottile:
- gli slug esistevano
- molte `data.view` puntavano però a blocchi non presenti nel tema
- il rendering quindi falliva a runtime

## Causa

Il layer contenuti e il layer tema erano fuori sync.

La regola corretta resta:

`pub_theme::components.blocks.<tipo>.<blade>`

Quando il CMS dichiara una view, il tema deve avere quel file. Se manca, la pagina diventa di fatto non navigabile anche se il JSON esiste.

## Strategia adottata

Per sbloccare le pagine mancanti senza propagare nuovo legacy:
- il provider base Xot ignora i path anonimi non validi invece di chiamare `dddx()`
- il tema Sixteen espone un set di block bridge compatibili con i JSON `tests.*`
- i bridge riusano dove possibile blocchi già esistenti

## Ambito coperto

Sono stati coperti i namespace oggi richiesti dai JSON:
- `administration.*`
- `breadcrumb.default`
- `contact.info`
- `event.*`
- `feedback.rating`
- `header.page`
- `hero.argomenti`
- `hero.homepage`
- `info.default`
- `news.*`
- `service.*`
- `services.related`
- `steps.horizontal`
- `tests.*`
- `topics.featured`

## Policy

Questo bridge non sostituisce la normalizzazione futura dei contenuti.

La direzione corretta resta:
- blocchi semantici e riusabili
- niente tipi di blocco pagina-specifici
- niente rollback Git
- convergenza progressiva verso HTML e resa visiva del reference Design Comuni
