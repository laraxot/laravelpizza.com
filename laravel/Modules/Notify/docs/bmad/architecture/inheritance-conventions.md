---
title: "Convenzioni di Ereditarietà"
type: concept
tags: [inheritance, conventions]
created: 2026-07-14
updated: 2026-07-14
qmd: "inheritance-conventions-1 convenzioni di ereditarietà"
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
status: superseded
superseded_by: ../../inheritance-conventions.md
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
