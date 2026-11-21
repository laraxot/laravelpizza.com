---
title: "Convenzioni di Ereditarietà"
type: concept
tags: [notify, docs, best-practices, inheritance, conventions]
module: Notify
created: 2026-07-20
updated: 2026-07-20
qmd: "notify documentazione best practices inheritance conventions convenzioni di ereditarietà frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - ../README.md
  - ../architecture/README.md
  - ../conventions/README.md
  - ../rules/README.md
  - naming-conventions.md
---
# Convenzioni di Ereditarietà

## Regole Generali
1. **Evitare Duplicazioni**
   - Non implementare interfacce già implementate dalla classe base
   - Non usare trait già usati dalla classe base
   - Verificare sempre la gerarchia di ereditarietà

2. **Gerarchia delle Classi**
   - Le classi base devono fornire le implementazioni comuni
   - Le classi derivate devono solo estendere le funzionalità specifiche
   - Evitare override non necessari

## Esempi Corretti e Incorretti

### Implementazione Interfacce
```php
// ✅ Corretto
class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
}

class SendSmsPage extends XotBasePage
{
    // Non serve implementare HasForms o usare InteractsWithForms
}

// ❌ Incorretto
class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms; // Duplicazione non necessaria
}
```

### Uso dei Trait
```php
// ✅ Corretto
trait FormTrait
{
    use InteractsWithForms;
}

class BasePage
{
    use FormTrait;
}

class ChildPage extends BasePage
{
    // Non serve usare FormTrait
}

// ❌ Incorretto
class ChildPage extends BasePage
{
    use FormTrait; // Duplicazione non necessaria
}
```

## Motivazione
1. **DRY (Don't Repeat Yourself)**: Evitare duplicazioni di codice
2. **Manutenibilità**: Ridurre la complessità e i punti di errore
3. **Chiarezza**: Rendere il codice più facile da comprendere
4. **Performance**: Evitare overhead non necessario

## Implementazione
- Verificare sempre la gerarchia di ereditarietà
- Documentare le interfacce e i trait usati nelle classi base
- Usare strumenti di analisi statica
- Seguire le convenzioni del framework 
