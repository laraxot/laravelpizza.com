---
title: "Configurazione per tenant: overlay, lettura, scrittura"
type: reference
module: Tenant
updated: 2026-11-25
qmd: "tenant config overlay array_replace_recursive GetTenantConfigValueAction ResolveTenantConfigValueAction SaveTenantConfigAction runningInConsole mergeConfigs morph_map traduzioni lang"
---

# Configurazione per tenant

Dato il nome del tenant ([tenant-resolution](tenant-resolution.md)), la config base di Laravel viene **sovrapposta** a quella
della cartella `config/<tenant>/`. Tutto il codice sta in `app/Actions/Config/`, piu' `Translations/` e `Markdown/`.

## Le Action

| Action | Cosa fa |
|---|---|
| `GetTenantFilePathAction` | percorso assoluto di un file sotto `config/<tenant>/`; rifiuta percorsi assoluti, NUL e segmenti `..` (`TENANT-PATH-INV-1..3`) |
| `GetTenantConfigPathAction` | prefisso Laravel di una chiave: `local/sito` + `app` -> `local.sito.app` |
| `GetTenantConfigNamesAction` | elenco dei `*.php` della cartella tenant (`id`, `name`) |
| `GetTenantConfigArrayAction` | `require` di `config/<tenant>/<nome>.php`; array vuoto se il file manca o non e' leggibile; chiavi forzate a stringa |
| `GetTenantConfigValueAction` | **overlay** e lettura di una chiave (vedi sotto) |
| `SaveTenantConfigAction` | scrive un gruppo nella cartella tenant (vedi sotto) |
| `FilterConfigStringKeysAction`, `MergeRecursiveStringKeyConfigAction` | utilita' per tenere array di config con sole chiavi stringa (richiesto da PHPStan livello 10) |
| `TranslateTenantKeyAction` | traduzione da `config/<tenant>/lang/<locale>/<file>.php`; se file o chiave mancano restituisce la chiave stessa |
| `GetLocalizedMarkdownPathAction` | percorso di un `.md` del tenant, prima in `lang/<locale>/`, poi nella radice; `#` se non esiste |

Contratti scritti: [contracts/index](contracts/index.md).

## Overlay (`GetTenantConfigValueAction::execute($key, $default)`)

1. `group` = primo segmento della chiave (`metatag.title` -> `metatag`); chiave vuota = eccezione.
2. `originalConf = config($group)`; `extraConf = config('<tenant con . al posto di />.<group>')`, cioe' il file che Laravel ha
   caricato dalla sottocartella (`config/local/sito/metatag.php` -> `local.sito.metatag`).
3. `array_replace_recursive(originalConf, extraConf)` e **`Config::set($group, merge)`**: l'effetto collaterale e' che dopo la
   prima lettura il gruppo e' gia' sovrapposto per il resto della richiesta.
4. Restituisce `config($key, $default)`; accetta solo numeri, stringhe, array e `null`, altrimenti eccezione.

`array_replace_recursive` sostituisce per chiave: le liste numeriche del tenant **rimpiazzano** elemento per indice, non si
accodano. Chi vuole azzerare una lista base deve riscriverla intera nel file tenant.

All'avvio `TenantServiceProvider::mergeConfigs()` chiama l'Action per **ogni** file della cartella tenant, cosi' ogni gruppo e'
sovrapposto prima che i moduli lo leggano. `registerMorphMap()` legge `morph_map` con lo stesso meccanismo, scarta alias o
classi che non esistono e **forza sempre** l'alias `user` sulla classe utente di `XotData`.

### Due nomi per la stessa classe

Lo stesso corpo vive oggi in due classi: `GetTenantConfigValueAction` (nome corrente, usato da una dozzina di file PHP) e
`ResolveTenantConfigValueAction` (nome precedente, ancora usato da Notify e Cms). Il refactoring dei nomi `Resolve*` -> `Get*`
e' stato fatto in blocco da uno script di sync e puo' lasciare coppie. Il contratto resta
[contracts/resolve-tenant-config-value-action](contracts/resolve-tenant-config-value-action.md) per entrambe; chi aggiunge un
caller usa `Get*`, e il giorno in cui Notify e Cms migrano si elimina `Resolve*`.

### Perche' non c'e' piu' il ramo `runningInConsole()`

Esisteva un blocco che in console restituiva la config globale senza overlay. E' stato rimosso (non solo commentato) perche':
comandi artisan e job in coda *sono* tenant-aware (percorsi di contenuto, connessioni, morph map); `GetTenantNameAction` sa
gia' funzionare in console (usa `app.url` e infine `localhost`); i test tenant-aware fallivano senza overlay; e meno rami
significa un comportamento solo da capire. Costo accettato: il merge costa anche in console. Se un comando deve essere
davvero globale, legge `config()` senza passare dall'Action.

## Scrittura (`SaveTenantConfigAction::execute($nome, $data)`)

- file di destinazione: `config/<tenant>/<nome>.php` via `GetTenantFilePathAction`;
- se esiste, lo legge e fa un **merge ricorsivo distinto**: i sotto-array associativi si fondono, tutto il resto (liste,
  scalari) viene **sostituito** dal nuovo valore;
- ordina ricorsivamente le chiavi (`Arr::sortRecursive`) e scrive con `SaveArrayAction` del modulo Xot (file PHP che ritorna un array);
- e' l'**unico** punto di scrittura: nessun altro codice deve scrivere in `config/<tenant>/`. Effetto: ogni salvataggio da
  pannello riordina le chiavi del file e quindi produce diff piu' larghi della modifica.

Isolamento nei test: `GetTenantFilePathAction` reindirizza **solo** i percorsi che iniziano con `database/content/`
(contenuti JSON dei modelli Sushi) su una copia sotto `storage/framework/testing/tenant-content/<tenant>/`, ricreata una volta
per processo ([ADR 0002](adr/0002-tenant-json-content-isolated-in-tests.md), [testing](testing.md)). I file di config
(`xra.php`, `metatag.php`...) **non** sono reindirizzati: un test che chiama `SaveTenantConfigAction` scrive nella cartella
tenant vera.

## Cosa NON fa

- Non c'e' cache dell'overlay oltre a `Config::set` sulla richiesta: l'overlay si rifa a ogni avvio.
- Non valida il contenuto dei file: un `config/<tenant>/x.php` che lancia o non ritorna un array viene letto come `[]`
  da `GetTenantConfigArrayAction`.
- Non crea la cartella del tenant: la cartella e' un deploy ([tenant-resolution](tenant-resolution.md)).
