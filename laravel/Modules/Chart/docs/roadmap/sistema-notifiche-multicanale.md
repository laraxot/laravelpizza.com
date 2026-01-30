# Sistema Notifiche Multi-canale

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Panoramica

Il sistema di notifiche multi-canale di il progetto è progettato per garantire una comunicazione efficace con pazienti e operatori attraverso diversi canali di comunicazione. Implementato al 50%, il sistema richiede ulteriori integrazioni per raggiungere la piena operatività.

## Funzionalità Implementate

- ✅ Architettura base del sistema di notifiche
- ✅ Integrazione email tramite SMTP configurabile
- ✅ Logging delle notifiche inviate
- ✅ Template di base per le notifiche più comuni
- ✅ Gestione code per l'invio asincrono

## Funzionalità da Implementare

- 🚧 Integrazione SMS attraverso provider esterni (40%)
- 🚧 Notifiche push per l'app mobile (10%)
- 🚧 Template personalizzabili per ciascun tenant (30%)
- 🚧 Dashboard di monitoraggio delle notifiche (25%)
- 🚧 Sistema di pianificazione notifiche ricorrenti (15%)
- 📅 Integrazione WhatsApp Business API

## Requisiti Tecnici

Il sistema di notifiche si basa sui seguenti componenti:

1. **Modulo Notify**
   - Gestisce la coda di notifiche
   - Implementa i driver per i vari canali
   - Mantiene il registro delle notifiche inviate

2. **Template Engine**
   - Blade per le email
   - Twig per contenuti dinamici
   - Sistema di traduzione multilingua

3. **Servizi Esterni**
   - Mailgun/SendGrid per email transazionali
   - Twilio per SMS
   - Firebase per notifiche push

## Implementazione Attuale

Il sistema attualmente utilizza la classe `SendNotificationAction` che implementa:

```php
public function execute(
    Model $recipient,
    string $title,
    string $message,
    array $channels = ['mail'],
    array $data = []
): bool
```

Le notifiche vengono registrate nella tabella `notification_logs` con i seguenti campi:
- `notifiable_type`
- `notifiable_id`
- `title`
- `content`
- `channels` (array)
- `data` (json)
- `sent_at`
- `status`

## Calendario di Completamento

| Attività | Completamento Previsto |
|----------|------------------------|
| Integrazione SMS | Maggio 2024 |
| Template personalizzabili | Giugno 2024 |
| Dashboard monitoraggio | Giugno 2024 |
| Notifiche push | Luglio 2024 |
| Pianificazione notifiche | Agosto 2024 |
| Integrazione WhatsApp | Q4 2024 |

## Priorità e Risorse

La priorità attuale è completare l'integrazione SMS e i template personalizzabili per supportare il workflow di prenotazione appuntamenti, con particolare attenzione alle notifiche relative alla verifica ISEE.

**Risorse Assegnate**:
- 1 Backend Developer (80% tempo)
- 1 Frontend Developer (30% tempo)
- 1 UI/UX Designer (10% tempo)
