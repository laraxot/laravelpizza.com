# Best Practices per Template Email

## 1. Struttura Base
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $subject }}</title>
</head>
<body>
    <!-- Contenuto -->
</body>
</html>
```

## 2. Principi Fondamentali

### 2.1 Compatibilità
- Utilizzare tabelle per il layout (supporto universale)
- Stili inline per massima compatibilità
- Evitare CSS esterno o `<style>` tag
- Testare su vari client email (Gmail, Outlook, Apple Mail)

### 2.2 Responsive Design
- Layout fluido con larghezza massima di 600px
- Media queries per dispositivi mobili
- Immagini responsive con `width: 100%`
- Font size minimo di 14px

### 2.3 Performance
- Ottimizzare le immagini
- Minimizzare il codice HTML
- Utilizzare CDN per risorse statiche
- Evitare script JavaScript

## 3. Struttura Template

### 3.1 Header
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <img src="{{ logo_url }}" alt="Logo" width="200" style="max-width: 200px;">
        </td>
    </tr>
</table>
```

### 3.2 Contenuto
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding: 20px; background-color: #ffffff;">
            <!-- Contenuto principale -->
        </td>
    </tr>
</table>
```

### 3.3 Footer
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding: 20px; text-align: center; font-size: 12px;">
            <!-- Link social, unsubscribe, etc. -->
        </td>
    </tr>
</table>
```

## 4. Best Practices per Engagement

### 4.1 Call-to-Action
- Pulsanti grandi e visibili
- Colori contrastanti
- Testo chiaro e diretto
- Spaziatura adeguata

### 4.2 Personalizzazione
- Utilizzare il nome del destinatario
- Contenuto dinamico basato su preferenze
- A/B testing per ottimizzare

### 4.3 Accessibilità
- Alt text per le immagini
- Contrasto adeguato
- Font leggibili
- Link descrittivi

## 5. Template Types

### 5.1 Newsletter
- Layout a griglia
- Immagini ottimizzate
- Sommario in alto
- Link "Leggi tutto"

### 5.2 Promozionali
- Offerta principale in evidenza
- Countdown timer
- Testimonianze
- Garanzie

### 5.3 Transazionali
- Conferma ordine
- Reset password
- Notifiche
- Ricevute

## 6. Struttura Directory
```
resources/
└── mail-layouts/
    ├── base/
    │   ├── default.blade.php
    │   └── dark.blade.php
    ├── components/
    │   ├── header.blade.php
    │   ├── footer.blade.php
    │   └── buttons.blade.php
    ├── templates/
    │   ├── newsletter/
    │   ├── promotion/
    │   └── transactional/
    └── themes/
        ├── light/
        └── dark/
```

## 7. Integrazione con Laravel

### 7.1 Configurazione
```php
// config/notify.php
return [
    'mail_layouts' => [
        'default' => 'notify::mail-layouts.base.default',
        'themes' => [
            'light' => 'notify::mail-layouts.themes.light',
            'dark' => 'notify::mail-layouts.themes.dark',
        ],
    ],
];
```

### 7.2 Utilizzo
```php
use Spatie\MailTemplates\TemplateMailable;

class WelcomeEmail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return view('notify::mail-layouts.base.default')->render();
    }
}
```

## 8. Testing

### 8.1 Client Email
- Gmail (Web, Mobile)
- Outlook (Desktop, Web)
- Apple Mail
- Yahoo Mail

### 8.2 Dispositivi
- Desktop
- Tablet
- Mobile

### 8.3 Strumenti
- Email on Acid
- Litmus
- Mailtrap

## 9. Ottimizzazione

### 9.1 Performance
- Compressione immagini
- Minificazione HTML
- Caching risorse
- CDN per assets

### 9.2 Deliverability
- SPF records
- DKIM
- DMARC
- Lista pulita

## 10. Risorse Utili

### 10.1 Strumenti
- [Email on Acid](https://www.emailonacid.com)
- [Litmus](https://www.litmus.com)
- [Mailtrap](https://mailtrap.io)
- [Unlayer](https://unlayer.com)

### 10.2 Template
- [Foundation for Emails](https://get.foundation/emails)
- [Mailchimp Templates](https://templates.mailchimp.com)
- [Campaign Monitor](https://www.campaignmonitor.com)

### 10.3 Guide
- [Email Design Guide](https://www.campaignmonitor.com/dev-resources/guides/coding-html-emails)
- [Responsive Email](https://www.emailonacid.com/blog/article/email-development/responsive-email-design)
- [Email Best Practices](https://www.mailtrap.io/blog/email-design-best-practices) 
