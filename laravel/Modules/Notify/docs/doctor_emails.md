# Email per i Dottori

## Introduzione

Questo documento descrive le email specifiche per i dottori nel sistema. Queste email sono gestite attraverso il sistema di template email basato su spatie/laravel-database-mail-templates.

## Template Disponibili

### 1. Email di Benvenuto Dottore

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => 'Benvenuto, Dott. {{ surname }}',
    'html_template' => '
        <h1>Benvenuto!</h1>
        <p>Gentile Dott. {{ surname }},</p>
        <p>Grazie per esserti registrato alla nostra piattaforma.</p>
        <p>Per completare la registrazione e accedere al tuo pannello di controllo, clicca sul link seguente:</p>
        <a href="{{ verification_url }}">Verifica il tuo account</a>
        <p>Una volta verificato il tuo account, potrai:</p>
        <ul>
            <li>Gestire il tuo profilo professionale</li>
            <li>Visualizzare e gestire i tuoi appuntamenti</li>
            <li>Accedere alla cartella clinica dei tuoi pazienti</li>
            <li>Utilizzare gli strumenti di telemedicina</li>
        </ul>
    ',
    'text_template' => 'Benvenuto! Gentile Dott. {{ surname }}, grazie per esserti registrato.'
]);
```

### 2. Email di Ripresa Registrazione

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => 'Completa la tua registrazione, Dott. {{ surname }}',
    'html_template' => '
        <h1>Completa la tua registrazione</h1>
        <p>Gentile Dott. {{ surname }},</p>
        <p>Abbiamo notato che non hai completato la registrazione del tuo account.</p>
        <p>Per completare la registrazione e accedere a tutti i servizi, clicca sul link seguente:</p>
        <a href="{{ registration_url }}">Completa la registrazione</a>
        <p>Se hai bisogno di assistenza, non esitare a contattarci.</p>
    ',
    'text_template' => 'Gentile Dott. {{ surname }}, completa la tua registrazione cliccando su {{ registration_url }}'
]);
```

### 3. Email di Conferma Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => 'Nuovo appuntamento con {{ patient_name }}',
    'html_template' => '
        <h1>Nuovo Appuntamento</h1>
        <p>Gentile Dott. {{ surname }},</p>
        <p>Hai un nuovo appuntamento con {{ patient_name }} per il {{ appointment_date }} alle {{ appointment_time }}.</p>
        <p>Dettagli appuntamento:</p>
        <ul>
            <li>Paziente: {{ patient_name }}</li>
            <li>Data: {{ appointment_date }}</li>
            <li>Orario: {{ appointment_time }}</li>
            <li>Luogo: {{ appointment_location }}</li>
            <li>Motivo: {{ appointment_reason }}</li>
        </ul>
        <p>Per gestire l\'appuntamento, clicca sul link seguente:</p>
        <a href="{{ appointment_management_url }}">Gestisci appuntamento</a>
    ',
    'text_template' => 'Nuovo appuntamento con {{ patient_name }} per il {{ appointment_date }} alle {{ appointment_time }}'
]);
```

### 4. Email di Promemoria Appuntamento

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => 'Promemoria: appuntamento con {{ patient_name }}',
    'html_template' => '
        <h1>Promemoria Appuntamento</h1>
        <p>Gentile Dott. {{ surname }},</p>
        <p>Ti ricordiamo che domani hai un appuntamento con {{ patient_name }}.</p>
        <p>Dettagli appuntamento:</p>
        <ul>
            <li>Paziente: {{ patient_name }}</li>
            <li>Data: {{ appointment_date }}</li>
            <li>Orario: {{ appointment_time }}</li>
            <li>Luogo: {{ appointment_location }}</li>
            <li>Motivo: {{ appointment_reason }}</li>
        </ul>
        <p>Per gestire l\'appuntamento, clicca sul link seguente:</p>
        <a href="{{ appointment_management_url }}">Gestisci appuntamento</a>
    ',
    'text_template' => 'Promemoria: appuntamento con {{ patient_name }} domani alle {{ appointment_time }}'
]);
```

### 5. Email di Aggiornamento Profilo

```php
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => 'Aggiorna il tuo profilo professionale',
    'html_template' => '
        <h1>Aggiorna il tuo profilo</h1>
        <p>Gentile Dott. {{ surname }},</p>
        <p>Ti invitiamo ad aggiornare il tuo profilo professionale per migliorare la visibilità sul portale.</p>
        <p>Puoi aggiornare:</p>
        <ul>
            <li>La tua biografia professionale</li>
            <li>Le tue specializzazioni</li>
            <li>Gli orari di ricevimento</li>
            <li>Le tariffe</li>
            <li>Le foto del tuo studio</li>
        </ul>
        <p>Per aggiornare il tuo profilo, clicca sul link seguente:</p>
        <a href="{{ profile_update_url }}">Aggiorna profilo</a>
    ',
    'text_template' => 'Aggiorna il tuo profilo professionale cliccando su {{ profile_update_url }}'
]);
```

## Variabili Specifiche per i Dottori

- `{{ surname }}`: Cognome del dottore
- `{{ title }}`: Titolo professionale (Dott., Dott.ssa)
- `{{ specialization }}`: Specializzazione
- `{{ registration_number }}`: Numero di iscrizione all'albo
- `{{ office_address }}`: Indirizzo dello studio
- `{{ office_phone }}`: Telefono dello studio
- `{{ office_email }}`: Email dello studio

## Invio delle Email

Per inviare un'email a un dottore:

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

$doctor = Doctor::find(1);
Mail::to($doctor->email)->send(new SpatieEmail($doctor));
```

## Best Practices per le Email ai Dottori

1. **Formalità**: Mantenere un tono formale e professionale
2. **Privacy**: Non includere informazioni sensibili dei pazienti
3. **Chiarezza**: Fornire informazioni chiare e concise
4. **Personalizzazione**: Utilizzare i dati specifici del dottore
5. **Call-to-Action**: Includere sempre link chiari per le azioni richieste

## Gestione degli Errori

```php
try {
    Mail::to($doctor->email)->send(new SpatieEmail($doctor));
} catch (\Exception $e) {
    Log::error('Errore invio email al dottore: ' . $e->getMessage());
    // Notifica all'amministratore
    Notification::route('mail', config('mail.admin_address'))
        ->notify(new DoctorEmailError($doctor, $e));
}
```

## Collegamenti Correlati

- [Documentazione Root](../../../../docs/README.md)
- [Documentazione Modulo Notify](./README.md)
- [Documentazione Template Email](./EMAIL_TEMPLATES.md)
- [Guida all'utilizzo di SpatieEmail](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Documentazione Filament Resources](./filament-resources.md)
