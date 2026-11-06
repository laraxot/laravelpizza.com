---
title: "Convenzioni di Naming per i Contracts"
type: concept
tags: [provider, contracts, naming]
created: 2026-07-14
updated: 2026-07-14
qmd: "provider-contracts-naming-2 convenzioni di naming per i contracts"
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

# Convenzioni di Naming per i Contracts 

## Regola Fondamentale

Nel sistema Quaeris, tutte le interfacce (interfaces) devono seguire queste convenzioni di naming:

1. **Suffisso `Contract` e non `Interface`**:
   - ✅ CORRETTO: `SmsProviderContract`
   - ❌ ERRATO: `SmsProviderInterface` o `SmsActionInterface`

2. **Naming Semantico**:
   - Il nome deve descrivere il ruolo/responsabilità dell'interfaccia
   - Utilizzare nomi precisi che denotano comportamenti (es. `CanSendSms`, `ProcessesSms`)
   - Evitare nomi generici come `SmsInterface`

3. **Collocazione delle Interfacce**:
   - Tutte le interfacce devono essere posizionate nella directory principale `app/Contracts/`
   - ✅ CORRETTO: `Modules\Notify\Contracts\SmsProviderContract`
   - ❌ ERRATO: `Modules\Notify\Contracts\SMS\SmsActionInterface`

4. **NO a Subdirectory per Tipologia**:
   - Non creare subdirectory come `Contracts/SMS/` o `Contracts/Email/`
   - Mantenere tutte le interfacce nello stesso livello in `Contracts/`

## Motivazione

1. **Coerenza con le Convenzioni Laravel**:
   - Laravel utilizza il suffisso `Contract` per le sue interfacce
   - Esempio: `Illuminate\Contracts\Mail\Mailer`

2. **Chiarezza Semantica**:
   - `Contract` comunica un'accordo/contratto tra componenti
   - `Interface` è un termine più tecnico che descrive l'implementazione

3. **Evitare Conflitti di Namespace**:
   - Subdirectory come `SMS` possono creare conflitti con altri namespace
   - Struttura piatta facilita l'importazione e la localizzazione delle interfacce

## Esempio di Interfaccia Corretta

```php
<?php

namespace Modules\Notify\Contracts;

use Modules\Notify\Datas\SmsData;

interface SmsProviderContract
{
    /**
     * Invia un SMS utilizzando il provider specificato.
     *
     * @param SmsData $smsData I dati necessari per l'invio dell'SMS
     * @return array Risposta del provider con stato dell'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Risorse Correlate

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PHP-FIG Interface Naming Conventions](https://www.php-fig.org/psr/psr-1/)