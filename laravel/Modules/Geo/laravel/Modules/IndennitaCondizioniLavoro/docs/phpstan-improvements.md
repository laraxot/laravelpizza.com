# PHPStan Improvements

## MakePdf action (2025-11-12)
- **Problema**: l'azione `MakePdf` assumeva che l'array `$data['anno/valutatore']` fosse sempre valido, passando valori `mixed` ai metodi `where()` e accedendo a chiavi non tipizzate; PHPStan segnalava errori `argument.type` e `offsetAccess.nonOffsetAccessible` in cascata.
- **Soluzione**: introdotta una validazione esplicita dell'input e la normalizzazione a `array{anno:int, valutatore_id:int}` prima di interrogare il modello `CondizioniLavoro`. Aggiunta un'eccezione significativa in caso di dati mancanti, e generazione del PDF con filename contestualizzato (`condizioni_lavoro_{valutatore}_{anno}.pdf`).
- **Effetti**: la query usa ora un array tipizzato, il recupero del valutatore è espresso con query builder fluent, e l'output PDF non viene più generato due volte. I controlli PHPStan su quest'azione passano senza errori.

Relazioni: vedi anche [`wire-model-input-reactivity.md`](./wire-model-input-reactivity.md) per il contesto sui dati provenienti dai form Filament.

## Populate action (2025-11-12)
- **Problema**: i parametri `anno` e `quadrimestre` venivano convertiti con `intval` senza verifiche, lasciando PHPStan a segnalare l'uso di `mixed` e rendendo possibile l'invocazione con dati non numerici.
- **Soluzione**: introdotta la validazione iniziale e il cast esplicito a `int`, documentando l'uso previsto. I dati esistenti e le nuove righe Rep00f sono ora gestiti tramite collection tipizzate, con un filtro `reject` che evita matricole già presenti.
- **Effetti**: l'azione ritorna immediatamente per input non validi, riduce l'uso di `mixed` e rende più esplicita la dipendenza dal modello `Rep00f`.

## ReplicateIndennita action (2025-11-12)
- **Problema**: l’azione prendeva l’array `anno/valutatore` così com’era, sottraendo valori a chiavi `mixed` e lasciando PHPStan segnalare errori aritmetici e di offset.
- **Soluzione**: validazione dell’input, cast esplicito a interi e ricostruzione dei filtri `$filters = ['anno' => ..., 'quadrimestre' => ...]` prima di interrogare `CondizioniLavoro`. La logica sul quadrimestre precedente è stata resa esplicita e l’operazione di `sync` esegue il clone solo quando necessario.
- **Nota**: l’action riceve direttamente i filtri della tabella (`$tableFilters`) e non un wrapper tipo `['anno/valutatore' => $tableFilters]`, perché la normalizzazione avviene all’interno dell’action.
- **Effetti**: niente più operazioni aritmetiche su `mixed`, query builder tipizzato e notifica finale con messaggio coerente.
