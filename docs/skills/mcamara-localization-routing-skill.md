# Skill Operativa: mcamara Localization Routing

## Quando usarla

Usare questa skill quando il task riguarda:

- route localizzate;
- language switcher;
- redirect post-login/logout localizzati;
- Folio/Volt con prefisso lingua;
- bug di URL `/it/...`, `/en/...`.

## Workflow

1. Verificare la config `laravellocalization.php`.
2. Verificare gli alias middleware in `bootstrap/app.php`.
3. Controllare che la route pubblica sia sotto gruppo con `LaravelLocalization::setLocale()`.
4. Cercare hardcode di `/it`, `/en`, `url('/' . app()->getLocale() ...)`.
5. Cercare nei temi pseudo-traduzioni tipo `__('Accedi')`, `__('Registrati')`, `__('Home')`.
6. Sostituire URL con `localizeUrl()` o `getLocalizedURL()` e label con chiavi namespaced reali.
7. Se il task tocca PHP, eseguire quality gate completo.

## Anti-pattern

- costruire URL localizzati con concatenazione manuale;
- creare helper custom che duplicano `localizeUrl()`;
- fare redirect di cambio lingua riscrivendo il primo segmento del path a stringa.
- usare testo letterale o `__('testo letterale')` nei Blade del tema.
