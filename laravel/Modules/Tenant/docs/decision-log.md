---
type: decision-log
title: "Decision Log: Tenant"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-26
tags: [docs, tenant]
qmd: "decision log   tenant tenant"
---
# Decision Log: Tenant

## Decisions

### 2026-10-26: DCP-289, i dati dell'ente hanno una sola sorgente (`config('ente')`) e il front office nasconde il blocco che non ha il suo dato
- **Choose**: file `config/<tenant>/ente.php` con tutte le chiavi vuote, letto da `Modules\Tenant\Actions\Ente\GetEnteDataAction` che restituisce `Modules\Tenant\Datas\EnteData` normalizzato (telefono numerico, email e URL validi, social da lista chiusa). I blocchi del tema leggono solo quello; un dato vuoto nasconde il blocco. Nel JSON dei contenuti una voce dichiara `"ente": "toll_free"` e un'etichetta con `:value`.
- **Over**: i valori finti nei JSON e nei lang ("Demo", "05 0505", `tel:050505`, `comune.regione`); riusare `config/comune.php` (default finti che sembrano veri), `metatag.nome_*` (dato SEO) o `gdpr.config.dpo` (una voce di dodici, letta da nessuno); nascondere l'intera barra alta (porta lingua e accesso).
- **Because**: l'audit del 2026-10-26 (FO-1-02/03/04/23/27, FO-4-05/07/23/27, FO-6-02, FO-2-29) ha misurato segnaposto su tutte le pagine in 4 lingue. Un dato mancante deve sparire, non essere inventato; il proprietario e' Tenant per dominio (contesto del tenant) e per dipendenza (Tenant non dipende da Cms, Fixcity, Sixteen).
- **Verifica**: Pest Tenant 31 verdi, tema 7 + 7 + 50 verdi, pagina impostazioni 29 verdi; sweep su :8091 (21 pagine x 4 lingue): "Demo" 21 -> 0, nome regione finto 63 -> 0, `tel:050505` 6 -> 0, `href="#"` 20 -> 0, "Seguici su" vuoto 168 -> 0, landmark Secondaria vuoto 84 -> 0, h4 Contatti senza dati 84 -> 0. PHPStan a zero sui file toccati. Story: `stories/dcp-289-dati-dell-ente-unica-sorgente-e-blocchi-che-si-nascondono.story.md`.

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

