# No Hardcoded Theme Strings Rule

## Regola critica

Nei temi (`laravel/Themes/*`) non sono ammesse stringhe UI hardcoded in lingua naturale.

## Obblighi

1. Tutte le label/testi visibili devono usare chiavi di traduzione (`__()`, `@lang`).
2. Le chiavi devono appartenere al namespace tema (`pub_theme::...`) o modulo pertinente.
3. Le viste Blade del tema non devono contenere microcopy italiano/inglese hardcoded.
4. Per nuovi componenti UI, creare prima le chiavi in `lang/{locale}`.

## Anti-pattern

- `Accedi`, `Registrati`, `Login`, `Sign up` scritti direttamente nel Blade.
- Placeholder, tooltip, aria-label hardcoded in lingua.

## Verifica rapida

```bash
rg -n \"(Accedi|Registrati|Login|Sign up|Sign in)\" laravel/Themes
```

Ogni occorrenza va validata: se e' testo UI, deve diventare chiave traduzione.
