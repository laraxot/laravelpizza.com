# mcamara/laravel-localization Deep Dive (<nome progetto>)

## Obiettivo

Allineare la nostra integrazione locale alle raccomandazioni del package ufficiale.

## Stato progetto

- Middleware alias registrati in `bootstrap/app.php`.
- Config pubblicata in `config/laravellocalization.php`.
- Default attuale:
  - `useAcceptLanguageHeader=true`
  - `hideDefaultLocaleInURL=false`
  - `httpMethodsIgnored=['POST','PUT','PATCH','DELETE']`

## Punti critici da presidiare

1. Form in pagine localizzate:
   - usare URL action localizzati per evitare redirect non desiderati.
2. Route translatable:
   - mantenere coerenza tra chiavi `routes.*` e definizioni route.
3. Caching route localizzate:
   - usare i comandi del package per route tradotte.
4. Test:
   - includere casi multi-lingua su pagine public e switch lingua.

## Nota su Profile/Event pages

Per pagine con schema SEO (Event/ProfilePage/WebPage), l'URL canonico usato nel JSON-LD deve restare coerente con l'URL localizzato generato dal package.
