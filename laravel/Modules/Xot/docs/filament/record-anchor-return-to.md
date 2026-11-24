---
title: "RecordAnchor — ancora di riga e ritorno all'elenco"
type: reference
status: stable
created: 2026-11-24
updated: 2026-11-24
issues: []
qmd: "RecordAnchor return_to ancora riga elenco Filament open redirect previousWithinResource"
---

# RecordAnchor: tornare alla riga giusta dopo Crea / Modifica

`Modules\Xot\Filament\Links\RecordAnchor` serve a una cosa: dopo aver salvato dal dettaglio o dal "Nuovo", l'utente torna all'elenco **nella stessa pagina, con gli stessi filtri e sulla riga appena toccata**, invece che in cima alla lista.

## Come funziona

| Metodo | Cosa fa |
|--------|---------|
| `id($key)` / `fragment($key)` | Identificatore della riga: `record-<chiave>` e `#record-<chiave>`. |
| `appendTo($url, $key)` | Toglie il frammento esistente e mette quello della riga. |
| `currentUrl()` | URL dell'elenco da usare come `return_to`. In una richiesta Livewire (filtro, ordinamento, paginazione) `request()` e' l'endpoint di aggiornamento e non una pagina: si usa `Livewire::originalUrl()`. |
| `appendReturnTo($url, $returnTo, $key)` | Aggiunge `?return_to=...` (o `&return_to=`) all'URL del link verso il dettaglio. |
| `previousWithinResource($previousUrl, $resourceIndexUrl)` | La pagina precedente vale come ritorno **solo** se e' l'elenco o un dettaglio della stessa resource. Chi apre "Nuovo" da un altro pannello o dalla dashboard, dopo il salvataggio arriva alla resource: un'ancora `record-N` sulla dashboard non esiste. |
| `resolveReturnTo($returnTo, $key)` | Valida il `return_to` ricevuto e aggiunge l'ancora; `null` se non e' sicuro. |

`XotBaseCreateRecord` e `XotBaseEditRecord` usano `return_to` se presente, altrimenti `previousWithinResource($this->previousUrl, static::getResource()::getUrl('index'))`.

## Perche' la validazione e' severa (open redirect)

`return_to` arriva dalla query string. `resolveReturnTo()` lo accetta solo se:

- non contiene caratteri che il browser legge diversamente da `parse_url()` (`\` vale `/`; tab, a capo e spazi iniziali sono ignorati: `/\evil.example` e `/<TAB>/evil.example` non hanno host per PHP ma il browser li apre come `//evil.example`);
- e' della **stessa origine** (schema, host e porta della richiesta: confrontare solo l'host lascerebbe passare `https://host/` su un'app in http e `host:8080`); un percorso relativo vale se inizia con una sola `/`;
- l'eventuale frammento e' del tipo `record-...` con caratteri ammessi.

Non allentare questi controlli per comodita': e' la difesa di ogni redirect post-salvataggio delle resource Xot.

## Tipi

`$resourceIndexUrl` di `previousWithinResource()` resta `mixed`, ed e' un confine legittimo: i due chiamanti passano `static::getResource()::getUrl('index')`, e Filament dichiara `getResource(): string` con `@return class-string` **senza generico**, quindi per PHPStan `::getUrl()` e' `mixed` anche se a runtime e' una stringa. Il controllo `is_string` e' quello che lo restringe. Stringere il parametro a `string` fa fallire PHPStan sui due chiamanti (`argument.type`), e le uniche vie per tipizzare il valore (`assert`, `@var`, cast) sono vietate dalle regole del progetto. Tentato e annullato il 2026-11-24: l'audit `mixed` aveva classificato il caso come evitabile senza verificarlo con PHPStan. Si potra' stringere solo se i due chiamanti avranno un tipo reale per la resource (un generico su `getResource()`). `$previousUrl` e' `?string` perche' viene da `$this->previousUrl`, che puo' mancare.

## Test

`Modules/Xot/tests/Unit/RecordAnchorReturnUrlTest.php` copre le ancore, il confine della resource (`/firs` si', `/firs-archive` no, altro pannello no, `null` no) e i `return_to` ostili.
