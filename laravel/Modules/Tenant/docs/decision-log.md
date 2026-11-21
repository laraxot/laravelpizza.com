---
type: decision-log
title: "Decision Log — Tenant"
links: {github_issue: #XXX, discussion: #XXX}
---
# Decision Log — Tenant

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `90acbda`, piu' tre correzioni al trait SushiToJson
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `90acbda` (07/10 06:40), l'ultimo commit prima del merge `2edad8e` (07/10 11:17) che ha ripreso una copia del 04/09.
- **Over**: Lasciare il trait `SushiToJson` alla copia del 04/09, o ripristinarlo da solo come stamattina (fallito: i test erano rimasti alla copia vecchia).
- **Because**: Con Xot riallineato le rotte dei moduli sono tornate e la dashboard ha cominciato a caricare modelli `BaseModelJson`: `Declaration of BaseModelJson::getSchema() must be compatible with HasSushiToJson::getSchema(): array`. Il trait della copia vecchia non aveva `getSchema()` e restava quello di Sushi, senza tipo.
  - 44 file riportati a `90acbda` (verificati come gia' esistenti prima del 07/10, salvo i 5 trait Sushi toccati da `656a2b1` alle 13:03, cioe' la riga `use SushiConnectionByName;` della story 7.4, gia' presente in `90acbda`).
  - 4 file eliminati: `config/test.php` e la cartella `database/Factories` (F maiuscola), doppione di `database/factories`.
  - Lavoro di Marco dell'08/10 `ee5cffc` (migrazione `TenantService` → Actions, `docs/concepts/tenant-service-to-actions-migration.md`): mantenuto. Restano eliminati `TenantService`, `TenantAction`, `Services/Config/**`; nessun file della linea buona li usa. I 4 test che li riguardavano uniti a tre vie; in `TenantGapsCoverageTest` rimesso l'import di `Fixtures\TenantConfigValueResolverStub`, perso nel merge.
- **Contratto**: l'utente ha tolto `: array` da `HasSushiToJson::getSchema()`. Il contratto ora accetta sia il `getSchema()` di Sushi sia quello del trait.
- **Correzioni al trait** (i test di `90acbda` si aspettavano comportamenti che il trait di `90acbda` non aveva, e che la copia vecchia aveva):
  - `getSushiRows()` restituisce `[]` se il file JSON non esiste (prima falliva su `file_get_contents`: circa 120 test bloccati).
  - Dati non array: eccezione `Data is not array [<path>]` invece del messaggio generico di `Assert::isArray()`.
  - Valori annidati convertiti in stringa JSON: la tabella in-memory di Sushi non salva array.
  - Boot: le callback accettano `Model` e saltano i modelli che non implementano `HasSushiToJson`, come gia' diceva il commento (i modelli Sushi in sola lettura altrimenti fallivano con `TypeError`). `TestSushiModel`, modello scrivibile, ora implementa `HasSushiToJson`.
- **Verifica**: `php -l` pulito; `php artisan about` si avvia; le 11 classi Sushi di tutti i moduli si caricano; PHPStan su `Modules` senza errori in Tenant. Pest prima/dopo a blocchi, confronto JUnit: 0 peggiorati.

## Open Questions

