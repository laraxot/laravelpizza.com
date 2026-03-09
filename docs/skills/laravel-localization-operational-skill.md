# laravel-localization-operational-skill.md

## Obiettivo

Applicare correttamente `mcamara/laravel-localization` in LaravelPizza senza regressioni su routing, redirect e form.

## Procedura operativa

1. Verificare config attiva in `config/laravellocalization.php`.
2. Verificare alias middleware in `bootstrap/app.php`.
3. Per nuove route localizzate, preferire helper package per URL/link/switch lingua.
4. Per route translatable, usare chiavi route tradotte coerenti.
5. Se toccata route cache tradotta, usare i comandi package.

## Comandi utili

```bash
php artisan route:list | rg -n "it|en|de|fr|es|ru"
php artisan route:trans:cache
php artisan route:trans:clear
```

## Errori da evitare

- action form hardcoded su URL non localizzato;
- route cache Laravel standard usata al posto della cache tradotta;
- introduzione di route pubbliche senza prefisso locale nel contesto corrente.
