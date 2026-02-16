# Guida ai Template Email Responsive

Questa guida descrive i template email responsive disponibili nel modulo Notify, la loro struttura e come utilizzarli nelle comunicazioni con gli utenti.

## Indice

- [Introduzione](#introduzione)
- [Template Disponibili](#template-disponibili)
- [Struttura Comune](#struttura-comune)
- [Variabili Disponibili](#variabili-disponibili)
- [Integrazione con il Sistema](#integrazione-con-il-sistema)
- [Best Practices](#best-practices)
- [File Correlati](#file-correlati)

## Introduzione

I template email responsive di SaluteOra sono progettati per offrire una comunicazione professionale e coinvolgente con gli utenti. Tutti i template sono:

- **Responsive**: ottimizzati per qualsiasi dispositivo (desktop, tablet, mobile)
- **Accessibili**: strutturati per garantire accessibilità secondo gli standard WCAG
- **Compatibili**: testati sui principali client email (Gmail, Outlook, Apple Mail, ecc.)
- **Personalizzabili**: includono variabili per contenuti dinamici
- **Dark Mode**: supportano la modalità scura automaticamente

## Template Disponibili

### 1. Template di Conferma (`confirmation-template.html`)

Utilizzato per verifiche email, conferme di account e altre conferme importanti.

**Caratteristiche principali**:
- Layout con header verde acqua
- Box di conferma con codice di verifica
- Sezione informativa su passi successivi
- Note di sicurezza

### 2. Template Password Reset (`password-reset-template.html`)

Utilizzato per le procedure di recupero password.

**Caratteristiche principali**:
- Layout con header blu
- Box di reset con icona di sicurezza
- Procedura step-by-step per il ripristino
- Avvisi di sicurezza e scadenza codice

### 3. Template Appuntamenti (`appointment-template.html`)

Utilizzato per conferme, promemoria e aggiornamenti relativi agli appuntamenti.

**Caratteristiche principali**:
- Layout con header viola
- Box dettagli appuntamento con informazioni complete
- Pulsanti di azione (conferma, riprogramma, annulla)
- Sezione con istruzioni di preparazione
- Mappa della posizione

### 4. Template Notifiche (`notification-template.html`)

Utilizzato per comunicazioni generali e notifiche di sistema.

**Caratteristiche principali**:
- Layout con header rosa
- Box notifica con icona personalizzabile
- Sezioni per contenuti multipli
- Lista feature con icone

### 5. Template Newsletter (`newsletter-template.html`)

Utilizzato per newsletter periodiche e comunicazioni promozionali.

**Caratteristiche principali**:
- Layout con header verde
- Sezioni per contenuti multipli e notizie
- Area testimonianze
- Chiamata all'azione prominente

## Struttura Comune

Tutti i template condividono elementi strutturali comuni:

1. **Header**: Logo e titoli principali
2. **Contenuto**: Corpo del messaggio con varie sezioni
3. **CTA**: Pulsanti di call-to-action
4. **Footer**: Informazioni di contatto, social, note legali

```html
<div class="container">
    <div class="header">
        <!-- Logo e titoli -->
    </div>
    
    <div class="content">
        <!-- Contenuto principale -->
        
        <div class="main-box">
            <!-- Box principale specifico del template -->
        </div>
        
        <!-- Altre sezioni -->
    </div>
    
    <div class="footer">
        <!-- Contatti, social, etc. -->
    </div>
</div>
```

## Variabili Disponibili

Tutti i template utilizzano il motore di templating Blade di Laravel. Le variabili disponibili sono configurabili dinamicamente e includono:

### Variabili Comuni a Tutti i Template

| Variabile | Descrizione | Default |
|-----------|-------------|---------|
| `$subject` | Oggetto dell'email | Definito nel controller |
| `$preheader` | Testo anteprima (visibile in alcuni client) | Varia per template |
| `$headline` | Titolo principale | Varia per template |
| `$subheadline` | Sottotitolo | Varia per template |
| `$name` | Nome destinatario | "Utente" |
| `$intro_text` | Testo introduttivo | Varia per template |
| `$outro_text` | Testo conclusivo | Varia per template |
| `$contact_email` | Email di contatto | "supporto@saluteora.it" |
| `$contact_phone` | Telefono di contatto | "+39 06 1234567" |
| `$office_hours` | Orari ufficio | "Lun-Ven: 9:00-19:00, Sab: 9:00-13:00" |

### Variabili Specifiche per Template

Ogni template ha ulteriori variabili specifiche documentate nei commenti del rispettivo file HTML.

## Integrazione con il Sistema

I template possono essere utilizzati attraverso il sistema di Queueable Actions integrato con spatie/laravel-mail-templates.

### Esempio di Utilizzo

```php
<?php

namespace Modules\Notify\Actions\Mail;

use Spatie\QueueableAction\QueueableAction;
use Modules\Notify\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

class SendAppointmentConfirmationAction
{
    use QueueableAction;

    public function execute(array $data)
    {
        $template = MailTemplate::where('mailable', 'appointment_confirmation')->first();
        
        // Prepara i dati per il template
        $templateData = [
            'name' => $data['patient_name'],
            'date' => $data['appointment_date'],
            'time' => $data['appointment_time'],
            'doctor' => $data['doctor_name'],
            'location' => $data['clinic_address'],
            'service' => $data['service_name'],
            // Altri dati specifici
        ];
        
        // Invia l'email
        Mail::to($data['patient_email'])
            ->send(new \Modules\Notify\Mail\AppointmentMail($template, $templateData));
            
        return true;
    }
}
```

## Best Practices

1. **Modifiche ai Template**:
   - Mantenere la struttura responsive e la compatibilità cross-client
   - Testare ogni modifica su [Email on Acid](https://www.emailonacid.com/) o [Litmus](https://www.litmus.com/)
   - Conservare il supporto per dark mode

2. **Contenuto Dinamico**:
   - Utilizzare sempre le variabili per contenuti personalizzati
   - Fornire valori predefiniti per tutte le variabili
   - Mantenere i testi concisi e scannerizzabili

3. **Immagini**:
   - Utilizzare immagini ottimizzate per email (max 600px di larghezza)
   - Sempre includere attributi `alt` per accessibilità
   - Preferire SVG per icone quando possibile

4. **Accessibilità**:
   - Mantenere un contrasto adeguato tra testo e sfondo
   - Utilizzare gerarchia di titoli logica (h1, h2, h3)
   - Assicurarsi che i link siano chiaramente identificabili

## File Correlati

- [HTML_EMAIL_COMPATIBILITY.md](./HTML_EMAIL_COMPATIBILITY.md) - Guide sulla compatibilità cross-client
- [EMAIL_BEST_PRACTICES.md](./EMAIL_BEST_PRACTICES.md) - Best practices per email transazionali
- [RESPONSIVE_EMAIL_TEMPLATES.md](../RESPONSIVE_EMAIL_TEMPLATES.md) - Guide dettagliate sul design responsive
- [MAILPACE_TEMPLATES_INTEGRATION.md](./MAILPACE_TEMPLATES_INTEGRATION.md) - Integrazione con template esterni
