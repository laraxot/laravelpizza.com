---
title: "SendGammuSMSAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendGammuSMSAction"
qmd: "SendGammuSMSAction Gammu modem SMS processo locale file temporaneo sendsms"
---

# SendGammuSMSAction

Invio SMS tramite un modem/gateway locale Gammu, lanciato come processo di sistema.

## Input

- `SmsData $smsData`: `recipient`, `body`.
- Config `sms` (via `GammuData`): path binario, file di configurazione, timeout.

## Output

- `array`: `status_code` (exit code) e `status_txt` (stdout), restituiti da `$this->vars`.

## Invarianti

- `NOTIFY-GAMMU-INV-1`: costruzione senza path o config lancia `Exception`. Test: `tests/Unit/Actions/SMS/SendGammuSMSActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-GAMMU-INV-2`: il numero viene portato a forma `+...`: `00` diventa `+`, senza `+` riceve `+39`. Stesso test.
- `NOTIFY-GAMMU-INV-3`: il testo passa da un file temporaneo, che viene rimosso. Stesso test.

## Effetti collaterali

- Crea un file temporaneo in `sys_get_temp_dir()` e lo cancella.
- Esegue il processo `gammu` con argomenti (`sendsms TEXT <numero> -text <file>`).

## Errori

- `Exception` con `Gammu error` e stderr se il processo fallisce, riscritta con marker di riga e classe.

## Bug rilevato (da correggere, non corretto qui)

- Il file temporaneo viene cancellato alla riga 96 e di nuovo nel `catch` (riga 108). Quando Gammu fallisce, la seconda `unlink` (Safe) lancia su file gia' rimosso e sostituisce l'errore di Gammu con un errore di filesystem. Verificare con un test.

## Non fa

- Non verifica l'invio reale: il successo e' solo exit code 0.
