---
qmd: "interface consolidated"
issues: []
discussions: []
title: "interface: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# interface: Consolidated Documentation

Consolidated from **13** individual files.

## Table of Contents

- [Deprecated](#interface-naming-convention-1)
- [---](#interface-naming-convention-2)
- [Convenzione di Naming per le Interfacce](#interface-naming-convention)
- [Chiarimento sulla Struttura delle Interfacce](#interface-structure-clarification-1)
- [---](#interface-structure-clarification-2)
- [Chiarimento sulla Struttura delle Interfacce](#interface-structure-clarification)
- [<<<<<<< HEAD](#interface_naming_convention)
- [Chiarimento sulla Struttura delle Interfacce ](#interface_structure_clarification)
- [Guida all'Implementazione delle Interfacce nel Modulo Notify](#interfaces-implementation-guide-1)
- [---](#interfaces-implementation-guide-2)
- [Guida all'Implementazione delle Interfacce nel Modulo Notify](#interfaces-implementation-guide)
- [Guida all'Implementazione delle Interfacce nel Modulo Notify](#interfaces-implementation)
- [Guida all'Implementazione delle Interfacce nel Modulo Notify](#interfaces_implementation_guide)

---

## interface-naming-convention-1

*Consolidated from: `interface-naming-convention.md`*
*Consolidated from: `interface-naming-convention-deprecated.md`*


This file is deprecated.

Use:

- [interface-naming-convention](./interface-naming-convention.md)
- [interface-naming-convention](../../interface-naming-convention.md)

---

## interface-naming-convention-2

*Consolidated from: `interface-naming-convention.md`*

title: "Convenzione di Naming per le Interfacce"
type: concept
tags: [interface, naming, convention]
created: 2026-07-14
updated: 2026-07-14
qmd: "interface-naming-convention-2 convenzione di naming per le interfacce"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Convenzione di Naming per le Interfacce 

## Regola Fondamentale

, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce (es. `Illuminate\Contracts\Auth\Authenticatable`).
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli .
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli App.
4. **Integrazione con tooling**: Gli strumenti di analisi statica e generazione di codice sono configurati per questa convenzione.

## Implementazione

Per garantire la conformità a questa convenzione:

1. Tutte le nuove interfacce devono essere create con il suffisso `Contract`.
2. Le interfacce esistenti con il suffisso `Interface` devono essere rinominate.
3. I riferimenti alle interfacce rinominate devono essere aggiornati in tutto il codice.

## Verifica

Per verificare la corretta implementazione:

```bash

# Cerca interfacce con naming errato
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/<nome repository>/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/<nome repository>/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/<nome repository>/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/<nome repository>/laravel/Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](/var/www/html/_bases/<nome repository>/laravel/docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/<nome repository>/laravel/Modules/Xot/app/Contracts/)
- [App Code Quality Guidelines](/var/www/_bases/<nome repository>/laravel/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [App Code Quality Guidelines](/var/www/_bases/<nome repository>/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/_bases/<nome repository>/laravel/Modules/Xot/app/Contracts/)
- [App Code Quality Guidelines](/var/www/html/_bases/<nome repository>/laravel/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [App Code Quality Guidelines](/var/www/html/_bases/<nome repository>/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/<nome repository>/laravel/Modules/Xot/app/Contracts/)
---

## interface-naming-convention

*Consolidated from: `interface-naming-convention.md`*


## Regola Fondamentale

, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce (es. `Illuminate\Contracts\Auth\Authenticatable`).
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli .
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
4. **Integrazione con tooling**: Gli strumenti di analisi statica e generazione di codice sono configurati per questa convenzione.

## Implementazione

Per garantire la conformità a questa convenzione:

1. Tutte le nuove interfacce devono essere create con il suffisso `Contract`.
2. Le interfacce esistenti con il suffisso `Interface` devono essere rinominate.
3. I riferimenti alle interfacce rinominate devono essere aggiornati in tutto il codice.

## Verifica

Per verificare la corretta implementazione:

```bash

# Cerca interfacce con naming errato
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](laravel/docs/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [PTVX Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
# Convenzione di Naming per le Interfacce

## Regola Fondamentale

, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce (es. `Illuminate\Contracts\Auth\Authenticatable`).
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli .
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
4. **Integrazione con tooling**: Gli strumenti di analisi statica e generazione di codice sono configurati per questa convenzione.

## Implementazione

Per garantire la conformità a questa convenzione:

1. Tutte le nuove interfacce devono essere create con il suffisso `Contract`.
2. Le interfacce esistenti con il suffisso `Interface` devono essere rinominate.
3. I riferimenti alle interfacce rinominate devono essere aggiornati in tutto il codice.

## Verifica

Per verificare la corretta implementazione:

```bash

# Cerca interfacce con naming errato
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

grep -r "interface.*Contract" --include="*.php" Modules

```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](laravel/docs/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [PTVX Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)

---

## interface-structure-clarification-1

*Consolidated from: `interface-structure-clarification.md`*


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

---

## interface-structure-clarification-2

*Consolidated from: `interface-structure-clarification.md`*

title: "Chiarimento sulla Struttura delle Interfacce"
type: concept
tags: [interface, structure, clarification]
created: 2026-07-14
updated: 2026-07-14
qmd: "interface-structure-clarification-2 chiarimento sulla struttura delle interfacce"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Chiarimento sulla Struttura delle Interfacce 

## Struttura Corretta per le Interfacce SMS

, le interfacce per le azioni SMS seguono questa struttura:

```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
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
---

## interface-structure-clarification

*Consolidated from: `interface-structure-clarification.md`*


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

---

## interface_naming_convention

*Consolidated from: `interface_naming_convention.md`*

# Convenzione di Naming per le Interfacce
## Regola Fondamentale

, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce (es. `Illuminate\Contracts\Auth\Authenticatable`).
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli .
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
4. **Integrazione con tooling**: Gli strumenti di analisi statica e generazione di codice sono configurati per questa convenzione.

## Implementazione

Per garantire la conformità a questa convenzione:

1. Tutte le nuove interfacce devono essere create con il suffisso `Contract`.
2. Le interfacce esistenti con il suffisso `Interface` devono essere rinominate.
3. I riferimenti alle interfacce rinominate devono essere aggiornati in tutto il codice.

## Verifica

Per verificare la corretta implementazione:

```bash

# Cerca interfacce con naming errato
grep -r "interface.*Interface" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules
grep -r "interface.*Interface" --include="*.php" [project-root]/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" [project-root]/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/_bases/<nome repository>/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/saluteora/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/saluteora/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](/var/www/html/_bases/base_ptvx_fila5/laravel/docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/base_ptvx_fila5/laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines]([project-root]/laravel/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines]([project-root]/laravel/project_docs/code-quality.md)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](../../ai-agents/code-quality.md)
- [Modulo Xot Contracts]([project-root]/laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](/var/www/_bases/<nome repository>/laravel/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](/var/www/_bases/<nome repository>/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/_bases/<nome repository>/laravel/Modules/Xot/app/Contracts/)
- [SaluteOra Code Quality Guidelines](/var/www/html/saluteora/laravel/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [SaluteOra Code Quality Guidelines](/var/www/html/saluteora/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/saluteora/laravel/Modules/Xot/app/Contracts/)
- [SaluteOra Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [SaluteOra Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Xot/app/Contracts/)

---

## interface_structure_clarification

*Consolidated from: `interface_structure_clarification.md`*


## Struttura Corretta per le Interfacce SMS

, le interfacce per le azioni SMS seguono questa struttura:

```
[project-root]/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
/var/www/html/saluteora/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
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

---

## interfaces-implementation-guide-1

*Consolidated from: `interfaces-implementation-guide.md`*


## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract

   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;

   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...

    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./INTERFACE_NAMING_CONVENTION.md)
- [Chiarimento sulla Struttura delle Interfacce](./INTERFACE_STRUCTURE_CLARIFICATION.md)
- [Architettura dei Contratti](./CONTRACTS_ARCHITECTURE.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)

---

## interfaces-implementation-guide-2

*Consolidated from: `interfaces-implementation-guide.md`*

title: "Guida all'Implementazione delle Interfacce nel Modulo Notify"
type: guide
tags: [interfaces, implementation, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "interfaces-implementation-guide-2 guida all'implementazione delle interfacce nel modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida all'Implementazione delle Interfacce nel Modulo Notify

## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract
   
   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;
   
   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...
    
    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./interface-naming-convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface-structure-clarification.md)
- [Architettura dei Contratti](./contracts-architecture.md)
- [Convenzioni di Naming per le Interfacce](./interface-naming-convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface-structure-clarification.md)
- [Architettura dei Contratti](./contracts-architecture.md)
- [Convenzioni di Naming per le Interfacce](../../interface-naming-convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface-structure-clarification.md)
- [Architettura dei Contratti](../../contracts-architecture.md)
- [Convenzioni di Naming per le Interfacce](../../interface-naming-convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface-structure-clarification.md)
- [Architettura dei Contratti](../../contracts-architecture.md)
---

## interfaces-implementation-guide

*Consolidated from: `interfaces-implementation-guide.md`*


## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract

   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;

   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...

    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./INTERFACE_NAMING_CONVENTION.md)
- [Chiarimento sulla Struttura delle Interfacce](./INTERFACE_STRUCTURE_CLARIFICATION.md)
- [Architettura dei Contratti](./CONTRACTS_ARCHITECTURE.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)
# Guida all'Implementazione delle Interfacce nel Modulo Notify

## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract

   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;

   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...

    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./INTERFACE_NAMING_CONVENTION.md)
- [Chiarimento sulla Struttura delle Interfacce](./INTERFACE_STRUCTURE_CLARIFICATION.md)
- [Architettura dei Contratti](./CONTRACTS_ARCHITECTURE.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)

---

## interfaces-implementation

*Consolidated from: `interfaces-implementation.md`*


## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract

   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;

   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...

    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface_structure_clarification.md)
- [Architettura dei Contratti](./contracts_architecture.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)
# Guida all'Implementazione delle Interfacce nel Modulo Notify

## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract

   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;

   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...

    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](./interface_structure_clarification.md)
- [Architettura dei Contratti](./contracts_architecture.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)

---

## interfaces_implementation_guide

*Consolidated from: `interfaces_implementation_guide.md`*


## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   [project-root]/laravel/Modules/Notify/app/Contracts/SmsActionContract.php
   /var/www/html/saluteora/laravel/Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   [project-root]/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   /var/www/html/saluteora/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract
   
   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;
   
   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...
    
    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./INTERFACE_NAMING_CONVENTION.md)
- [Chiarimento sulla Struttura delle Interfacce](./INTERFACE_STRUCTURE_CLARIFICATION.md)
- [Architettura dei Contratti](./CONTRACTS_ARCHITECTURE.md)
- [Convenzioni di Naming per le Interfacce](../../interface_naming_convention.md)
- [Chiarimento sulla Struttura delle Interfacce](../../interface_structure_clarification.md)
- [Architettura dei Contratti](../../contracts_architecture.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04