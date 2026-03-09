# Laravel Folio Routing Skill

## Quando usarla

Usare questa skill quando il problema riguarda:

- pages path Folio;
- parametri `[slug]`, `[id]`, `[...segments]`;
- named routes Folio;
- middleware Folio;
- render hooks;
- bug di routing file-based nel tema o nel CMS.

## Workflow

1. Verificare dove viene montato Folio (`Folio::path`, `uri`, `domain`, `middleware`).
2. Verificare se il root di sezione deve essere un `index.blade.php` invece di uno slug artificiale.
3. Verificare se il pattern URL puo' essere espresso dal filename (`[slug]`, `[id]`, `[...segments]`, implicit model binding) invece che da parsing manuale.
4. Verificare se il middleware sta sul mount giusto o e' stato spostato impropriamente nei Blade.
5. Usare `name()` solo quando la pagina ha bisogno di URL generation stabile.
6. Usare `render()` solo per adattare la response o aggiungere dati, non per business logic pesante o ricostruzione opaca del routing.
7. Aggiungere test che colpiscono davvero la URL Folio finale.
8. Ricordare che `route:cache` e' compatibile con Folio; separare questo tema da eventuali limitazioni di package di localizzazione.

## Anti-pattern

- controller routes duplicate di pagine Folio;
- segment parsing manuale superfluo;
- ignorare `index.blade.php` e simulare il root via redirect/slug;
- locale/auth/slug riparati nei Blade invece che nel mount/middleware;
- usare `render()` come contenitore di logica non di routing;
- test che non esercitano la URL reale.
