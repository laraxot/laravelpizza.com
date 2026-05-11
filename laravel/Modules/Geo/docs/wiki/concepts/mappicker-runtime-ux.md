# mappicker runtime ux

## regola

Se `MapPicker` parte con coordinate non valorizzate (`latitude = null` oppure `longitude = null`), deve tentare automaticamente la geolocalizzazione browser e aggiornare lo stato con la posizione corrente.

La regola vale anche se solo una delle due coordinate e assente: la coppia viene considerata invalida e deve essere ricalcolata come blocco unico.

## contratto operativo

- condizione trigger: coordinate iniziali non finite (`null`, `NaN`, stringhe vuote)
- azione: richiesta geolocalizzazione (`navigator.geolocation.getCurrentPosition`)
- risultato: update marker + pan mappa + emissione evento `coords-changed`
- persistenza: entrambe le coordinate correnti vengono materializzate nello stato Livewire, non solo nel marker UI
- sincronizzazione: bridge Alpine aggiorna il `statePath` Livewire via `$wire.$set(...)`

## note implementative

- il fallback visivo resta sul centro configurato fino alla risposta geolocation
- in caso di diniego permessi, la mappa rimane sul centro fallback senza rompere il flusso
- la regola vale per `MapPicker` e per i consumer che usano la stessa core UI (`coordinate-picker-field`)
- non devono esistere stati misti tipo `latitude` valorizzata e `longitude` nulla

## riferimenti

- [map-picker-family-architecture](./map-picker-family-architecture.md)
- [mappicker-xotbasefield-rule](./mappicker-xotbasefield-rule.md)
- [latitudelongitudeinput-runtime-ux](./latitudelongitudeinput-runtime-ux.md)
