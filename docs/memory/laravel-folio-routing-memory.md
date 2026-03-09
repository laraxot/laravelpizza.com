# Laravel Folio Routing Memory

Memoria operativa:

- Folio e' il router file-based canonico del frontoffice;
- route params e model binding possono nascere direttamente dal filename;
- middleware di gruppo vanno messi sul mount Folio, non distribuiti come workaround nei Blade;
- `render()` serve per modellare la response, non per spostare tutta la logica nel template;
- `name()` rende le page route compatibili con `route()` quando serve davvero.
