# Laravel Folio Routing Rule

## Regola canonica

Quando una pagina pubblica appartiene al frontoffice CMS/theme, il routing deve restare Folio-first.

Questo significa:

- file page dentro i path montati da Folio;
- uso di `Folio::path()->uri()` o `domain()->path()` nel provider;
- middleware di gruppo registrati sul mount Folio;
- middleware specifici solo quando servono davvero a livello pagina.

## Primitive da rispettare

Da Laravel Folio:

- parametri route da filename: `[id]`
- catch-all da filename: `[...segments]`
- implicit model binding da filename: `[User]` o FQCN
- named route via `name()`
- page middleware via `middleware()`
- render hook via `render()`

## Non fare

- non duplicare in controller route che Folio puo' rappresentare meglio;
- non usare Blade page come sostituto di middleware o route registration;
- non ricostruire a mano parsing di segmenti se il filename Folio puo' esprimerlo gia';
- non trattare Folio come se fosse solo una convenzione di cartelle.

## Fare

- usare `[param]` e `[...param]` quando il path e' realmente route-driven;
- usare `name()` solo per pagine che hanno un vero bisogno di URL generation;
- usare `render()` per personalizzare la response, non per infilare business logic nel template;
- usare route cache anche con Folio.
