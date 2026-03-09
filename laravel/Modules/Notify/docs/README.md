# 🔔 **Notify Module** - Sistema Avanzato di Comunicazione

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Multi-Channel](https://img.shields.io/badge/Channels-Email%20%7C%20SMS%20%7C%20WhatsApp%20%7C%20DB-blue.svg)](https://filamentphp.com/docs/notifications)

> **🚀 Modulo Notify**: Il cuore pulsante delle comunicazioni dell'ecosistema Laraxot. Gestisce l'invio multicanale, la generazione di PDF on-the-fly e l'integrazione di template dinamici gestiti da database.

## Panoramica

Il modulo **Notify** centralizza tutta la logica di invio messaggi, garantendo che ogni comunicazione sia tracciata, sicura e facilmente personalizzabile tramite Admin Panel.

- 📧 **Database Email System**: Integrazione con `spatie/laravel-mail-templates`.
- 📎 **Advanced Attachments**: Supporto nativo per allegati binari (PDF generati in memoria).
- 📱 **Multi-Channel**: Gestione unificata di Email, SMS (via Netfun/Twilio), WhatsApp e notifiche Database.
- 🎯 **Super Mucca Rules**: Uso intensivo di DTO e Smart Enums per la gestione dei canali.

## 🧩 RecordNotification

Un sistema di notifica generico che permette di inviare messaggi basati su record Eloquent con risoluzione automatica dei template tramite slug.

## 📄 Allegati Dinamici

Permette di allegare file PDF generati al volo senza scrittura su disco, migliorando le performance e la scalabilità.

## 🚀 Quick Start

### Invio Email Semplice
```php
use Modules\Notify\Notifications\RecordNotification;

$notify = new RecordNotification($record, 'welcome-email');
$user->notify($notify);
```

### Invio con Allegati Binari
```php
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
$attachments = [['data' => $pdfContent, 'as' => 'report.pdf', 'mime' => 'application/pdf']];

$notify = (new RecordNotification($record, 'report'))
    ->addAttachments($attachments);
$user->notify($notify);
```

## 📚 Documentazione Completa

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa completa di tutti i pattern e componenti.
- 🗺️ **[Roadmap](./roadmap.md)** - Evoluzione del modulo e prossimi step.
- 🧘 **[Zen of Reuse](./refactoring/zen-of-reuse.md)** - Filosofia dei componenti riutilizzabili.
- 🛠️ **[Troubleshooting](./troubleshooting.md)** - Soluzioni ai problemi comuni.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 2.1.0
**✅ PHPStan level 10**: Compliance verificata

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.

## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT