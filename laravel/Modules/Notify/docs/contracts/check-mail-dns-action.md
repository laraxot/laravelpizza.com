---
title: "CheckMailDnsAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\CheckMailDnsAction"
qmd: "CheckMailDnsAction DNS CNAME DMARC TXT dominio mail verifica record resolver"
---

# CheckMailDnsAction

Verifica i record DNS di un dominio di posta: CNAME attesi per etichetta e presenza del record DMARC.

## Input

- `string $domain`: dominio di zona.
- `array $expectedCnames`: mappa `etichetta => target` atteso.
- `?Closure $resolver`: risolutore `(name, type) => string[]`; default `dns_get_record`.

## Output

- `array` di risultati, uno per CNAME atteso piu' uno per DMARC. Ogni elemento: `record`, `expected`, `found`, `ok`, `hint`.

## Invarianti

- `NOTIFY-MAILDNS-INV-1`: un CNAME assente produce `hint = missing`; trovato senza il target produce `wrong-target`; trovato come `<target>.<zona>` (punto finale mancante: il DNS ha aggiunto la zona) produce `missing-trailing-dot`. Test: `tests/Unit/Actions/Mail/CheckMailDnsActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-MAILDNS-INV-2`: `ok` vale `true` solo se `hint` e' `null`. Stesso test.
- `NOTIFY-MAILDNS-INV-3`: il DMARC e' cercato in `_dmarc.<zona>` tra i TXT che iniziano per `v=dmarc1` (case-insensitive). Stesso test.
- `NOTIFY-MAILDNS-INV-4`: il confronto ignora maiuscole e il punto finale. Stesso test.

## Effetti collaterali

- Query DNS di sola lettura tramite `dns_get_record`, salvo resolver iniettato.

## Errori

- `NetworkException` (Safe) nel risolutore di sistema restituisce `[]`, quindi il record risulta mancante. Nessuna eccezione esce.

## Non fa

- Non verifica SPF/DKIM.
- Non cerca il record DMARC con il valore completo, solo il prefisso.
