# Best Practices per Email Transazionali

## Introduzione

Questo documento descrive le best practices per la creazione e gestione di email transazionali , con particolare attenzione agli aspetti di design, contenuto e tecnici.

## Design e Contenuto

### 1. Chiarezza e Concisione

- **Oggetto chiaro**: Breve e descrittivo (max 50 caratteri)
- **Contenuto essenziale**: Comunicare solo l'informazione necessaria
- **Call to action**: Una sola CTA principale per email
- **Struttura scannable**: Suddividere il contenuto in sezioni brevi e facilmente leggibili

### 2. Branding Coerente

- **Elementi visuali**: Utilizzare logo, colori e font SaluteOra
- **Voce e tono**: Mantenere un tono professionale ma amichevole
- **Firma coerente**: Includere sempre lo stesso formato di firma e disclaimer

### 3. Accessibilità

- **Contrasto**: Mantenere un rapporto di contrasto minimo di 4.5:1
- **Dimensione font**: Minimo 14px per il corpo del testo
- **Alt text**: Fornire descrizioni alternative per tutte le immagini
- **Structure semantica**: Utilizzare gerarchia di titoli appropriata (h1, h2, ecc.)

## Aspetti Tecnici

### 1. Struttura Email

- **Layout responsive**: Design che si adatta a tutti i dispositivi
- **Larghezza massima**: 600px per la compatibilità con la maggior parte dei client
- **Peso totale**: Mantenere l'email sotto i 100KB
- **Immagini ottimizzate**: Comprimere tutte le immagini (max 200KB ciascuna)

### 2. Consegna e Performance

- **SPF e DKIM**: Assicurarsi che siano configurati correttamente
- **Test spam**: Verificare il punteggio spam prima dell'invio
- **Monitoraggio**: Tracciare aperture, click e conversioni
- **Tempo di invio**: Pianificare l'invio nei momenti di maggior engagement

### 3. Localizzazione

- Utilizzare `LaravelLocalization::getCurrentLocale()` come indicato nelle regole utente
- Separare il contenuto dalla presentazione per facilitare le traduzioni
- Supportare lingue RTL quando necessario

## Template e Layout 

### Utilizzo di MailPace Templates

I template di [mailpace/templates](https://github.com/mailpace/templates) integrati  offrono:

- Design moderno e responsive
- Supporto Dark Mode
- Compatibilità cross-client
- Base solida personalizzabile

### Directory `mail-layouts`

La directory `/var/www/html/saluteora/laravel/Modules/Notify/resources/mail-layouts/` contiene:

- **default.html**: Template base per la maggior parte delle comunicazioni
- **main.html**: Alternativa minimalista
- **marketing.html**: Layout ottimizzato per comunicazioni promozionali
- **notification.html**: Design specifico per notifiche di sistema

### Integrazione con Spatie Mail Templates

Seguendo le regole di progetto SaluteOra, ricordare di:

- NON creare controller personalizzati per gestire l'invio di email
- Utilizzare il package `spatie/laravel-mail-templates`
- Implementare il modello `MailTemplate` con `HasSlug` per identificare facilmente i template

```php
// Esempio di utilizzo corretto
$mailTemplate = MailTemplate::findBySlug('appointment-confirmation');
$mailTemplate->send($user->email, [
    'name' => $user->first_name, // Nota l'uso di first_name come da regole utente
    'date' => $appointment->formatted_date,
    'time' => $appointment->formatted_time,
    'doctor' => $doctor->full_name,
]);
```

## Tipi di Email Transazionali

### 1. Email di Benvenuto
- Inviata immediatamente dopo la registrazione
- Conferma la creazione dell'account
- Fornisce i primi passi/risorse utili
- Include CTA per completare il profilo

### 2. Email di Conferma
- Per verificare l'identità dell'utente
- Design semplice con un solo link/button di conferma
- Spiegazione chiara dello scopo

### 3. Notifiche di Appuntamento
- Conferma di prenotazione
- Promemoria (24-48 ore prima)
- Modifiche o cancellazioni
- Istruzioni per la preparazione

### 4. Email di Riepilogo
- Riassunto degli appuntamenti passati
- Trattamenti completati
- Fatture e pagamenti
- Suggerimenti per follow-up

## Riferimenti

- [Guida Layout Email](../MAIL_LAYOUTS_GUIDE.md)
- [Integrazione MailPace](./MAILPACE_TEMPLATES_INTEGRATION.md)
- [HTML Email Compatibility](./HTML_EMAIL_COMPATIBILITY.md)
- [Spatie Email Usage Guide](../SPATIE_EMAIL_USAGE_GUIDE.md)
