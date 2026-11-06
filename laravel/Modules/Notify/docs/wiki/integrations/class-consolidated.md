---
qmd: "class consolidated"
issues: []
discussions: []
title: "class: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# class: Consolidated Documentation

Consolidated from **8** individual files.

## Table of Contents

- [Best Practices per l'Ereditarietà delle Classi](#class-inheritance-best-practices-1)
- [---](#class-inheritance-best-practices-2)
- [Best Practices per l'Ereditarietà delle Classi](#class-inheritance-best-practices)
- [Principi di Ereditarietà nelle Classi <nome progetto>](#class-inheritance-principles-1)
- [---](#class-inheritance-principles-2)
- [Principi di Ereditarietà nelle Classi](#class-inheritance-principles)
- [Best Practices per l'Ereditarietà delle Classi](#class_inheritance_best_practices)
- [Principi di Ereditarietà nelle Classi <nome progetto>](#class_inheritance_principles)

---

## class-inheritance-best-practices-1

*Consolidated from: `class-inheritance-best-practices.md`*


Questo documento definisce le best practices per l'ereditarietà delle classi nel sistema <nome progetto>, con particolare attenzione alle classi che estendono `XotBasePage`.

## Analisi dell'Ereditarietà di XotBasePage

`XotBasePage` è una classe base che estende `Filament\Pages\Page` e implementa già diverse interfacce e traits:

```php
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;

    // ...
}
```

## Regole Fondamentali

1. **Non Duplicare Interfacce e Traits**: Se una classe base già implementa un'interfaccia o utilizza un trait, non è necessario ridichiararli nelle classi derivate.

2. **Verifica delle Implementazioni Base**: Prima di aggiungere un'interfaccia o un trait a una classe, verificare se la classe base già li implementa.

3. **Evitare Ridondanze**: La duplicazione di interfacce e traits può causare confusione e potenziali conflitti.

## Esempi Corretti e Incorretti

### Esempio Corretto

```php
// ✅ Corretto - XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage
{
    // Implementazione...
}
```

### Esempio Errato

```php
// ❌ Errato - Ridondante, XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;

    // Implementazione...
}
```

## Motivazione

1. **Chiarezza del Codice**: Evitare ridondanze rende il codice più chiaro e facile da mantenere.
2. **Prevenzione di Errori**: Riduce il rischio di conflitti e comportamenti imprevisti.
3. **Efficienza**: Meno codice significa meno possibilità di errori e meno manutenzione.
4. **Principio DRY (Don't Repeat Yourself)**: Evitare la duplicazione del codice è un principio fondamentale della programmazione.

## Implementazione

### Verifica delle Classi Base

Prima di implementare una nuova classe, verificare quali interfacce e traits sono già implementati nelle classi base:

```php
// Verifica delle interfacce implementate
$interfaces = class_implements(XotBasePage::class);
// Verifica dei traits utilizzati
$traits = class_uses_recursive(XotBasePage::class);
```

### Correzione delle Classi Esistenti

Per le classi esistenti, rimuovere le interfacce e i traits ridondanti:

1. Rimuovere `implements HasForms` se la classe estende `XotBasePage`
2. Rimuovere `use InteractsWithForms;` se la classe estende `XotBasePage`

## Conclusione

Seguire queste best practices garantisce un codice più pulito, manutenibile e meno soggetto a errori. La comprensione dell'ereditarietà delle classi è fondamentale per lo sviluppo di un sistema robusto e scalabile.

---

## class-inheritance-best-practices-2

*Consolidated from: `class-inheritance-best-practices.md`*

title: "Best Practices per l'Ereditarietà delle Classi"
type: concept
tags: [class, inheritance, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "class-inheritance-best-practices-2 best practices per l'ereditarietà delle classi"
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

# Best Practices per l'Ereditarietà delle Classi

Questo documento definisce le best practices per l'ereditarietà delle classi nel sistema App, con particolare attenzione alle classi che estendono `XotBasePage`.

## Analisi dell'Ereditarietà di XotBasePage

`XotBasePage` è una classe base che estende `Filament\Pages\Page` e implementa già diverse interfacce e traits:

```php
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;
    
    // ...
}
```

## Regole Fondamentali

1. **Non Duplicare Interfacce e Traits**: Se una classe base già implementa un'interfaccia o utilizza un trait, non è necessario ridichiararli nelle classi derivate.

2. **Verifica delle Implementazioni Base**: Prima di aggiungere un'interfaccia o un trait a una classe, verificare se la classe base già li implementa.

3. **Evitare Ridondanze**: La duplicazione di interfacce e traits può causare confusione e potenziali conflitti.

## Esempi Corretti e Incorretti

### Esempio Corretto

```php
// ✅ Corretto - XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage
{
    // Implementazione...
}
```

### Esempio Errato

```php
// ❌ Errato - Ridondante, XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    
    // Implementazione...
}
```

## Motivazione

1. **Chiarezza del Codice**: Evitare ridondanze rende il codice più chiaro e facile da mantenere.
2. **Prevenzione di Errori**: Riduce il rischio di conflitti e comportamenti imprevisti.
3. **Efficienza**: Meno codice significa meno possibilità di errori e meno manutenzione.
4. **Principio DRY (Don't Repeat Yourself)**: Evitare la duplicazione del codice è un principio fondamentale della programmazione.

## Implementazione

### Verifica delle Classi Base

Prima di implementare una nuova classe, verificare quali interfacce e traits sono già implementati nelle classi base:

```php
// Verifica delle interfacce implementate
$interfaces = class_implements(XotBasePage::class);
// Verifica dei traits utilizzati
$traits = class_uses_recursive(XotBasePage::class);
```

### Correzione delle Classi Esistenti

Per le classi esistenti, rimuovere le interfacce e i traits ridondanti:

1. Rimuovere `implements HasForms` se la classe estende `XotBasePage`
2. Rimuovere `use InteractsWithForms;` se la classe estende `XotBasePage`

## Conclusione

Seguire queste best practices garantisce un codice più pulito, manutenibile e meno soggetto a errori. La comprensione dell'ereditarietà delle classi è fondamentale per lo sviluppo di un sistema robusto e scalabile.
---

## class-inheritance-best-practices

*Consolidated from: `class-inheritance-best-practices.md`*


Questo documento definisce le best practices per l'ereditarietà delle classi nel sistema , con particolare attenzione alle classi che estendono `XotBasePage`.
Questo documento definisce le best practices per l'ereditarietà delle classi nel sistema <nome progetto>, con particolare attenzione alle classi che estendono `XotBasePage`.

## Analisi dell'Ereditarietà di XotBasePage

`XotBasePage` è una classe base che estende `Filament\Pages\Page` e implementa già diverse interfacce e traits:

```php
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;
    
    // ...
}
```

## Regole Fondamentali

1. **Non Duplicare Interfacce e Traits**: Se una classe base già implementa un'interfaccia o utilizza un trait, non è necessario ridichiararli nelle classi derivate.

2. **Verifica delle Implementazioni Base**: Prima di aggiungere un'interfaccia o un trait a una classe, verificare se la classe base già li implementa.

3. **Evitare Ridondanze**: La duplicazione di interfacce e traits può causare confusione e potenziali conflitti.

## Esempi Corretti e Incorretti

### Esempio Corretto

```php
// ✅ Corretto - XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage
{
    // Implementazione...
}
```

### Esempio Errato

```php
// ❌ Errato - Ridondante, XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    
    // Implementazione...
}
```

## Motivazione

1. **Chiarezza del Codice**: Evitare ridondanze rende il codice più chiaro e facile da mantenere.
2. **Prevenzione di Errori**: Riduce il rischio di conflitti e comportamenti imprevisti.
3. **Efficienza**: Meno codice significa meno possibilità di errori e meno manutenzione.
4. **Principio DRY (Don't Repeat Yourself)**: Evitare la duplicazione del codice è un principio fondamentale della programmazione.

## Implementazione

### Verifica delle Classi Base

Prima di implementare una nuova classe, verificare quali interfacce e traits sono già implementati nelle classi base:

```php
// Verifica delle interfacce implementate
$interfaces = class_implements(XotBasePage::class);
// Verifica dei traits utilizzati
$traits = class_uses_recursive(XotBasePage::class);
```

### Correzione delle Classi Esistenti

Per le classi esistenti, rimuovere le interfacce e i traits ridondanti:

1. Rimuovere `implements HasForms` se la classe estende `XotBasePage`
2. Rimuovere `use InteractsWithForms;` se la classe estende `XotBasePage`

## Conclusione

Seguire queste best practices garantisce un codice più pulito, manutenibile e meno soggetto a errori. La comprensione dell'ereditarietà delle classi è fondamentale per lo sviluppo di un sistema robusto e scalabile.

---

## class-inheritance-principles-1

*Consolidated from: `class-inheritance-principles.md`*

# Principi di Ereditarietà nelle Classi <nome progetto>

## Regola Fondamentale: No Duplicate Declarations

Le classi che estendono altre classi  **NON devono ridichiarare** interfacce, trait o metodi già presenti nella classe genitore, a meno che non ne modifichino il comportamento.

## Esempi Corretti vs Errati

### ❌ Errato: Duplicazione di Interfacce/Trait

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - ERRATO
class SendSmsPage extends XotBasePage implements HasForms // ⚠️ Duplicato!
{
    use InteractsWithForms; // ⚠️ Duplicato!
    // ...
}
```

### ✅ Corretto: Nessuna Duplicazione

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - CORRETTO
class SendSmsPage extends XotBasePage
{
    // Non ridichiarare interfacce o trait già definiti nella classe base
    // ...
}
```

## Motivazioni

1. **Principio DRY (Don't Repeat Yourself)**:
   - Evita duplicazione del codice
   - Riduce il rischio di incoerenze quando la classe base cambia
   - Migliora la leggibilità
   - Facilita la manutenzione

2. **Chiarezza Contrattuale**:
   - Le implementazioni delle interfacce/trait sono gestite dalla classe base
   - Evita confusione sul "contratto" che la classe deve rispettare
   - Rende più chiara la gerarchia delle classi

3. **Ottimizzazione**:
   - Evita overhead di dichiarazioni ridondanti
   - Riduce la dimensione del codice
   - Semplifica l'analisi statica

## Eccezioni

L'unico caso in cui è accettabile ridichiarare un'interfaccia è quando:

1. Si sovrascrive il comportamento dell'interfaccia in modo significativo, modificando i metodi ereditati
2. È necessario esplicitare che la classe implementa un'interfaccia specifica per motivi di documentazione

## Verifica del Codice

Per identificare dichiarazioni duplicate, usare:

```bash

# Trova classi che estendono XotBasePage e implementano HasForms
grep -r --include="*.php" "extends XotBasePage implements HasForms" Modules/
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [PHP OOP Best Practices](https://phptherightway.com/#object-oriented-programming)

---

## class-inheritance-principles-2

*Consolidated from: `class-inheritance-principles.md`*

title: "Principi di Ereditarietà nelle Classi <nome progetto>"
type: concept
tags: [class, inheritance, principles]
created: 2026-07-14
updated: 2026-07-14
qmd: "class-inheritance-principles-2 principi di ereditarietà nelle classi <nome progetto>"
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

# Principi di Ereditarietà nelle Classi <nome progetto>
# Principi di Ereditarietà nelle Classi App

## Regola Fondamentale: No Duplicate Declarations

Le classi che estendono altre classi  **NON devono ridichiarare** interfacce, trait o metodi già presenti nella classe genitore, a meno che non ne modifichino il comportamento.

## Esempi Corretti vs Errati

### ❌ Errato: Duplicazione di Interfacce/Trait

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - ERRATO
class SendSmsPage extends XotBasePage implements HasForms // ⚠️ Duplicato!
{
    use InteractsWithForms; // ⚠️ Duplicato!
    // ...
}
```

### ✅ Corretto: Nessuna Duplicazione

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - CORRETTO
class SendSmsPage extends XotBasePage
{
    // Non ridichiarare interfacce o trait già definiti nella classe base
    // ...
}
```

## Motivazioni

1. **Principio DRY (Don't Repeat Yourself)**:
   - Evita duplicazione del codice
   - Riduce il rischio di incoerenze quando la classe base cambia
   - Migliora la leggibilità
   - Facilita la manutenzione

2. **Chiarezza Contrattuale**:
   - Le implementazioni delle interfacce/trait sono gestite dalla classe base
   - Evita confusione sul "contratto" che la classe deve rispettare
   - Rende più chiara la gerarchia delle classi

3. **Ottimizzazione**:
   - Evita overhead di dichiarazioni ridondanti
   - Riduce la dimensione del codice
   - Semplifica l'analisi statica

## Eccezioni

L'unico caso in cui è accettabile ridichiarare un'interfaccia è quando:

1. Si sovrascrive il comportamento dell'interfaccia in modo significativo, modificando i metodi ereditati
2. È necessario esplicitare che la classe implementa un'interfaccia specifica per motivi di documentazione

## Verifica del Codice

Per identificare dichiarazioni duplicate, usare:

```bash

# Trova classi che estendono XotBasePage e implementano HasForms
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/html/<nome progetto>/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/_bases/<nome repository>/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/html/_bases/<nome repository>/laravel/Modules/
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [PHP OOP Best Practices](https://phptherightway.com/#object-oriented-programming)
---

## class-inheritance-principles

*Consolidated from: `class-inheritance-principles.md`*

# Principi di Ereditarietà nelle Classi <nome progetto>

## Regola Fondamentale: No Duplicate Declarations

Le classi che estendono altre classi  **NON devono ridichiarare** interfacce, trait o metodi già presenti nella classe genitore, a meno che non ne modifichino il comportamento.

## Esempi Corretti vs Errati

### ❌ Errato: Duplicazione di Interfacce/Trait

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - ERRATO
class SendSmsPage extends XotBasePage implements HasForms // ⚠️ Duplicato!
{
    use InteractsWithForms; // ⚠️ Duplicato!
    // ...
}
```

### ✅ Corretto: Nessuna Duplicazione

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - CORRETTO
class SendSmsPage extends XotBasePage
{
    // Non ridichiarare interfacce o trait già definiti nella classe base
    // ...
}
```

## Motivazioni

1. **Principio DRY (Don't Repeat Yourself)**:
   - Evita duplicazione del codice
   - Riduce il rischio di incoerenze quando la classe base cambia
   - Migliora la leggibilità
   - Facilita la manutenzione

2. **Chiarezza Contrattuale**:
   - Le implementazioni delle interfacce/trait sono gestite dalla classe base
   - Evita confusione sul "contratto" che la classe deve rispettare
   - Rende più chiara la gerarchia delle classi

3. **Ottimizzazione**:
   - Evita overhead di dichiarazioni ridondanti
   - Riduce la dimensione del codice
   - Semplifica l'analisi statica

## Eccezioni

L'unico caso in cui è accettabile ridichiarare un'interfaccia è quando:

1. Si sovrascrive il comportamento dell'interfaccia in modo significativo, modificando i metodi ereditati
2. È necessario esplicitare che la classe implementa un'interfaccia specifica per motivi di documentazione

## Verifica del Codice

Per identificare dichiarazioni duplicate, usare:

```bash

# Trova classi che estendono XotBasePage e implementano HasForms
grep -r --include="*.php" "extends XotBasePage implements HasForms" Modules/
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [PHP OOP Best Practices](https://phptherightway.com/#object-oriented-programming)
# Principi di Ereditarietà nelle Classi <nome progetto>

## Regola Fondamentale: No Duplicate Declarations

Le classi che estendono altre classi  **NON devono ridichiarare** interfacce, trait o metodi già presenti nella classe genitore, a meno che non ne modifichino il comportamento.

## Esempi Corretti vs Errati

### ❌ Errato: Duplicazione di Interfacce/Trait

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - ERRATO
class SendSmsPage extends XotBasePage implements HasForms // ⚠️ Duplicato!
{
    use InteractsWithForms; // ⚠️ Duplicato!
}
```

### ✅ Corretto: Nessuna Duplicazione

{
}

// Classe figlia - CORRETTO
class SendSmsPage extends XotBasePage
{
    // Non ridichiarare interfacce o trait già definiti nella classe base
}

## Motivazioni

1. **Principio DRY (Don't Repeat Yourself)**:
   - Evita duplicazione del codice
   - Riduce il rischio di incoerenze quando la classe base cambia
   - Migliora la leggibilità
   - Facilita la manutenzione

2. **Chiarezza Contrattuale**:
   - Le implementazioni delle interfacce/trait sono gestite dalla classe base
   - Evita confusione sul "contratto" che la classe deve rispettare
   - Rende più chiara la gerarchia delle classi

3. **Ottimizzazione**:
   - Evita overhead di dichiarazioni ridondanti
   - Riduce la dimensione del codice
   - Semplifica l'analisi statica

## Eccezioni

L'unico caso in cui è accettabile ridichiarare un'interfaccia è quando:

1. Si sovrascrive il comportamento dell'interfaccia in modo significativo, modificando i metodi ereditati
2. È necessario esplicitare che la classe implementa un'interfaccia specifica per motivi di documentazione

## Verifica del Codice

Per identificare dichiarazioni duplicate, usare:

```bash

# Trova classi che estendono XotBasePage e implementano HasForms
grep -r --include="*.php" "extends XotBasePage implements HasForms" Modules/
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [PHP OOP Best Practices](https://phptherightway.com/#object-oriented-programming)

---

## class_inheritance_best_practices

*Consolidated from: `class_inheritance_best_practices.md`*


Questo documento definisce le best practices per l'ereditarietà delle classi nel sistema <nome progetto>, con particolare attenzione alle classi che estendono `XotBasePage`.

## Analisi dell'Ereditarietà di XotBasePage

`XotBasePage` è una classe base che estende `Filament\Pages\Page` e implementa già diverse interfacce e traits:

```php
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;
    // ...
}
```

## Regole Fondamentali

1. **Non Duplicare Interfacce e Traits**: Se una classe base già implementa un'interfaccia o utilizza un trait, non è necessario ridichiararli nelle classi derivate.

2. **Verifica delle Implementazioni Base**: Prima di aggiungere un'interfaccia o un trait a una classe, verificare se la classe base già li implementa.

3. **Evitare Ridondanze**: La duplicazione di interfacce e traits può causare confusione e potenziali conflitti.

## Esempi Corretti e Incorretti

### Esempio Corretto

```php
// ✅ Corretto - XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage
{
    // Implementazione...
}
```

### Esempio Errato

```php
// ❌ Errato - Ridondante, XotBasePage già implementa HasForms e usa InteractsWithForms
class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    // Implementazione...
}
```

## Motivazione

1. **Chiarezza del Codice**: Evitare ridondanze rende il codice più chiaro e facile da mantenere.
2. **Prevenzione di Errori**: Riduce il rischio di conflitti e comportamenti imprevisti.
3. **Efficienza**: Meno codice significa meno possibilità di errori e meno manutenzione.
4. **Principio DRY (Don't Repeat Yourself)**: Evitare la duplicazione del codice è un principio fondamentale della programmazione.

## Implementazione

### Verifica delle Classi Base

Prima di implementare una nuova classe, verificare quali interfacce e traits sono già implementati nelle classi base:

```php
// Verifica delle interfacce implementate
$interfaces = class_implements(XotBasePage::class);
// Verifica dei traits utilizzati
$traits = class_uses_recursive(XotBasePage::class);
```

### Correzione delle Classi Esistenti

Per le classi esistenti, rimuovere le interfacce e i traits ridondanti:

1. Rimuovere `implements HasForms` se la classe estende `XotBasePage`
2. Rimuovere `use InteractsWithForms;` se la classe estende `XotBasePage`

## Conclusione

Seguire queste best practices garantisce un codice più pulito, manutenibile e meno soggetto a errori. La comprensione dell'ereditarietà delle classi è fondamentale per lo sviluppo di un sistema robusto e scalabile.

---

## class_inheritance_principles

*Consolidated from: `class_inheritance_principles.md`*

# Principi di Ereditarietà nelle Classi <nome progetto>

## Regola Fondamentale: No Duplicate Declarations

Le classi che estendono altre classi  **NON devono ridichiarare** interfacce, trait o metodi già presenti nella classe genitore, a meno che non ne modifichino il comportamento.

## Esempi Corretti vs Errati

### ❌ Errato: Duplicazione di Interfacce/Trait

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - ERRATO
class SendSmsPage extends XotBasePage implements HasForms // ⚠️ Duplicato!
{
    use InteractsWithForms; // ⚠️ Duplicato!
    // ...
}
```

### ✅ Corretto: Nessuna Duplicazione

```php
// Classe base
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    // ...
}

// Classe figlia - CORRETTO
class SendSmsPage extends XotBasePage
{
    // Non ridichiarare interfacce o trait già definiti nella classe base
    // ...
}
```

## Motivazioni

1. **Principio DRY (Don't Repeat Yourself)**:
   - Evita duplicazione del codice
   - Riduce il rischio di incoerenze quando la classe base cambia
   - Migliora la leggibilità
   - Facilita la manutenzione

2. **Chiarezza Contrattuale**:
   - Le implementazioni delle interfacce/trait sono gestite dalla classe base
   - Evita confusione sul "contratto" che la classe deve rispettare
   - Rende più chiara la gerarchia delle classi

3. **Ottimizzazione**:
   - Evita overhead di dichiarazioni ridondanti
   - Riduce la dimensione del codice
   - Semplifica l'analisi statica

## Eccezioni

L'unico caso in cui è accettabile ridichiarare un'interfaccia è quando:

1. Si sovrascrive il comportamento dell'interfaccia in modo significativo, modificando i metodi ereditati
2. È necessario esplicitare che la classe implementa un'interfaccia specifica per motivi di documentazione

## Verifica del Codice

Per identificare dichiarazioni duplicate, usare:

```bash

# Trova classi che estendono XotBasePage e implementano HasForms
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/html/<nome progetto>/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" [project-root]/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/_bases/<nome repository>/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/html/saluteora/laravel/Modules/
grep -r --include="*.php" "extends XotBasePage implements HasForms" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/
```

## Riferimenti

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [PHP OOP Best Practices](https://phptherightway.com/#object-oriented-programming)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
