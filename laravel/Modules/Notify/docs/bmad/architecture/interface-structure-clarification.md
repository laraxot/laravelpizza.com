---
title: "Chiarimento sulla Struttura delle Interfacce"
type: concept
tags: [interface, structure, clarification]
created: 2026-07-14
updated: 2026-07-14
qmd: "interface-structure-clarification-2 chiarimento sulla struttura delle interfacce"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Chiarimento sulla Struttura delle Interfacce 

## Struttura Corretta per le Interfacce SMS

, le interfacce per le azioni SMS seguono questa struttura:

```
/var/www/html/Quaeris/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
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

1. **PATH_AND_INTERFACE_RULES.md** indica che le interfacce dovrebbero essere nella directory principale `Contracts` e non in sottodirectory.
2. **SMS_ACTIONS.md** indica che le interfacce SMS sono definite in `app/Contracts/SMS/`.

**La struttura corretta e funzionante è quella indicata in SMS_ACTIONS.md**, con le interfacce SMS posizionate nella sottodirectory `Contracts/SMS/`.

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