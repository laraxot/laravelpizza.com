---
title: "Modelli Eloquent su file del tenant (Sushi)"
type: reference
module: Tenant
updated: 2026-11-25
qmd: "sushi SushiToJson SushiToJsons SushiToCsv SushiToPhpArray SushiConnectionByName BaseModelJson database/content json modello file tenant getRows"
---

# Modelli Eloquent su file del tenant

Pagine, sezioni, menu e altri contenuti del sito non stanno in tabelle: sono file versionati sotto
`config/<tenant>/database/content/<tabella>.json`. Il modulo li espone come modelli Eloquent in sola memoria con il pacchetto
Sushi: si interrogano con `Page::query()`, e il **file e' il dato**. La cartella e' del tenant, quindi ogni tenant ha i suoi
contenuti ([tenant-resolution](tenant-resolution.md)).

## I trait

| Trait / classe | Sorgente delle righe | Scrittura |
|---|---|---|
| `SushiToJson` (+ `BaseModelJson`, contratto `HasSushiToJson`) | `config/<tenant>/database/content/<tabella>.json`, via `GetTenantFilePathAction` | `creating`/`updating`/`deleting` riscrivono il file |
| `SushiToJsons` (+ `BaseModelJsons`) | variante con piu' file; deve fornire `getJsonFile()` | gli stessi hook |
| `SushiToCsv` | `config/<tenant>/<tabella>.csv` (intestazione alla riga 0, lettore `League\Csv`) | hook `creating`/`updating`/`deleting` |
| `SushiToPhpArray` | file PHP che ritorna un array | hook `creating`/`updating` |
| `SushiConnectionByName` | non legge file: registra con `DB::extend()` la connessione col nome della classe, cosi' Sushi usa la connessione risolta dal modello | -- |

Consumatori fuori dal modulo: i modelli del CMS (`Page`, `PageContent`, `Section`, `Menu`, `Attachment`), `Geo\Comune`,
`User\SocialProvider`, `Xot\InformationSchemaTable`. Nel modulo Tenant, `Domain` e `TenantDomain` usano Sushi con
`getRows()` che chiama `GetDomainsArrayAction` (vedi [admin-ui](admin-ui.md)).

## Come funziona `SushiToJson`

- **Lettura** (`getSushiRows()`): se il file manca, nessuna riga (non un errore); se il contenuto non e' un array JSON,
  eccezione con il percorso. Ogni valore array/oggetto viene serializzato a stringa JSON (Sushi non ha colonne annidate), le
  colonne dichiarate in `$schema` ma assenti in una riga valgono `null`, le chiavi sono ordinate.
- **Schema**: `$schema` (nome colonna => tipo, `string` di default) fa da contratto minimo delle colonne.
- **Scrittura**: gli hook leggono il file, aggiungono/aggiornano/togliono la riga per `id` e riscrivono tutto con
  `JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE`. In `creating` l'`id` e' `max(id nel file, id in memoria) + 1`; il record
  riceve `created_at`/`updated_at`.
- **Azioni equivalenti**: `Actions/Json/{Create,Update,Delete}JsonFileByRecordAction` fanno lo stesso lavoro come Action
  (calcolo del nuovo id con `SafeIntCastAction`, completamento delle chiavi con `EnsureKeysAction`, salvataggio con
  `SaveArrayAction`). Sono coperte da `JsonFileByRecordActionsTest`; i modelli passano dagli hook dei trait.

## Cosa NON e' garantito

- **Nessun lock sul file**: due richieste che scrivono insieme sullo stesso JSON fanno vincere l'ultima. I contenuti sono
  pensati per essere scritti da un'unica persona (pannello CMS), non da traffico concorrente.
- **Nessuna transazione**: `DB::transaction()` non copre il file. Il rollback di un test non annulla la scrittura (per questo
  esiste l'isolamento sotto, nei test).
- **`unlink` senza controllo**: `SushiToJsons::handleJsonDeleting()` chiama `Safe\unlink()` sul file senza verificare che
  esista; se il file e' sparito, cancellare il record lancia (TEN-P2-02, [audit-and-roadmap](audit-and-roadmap.md)).
- **`id` numerico**: la logica di calcolo dell'id presume interi; ids a stringa passano dall'Action Json (test dedicato).

## Contenuti versionati e test

Cambiare un modello Sushi in un test significherebbe modificare file versionati in git. Per questo, sotto Pest,
`GetTenantFilePathAction` reindirizza `database/content/*` su una copia in
`storage/framework/testing/tenant-content/<tenant>/`: [ADR 0002](adr/0002-tenant-json-content-isolated-in-tests.md) e
[testing](testing.md). Chi aggiunge un nuovo tipo di contenuto scrivibile *fuori* da `database/content/` deve estendere la
stessa regola, altrimenti i test scrivono nella cartella vera.

## Convenzioni per un nuovo modello su file

1. Estendere `BaseModelJson` (o usare `SushiToJson` e implementare `HasSushiToJson`); il nome della tabella decide il file.
2. Dichiarare `$schema` con tutte le colonne usate, per non avere righe con chiavi mancanti.
3. Aggiungere il JSON in `config/<tenant>/database/content/` e **versionarlo**: la cartella e' tracciata apposta
   ([story](bmad/stories/tenant-config-untracked-by-gitignore.story.md)).
4. Nessuna logica nel modello: la logica di dominio va in una Action ([conventions](conventions.md)).
5. Non esporre mai un campo con segreti: il file e' in chiaro nel repository.

## Debito noto

`SushiToJson` (405 righe) e `SushiToJsons` (264) sono due varianti dello stesso trait; `SushiToJsons` e' usato solo da
`BaseModelJsons`, che non ha sottoclassi nel repository (TEN-P2-01). Si unificano in un trait solo o si rimuove la variante
inutilizzata.
