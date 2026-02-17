# Sistema di Email Template

## Introduzione

Il modulo Notify implementa un sistema avanzato di gestione delle email template basato su [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates). Questo sistema permette di gestire e personalizzare facilmente i template delle email direttamente dal database.

## 🚨 Errore Critico Identificato

**Data**: 26 Giugno 2025  
**Errore**: `MissingMailTemplate` durante registrazione pazienti  
**Status**: CRITICO - Sistema registrazione bloccato  

➡️ **Documentazione completa**: [<nome progetto>: Missing Mail Template Error](../../<nome progetto>/docs/errori/missing-mail-template-spatiemail.md)  
➡️ **Pattern globali**: [Missing Mail Template Patterns](../../../docs/errori_gravi/missing-mail-template-patterns.md)
➡️ **Documentazione completa**: [SaluteOra: Missing Mail Template Error](../../SaluteOra/docs/errori/missing-mail-template-spatiemail.md)  
➡️ **Pattern globali**: [Missing Mail Template Patterns](../../../docs/errori_gravi/missing-mail-template-patterns.md)➡️ **Documentazione completa**: [SaluteOra: Missing Mail Template Error](../../SaluteOra/project_docs/errori/missing-mail-template-spatiemail.md)  
➡️ **Pattern globali**: [Missing Mail Template Patterns](../../../project_docs/errori_gravi/missing-mail-template-patterns.md)

### Fix Immediato

Per risolvere immediatamente il problema di registrazione:

```bash

# 1. Creare seeder per template critici
php artisan make:seeder CriticalMailTemplatesSeeder

# 2. Eseguire seeder
php artisan db:seed --class=CriticalMailTemplatesSeeder

# 3. Verificare template
php artisan tinker
>>> \Modules\Notify\Models\MailTemplate::where('slug', 'patient-pending')->exists()
```

## Struttura del Sistema

### Componenti Principali

1. **SpatieEmail** (`app/Emails/SpatieEmail.php`)
   - Classe base per l'invio di email template
   - Gestisce il layout HTML e i dati aggiuntivi
   - Supporta la personalizzazione del layout
   - Supporta l'identificazione dei template tramite slug
   - ⚠️ **ATTENZIONE**: Constructor può fallire se template mancante

2. **MailTemplate** (`app/Models/MailTemplate.php`)
   - Model per la gestione dei template nel database
   - Supporta traduzioni multilingua
   - Gestisce versioni dei template
   - Traccia i log delle email inviate
   - Include identificatore slug per i template
   - ⚠️ **ATTENZIONE**: Richiede pre-creazione per template critici

### Database

La tabella `mail_templates` contiene:
- `mailable`: Classe Mailable associata
- `subject`: Oggetto dell'email (traducibile)
- `html_template`: Template HTML (traducibile)
- `text_template`: Template testo (traducibile)
- `version`: Versione corrente del template
- `slug`: Identificatore univoco del template

## Utilizzo Pratico

### 1. Creazione di un Template Email

```php
// Esempio: Template Email di Benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'welcome-email',
    'subject' => [
        'it' => 'Benvenuto, {{ first_name }}!',
        'en' => 'Welcome, {{ first_name }}!'
    ],
    'html_template' => [
        'it' => '
            <h1>Benvenuto!</h1>
            <p>Ciao {{ first_name }},</p>
            <p>Grazie per esserti registrato.</p>
            <p>Puoi accedere al tuo account utilizzando le credenziali che hai fornito.</p>
        ',
        'en' => '
            <h1>Welcome!</h1>
            <p>Hello {{ first_name }},</p>
            <p>Thank you for registering.</p>
            <p>You can access your account using the credentials you provided.</p>
        '
    ]
]);

// ✅ TEMPLATE CRITICI - Registrazione Pazienti
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'patient-pending',
    'subject' => ['it' => 'Registrazione in attesa di approvazione'],
    'html_template' => ['it' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione è in attesa di approvazione.</p>'],
    'text_template' => ['it' => 'La tua registrazione è in attesa di approvazione.']
]);

MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'patient-active',
    'subject' => ['it' => 'Account attivato con successo'],
    'html_template' => ['it' => '<p>Gentile {{ first_name }},</p><p>Il tuo account è stato attivato.</p>'],
    'text_template' => ['it' => 'Il tuo account è stato attivato.']
]);
```

### 2. Invio di Email

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

// ✅ CORRETTO - Con validazione slug
try {
    $user = User::find(1);
    
    // Verifica esistenza template prima dell'invio
    if (!\Modules\Notify\Models\MailTemplate::where('slug', 'welcome-email')->exists()) {
        throw new \Exception('Template welcome-email non trovato');
    }
    
    Mail::to($user->email)->send(new SpatieEmail($user, 'welcome-email'));
} catch (\Exception $e) {
    \Log::error('Email sending failed', ['error' => $e->getMessage()]);
}

// ❌ ERRATO - Senza validazione (può causare MissingMailTemplate)
$user = User::find(1);
Mail::to($user->email)->send(new SpatieEmail($user, 'welcome-email'));
```

### 3. Personalizzazione del Layout

Per personalizzare il layout HTML delle email, modifica il metodo `getHtmlLayout()` in `SpatieEmail`:

```php
public function getHtmlLayout(): string
{
    return view('emails.layouts.main', [
        'siteName' => config('app.name'),
        'year' => date('Y')
    ])->render();
}
```

## Best Practices

1. **Prevenzione Errori MissingMailTemplate** ⚠️ **CRITICO**
   - **SEMPRE** creare seeder per template critici
   - **SEMPRE** validare esistenza template prima dell'invio
   - **SEMPRE** implementare fallback per template mancanti
   - **MAI** generare slug dinamici senza validazione

2. **Gestione delle Versioni**
   - Utilizzare il sistema di versioning per tracciare le modifiche ai template
   - Documentare le modifiche significative
   - Mantenere lo slug costante tra le versioni

3. **Traduzioni**
   - Mantenere sempre le traduzioni in italiano e inglese
   - Utilizzare chiavi di traduzione coerenti
   - Utilizzare lo slug come chiave di traduzione quando appropriato

4. **Variabili nei Template**
   - Utilizzare nomi descrittivi per le variabili
   - Documentare tutte le variabili disponibili
   - Validare la presenza delle variabili richieste

5. **Testing**
   - Testare i template con dati reali
   - Verificare il rendering in diversi client email
   - Controllare le traduzioni in tutte le lingue supportate

6. **Gestione degli Slug**
   - Utilizzare kebab-case per gli slug
   - Mantenere gli slug brevi e descrittivi
   - Evitare caratteri speciali
   - Verificare l'unicità degli slug
   - **✅ NUOVO**: Implementare validazione slug robusti

## Template Critici per il Sistema

### Template di Registrazione (PRIORITÀ URGENTE)

Questi template DEVONO esistere per il funzionamento del sistema:

```php
// Paziente - Stati registrazione
'patient-pending'     // Registrazione in attesa
'patient-active'      // Account attivato
'patient-rejected'    // Registrazione respinta

// Dottore - Stati registrazione  
'doctor-pending'      // Registrazione in verifica
'doctor-active'       // Account dottore attivato
'doctor-rejected'     // Registrazione respinta

// Sistema - Template fallback
'system-notification' // Notifica generica
'default-notification' // Template di emergenza
```

## Esempi di Template Comuni

### 1. Conferma Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-confirmation',
    'subject' => [
        'it' => 'Conferma Appuntamento: {{ appointment_date }}',
        'en' => 'Appointment Confirmation: {{ appointment_date }}'
    ],
    'html_template' => [
        'it' => '
            <h1>Conferma Appuntamento</h1>
            <p>Gentile {{ first_name }},</p>
            <p>Il tuo appuntamento è stato confermato per il {{ appointment_date }} alle {{ appointment_time }}.</p>
            <p>Dottore: {{ doctor_name }}</p>
            <p>Servizio: {{ service_name }}</p>
            <p>Per modificare o cancellare l\'appuntamento, accedi al tuo account.</p>
        '
    ]
]);
```

### 2. Promemoria Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-reminder',
    'subject' => [
        'it' => 'Promemoria: Appuntamento domani',
        'en' => 'Reminder: Appointment tomorrow'
    ],
    'html_template' => [
        'it' => '
            <h1>Promemoria Appuntamento</h1>
            <p>Gentile {{ first_name }},</p>
            <p>Ti ricordiamo il tuo appuntamento di domani:</p>
            <p>Data: {{ appointment_date }}</p>
            <p>Ora: {{ appointment_time }}</p>
            <p>Dottore: {{ doctor_name }}</p>
            <p>Servizio: {{ service_name }}</p>
        '
    ]
]);
```

## Troubleshooting

### Problemi Comuni

1. **🚨 CRITICO: MissingMailTemplate Exception**
   ```
   Spatie\MailTemplates\Exceptions\MissingMailTemplate
   No mail template exists for mailable `SpatieEmail`.
   ```
   
   **Soluzioni**:
   - Eseguire `CriticalMailTemplatesSeeder`
   - Verificare esistenza template con `php artisan mail:check-templates`
   - Implementare validazione slug nelle Actions
   - ➡️ [Documentazione completa errore](../../<nome progetto>/docs/errori/missing-mail-template-spatiemail.md)
   - ➡️ [Documentazione completa errore](../../SaluteOra/docs/errori/missing-mail-template-spatiemail.md)
   - ➡️ [Documentazione completa errore](../../SaluteOra/project_docs/errori/missing-mail-template-spatiemail.md)
   - ➡️ [Documentazione completa errore](../../SaluteOra/docs/errori/missing-mail-template-spatiemail.md)   - ➡️ [Documentazione completa errore](../../SaluteOra/project_docs/errori/missing-mail-template-spatiemail.md)

2. **Template non trovato**
   - Verificare che il template esista nel database
   - Controllare che la classe Mailable sia corretta
   - **NUOVO**: Controllare che lo slug sia corretto e non vuoto

3. **Variabili mancanti**
   - Assicurarsi che tutti i dati necessari siano passati al costruttore
   - Verificare i nomi delle variabili nel template

4. **Problemi di traduzione**
   - Controllare che tutte le traduzioni necessarie siano presenti
   - Verificare la configurazione della lingua corrente

### Comandi Utili per Debug

```bash

# Verifica template esistenti
php artisan tinker
>>> \Modules\Notify\Models\MailTemplate::where('mailable', 'like', '%SpatieEmail%')->get(['id', 'slug', 'subject'])

# Verifica template specifico
>>> \Modules\Notify\Models\MailTemplate::where('slug', 'patient-pending')->exists()

# Test invio email
>>> Mail::to('test@example.com')->send(new \Modules\Notify\Emails\SpatieEmail(User::first(), 'patient-pending'))
```

## Collegamenti Correlati

### **Errori Critici e Soluzioni**
- [<nome progetto>: Missing Mail Template Error](../../<nome progetto>/docs/errori/missing-mail-template-spatiemail.md) - **URGENT**
- [SaluteOra: Missing Mail Template Error](../../SaluteOra/docs/errori/missing-mail-template-spatiemail.md) - **URGENT**
- [Missing Mail Template Patterns](../../../docs/errori_gravi/missing-mail-template-patterns.md) - Pattern globali
- [Array to String Conversion](../../../docs/errori_gravi/array-to-string-conversion-patterns.md) - Errore correlato

### **Documentazione Tecnica**
- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Gestione Traduzioni](../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Configurazione Email](../../../docs/email-configuration.md)
- [SaluteOra: Missing Mail Template Error](../../SaluteOra/project_docs/errori/missing-mail-template-spatiemail.md) - **URGENT**
- [Configurazione Email](../../../docs/email-configuration.md)- [SaluteOra: Missing Mail Template Error](../../SaluteOra/project_docs/errori/missing-mail-template-spatiemail.md) - **URGENT**
- [Missing Mail Template Patterns](../../../project_docs/errori_gravi/missing-mail-template-patterns.md) - Pattern globali
- [Array to String Conversion](../../../project_docs/errori_gravi/array-to-string-conversion-patterns.md) - Errore correlato

### **Documentazione Tecnica**
- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Gestione Traduzioni](../Lang/project_docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Configurazione Email](../../../project_docs/email-configuration.md)
- [Documentazione Traduzioni](./translations.md)
- [Proposta Slug Template](./EMAIL_TEMPLATE_SLUG_PROPOSAL.md)
- [Notify Module Index](./INDEX.md)
- [Architecture Overview](./ARCHITECTURE.md)
- [Notification Channels Implementation](./NOTIFICATION_CHANNELS_IMPLEMENTATION.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [Troubleshooting](./TROUBLESHOOTING.md)

---

**Ultimo aggiornamento**: 26 Giugno 2025  
**Status**: Aggiornato per errore critico MissingMailTemplate  
**Priorità**: URGENT - Fix sistema registrazione
