---
title: "CreateMailjetTransportAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\Mailjet\\CreateMailjetTransportAction"
qmd: "CreateMailjetTransportAction Mailjet transport Symfony mailer api smtp sandbox chiavi"
---

# CreateMailjetTransportAction

Crea un `TransportInterface` Symfony Mailer per Mailjet, via API o SMTP.

## Input

- `string $key`, `string $secret`: chiavi pubblica e privata Mailjet.
- `bool $sandbox = false`: attivo solo con schema `api`.
- `string $scheme = 'api'`: `api` oppure `smtp`.
- `?HttpClientInterface $client`: client HTTP iniettabile.

## Output

- `TransportInterface` (Symfony Mailer) per il DSN `mailjet+<scheme>`.

## Invarianti

- `NOTIFY-MJTRANS-INV-1`: chiave o segreto vuoti (dopo trim) lanciano `InvalidArgumentException`. Test: `tests/Unit/Actions/Mail/MailjetTransportTest.php` (dedicato, asserti non verificati).
- `NOTIFY-MJTRANS-INV-2`: lo schema diverso da `api`/`smtp` lancia `InvalidArgumentException`. Stesso test.
- `NOTIFY-MJTRANS-INV-3`: l'opzione `sandbox` viene passata solo con schema `api`, come stringa `true`/`false`. Stesso test.

## Effetti collaterali

- Nessuno. Non apre connessioni: la factory le apre quando si invia.

## Errori

- `InvalidArgumentException` per input non validi.

## Non fa

- Non invia e non verifica le credenziali presso Mailjet.
