# Logout: POST /{lang}/auth/logout rispondeva 405

- Stato: done (2026-10-07)
- Fase BMAD: Quick Flow (errore da trace, causa, fix, verifica HTTP)
- Owner: Modules/User (`LogoutAction`), route dell'app (`laravel/routes/web.php`)

## Problema

`MethodNotAllowedHttpException`: "The POST method is not supported for route it/auth/logout.
Supported methods: GET, HEAD." Gli header del tema inviano un form POST con CSRF a `route('logout')`.

## Cause radice

1. `route('logout')` e' la pagina Folio `auth/logout`, che accetta solo GET/HEAD.
2. L'handler POST esisteva ma in `Modules/User/routes/web.php`, che **non viene mai caricato**:
   `XotBaseRouteServiceProvider::map()` e' disabilitato di proposito ("Folio + Volt").
3. `LogoutAction` faceva `redirect()->route('home')`, route inesistente: avrebbe dato 500 subito dopo.
4. Il vincolo iniziale `->whereIn('lang', ['it','en'])` lasciava de/es con 405.

## Modifiche

- `laravel/routes/web.php`: `Route::post('/{lang}/auth/logout', LogoutAction::class)` con
  `where('lang','[a-z]{2}')`, middleware `auth`, nome `logout.post` (diverso da `logout` per non
  collidere con la pagina Folio).
- `LogoutAction`: accetta `?string $lang` e reindirizza a `/{lang}` (o al locale corrente).
- Nessun form di header modificato: stesso URL, ora anche POST.

## Verifica

POST con cookie e token CSRF reali contro `https://192.168.1.40:8080`:
it, en, de, es -> 302 verso `/{lang}/auth/login` (redirect dei guest del middleware `auth`);
GET `/de/auth/logout` -> 200 (pagina Folio intatta); POST senza CSRF -> 419.

## Aperto

- Il corpo di `LogoutAction` non e' stato esercitato con un utente loggato (nessun utente di test).
- `Modules/User/routes/web.php` contiene ancora la vecchia `Route::post('logout')`, mai raggiungibile.
- Regola da ricordare: le route nei file `Modules/*/routes/*.php` non sono caricate.
