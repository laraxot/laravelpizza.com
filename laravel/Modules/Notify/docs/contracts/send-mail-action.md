---
title: "SendMailAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\SendMailAction"
qmd: "SendMailAction invio mail driver engine duocircle Send{Driver}MailAction WIP"
---

# SendMailAction

Dispatcher di invio email: risolve l'engine per driver (`Mail\Engines\{Driver}\Send{Driver}MailAction`) e lo esegue.

## Input

- `string $to`, `?string $body`, `array $vars`, `?string $from`, `string $driver = 'duocircle'`.

## Output

- `void`.

## Invarianti

- `NOTIFY-SENDMAIL-INV-1`: il driver e' normalizzato con `Str::studly`; se la classe engine non esiste lancia `Assert` (classe non trovata). Test: nessuno dedicato verificato.
- `NOTIFY-SENDMAIL-INV-2`: le chiavi stringa di `$vars` diventano proprieta' dell'Action (`$this->{$key}`) prima dell'invio. Test: nessuno.
- `NOTIFY-SENDMAIL-INV-3`: l'engine riceve `$this->vars` (non i parametri `to`/`body`). Test: nessuno.

## Effetti collaterali

- Delega all'engine. Con il driver di default (`duocircle`) l'engine lancia `RuntimeException('WIP')`: nessuna email parte.

## Errori

- `Assert` su classe engine mancante.
- `RuntimeException` se l'engine non ha `execute()`.
- Eccezioni dell'engine propagano.

## Rischi rilevati

- Mass assignment: una chiave di `$vars` come `driver`, `vars` o `to` sovrascrive la proprieta' interna. Il metodo non filtra le chiavi.

## Non fa

- Non invia direttamente. Non registra l'esito.
- Non e' un sostituto funzionante per `SendNotificationAction` finche' l'engine Duocircle e' WIP.
