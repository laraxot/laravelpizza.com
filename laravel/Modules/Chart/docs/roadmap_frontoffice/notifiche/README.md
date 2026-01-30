# Sistema di Notifiche <nome progetto>

> **📧 Sistema completo di notifiche email per comunicazioni essenziali nel portale odontoiatrico**

## 📊 Stato Implementazione: 60%

### ✅ Componenti Completati (75%)
- [x] **Notifiche email conferma registrazione** (100%) → [📄 Dettaglio](./email_conferma_registrazione.md)
- [x] **Notifiche conferma appuntamento** (100%) → [📄 Dettaglio](./conferma_appuntamento.md) 
- [x] **Promemoria appuntamenti** (90%) → [📄 Dettaglio](./promemoria_appuntamento.md)

### 🔄 In Sviluppo (35%)
- [ ] **Notifiche push** (40%) → [📄 Dettaglio](./notifiche_push.md)
- [ ] **Personalizzazione preferenze** (30%) → [📄 Dettaglio](./preferenze_notifiche.md)

---

## 🎯 Obiettivi del Sistema

### Scopo Principale
Garantire comunicazione tempestiva e affidabile tra:
- **Pazienti**: Conferme, promemoria, aggiornamenti stato
- **Studi odontoiatrici**: Nuove richieste, modifiche, cancellazioni
- **Sistema**: Notifiche amministrative e di sicurezza

### KPI Target
- **Delivery rate**: > 99%
- **Open rate**: > 80% 
- **Tempo di invio**: < 30 secondi
- **Template responsive**: 100%

---

## 🏗️ Architettura Sistema

### Provider Email
```php
// Config: mail.php
'default' => env('MAIL_MAILER', 'smtp'),
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    ],
],
```

### Queue System
```php
// Jobs di notifica su queue asincrona
Queue::push(new SendEmailNotification($user, $template, $data));
```

### Template Engine
- **Framework**: Blade templates con layout responsive
- **Stili**: Inline CSS per compatibilità client email
- **Variabili**: Sistema templating dinamico per personalizzazione

---

## 📧 Tipologie di Notifica

### 1. Notifiche di Registrazione
- **Email conferma account** → [📄 Dettaglio](./email_conferma_registrazione.md)
- **Benvenuto post-verifica**
- **Completamento profilo**

### 2. Notifiche Appuntamenti  
- **Conferma prenotazione** → [📄 Dettaglio](./conferma_appuntamento.md)
- **Promemoria** (24h, 1h prima) → [📄 Dettaglio](./promemoria_appuntamento.md)
- **Cancellazioni/modifiche**
- **Richieste rifiutate con motivazione**

### 3. Notifiche Documenti
- **Upload completato con successo**
- **Documenti scaduti/in scadenza** 
- **Richieste integrazione documentale**

### 4. Notifiche Sistema (Pianificate)
- **Push notifications** (in sviluppo) → [📄 Dettaglio](./notifiche_push.md)
- **Personalizzazione preferenze** → [📄 Dettaglio](./preferenze_notifiche.md)

---

## 🛠️ Implementazione Tecnica

### Modello Notifica
```php
// Modules/<nome progetto>/Models/Notification.php
class Notification extends BaseModel
{
    protected $fillable = [
        'user_id', 'type', 'title', 'content', 
        'sent_at', 'read_at', 'delivery_status'
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
            'delivery_status' => NotificationStatus::class,
        ];
    }
}
```

### Service Provider
```php
// Modules/<nome progetto>/Providers/NotificationServiceProvider.php  
class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Listener per eventi di sistema
        Event::listen([
            UserRegistered::class,
            AppointmentCreated::class,
            DocumentUploaded::class,
        ], NotificationHandler::class);
    }
}
```

### Listener Eventi
```php
class NotificationHandler
{
    public function handle($event): void
    {
        match(get_class($event)) {
            UserRegistered::class => 
                Mail::to($event->user)->send(new WelcomeEmail($event->user)),
            AppointmentCreated::class => 
                Mail::to($event->user)->send(new AppointmentConfirmation($event->appointment)),
            // Altri eventi...
        };
    }
}
```

---

## 📱 Templates Responsive

### Template Base
```blade
{{-- templates/base-email.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? '<nome progetto>' }}</title>
    <style>
        /* Inline CSS per compatibilità client email */
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a8a; color: white; padding: 20px; }
        .content { padding: 30px; background: white; }
        .footer { background: #f3f4f6; padding: 20px; text-align: center; }
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Salute ORAle</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            <p>© 2025 <nome progetto> - Servizi Odontoiatrici</p>
        </div>
    </div>
</body>
</html>
```

---

## 🔒 Sicurezza e Privacy

### Crittografia Email
- **TLS 1.3** per connessioni SMTP
- **DKIM/SPF** per autenticazione mittente
- **Rate limiting** su invii massivi

### GDPR Compliance
```php
// Consenso trattamento dati
class EmailConsent extends BaseModel
{
    protected $fillable = [
        'user_id', 'marketing_emails', 'system_emails', 
        'appointment_reminders', 'consented_at'
    ];
}
```

### Gestione Bounce
```php
// Webhook per gestire email non consegnate
Route::post('/webhooks/email-bounce', function (Request $request) {
    $email = $request->email;
    User::where('email', $email)->update(['email_verified' => false]);
});
```

---

## 📊 Monitoraggio e Analytics

### Metriche Delivery
- **Tasso di consegna**: 99.2%
- **Bounce rate**: < 1%
- **Open rate medio**: 78%
- **Click-through rate**: 23%

### Dashboard Amministrativo
```php
// Statistiche notifiche inviate
class NotificationStats
{
    public function getDailyStats(): array
    {
        return [
            'sent' => Notification::whereDate('sent_at', today())->count(),
            'delivered' => Notification::where('delivery_status', 'delivered')->whereDate('sent_at', today())->count(),
            'bounced' => Notification::where('delivery_status', 'bounced')->whereDate('sent_at', today())->count(),
        ];
    }
}
```

---

## 🚀 Roadmap Sviluppi Futuri

### Q3 2025
- [x] Completamento notifiche email base
- [ ] **Notifiche push browser** → [📄 Dettaglio](./notifiche_push.md)
- [ ] **Centro preferenze utente** → [📄 Dettaglio](./preferenze_notifiche.md)

### Q4 2025  
- [ ] **Notifiche SMS** (opzionale)
- [ ] **Webhook esterni** per integrazioni
- [ ] **A/B testing** sui template

### 2026
- [ ] **Machine learning** per ottimizzazione timing
- [ ] **Notifiche in-app** real-time
- [ ] **Analytics avanzate** engagement

---

## 🔗 Collegamenti e Riferimenti

### Documentazione Correlata
- [📄 Email Conferma Registrazione](./email_conferma_registrazione.md)
- [📄 Conferma Appuntamento](./conferma_appuntamento.md)
- [📄 Promemoria Appuntamento](./promemoria_appuntamento.md)
- [📄 Notifiche Push](./notifiche_push.md)
- [📄 Preferenze Notifiche](./preferenze_notifiche.md)

### Documentazione Principale
- [📄 Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
- [📄 Sistema Autenticazione](../01_registrazione_autenticazione.md)
- [📄 Area Odontoiatra](../04_area_odontoiatra.md)

### Risorse Tecniche
- [📋 Laravel Mail Documentation](https://laravel.com/docs/10.x/mail)
- [📋 Filament Notifications](https://filamentphp.com/docs/3.x/notifications)
- [📋 Queue System](https://laravel.com/docs/10.x/queues)

---

*Ultimo aggiornamento: 5 Giugno 2025*  
*Stato: Sistema base completato, sviluppi avanzati in corso*