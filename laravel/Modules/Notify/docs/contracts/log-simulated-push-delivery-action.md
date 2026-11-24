---
title: "LogSimulatedPushDeliveryAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\LogSimulatedPushDeliveryAction"
qmd: "LogSimulatedPushDeliveryAction push simulato log APNs webpush target token troncato"
---

# LogSimulatedPushDeliveryAction

Registra nel log la consegna push simulata per le piattaforme senza transport reale (APNs, Web Push).

## Input

- `string $platform`: `apns` o `webpush`.
- `string $target`: token o topic (abbreviato a 12 caratteri).
- `array $payload`: payload che sarebbe stato consegnato.

## Output

- `void`.

## Invarianti

- `NOTIFY-PUSHSIM-INV-1`: ogni chiamata produce un `Log::notice` con `platform`, `target` troncato a 12 caratteri (`Str::limit`) e il payload completo. Test: nessuno dedicato verificato (solo menzioni in test di copertura).
- `NOTIFY-PUSHSIM-INV-2`: non c'e' nessuna chiamata di rete. Test: nessuno.

## Effetti collaterali

- Solo log `notice`. Il payload completo finisce nel log.

## Errori

- Nessuna eccezione.

## Non fa

- Non consegna nulla: il chiamante riceve successo anche se nessun push e' partito.
- Non maschera il payload (titolo, corpo, dati): per i dati personali valutare il livello di log.
