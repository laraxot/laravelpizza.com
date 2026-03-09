# Convenzioni per la Struttura dei DTO nel Modulo Notify

## Introduzione

Questo documento definisce le convenzioni per la struttura e l'organizzazione dei Data Transfer Objects (DTO) nel modulo Notify. Seguire queste convenzioni è essenziale per mantenere coerenza e prevenire errori.

## Struttura delle Directory

### Directory Principale per i DTO

I DTO nel modulo Notify devono essere collocati nella directory:

```
/Modules/Notify/app/Datas/
```

**IMPORTANTE**: Non utilizzare le directory `/app/Data/` o `/app/DTOs/` per i nuovi DTO.

### Organizzazione dei File

I DTO devono essere posizionati direttamente nella directory `Datas/` e non in sottodirectory, a meno che non sia assolutamente necessario per ragioni di organizzazione.

✅ **Corretto**:
```
/Modules/Notify/app/Datas/NetfunSmsData.php
/Modules/Notify/app/Datas/NetfunSmsRequestData.php
/Modules/Notify/app/Datas/NetfunSmsResponseData.php
```

❌ **Errato**:
```
/Modules/Notify/app/Data/NetfunSmsData.php
/Modules/Notify/app/DTOs/NetfunSmsData.php
/Modules/Notify/app/Datas/SMS/NetfunSmsData.php
```

## Convenzioni di Nomenclatura

### Naming dei File

I file DTO devono seguire la convenzione di nomenclatura PascalCase con il suffisso `Data`:

✅ **Corretto**:
```
NetfunSmsData.php
EmailData.php
NotificationData.php
```

❌ **Errato**:
```
netfun_sms_data.php
NetfunSMS.php
Netfun.php
```

### Namespace

Il namespace dei DTO deve essere:

```php
namespace Modules\Notify\Datas;
```

**IMPORTANTE**: Non utilizzare namespace come `Modules\Notify\Data` o `Modules\Notify\DTOs`.

## Implementazione dei DTO

### Proprietà Readonly

Utilizzare sempre proprietà readonly per i DTO in PHP 8.2+:

```php
readonly class NetfunSmsData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        // ...
    ) {}
}
```

### Tipi Rigorosi

Specificare sempre i tipi per tutte le proprietà e utilizzare tipi nullable quando appropriato:

```php
public string $recipient,       // Obbligatorio
public ?string $sender = null,  // Opzionale
```

### Documentazione

Ogni DTO deve includere PHPDoc completo:

```php
/**
 * DTO per i dati di richiesta SMS Netfun
 */
readonly class NetfunSmsRequestData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     */
    public function __construct(
        // ...
    ) {}
}
```

## Esempi di DTO Corretti

### NetfunSmsData

```php
<?php

namespace Modules\Notify\Datas;

/**
 * DTO per i dati SMS Netfun
 */
readonly class NetfunSmsData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     * @param string|null $reference Riferimento univoco (opzionale)
     * @param string|null $scheduledDate Data pianificata di invio (opzionale)
     */
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
```

## Checklist di Verifica

Prima di creare un nuovo DTO, verificare che:

- [ ] Il file sia posizionato nella directory corretta (`/Modules/Notify/app/Datas/`)
- [ ] Il nome del file segua la convenzione PascalCase con suffisso `Data`
- [ ] Il namespace sia corretto (`Modules\Notify\Datas`)
- [ ] Le proprietà siano readonly e tipizzate correttamente
- [ ] La documentazione PHPDoc sia completa e accurata

## Riferimenti

- [PHP 8.2 Readonly Properties](https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties)
- [Laravel Data Transfer Objects Best Practices](https://laravel.com/docs/10.x/eloquent-serialization#data-transfer-objects)

---

*Ultimo aggiornamento: 2025-05-12*
