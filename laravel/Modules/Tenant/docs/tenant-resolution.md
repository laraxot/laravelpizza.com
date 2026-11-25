---
title: "Dal nome host alla cartella di config del tenant"
type: reference
module: Tenant
updated: 2026-11-25
qmd: "tenant name host dominio invertito config cartella GetTenantNameAction SERVER_NAME Host symlink pub_theme xra TrustHosts"
---

# Risoluzione del tenant

Il tenant **e' una cartella di `config/`**, non una riga di database. Decisione: [ADR 0003](adr/0003-tenant-name-from-reversed-host.md);
contratto completo con gli invarianti `TENANT-NAME-INV-1..5`: [get-tenant-name-action](contracts/get-tenant-name-action.md).

## Algoritmo (`app/Actions/GetTenantNameAction.php`)

1. **Host sorgente**, in quest'ordine:
   - `$_SERVER['SERVER_NAME']`, se non e' vuoto e non e' `127.0.0.1`, `::1`, `localhost`;
   - altrimenti l'header `Host` (`request()->getHost()`), ma **solo fuori dalla console** (artisan, queue e scheduler non
     hanno una richiesta). `php artisan serve` e i proxy inversi lasciano in `SERVER_NAME` l'indirizzo di bind: senza
     l'header ogni dominio ricadrebbe sul tenant di fallback e le pagine risponderebbero 404;
   - altrimenti l'host di `config('app.url')` (scheme, porta e path sono scartati con `parse_url`).
2. Si toglie `www.`, si spezza sui punti, ogni parte passa da `Str::slug`, l'ordine si **inverte**:
   `foo.example.com` diventa `com/example/foo`.
3. Si cerca la cartella `config/com/example/foo`. Se non esiste e le parti sono **piu' di due**, si riprova senza l'ultima
   parte della lista invertita, cioe' senza il sottodominio piu' a sinistra (`a.foo.test` prova `config/test/foo`).
4. Ripiego: la cartella ricavata allo stesso modo da `app.url`; ultimo ripiego la stringa `localhost`. Il risultato non e'
   mai vuoto.
5. **Symlink**: se la cartella e' un alias (es. `eu/sito` che punta a `local/sito`) il nome restituito e' il percorso
   *reale* sotto `config_path()` (`local/sito`), non l'alias, altrimenti Laravel non trova i file gia' caricati. Se il
   percorso reale non sta sotto `config/`, vale il nome logico.

Il nome e' il percorso con `/`; per le chiavi Laravel la `/` diventa `.` (`local/sito` -> `local.sito.<chiave>`,
`GetTenantConfigPathAction`).

## Cosa contiene una cartella tenant

`config/<tenant>/` riproduce la config base: un file PHP per gruppo (`app.php`, `database.php`, `auth.php`, `morph_map.php`,
`metatag.php`, `permission.php`, `xra.php`...), piu' `modules_statuses.json` ([module-registry](module-registry.md)),
`lang/<locale>/*.php` (traduzioni del tenant, `TranslateTenantKeyAction`) e `database/content/` con i contenuti JSON
(pagine, sezioni, menu: [sushi-json-models](sushi-json-models.md)). Le cartelle sono **versionate apposta**: toglierle dal
repository le cancella da ogni altro checkout e il tenant ripiega su `localhost` (altro database, niente morph map, niente
logo). Storia e test di guardia: [story tenant-config-untracked-by-gitignore](bmad/stories/tenant-config-untracked-by-gitignore.story.md),
`tests/Unit/TenantConfigTrackedTest.php`.

## Dal tenant al tema pubblico

`xra.php` del tenant e' il file che dice quali moduli e temi usa:

| Chiave | Significato |
|---|---|
| `main_module` | modulo principale del progetto |
| `adm_theme` | tema del backend, tra quelli in `laravel/Themes` |
| `pub_theme` | tema del frontend (cartella `laravel/Themes/<pub_theme>`) |
| `primary_lang` | lingua di default |

Catena: `app.url` -> `GetTenantNameAction` -> `config/<tenant>/` -> `GetTenantConfigArrayAction('xra')` (letta da
`XotData`) -> `pub_theme` -> `laravel/Themes/<pub_theme>`.

## Dove sta il rischio

- **L'host e' input del client.** `Host:` forgiato su un vhost catch-all seleziona la config (e la connessione) di un altro
  ente. Mitigazioni reali: ogni parte passa da `Str::slug` e la cartella deve esistere, altrimenti si va sul default. Nel
  codice dell'applicazione non risulta alcun `trustHosts()` (grep su `bootstrap/app.php` e `app/`, 2026-11-25): l'isolamento
  e' affidato al `server_name` esplicito del web server. Finding aperto TEN-P1-01: [audit-and-roadmap](audit-and-roadmap.md).
- **Nessuna query, nessuna facade**: il codice gira prima che il database e le facade siano pronti. Qualsiasi accesso al DB
  in questo punto e' un errore di ordine.
- **Un errore qui e' muto**: un metodo mancante in `GetTenantNameAction` ha gia' fatto fallire il bootstrap del tenant, con le
  pagine CMS non caricate e rotte `auth` ignorate (guest a 200 invece di 302). Dopo ogni modifica: `php artisan optimize:clear`
  e verifica che il tenant risolto sia quello atteso
  (`php artisan tinker --execute="echo app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();"`).

## Perche' una cartella e non una colonna

Il database non e' ancora configurato quando serve decidere *quale* database usare. La cartella e' leggibile con
`file_exists()`, si versiona, si confronta con un diff e si sposta con un symlink. Il costo: nessun isolamento a livello di
riga, e un tenant nuovo e' un deploy di file.
