---
title: "SendPushWithTargetingAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushWithTargetingAction"
qmd: "SendPushWithTargetingAction push criteri targeting piattaforma stub device token store"
---

# SendPushWithTargetingAction

Invia una push ai token che soddisfano dei criteri. Il recupero dei token per criterio e' uno stub.

## Input

- `PushCriteriaData $criteria`, `PushNotificationData $notification`, `array $data`.

## Output

- Senza token: `['success' => false, 'message' => 'No tokens found matching criteria']`.
- Altrimenti: la mappa di `SendPushToDevicesAction`.

## Invarianti

- `NOTIFY-PUSHTGT-INV-1`: una piattaforma nei criteri fuori da `fcm`, `apns`, `webpush` viene loggata come warning e produce nessun token. Test: `tests/Unit/NotifyRemainingCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHTGT-INV-2`: in tutti gli altri casi `getTokensByCriteria` restituisce `[]` e logga `notice` (nessuno store dei device token collegato). Test: nessuno dedicato verificato.

## Effetti collaterali

- Solo log. Nessuna push parte.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non interroga alcuno store: finche' lo store non esiste, il targeting non puo' inviare nulla. Il messaggio di esito non distingue criterio errato da store assente.
