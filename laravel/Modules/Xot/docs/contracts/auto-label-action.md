---
title: "AutoLabelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\AutoLabelAction"
qmd: "AutoLabelAction etichetta automatica componenti Filament traduzione label debug_backtrace SaveTransAction WIP"
---

# AutoLabelAction

Applica a un componente Filament la label letta dalle traduzioni del modulo. Marcata WIP.

Codice: `app/Actions/Filament/AutoLabelAction.php:21-115`.

## Input

- `Field|Component $component`: la firma accetta anche `Component`, ma il codice richiede `Field` (riga 33).

## Output

`Field|Component`: stesso componente, eventualmente con label applicata.

## Invarianti

- `FIL-AUTOLABEL-INV-1`: un `Component` che non è `Field` lancia eccezione da `Assert::isInstanceOf` (riga 33), anche se la firma lo dichiara accettato. Test: nessuno; tests/Arch/debt.php cita la classe come debito.
- `FIL-AUTOLABEL-INV-2`: se esiste la traduzione `{trans}.fields.{nome}.label`, applica `->label()` con quel testo (righe 64-68, 90). Test: Nessun test dedicato.
- `FIL-AUTOLABEL-INV-3`: se la traduzione manca, non applica label e non salva nulla: il ramo con `SaveTransAction` (righe 82-85) è irraggiungibile perché la condizione interna (riga 69) contraddice quella esterna (riga 68). Test: Nessun test dedicato.

## Effetti collaterali

Nessun salvataggio di traduzioni (il ramo che salverebbe è morto). Lettura di `debug_backtrace` (riga 34) per ricavare la classe chiamante.

## Errori

`Assert` per tipo del componente e per chiavi vuote.

## Non fa

- BUG: il ramo di salvataggio non può essere eseguito. Da correggere separatamente, senza modificare questo contract.
- La classe chiamante è ricavata da `debug_backtrace` alla posizione 5: fragile rispetto alla profondità dello stack.
