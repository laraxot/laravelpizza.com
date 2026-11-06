---
title: "netfun sms error log false positive.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "netfun sms error log false positive.story"
issues: []
discussions: []
name: netfun-sms-error-log-false-positive
description: SendNetfunSMSAction loggava ogni risposta Netfun a livello error() a prescindere dall'esito, segnalando come errore anche gli SMS partiti correttamente, e scriveva api_token in chiaro nel log
metadata:
  type: story
  status: done
  module: Notify
  created: 2026-09-22
  updated: 2026-09-22
  repository: "git@github.com:laraxot/module_notify_fila5.git"
  github_issue: "https://github.com/laraxot/module_notify_fila5/issues/76"
  github_discussion: "https://github.com/laraxot/base_quaeris_fila5/discussions/207"
---

# Story: log Netfun SMS a error() anche sugli invii riusciti

## Richiesta utente

L'utente ha trovato in produzione righe come:

```
[2026-09-21 08:48:06] local.ERROR: Netfun SMS response {"request":{"api_token":"62tS5DQipXdvfqm8kvaygxflCh....",...},"status_code":200,"status_txt":"{\"async\":true,\"error\":0,\"credit\":315848,\"sending_contacts_count\":1,\"sending_batch_id\":\"26263325060281687\"}"}
```

Il payload indica chiaramente successo (`status_code` 200, `"error":0`,
credito scalato, `sending_batch_id` presente), ma la riga è loggata a
livello `ERROR`. Chiesto il perché e, una volta confermato che non era
comportamento voluto, un fix minimo: log solo sui fallimenti reali,
nessuna riga per gli invii andati a buon fine, e token non in chiaro nel
log.

## Diagnosi

`Modules/Notify/app/Actions/SMS/SendNetfunSMSAction.php` (creato il
2026-07-20, mai toccato su questo punto da allora: non una
regressione, difetto di design presente fin dall'origine del file):
dopo aver ricevuto la risposta HTTP, il metodo `execute()` chiamava
incondizionatamente `Log::channel('daily')->error('Netfun SMS
response', [...])`, senza mai controllare `status_code` né decodificare
`status_txt`. Netfun risponde sempre con HTTP 200 su richiesta accettata
async: l'esito reale (successo/errore) è nel campo `error` del body
JSON, non nello status HTTP: quindi ogni invio riuscito finiva loggato
come errore, e i veri fallimenti HTTP (4xx) non passavano nemmeno da lì
(finiscono in un'`Exception` rilanciata dal blocco `catch
(ClientException)` sopra).

In più, il payload loggato includeva `'request' => $body`, con
`api_token` (il token Netfun) in chiaro: visibile anche nel log
incollato dall'utente (troncato lì solo per condividerlo in chat).

Verificato che non fosse un comportamento già discusso/voluto: nessuna
story, issue o discussion esistente (in `module_notify_fila5`,
`module_quaeris_fila5`, `base_quaeris_fila5`) parla del livello di log
sbagliato: solo di problemi di configurazione ormai risolti (token,
driver, sender) o del refactor delle factory SMS/Telegram/WhatsApp
(discussion [module_notify_fila5#50](https://github.com/laraxot/module_notify_fila5/discussions/50),
non pertinente a questo punto).

Il pattern corretto esisteva già nel modulo per altri provider (es.
`Send360dialogWhatsAppAction.php`: `debug()`/`info()` sul successo,
`warning()`/`error()` sul fallimento con body decodificato) -
`SendNetfunSMSAction` era l'eccezione.

## Fix applicato

In `execute()`:
- Nuovo metodo privato `isSuccessfulResponse(int $statusCode, string
  $statusTxt): bool`: successo solo se `status_code` è 2xx **e** il
  campo `error` del body JSON è `0`/assente (usa `Safe\json_decode`,
  cattura `JsonException` sul body malformato → trattato come
  fallimento).
- Il log (`Log::channel('daily')->error(...)`) parte **solo** se
  `isSuccessfulResponse()` è `false`: nessuna riga scritta sui successi
  (né a `debug()` né a `info()`: il progetto vieta `Log::debug()`
 : [[no-log-debug]]: e l'utente ha esplicitamente chiesto zero rumore
  sui successi, non solo di scendere a `info()`).
- Nel payload loggato, `api_token` è sostituito con `'***redacted***'`
  prima di finire nel log (`$redactedRequest`, copia di `$body` non
  usata per la chiamata HTTP reale: il token vero resta intatto in
  `$body`).

## Verifica

Il framework Pest non è risultato eseguibile in questa sessione (fallisce
identico anche su un file di test esistente e invariato: problema di
ambiente/DB di test, non di questa modifica). Verificato quindi in altro
modo:
- `php -l` pulito su entrambi i file toccati.
- `phpstan analyse` (livello `max`, config centrale del progetto) pulito
  su entrambi i file: inclusi i due giri di fix richiesti dal linter
  stesso (`Safe\json_decode`/`Safe\json_encode` al posto delle funzioni
  native, come da regola `thecodingmachine/safe` già in uso nel resto
  del modulo, es. `Send360dialogWhatsAppAction.php`).
- Logica di `isSuccessfulResponse()` verificata via reflection (PHP
  diretto, bypassando Pest) contro 4 casi: il payload reale di
  produzione (successo), un payload con `error` valorizzato, uno status
  HTTP 500, un body JSON malformato: tutti col risultato atteso.
- Aggiunti gli stessi 4 casi come test Pest in
  `tests/Unit/Actions/SMS/SendNetfunSMSActionTest.php` (il file esisteva
  già ma copriva solo il contratto pubblico via reflection, zero
  comportamento): da far girare in un ambiente dove Pest/DB
  funzionano, prima di considerare il fix definitivamente confermato
  dalla suite.
- Redazione del token verificata a mano (l'array originale usato per la
  richiesta HTTP non viene alterato, solo la copia loggata).

## Esito

2 file modificati in `module_notify_fila5`
(`app/Actions/SMS/SendNetfunSMSAction.php`,
`tests/Unit/Actions/SMS/SendNetfunSMSActionTest.php`), non ancora
committati al momento della creazione di questa story: commit su
richiesta esplicita dell'utente, come da [[feedback-confirm-before-implementing]].
