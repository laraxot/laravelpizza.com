# Permission self-heal: PermissionDoesNotExist non deve piu' produrre 500

Status: done
Data: 2026-09-21
Modulo owner: User

## Bug

`GET /user/admin/users` -> 500. `Spatie\Permission\Exceptions\PermissionDoesNotExist`: "There is no permission
named `oauth-access-token.view.any` for guard `web`." Origine: `OauthAccessTokenPolicy::viewAny()` ->
`$user->hasPermissionTo('oauth-access-token.view.any')`. Ambiente: 192.168.1.35:8000, PHP 8.4.25, Laravel 13.26.1.

## Analisi BMAD

**B (business)**: un permesso mancante in DB non deve mai rompere una pagina Filament con 500; deve negare
l'accesso (comportamento sicuro di default) e potersi auto-riparare dove esplicitamente richiesto.

**M (model/architettura)**: ~230+ Policy nel repo chiamano `hasPermissionTo('<risorsa>.<abilita>')` con stringa
letterale (convenzione kebab-case + dot, es. `oauth-access-token.view.any`). Ogni User model passa da
`Modules\User\Models\BaseUser` -> trait `HasSpatiePermission`.

**A (alternative valutate, in ordine cronologico reale — l'implementazione e' cambiata piu' volte nel corso del
task, sessioni concorrenti sullo stesso repo)**:

1. Solo seeding (`PermissionSeeder::run()`): risolve solo il permesso mancante oggi, non previene la prossima
   dimenticanza. Scartata come unica soluzione.
2. Self-heal via derivazione nome permesso da classe Policy + ability (pattern gia' tentato in
   `UserPermissionBasePolicy::before()`, vedi Ridondanza): fragile, la derivazione automatica produce nomi
   diversi dalle stringhe letterali realmente usate. Scartata.
3. Override silenzioso di `hasPermissionTo()`: intercetta `PermissionDoesNotExist` su QUALUNQUE chiamata,
   ovunque nell'app, e auto-crea. Blast radius incontrollato (un typo in qualsiasi punto del codice crea
   permessi spazzatura in silenzio). Committata (`4362e42d5`), poi sostituita.
4. Metodo esplicito `hasPermissionToOrCreate()` che delega a un `ensurePermissionExists()` separato, che a sua
   volta passava per una Queueable Action (`EnsurePermissionExistsAction`) per rispettare il binding config
   `permission.models.permission`. Implementata, poi semplificata: l'indirezione via Action non aggiungeva
   nulla (il progetto estende gia' i modelli Spatie direttamente, vedi `.claude/CLAUDE.md`).
5. **Scelta finale**: un solo metodo pubblico in `HasSpatiePermission`, nessun override di `hasPermissionTo()`:
   ```php
   public function hasPermissionToOrCreate(string $permission, ?string $guardName = null): bool
   {
       $guardName ??= $this->getDefaultGuardName();
       Permission::findOrCreate($permission, $guardName);
       return $this->hasPermissionTo($permission, $guardName);
   }
   ```
   `Permission::findOrCreate()` chiamato diretto su `Modules\User\Models\Permission` (classe concreta del
   modulo, gia' `extends SpatiePermission`). Ogni Policy che vuole l'auto-create lo dichiara esplicitamente
   chiamando `hasPermissionToOrCreate()` invece di `hasPermissionTo()`. Blast radius contenuto al solo call
   site che lo richiede di proposito. Applicato a tutte le 6 abilita' di `OauthAccessTokenPolicy` (viewAny,
   view, create, update, delete, restore, forceDelete).

**D (dettagli implementazione finale)**:
- `Modules/User/app/Models/Traits/HasSpatiePermission.php`: `use HasRoles;` invariato (nessun alias/override),
  un solo metodo pubblico aggiuntivo come sopra. Permesso creato senza ruoli -> `hasPermissionTo()` ritorna
  `false` dopo la creazione: nega accesso, comportamento corretto (mai grant implicito).
- `Modules/User/app/Models/Policies/OauthAccessTokenPolicy.php`: tutte le abilita' convertite da
  `hasPermissionTo(...)` a `hasPermissionToOrCreate(...)`.
- Nessuna Action Queueable dedicata: chiamata diretta a `Permission::findOrCreate()`, coerente con la
  convenzione del repo "estendi il modello Spatie direttamente, usalo direttamente".

## Ridondanza trovata e rimossa (due occorrenze)

1. `Modules/User/app/Models/Policies/UserPermissionBasePolicy.php` (abstract, commento "EX XotBasePolicy"):
   stesso intento (self-heal permesso mancante) ma derivazione nome rotta (non rispetta la convenzione
   kebab-case + dot usata ovunque) e **zero classi la estendono** in tutto il repo (grep repo-wide prima
   della rimozione). Dead code mai attivo. Rimosso.
2. `Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php`: Queueable Action creata
   nell'alternativa 4 sopra, passata attraverso `GetPermissionModelAction` per rispettare il binding config.
   Resa orfana dal passaggio all'alternativa 5 (chiamata diretta inline). Verificato zero chiamanti residui
   (grep repo-wide, ripetuto due volte in momenti diversi, sempre zero risultati). Rimossa, cartella
   `Actions/Permission/` vuota rimossa con essa. `GetPermissionModelAction.php` resta: ha altri chiamanti
   (`RoleResource/Pages/EditRole.php`), non toccato.

## Verifica

Test: `Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php` (5 casi):
1. Permesso esistente: comportamento identico a Spatie standard.
2. Permesso mancante via `hasPermissionToOrCreate()`: non esplode, viene creato, accesso negato.
3. `hasPermissionTo()` standard (senza opt-in): continua a esplodere su permesso mancante — conferma che il
   blast radius resta contenuto al solo `hasPermissionToOrCreate()`.
4. Permesso auto-creato: assegnabile via ruolo dopo, funziona normalmente.
5. `OauthAccessTokenPolicy::viewAny()` end-to-end: non esplode piu' su permesso mancante.

Esecuzione:
```
APP_ENV=testing CACHE_STORE=array vendor/bin/pest Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php --no-coverage
Tests:    5 passed (9 assertions)
```

PHPStan sui file finali (`HasSpatiePermission.php`, `OauthAccessTokenPolicy.php`, il test): `[OK] No errors`.

Nota di processo: piu' sessioni concorrenti hanno lavorato sullo stesso file `HasSpatiePermission.php` durante
questo task, riscrivendone l'architettura piu' volte (override silenzioso -> metodo esplicito con Action
separata -> metodo esplicito inline) senza coordinamento diretto. Una corsa di test intermedia ha mostrato 3
falliti su 5, non un bug del fix ma uno snapshot letto a meta' di una riscrittura concorrente. Rimisurato piu'
volte, stato finale stabile e confermato per iscritto qui.

## Follow-up non risolti in questo task (fuori scope, flaggati)

1. `.env.testing` usa `CACHE_DRIVER=array` (chiave Laravel <11, ignorata da `config/cache.php` che legge
   `CACHE_STORE`, default `database`). Causa fallimento silenzioso di QUALSIASI test che tocchi permission-cache
   Spatie (tabella `cache` assente su `quaeris_data_test`), non solo questo. File dichiarato generato da
   `bashscripts/tools/sync-env-testing.sh` -> non editato a mano in questo task, utente non ha ancora risposto
   se vuole che venga sistemato.

   **RISOLTO 2026-09-21** (stessa giornata, follow-up separato): fix applicato in `phpunit.xml`
   (`<env name="CACHE_STORE" value="array" />` aggiunta, `.env.testing` NON toccato — evita il
   problema del file generato). `<env>` di phpunit.xml vince su `.env.testing` a boot time. Verificato
   `.env.sqlite` (cercato per primo da `app/Application.php::environmentFile()`) non esiste su disco
   in questo repo, quindi si cade sempre su `.env.testing`. Test rieseguiti senza override CLI:
   5 passed (9 assertions). Dettagli:
   `Modules/User/docs/stories/cache-store-env-var-test-infra-2026-09-21.story.md`.
2. `Modules/Lang/tests/Unit/Models/BaseModelTest.php` vs `Modules/Lang/tests/unit/models/BaseModelTest.php`
   (case-variant duplicate): rompe qualunque `--filter` che carichi l'intera suite configurata. Pre-esistente,
   non correlato a questo fix.
3. Permessi `oauth-access-token.*` non assegnati a nessun ruolo sull'ambiente 192.168.1.35:8000 (solo creati
   vuoti dal self-heal al primo accesso): accesso resta negato finche' un admin non li assegna esplicitamente
   a un ruolo. Decisione di business, non presa qui.
4. Le altre ~230 Policy del repo NON sono state convertite a `hasPermissionToOrCreate()` — solo
   `OauthAccessTokenPolicy` (quella del bug report). Ogni altra Policy che incontri lo stesso 500 va convertita
   caso per caso, di proposito (e' il compromesso scelto: blast radius contenuto invece di copertura totale
   automatica).

## File

- `Modules/User/app/Models/Traits/HasSpatiePermission.php` (modificato: `hasPermissionToOrCreate()` unico
  metodo aggiunto, nessun override di `hasPermissionTo()`)
- `Modules/User/app/Models/Policies/OauthAccessTokenPolicy.php` (modificato: 6 abilita' su
  `hasPermissionToOrCreate()`)
- `Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php` (nuovo, 5 test)
- `Modules/User/app/Models/Policies/UserPermissionBasePolicy.php` (rimosso, dead code ridondante)
- `Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php` (rimosso, reso orfano dal refactor
  verso la chiamata diretta inline)
