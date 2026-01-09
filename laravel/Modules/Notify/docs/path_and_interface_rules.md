# Regole di Percorso e Interfacce nel Modulo Notify

## Principi Fondamentali

1. **Regola Principale per le Interfacce**
   - Le interfacce DEVONO essere posizionate in `/app/Contracts/`
   - MAI in sottodirectory di Contracts come `/app/Contracts/SMS/`
   - MAI nelle directory di implementazione come `/app/Actions/SMS/`

2. **Regola Principale per i Namespace**
   - Namespace corretto: `Modules\Notify\Contracts`
   - Namespace ERRATO: `Modules\Notify\Contracts\SMS`
   - Namespace ERRATO: `Modules\Notify\Actions\SMS`

## Struttura delle Directory e Namespace

### Directory Fisiche (path su disco)
```
/var/www/html/<directory progetto>/laravel/Modules/Notify/
├── app/                           # Directory fisica con app minuscolo
│   ├── Actions/
│   │   ├── Email/                # Azioni per email
│   │   ├── SMS/                  # Azioni per SMS
│   │   └── WhatsApp/             # Azioni per WhatsApp
│   ├── Contracts/                # TUTTE le interfacce qui (no sottodirectory)
│   ├── Datas/                    # Data Transfer Objects
│   └── ...
└── config/
    ├── sms.php                   # Config per SMS
    ├── mail.php                  # Config per Email
    └── whatsapp.php              # Config per WhatsApp
```

### Namespace (in codice PHP)
```php
namespace Modules\Notify\Actions\SMS;      // Per le azioni SMS
namespace Modules\Notify\Actions\WhatsApp; // Per le azioni WhatsApp
namespace Modules\Notify\Contracts;        // Per TUTTE le interfacce
namespace Modules\Notify\Datas;            // Per tutti i DTO
```

## Convenzioni di Nomenclatura

### Interfacce
- Usare suffisso `Interface`: `SmsProviderActionInterface`
- Usare prefisso descrittivo: `SmsProvider`, `EmailProvider`, `WhatsAppProvider`
- MAI usare solo il servizio: `SmsInterface` (troppo generico)

### Implementazioni
- Usare prefisso `Send` seguito dal provider: `SendNetfunSMSAction`
- Usare suffisso `Action` per le azioni: `SendTwilioWhatsAppAction`
- Mantenere coerenza nella capitalizzazione: `SMS` maiuscolo, non `Sms`

### DTO
- Usare nomi descrittivi: `SmsData`, `WhatsAppData`, `EmailData`
- Ogni campo deve essere fortemente tipizzato
- Utilizzare solo proprietà readonly in PHP 8.2+

## Errori Comuni da Correggeere Immediatamente

1. **Interfacce nei percorsi sbagliati**
   - ❌ `/app/Actions/SMS/SmsActionInterface.php`
   - ❌ `/app/Contracts/SMS/SmsActionInterface.php`
   - ✅ `/app/Contracts/SmsProviderActionInterface.php`

2. **Interfacce con nomenclatura errata**
   - ❌ `SmsActionInterface` (troppo generico)
   - ✅ `SmsProviderActionInterface` (chiaro e specifico)

3. **Implementazioni che usano l'interfaccia sbagliata**
   - ❌ `implements SmsActionInterface`
   - ✅ `implements SmsProviderActionInterface`

## Azioni di Correzione Richieste

Per ogni nuova implementazione (come WhatsApp) o correzione di implementazioni esistenti:

1. Verificare che le interfacce siano in `/app/Contracts/`
2. Verificare che i namespace siano corretti
3. Verificare che le classi implementino le interfacce corrette
4. Verificare che i DTO siano nella directory corretta
5. Aggiornare la documentazione per riflettere l'architettura corretta

## Motivazioni Architetturali

Questa struttura garantisce:

1. **Separazione delle Responsabilità**: Interfacce separate dalle implementazioni
2. **Inversione delle Dipendenze**: Dependency Injection basato su interfacce
3. **Coerenza**: Pattern coerenti in tutto il modulo
4. **Manutenibilità**: Facile trovare e comprendere il codice
5. **Estendibilità**: Aggiungere nuovi provider senza modificare l'architettura
