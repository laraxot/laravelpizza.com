---
status: accepted
date: 2025-09-22
decision-makers: team back office
---

# Le operazioni di business nuove si scrivono come Actions, non come Services

## Context and Problem Statement

La logica dei rimborsi vive in `RefundService`, un Service nato per un solo caso (il rimborso totale) che controlla l'autorizzazione al suo interno con `isStaff()`, non usa transazioni e scrive un log invece dell'audit. Chi aggiunge un'operazione accanto a quella esistente tende a copiarne la forma, difetti compresi. Che forma diamo alle operazioni di business nuove, sapendo che il Service resta in produzione?

## Decision Drivers

- Un'operazione = un file: un Behavioral Contract e i suoi test hanno un solo bersaglio, citato con `@contract`.
- Autorizzazione in `OrderPolicy`, visibile nel controller che avvia l'operazione, non sparsa nei Service.
- Transazione e audit nello stesso punto dell'operazione, così si vedono in revisione.
- Nessuna riscrittura forzata del legacy: il rimborso totale funziona e ha clienti.

## Considered Options

- Actions in `app/Actions/<Dominio>/`: una classe finale, un metodo `handle()`, transazione e `RecordAuditEntry` dentro.
- Estendere i Services esistenti con un metodo per ogni operazione nuova (`RefundService::refundPartially()`).
- Logica nei controller.

## Decision Outcome

Scelta: **Actions**, perché è l'unica opzione in cui contract, test e docblock `@contract` puntano a un file solo, e in cui la forma dell'operazione (Policy, transazione, audit) non dipende da quella del codice vicino. È la forma di `PlaceOrder` e `CancelOrder`.

### Consequences

- Buono, perché ogni operazione nuova ha il suo contract e i suoi test si lanciano per group (`--group=<ID>`).
- Buono, perché un'eccezione del legacy (l'autorizzazione con `isStaff()`) non si propaga al codice nuovo.
- Cattivo, perché per un periodo convivono due stili: chi legge `app/` vede entrambi e deve sapere quale vale. Per questo `RefundService` è elencato in AGENTS.md → Conflicts (C1).
- Cattivo, perché il rimborso totale e quello parziale avranno due implementazioni finché un Task Contract non mette in scope la migrazione del Service.

### Confirmation

- In revisione: una classe nuova sotto `app/Services/`, o un metodo pubblico nuovo in `RefundService`, si respinge con un rimando a questo ADR.
- Ogni Action nuova ha `@contract` nel docblock e il suo contract è in `docs/contracts/index.md`.
