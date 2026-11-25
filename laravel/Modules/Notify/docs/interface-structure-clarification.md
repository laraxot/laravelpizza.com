---
title: "interface structure clarification"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "interface structure clarification"
issues: []
discussions: []
---

# Chiarimento sulla Struttura delle Interfacce

## Struttura Corretta per le Interfacce SMS

, le interfacce per le azioni SMS seguono questa struttura:

```
Modules/Notify/app/Contracts/SMS/SmsActionContract.php
Modules/Notify/app/Contracts/SMS/SmsActionContract.php
Modules/Notify/app/Contracts/SMS/SmsActionContract.php
```

Con il namespace corrispondente:

```php
namespace Modules\Notify\Contracts\SMS;
```

## Implementazione nelle Classi

Tutte le classi di azione SMS devono implementare questa interfaccia:

```php
use Modules\Notify\Contracts\SMS\SmsActionContract;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...
}
```

## Nota sulla Discrepanza nella Documentazione

Si noti che esiste una discrepanza nella documentazione del progetto:

1. **path-and-interface-rules-2.md** indica che le interfacce dovrebbero essere nella directory principale `Contracts` e non in sottodirectory.
2. **sms-actions-2.md** indica che le interfacce SMS sono definite in `app/Contracts/SMS/`.

**La struttura corretta e funzionante è quella indicata in sms-actions-2.md**, con le interfacce SMS posizionate nella sottodirectory `Contracts/SMS/`.

## Convenzioni di Naming

Indipendentemente dalla posizione, tutte le interfacce  devono seguire queste convenzioni di naming:

1. Utilizzare il suffisso `Contract` e non `Interface`
2. Seguire il pattern PascalCase
3. Essere descrittive del loro scopo

## Verifica dell'Implementazione Corretta

Per verificare che una classe implementi correttamente l'interfaccia:

```php
// Nella Factory
if (!($instance instanceof SmsActionContract)) {
    throw new Exception("Class {$className} does not implement SmsActionContract.");
}
```
# Chiarimento sulla Struttura delle Interfacce

## Struttura Corretta per le Interfacce SMS

, le interfacce per le azioni SMS seguono questa struttura:

```
Modules/Notify/app/Contracts/SMS/SmsActionContract.php
```

Con il namespace corrispondente:

```php
namespace Modules\Notify\Contracts\SMS;
```

## Implementazione nelle Classi

Tutte le classi di azione SMS devono implementare questa interfaccia:

```php
use Modules\Notify\Contracts\SMS\SmsActionContract;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...
}
```

## Nota sulla Discrepanza nella Documentazione

Si noti che esiste una discrepanza nella documentazione del progetto:

1. **path-and-interface-rules-2.md** indica che le interfacce dovrebbero essere nella directory principale `Contracts` e non in sottodirectory.
2. **sms-actions-2.md** indica che le interfacce SMS sono definite in `app/Contracts/SMS/`.

**La struttura corretta e funzionante è quella indicata in sms-actions-2.md**, con le interfacce SMS posizionate nella sottodirectory `Contracts/SMS/`.

## Convenzioni di Naming

Indipendentemente dalla posizione, tutte le interfacce  devono seguire queste convenzioni di naming:

1. Utilizzare il suffisso `Contract` e non `Interface`
2. Seguire il pattern PascalCase
3. Essere descrittive del loro scopo

## Verifica dell'Implementazione Corretta

Per verificare che una classe implementi correttamente l'interfaccia:

```php
// Nella Factory
if (!($instance instanceof SmsActionContract)) {
    throw new Exception("Class {$className} does not implement SmsActionContract.");
}
```
