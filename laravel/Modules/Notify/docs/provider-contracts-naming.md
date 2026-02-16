# Convenzioni di Naming per i Contracts 

## Regola Fondamentale

Nel sistema , tutte le interfacce (interfaces) devono seguire queste convenzioni di naming:
Nel sistema <nome progetto>, tutte le interfacce (interfaces) devono seguire queste convenzioni di naming:

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
