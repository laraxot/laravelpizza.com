---
title: "Tenant: connessioni di modulo come alias della default (transazioni atomiche fra moduli)"
type: story
status: review
priority: P0
created: 2026-11-05
updated: 2026-11-05
module: Tenant
depends_on: []
related: [roosko-audit]
owned_scope: [app/Providers/TenantServiceProvider.php, tests/Feature/ModuleConnectionAliasTest.php]
tags: [database, transaction, connection, multi-module]
qmd: "tenant connessioni modulo alias default transazione atomica DB::extend"
---

# Tenant: connessioni di modulo come alias della default

## Story

Come **applicazione modulare Laraxot** che scrive in una sola operazione su più moduli (es. Roosko: conferimento + magazzino + registro rifiuti)
voglio **che una transazione copra davvero tutte le scritture**
così da **non lasciare mai il registro scritto senza il conferimento, o il contrario**.

## Perché (evidenza)

- `mergeModuleConnections()` crea per ogni modulo una connessione con nome proprio copiando la default: in produzione sono N sessioni distinte sullo stesso database.
- `DB::connection('waste')->transaction()` dentro `DB::connection('roosko')->transaction()` non è un savepoint: sono due transazioni indipendenti, con commit in sequenza. Un errore durante un commit successivo lascia scritti i dati del primo.
- I test non lo vedono perché `XotBaseTestCase` fa puntare tutti i nomi alla stessa connessione.
- Rilievo R2 dell'audit Roosko (database).

## Acceptance criteria

1. Una connessione di modulo creata copiando la default si risolve sulla stessa istanza `Connection` della default.
2. Una connessione dichiarata esplicitamente nella config del tenant (es. `user` su un altro database) resta separata.
3. Un'unica sessione DB per richiesta invece di una per modulo.

## Dev agent record

- 2026-11-05 — Claude: `aliasModuleConnectionsToDefault()` registra `DB::extend($modulo, fn () => DB::connection($default))` per i soli moduli senza connessione esplicita. Test in `tests/Feature/ModuleConnectionAliasTest.php` (da eseguire con vendor).
- 2026-11-05 — swarm PHPStan (moduli piccoli): `ModuleConnectionAliasTest` dava `method.notFound` perche' `app()->getProvider(...)` e' tipizzato
  `?ServiceProvider` e `registerDB()` e' di `TenantServiceProvider`. Il `?->` era anche un difetto del test: se il provider non fosse registrato la
  chiamata sarebbe saltata in silenzio. Ora `Assert::assertInstanceOf(TenantServiceProvider::class, $provider)` poi `$provider->registerDB()`:
  asserzione sull'alias invariata, nessuna Reflection (`registerDB()` e' pubblico; `aliasModuleConnectionsToDefault()` resta privato, esercitato da `registerDB()`).
  Verifica: PHPStan 0 errori sul file; Pest `ModuleConnectionAliasTest` 2 passed (4 assertions).
- 2026-11-10 — Claude: l'alias ora vale solo finche' la config del modulo coincide con quella della default (a parte `name`). Prima un test che
  ridefiniva a runtime `database.connections.waste` su un file sqlite proprio (Waste `ConcurrentRegisterNumberingTest`) riceveva comunque la
  connessione default e falliva ("Registro #1 inesistente"). Confronto tipizzato (`instanceof Connection`, `is_array`). Test riscritto: config
  uguale → stessa istanza; config diversa → istanza separata. Verifica: PHPStan 0 sul provider; Pest alias 2 passed; Waste concorrenza 1 passed.
