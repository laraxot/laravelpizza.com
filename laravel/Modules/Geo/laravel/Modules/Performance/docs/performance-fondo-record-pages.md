# Performance Fondo Record Pages

## Scopo

Chiarire come rendere disponibile il record dentro `getViewData()` per le pagine custom del resource `PerformanceFondoResource`, in particolare per `OrganizzativaMoney`.

## Sintomo

La pagina `OrganizzativaMoney` risponde a un URL con pattern `/{record}/organizzativa-money`, quindi nella rotta il record c'e'. Tuttavia, dentro `getViewData()` il record non e' disponibile automaticamente.

## Causa reale

Il problema non e' `getViewData()`.

Il problema e' la **classe base** usata dalla pagina:

- `XotBasePage` e' una pagina generica
- `XotBaseViewRecord` e' una pagina pensata esplicitamente per lavorare su un record

`XotBasePage` restituisce anche `record` nel proprio `getViewData()`, ma lo espone solo se la proprieta' e' stata gia' popolata altrove. Da sola, questa classe non risolve il parametro `{record}` della route e non inizializza il record.

## Regola pratica

Se la route contiene `/{record}/...` e la pagina ragiona su un singolo modello, la pagina deve essere trattata come **record page**, non come pagina generica.

Nel caso di `PerformanceFondoResource` questo significa:

- `OrganizzativaMoney` non deve essere pensata come semplice `XotBasePage`
- deve seguire lo stesso pattern di `IndividualeMoney`
- il riferimento corretto e' una base page record-aware come `XotBaseViewRecord`

## Perche' `IndividualeMoney` funziona meglio

La pagina sorella `IndividualeMoney` estende `XotBaseViewRecord`.

Questo e' il punto importante: una page di tipo view-record nasce per vivere su una route con record, quindi il record viene risolto e mantenuto nel ciclo di vita della pagina. Per questo dentro `getViewData()` puoi ragionare su `$this->record`.

## Come farlo correttamente

Per avere il record disponibile dentro `getViewData()`:

1. la pagina deve essere una **pagina di record**
2. la route deve continuare a usare `/{record}/...`
3. la classe deve usare una base coerente con quel contratto, cioe' una base che risolve il route parameter in un modello
4. dentro `getViewData()` devi leggere il record gia' risolto, non tentare di ricostruirlo in modo improvvisato

## Cosa non fare

Non partire da `XotBasePage` aspettandoti che il solo fatto di avere `/{record}` nella route renda disponibile il record.

Quella classe e' utile per pagine custom generiche, dashboard, utility pages, pagine senza record implicito.

Se vuoi restare su una pagina generica, devi assumerti manualmente tutta la logica di binding del route parameter al modello. Questo e' piu' fragile, piu' verboso e meno coerente con Filament.

## Decisione consigliata

Per `OrganizzativaMoney`, la scelta architetturalmente corretta e' uniformarla a `IndividualeMoney`:

- stessa semantica di pagina
- stessa idea di route basata su record
- stesso lifecycle di Filament
- stesso modo di accedere al record in `getViewData()`

In sintesi: **non devi "portare il record dentro getViewData()"**. Devi fare in modo che la pagina sia una vera record page; a quel punto `getViewData()` eredita un contesto corretto e il record e' gia' disponibile.

## Riferimenti

- `../app/Filament/Resources/PerformanceFondoResource/Pages/OrganizzativaMoney.php`
- `../app/Filament/Resources/PerformanceFondoResource/Pages/IndividualeMoney.php`
- `../../Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `../../Xot/app/Filament/Resources/Pages/XotBaseViewRecord.php`
