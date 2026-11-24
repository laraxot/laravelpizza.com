---
title: "RememberLoginReturnUrlAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\RememberLoginReturnUrlAction"
qmd: "RememberLoginReturnUrlAction redirect login url.intended referer stesso host open redirect pagine auth"
---

# RememberLoginReturnUrlAction

Ricorda la pagina che ha mandato l'utente al login, così che `redirectIntended()` lo riporti indietro. Codice: `app/Actions/Auth/RememberLoginReturnUrlAction.php:22-79`.

## Input

- `Request $request`: query `redirect` e header `Referer` (`execute`, riga 26).

## Output

- `void`. Effetto: eventuale scrittura di `url.intended` in sessione.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `REMEMBER-RET-INV-1` | Sono accettati solo URL http/https sullo stesso host della richiesta; `//`, backslash, caratteri di controllo e altri schemi sono rifiutati. | righe 46-78 | `tests/Feature/Auth/AuthFlowRedirectsTest.php` (riferimento alla classe) |
| `REMEMBER-RET-INV-2` | Percorsi che contengono un segmento `auth` non sono mai memorizzati (non si torna al login). | righe 72-74 | come sopra |
| `REMEMBER-RET-INV-3` | Il parametro `redirect` esplicito prevale e sovrascrive `url.intended` già presente. | righe 29-34 | come sopra |
| `REMEMBER-RET-INV-4` | Senza `redirect` valido, un `url.intended` già presente non viene sovrascritto dal Referer. | righe 36-38 | come sopra |

## Effetti collaterali

Solo scrittura di sessione (`url.intended`). Nessun redirect, nessun database.

## Errori

- Errori di `parse_url` (`UrlException`) sono catturati e trattati come candidato non valido.

## Non fa

- Non esegue il redirect: lo fa `redirectIntended()` del chiamante.
