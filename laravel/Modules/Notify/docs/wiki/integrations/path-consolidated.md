---
qmd: "path consolidated"
issues: []
discussions: []
title: "path: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# path: Consolidated Documentation

Consolidated from **14** individual files.

## Table of Contents

- [Regole di Percorso e Interfacce nel Modulo Notify](#path-and-interface-rules-1)
- [---](#path-and-interface-rules-2)
- [Regole di Percorso e Interfacce nel Modulo Notify](#path-and-interface-rules)
- [Regole di Percorso e Interfacce nel Modulo Notify](#path-and-interface)
- [Regole per Path e Namespace nel Modulo Notify](#path-and-namespace-rules-1)
- [---](#path-and-namespace-rules-2)
- [Regole per Path e Namespace nel Modulo Notify](#path-and-namespace-rules)
- [Regole per Path e Namespace nel Modulo Notify](#path-and-namespace)
- [Convenzioni sui Percorsi](#path-conventions-1)
- [---](#path-conventions-2)
- [Convenzioni sui Percorsi](#path-conventions)
- [Regole di Percorso e Interfacce nel Modulo Notify](#path_and_interface_rules)
- [Regole per Path e Namespace nel Modulo Notify](#path_and_namespace_rules)
- [Convenzioni sui Percorsi ](#path_conventions)

---

## path-and-interface-rules-1

*Consolidated from: `path-and-interface-rules.md`*


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
Modules/Notify/
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

---

## path-and-interface-rules-2

*Consolidated from: `path-and-interface-rules.md`*

title: "Regole di Percorso e Interfacce nel Modulo Notify"
type: rule
tags: [path, interface, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "path-and-interface-rules-2 regole di percorso e interfacce nel modulo notify"
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
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

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
/var/www/_bases/<nome repository>/laravel/Modules/Notify/
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
---

## path-and-interface-rules

*Consolidated from: `path-and-interface-rules.md`*


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
Modules/Notify/
Modules/Notify/
Modules/Notify/
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
Modules/Notify/
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

---

## path-and-interface

*Consolidated from: `path-and-interface.md`*


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
Modules/Notify/
Modules/Notify/
Modules/Notify/
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
Modules/Notify/
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

---

## path-and-namespace-rules-1

*Consolidated from: `path-and-namespace-rules.md`*


> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
```

### ❌ Path Errati

```
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <nome progetto>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../Xot/docs/NAMESPACE-RULES.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Convenzioni di Codice](/laravel/Modules/Xot/docs/CODE-CONVENTIONS.md)
- [Struttura dei Moduli](/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

*Ultimo aggiornamento: 2025-05-12*
---

## path-and-namespace-rules-2

*Consolidated from: `path-and-namespace-rules.md`*

title: "Regole per Path e Namespace nel Modulo Notify"
type: rule
tags: [path, namespace, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "path-and-namespace-rules-2 regole per path e namespace nel modulo notify"
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
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Regole per Path e Namespace nel Modulo Notify

> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Actions/SMS
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Http/Controllers
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Providers
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Models
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Filament
```

### ❌ Path Errati

```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/App/Actions/SMS
/var/www/_bases/<nome repository>/laravel/Modules/Notify/App/Http/Controllers
/var/www/_bases/<nome repository>/laravel/Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto App.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../xot/docs/namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/modules/xot/docs/namespace-rules.md)
- [Convenzioni di Codice](/laravel/modules/xot/docs/code-conventions.md)
- [Struttura dei Moduli](/laravel/modules/xot/docs/module-structure.md)
- [Regole generali per i namespace (Xot)](../../Xot/docs/NAMESPACE-RULES.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Convenzioni di Codice](/laravel/Modules/Xot/docs/CODE-CONVENTIONS.md)
- [Struttura dei Moduli](/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

*Ultimo aggiornamento: 2025-05-12*
*Ultimo aggiornamento: 2025-05-12*
---

## path-and-namespace-rules

*Consolidated from: `path-and-namespace-rules.md`*


> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
```

### ❌ Path Errati

```
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
Modules/Notify/app/Http/Controllers/NotificationController.php
Modules/Notify/app/Http/Controllers/NotificationController.php
Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
Modules/Notify/app/Providers/NotifyServiceProvider.php
Modules/Notify/app/Providers/NotifyServiceProvider.php
Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
Modules/Notify/app/Datas/NetfunSMSMessage.php
Modules/Notify/app/Datas/NetfunSMSMessage.php
Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto .
Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <nome progetto>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../Xot/docs/NAMESPACE-RULES.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Convenzioni di Codice](/laravel/Modules/Xot/docs/CODE-CONVENTIONS.md)
- [Struttura dei Moduli](/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

*Ultimo aggiornamento: 2025-05-12*
# Regole per Path e Namespace nel Modulo Notify

> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
```

### ❌ Path Errati

```
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <main module>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../Xot/docs/NAMESPACE-RULES.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Convenzioni di Codice](/laravel/Modules/Xot/docs/CODE-CONVENTIONS.md)
- [Struttura dei Moduli](/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

*Ultimo aggiornamento: 2025-05-12*

---

## path-and-namespace

*Consolidated from: `path-and-namespace.md`*


> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
```

### ❌ Path Errati

```
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
Modules/Notify/app/Http/Controllers/NotificationController.php
Modules/Notify/app/Http/Controllers/NotificationController.php
Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
Modules/Notify/app/Providers/NotifyServiceProvider.php
Modules/Notify/app/Providers/NotifyServiceProvider.php
Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
Modules/Notify/app/Datas/NetfunSMSMessage.php
Modules/Notify/app/Datas/NetfunSMSMessage.php
Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto .
Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <nome progetto>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../xot/docs/namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/modules/xot/docs/namespace-rules.md)
- [Convenzioni di Codice](/laravel/modules/xot/docs/code-conventions.md)
- [Struttura dei Moduli](/laravel/modules/xot/docs/module-structure.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

# Regole per Path e Namespace nel Modulo Notify

> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
Modules/Notify/app/Actions/SMS
Modules/Notify/app/Http/Controllers
Modules/Notify/app/Providers
Modules/Notify/app/Models
Modules/Notify/app/Filament
```

### ❌ Path Errati

```
Modules/Notify/App/Actions/SMS
Modules/Notify/App/Http/Controllers
Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <main module>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../xot/docs/namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/modules/xot/docs/namespace-rules.md)
- [Convenzioni di Codice](/laravel/modules/xot/docs/code-conventions.md)
- [Struttura dei Moduli](/laravel/modules/xot/docs/module-structure.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../../../docs/links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---


---

## path-conventions-1

*Consolidated from: `path-conventions-1.md`*
*Consolidated from: `path-conventions.md`*


## Regole Fondamentali

1. **Directory vs Namespace**
   - Le directory nel filesystem sono in lowercase: `app`, `config`, `resources`
   - I namespace possono essere in PascalCase ma devono mappare correttamente alle directory lowercase

2. **Struttura Directory Principale**
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)

## Namespace vs Directory

| Directory (filesystem) | Namespace PHP | Note |
|------------------------|---------------|------|
| `app/`                 | `Modules\Notify` | Nessun segmento "App" nel namespace |
| `app/Actions/`         | `Modules\Notify\Actions` | Il modulo definisce il proprio PSR-4 |
| `app/Datas/`           | `Modules\Notify\Datas` | Data objects utilizzati nel modulo |
| `app/Models/`          | `Modules\Notify\Models` | Modelli Eloquent |

## Errori Comuni da Evitare

1. **Mai utilizzare la "A" maiuscola nel percorso fisico della directory app**
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`

2. **Mai aggiungere "App" nel namespace se non definito nel composer.json del modulo**
   - ✅ CORRETTO: `namespace Modules\Notify\Actions;`
   - ❌ ERRATO: `namespace Modules\Notify\App\Actions;`

3. **Mai creare directory con nomi inconsistenti rispetto alle convenzioni di Laravel**
   - Le directory standard `app`, `config`, `resources` devono sempre essere in lowercase
   - Le classi e i namespace utilizzano PascalCase ma puntano a percorsi in lowercase

## Riferimento PSR-4 nel composer.json

I moduli  definiscono il proprio mapping PSR-4 nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

Questo significa che il namespace `Modules\Notify` mappa alla directory `app/` del modulo, non alla directory principale. Pertanto, qualsiasi classe all'interno di `app/Actions/` avrà il namespace `Modules\Notify\Actions`, non `Modules\Notify\App\Actions`.

---

## path-conventions-2

*Consolidated from: `path-conventions.md`*
*Consolidated from: `path-conventions-user.md`*

title: "Path Conventions"
type: concept
tags: [path, conventions]
created: 2026-07-14
updated: 2026-07-14
qmd: "path-conventions-2 path conventions"
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
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Path Conventions

This document outlines the path and directory structure conventions for the Notify module.
---

## path-conventions

*Consolidated from: `path-conventions.md`*


## Regole Fondamentali

1. **Directory vs Namespace**
   - Le directory nel filesystem sono in lowercase: `app`, `config`, `resources`
   - I namespace possono essere in PascalCase ma devono mappare correttamente alle directory lowercase

2. **Struttura Directory Principale**
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)

## Namespace vs Directory

| Directory (filesystem) | Namespace PHP | Note |
|------------------------|---------------|------|
| `app/`                 | `Modules\Notify` | Nessun segmento "App" nel namespace |
| `app/Actions/`         | `Modules\Notify\Actions` | Il modulo definisce il proprio PSR-4 |
| `app/Datas/`           | `Modules\Notify\Datas` | Data objects utilizzati nel modulo |
| `app/Models/`          | `Modules\Notify\Models` | Modelli Eloquent |

## Errori Comuni da Evitare

1. **Mai utilizzare la "A" maiuscola nel percorso fisico della directory app**
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`

2. **Mai aggiungere "App" nel namespace se non definito nel composer.json del modulo**
   - ✅ CORRETTO: `namespace Modules\Notify\Actions;`
   - ❌ ERRATO: `namespace Modules\Notify\App\Actions;`

3. **Mai creare directory con nomi inconsistenti rispetto alle convenzioni di Laravel**
   - Le directory standard `app`, `config`, `resources` devono sempre essere in lowercase
   - Le classi e i namespace utilizzano PascalCase ma puntano a percorsi in lowercase

## Riferimento PSR-4 nel composer.json

I moduli  definiscono il proprio mapping PSR-4 nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

Questo significa che il namespace `Modules\Notify` mappa alla directory `app/` del modulo, non alla directory principale. Pertanto, qualsiasi classe all'interno di `app/Actions/` avrà il namespace `Modules\Notify\Actions`, non `Modules\Notify\App\Actions`.
# Convenzioni sui Percorsi

## Regole Fondamentali

1. **Directory vs Namespace**
   - Le directory nel filesystem sono in lowercase: `app`, `config`, `resources`
   - I namespace possono essere in PascalCase ma devono mappare correttamente alle directory lowercase

2. **Struttura Directory Principale**
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)

## Namespace vs Directory

| Directory (filesystem) | Namespace PHP | Note |
|------------------------|---------------|------|
| `app/`                 | `Modules\Notify` | Nessun segmento "App" nel namespace |
| `app/Actions/`         | `Modules\Notify\Actions` | Il modulo definisce il proprio PSR-4 |
| `app/Datas/`           | `Modules\Notify\Datas` | Data objects utilizzati nel modulo |
| `app/Models/`          | `Modules\Notify\Models` | Modelli Eloquent |

## Errori Comuni da Evitare

1. **Mai utilizzare la "A" maiuscola nel percorso fisico della directory app**
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`

2. **Mai aggiungere "App" nel namespace se non definito nel composer.json del modulo**
   - ✅ CORRETTO: `namespace Modules\Notify\Actions;`
   - ❌ ERRATO: `namespace Modules\Notify\App\Actions;`

3. **Mai creare directory con nomi inconsistenti rispetto alle convenzioni di Laravel**
   - Le directory standard `app`, `config`, `resources` devono sempre essere in lowercase
   - Le classi e i namespace utilizzano PascalCase ma puntano a percorsi in lowercase

## Riferimento PSR-4 nel composer.json

I moduli  definiscono il proprio mapping PSR-4 nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

Questo significa che il namespace `Modules\Notify` mappa alla directory `app/` del modulo, non alla directory principale. Pertanto, qualsiasi classe all'interno di `app/Actions/` avrà il namespace `Modules\Notify\Actions`, non `Modules\Notify\App\Actions`.

---

## path_and_interface_rules

*Consolidated from: `path_and_interface_rules.md`*


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
[project-root]/laravel/Modules/Notify/
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

---

## path_and_namespace_rules

*Consolidated from: `path_and_namespace_rules.md`*


> **ATTENZIONE:** In nessun caso il namespace deve contenere il segmento `App`, anche se il file si trova nella cartella `app/`. Questa è una regola fondamentale e ogni violazione può causare errori di autoloading, incompatibilità con PSR-4 e problemi di coerenza nel progetto. Consulta sempre questa sezione prima di creare nuovi file o correggere errori di namespace.

## Struttura Corretta dei Path

### ✅ Path Corretti

```
[project-root]/laravel/Modules/Notify/app/Actions/SMS
[project-root]/laravel/Modules/Notify/app/Http/Controllers
[project-root]/laravel/Modules/Notify/app/Providers
[project-root]/laravel/Modules/Notify/app/Models
[project-root]/laravel/Modules/Notify/app/Filament
```

### ❌ Path Errati

```
[project-root]/laravel/Modules/Notify/App/Actions/SMS
[project-root]/laravel/Modules/Notify/App/Http/Controllers
[project-root]/laravel/Modules/Notify/App/Providers
```

## Struttura Corretta dei Namespace

### ✅ Namespace Corretti

```php
namespace Modules\Notify\Actions\SMS;
namespace Modules\Notify\Http\Controllers;
namespace Modules\Notify\Providers;
namespace Modules\Notify\Models;
namespace Modules\Notify\Filament;
namespace Modules\Notify\Datas;
```

### ❌ Namespace Errati

```php
namespace Modules\Notify\App\Actions\SMS;
namespace Modules\Notify\App\Http\Controllers;
namespace Modules\Notify\App\Providers;
namespace Modules\Notify\App\Datas;
```

## Regola Fondamentale

**Il namespace NON deve mai contenere il segmento `App`.** Anche se i file sono fisicamente posizionati nella cartella `app` (minuscolo), il namespace deve partire da `Modules\Notify\` seguito dalla sottocartella, senza mai includere `App`.

## Esempi Concreti

### Esempio 1: Action per invio SMS

**Path fisico corretto:**
```
[project-root]/laravel/Modules/Notify/app/Actions/SMS/SendNetfunSmsAction.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Actions\SMS;
```

### Esempio 2: Controller

**Path fisico corretto:**
```
[project-root]/laravel/Modules/Notify/app/Http/Controllers/NotificationController.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Http\Controllers;
```

### Esempio 3: Provider

**Path fisico corretto:**
```
[project-root]/laravel/Modules/Notify/app/Providers/NotifyServiceProvider.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Providers;
```

### Esempio 4: Data per SMS Netfun

**Path fisico corretto:**
```
[project-root]/laravel/Modules/Notify/app/Datas/NetfunSMSMessage.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Datas;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Datas;
```

> **Nota:** Questa regola si applica a tutte le sottocartelle di `app`, incluse `Datas`, `Filament`, ecc. Il segmento `App` non deve mai comparire nel namespace.

## Motivo di questa Regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso. Questo approccio è stato adottato per standardizzare i namespace in tutto il progetto <nome progetto>.

## Esempio per Datas

### ❌ Namespace Errato
```php
namespace Modules\Notify\App\Datas; // ERRATO
```

### ✅ Namespace Corretto
```php
namespace Modules\Notify\Datas; // CORRETTO
```

> **Attenzione:** Anche se il file si trova in `app/Datas`, il namespace NON deve includere `App`. Seguire sempre la forma `Modules\<NomeModulo>\Datas`.

## Collegamento alle Regole Generali

Per le regole generali e condivise tra tutti i moduli, consulta anche:
- [Regole generali per i namespace (Xot)](../../Xot/docs/NAMESPACE-RULES.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.
- [Regole generali per i namespace (Xot)](../../namespace-rules.md): linee guida ufficiali e motivazioni delle scelte di struttura dei namespace nei moduli Laraxot.

## Collegamenti

- [Regole Generali per i Namespace](/laravel/Modules/Xot/docs/NAMESPACE-RULES.md)
- [Convenzioni di Codice](/laravel/Modules/Xot/docs/CODE-CONVENTIONS.md)
- [Struttura dei Moduli](/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Collegamento Bidirezionale: Documentazione Root](../../../../docs/links.md)
- [Collegamento Bidirezionale: Documentazione Root](../../links.md)

### Esempio 5: Console Command

**Path fisico corretto:**
```
[project-root]/laravel/Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php
```

**Namespace corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

**❌ Namespace errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```

> **Nota:** Anche per i comandi console, il namespace non deve mai includere il segmento `App`.

---

*Ultimo aggiornamento: 2025-05-12*

---

## path_conventions

*Consolidated from: `path_conventions.md`*


## Regole Fondamentali

1. **Directory vs Namespace**
   - Le directory nel filesystem sono in lowercase: `app`, `config`, `resources`
   - I namespace possono essere in PascalCase ma devono mappare correttamente alle directory lowercase

2. **Struttura Directory Principale**
   - `[project-root]/laravel/Modules/Notify/app/` (CORRETTO)
   - `[project-root]/laravel/Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `[project-root]/laravel/Modules/Notify/app/Actions/` (CORRETTO)
   - `[project-root]/laravel/Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `[project-root]/laravel/Modules/Notify/app/Datas/` (CORRETTO)
   - `[project-root]/laravel/Modules/Notify/App/Datas/` (ERRATO)

## Namespace vs Directory

| Directory (filesystem) | Namespace PHP | Note |
|------------------------|---------------|------|
| `app/`                 | `Modules\Notify` | Nessun segmento "App" nel namespace |
| `app/Actions/`         | `Modules\Notify\Actions` | Il modulo definisce il proprio PSR-4 |
| `app/Datas/`           | `Modules\Notify\Datas` | Data objects utilizzati nel modulo |
| `app/Models/`          | `Modules\Notify\Models` | Modelli Eloquent |

## Errori Comuni da Evitare

1. **Mai utilizzare la "A" maiuscola nel percorso fisico della directory app**
   - ✅ CORRETTO: `[project-root]/laravel/Modules/Notify/app/Actions/`
   - ❌ ERRATO: `[project-root]/laravel/Modules/Notify/App/Actions/`

2. **Mai aggiungere "App" nel namespace se non definito nel composer.json del modulo**
   - ✅ CORRETTO: `namespace Modules\Notify\Actions;`
   - ❌ ERRATO: `namespace Modules\Notify\App\Actions;`

3. **Mai creare directory con nomi inconsistenti rispetto alle convenzioni di Laravel**
   - Le directory standard `app`, `config`, `resources` devono sempre essere in lowercase
   - Le classi e i namespace utilizzano PascalCase ma puntano a percorsi in lowercase

## Riferimento PSR-4 nel composer.json

I moduli  definiscono il proprio mapping PSR-4 nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

Questo significa che il namespace `Modules\Notify` mappa alla directory `app/` del modulo, non alla directory principale. Pertanto, qualsiasi classe all'interno di `app/Actions/` avrà il namespace `Modules\Notify\Actions`, non `Modules\Notify\App\Actions`.

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
