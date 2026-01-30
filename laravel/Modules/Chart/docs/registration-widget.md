# Integrazione del Widget di Registrazione in <nome progetto>

## Panoramica

Questo documento descrive come il widget di registrazione generico del modulo User viene utilizzato e integrato specificamente nel progetto <nome progetto>. Il widget è progettato per essere riutilizzabile in diversi progetti, quindi questa documentazione si concentra sulle personalizzazioni e configurazioni specifiche per <nome progetto>.

## Posizione del File

```
/var/www/html/<nome progetto>/laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php
```

## Architettura

Il widget estende `XotBaseWidget` e implementa l'interfaccia `HasForms` per gestire i form di registrazione. È progettato per funzionare in modo modulare, adattandosi dinamicamente al tipo di utente che si sta registrando attraverso il parametro `$type`.

### Pattern Action

Il widget utilizza un pattern Action per delegare la logica di registrazione a classi specializzate. Questo approccio segue il principio di responsabilità singola e rende il codice più manutenibile e testabile.

Il widget determina dinamicamente quale azione utilizzare in base al tipo di utente, seguendo questa convenzione di naming:

```php
// Da namespace del modello a namespace dell'azione
$this->model = $this->resource::getModel();
$this->action = Str::of($this->model)->replace('\Models\', '\Actions\')->append('\RegisterAction')->toString();
```

Ad esempio:
- Per `Modules\Patient\Models\Doctor` → `Modules\Patient\Actions\Doctor\RegisterAction`
- Per `Modules\Patient\Models\Patient` → `Modules\Patient\Actions\Patient\RegisterAction`

Le azioni di registrazione sono implementate in modo semplice e diretto, utilizzando l'intero array di dati del form e impostando lo stato appropriato tramite gli enum:

```php
public function execute(array $data): Model
{
    // Imposta lo stato appropriato tramite enum
    $data['status'] = TipoStatus::VALORE->value;
    
    // Creazione dell'utente con tutti i dati del form
    $user = ModelClass::create($data);
    
    // Logica aggiuntiva specifica per il tipo di utente
    // ...
    
    return $user;
}
```

Per esempio, nell'azione di registrazione del paziente:

```php
// Modules\Patient\Actions\Patient\RegisterAction
public function execute(array $data): Patient
{
    // Imposta lo stato su APPROVED per i pazienti
    $data['status'] = PatientStatus::APPROVED->value;
    
    // Creazione del paziente
    $patient = Patient::create($data);
    
    // ...
}
```

E nell'azione di registrazione del dottore:

```php
// Modules\Patient\Actions\Doctor\RegisterAction
public function execute(array $data): Doctor
{
    // Imposta lo stato su PENDING per i dottori (richiedono moderazione)
    $data['status'] = DoctorStatus::PENDING->value;
    
    // Creazione del dottore
    $doctor = Doctor::create($data);
    
    // ...
}
```

## Campi Richiesti per la Registrazione

Per la registrazione del dottore, è essenziale raccogliere almeno i seguenti campi:

```php
// Modules\Patient\Filament\Resources\DoctorResource
protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('personal_info')
        ->schema([
            'personal_section' => Forms\Components\Section::make()
                ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')->required(),
                    'last_name' => Forms\Components\TextInput::make('last_name')->required(),
                    'email' => Forms\Components\TextInput::make('email')->required()->email(),
                    // Altri campi...
                ]),
        ]);
}
```

**Nota importante**: È fondamentale raccogliere l'indirizzo email durante la registrazione, poiché viene utilizzato per inviare notifiche importanti all'utente, come la conferma della registrazione e gli aggiornamenti sullo stato della moderazione.

## Caratteristiche Principali

1. **Flessibilità Multi-Tipo**: Il widget può gestire la registrazione di diversi tipi di utenti (pazienti, dottori, ecc.)
2. **Integrazione con XotData**: Utilizza `XotData::make()->getUserResourceClassByType($type)` per determinare la classe Resource appropriata
3. **Form Schema Dinamico**: Ottiene lo schema del form dalla Resource corrispondente al tipo di utente
4. **Gestione Stati**: Deve integrarsi con il sistema di stati specifico per ogni tipo di utente

## Integrazione con <nome progetto>

In <nome progetto>, il widget di registrazione viene utilizzato per diversi tipi di utenti attraverso un sistema di azioni specializzate. Questo approccio permette di:

1. **Separare le Responsabilità**: Ogni tipo di utente ha la propria azione di registrazione
2. **Semplificare il Widget**: Il widget si limita a delegare la logica all'azione appropriata
3. **Facilitare i Test**: Le azioni possono essere testate indipendentemente dal widget
4. **Migliorare la Manutenibilità**: Modifiche alla logica di registrazione non richiedono modifiche al widget

### Integrazione con il Workflow del Dottore

Per la registrazione del dottore in <nome progetto>, il widget deve integrarsi con il workflow di registrazione specifico:

1. **Raccolta Dati Iniziali**: Il widget raccoglie i dati di base del dottore (nome, email, certificazione)
2. **Creazione Record**: I dati vengono salvati nel modello `Doctor` con lo stato iniziale `Pending`
3. **Workflow di Moderazione**: Viene creato un workflow di registrazione con stato `PENDING_MODERATION`
4. **Notifica**: Il sistema invia un'email di conferma utilizzando il template `registration_pending`
5. **Moderazione**: Un amministratore esamina la richiesta (questa fase è gestita da `DoctorResource`)
6. **Continuazione**: Se approvato, il dottore riceve un'email con un link per continuare la registrazione

### Gestione dei Diversi Tipi di Utenti in <nome progetto>

In <nome progetto>, il widget gestisce diversi tipi di utenti con flussi di registrazione specifici:

#### Registrazione Dottori
- Lo stato iniziale è `Pending` (richiede moderazione)
- Viene creato un workflow di registrazione con stato `PENDING_MODERATION`
- Il sistema invia un'email di conferma con template `registration_pending`
- Dopo la moderazione, il dottore riceve un'email per completare la registrazione

#### Registrazione Pazienti
- Lo stato iniziale è `Active` (non richiede moderazione)
- Non necessita di un workflow di registrazione
- Il sistema invia un'email di benvenuto con template `patient_welcome`
- L'account è immediatamente utilizzabile

## Integrazione con il Sistema di Stati di <nome progetto>

<nome progetto> utilizza `spatie/laravel-model-states` per gestire gli stati degli utenti in modo type-safe. Il widget di registrazione deve integrarsi con questo sistema, utilizzando le classi di stato appropriate per ogni tipo di utente.

Per i dottori, le classi di stato si trovano in `Modules\Patient\States\` e includono stati come `Pending`, `Approved`, `Rejected` e `Active`.

## Sistema di Notifiche in <nome progetto>

Il widget utilizza `SpatieEmail` per inviare notifiche agli utenti. Questo sistema permette:

1. **Template Localizzati**: Supporto per email in diverse lingue
2. **Template nel Database**: I template sono memorizzati nel database e possono essere modificati senza toccare il codice
3. **Personalizzazione Dinamica**: I dati dell'utente vengono inseriti dinamicamente nel template
4. **Allegati**: Possibilità di allegare documenti alle email

## Template Email in <nome progetto>

In <nome progetto>, i template email per la registrazione sono gestiti attraverso il modello `MailTemplate` del modulo Notify. Questi template sono memorizzati nel database e possono essere modificati senza toccare il codice.

I template principali utilizzati nel processo di registrazione includono:

1. **registration_pending**: Inviato ai dottori dopo la registrazione iniziale
2. **registration_moderated**: Inviato ai dottori dopo l'approvazione della moderazione
3. **patient_welcome**: Inviato ai pazienti dopo la registrazione

Ogni template supporta la localizzazione con versioni in italiano e inglese, e include variabili dinamiche come:

- `{{ full_name }}`: Nome completo dell'utente
- `{{ email }}`: Indirizzo email dell'utente
- `{{ continue_url }}`: URL per continuare la registrazione (solo per dottori approvati)
- `{{ status }}`: Stato della registrazione
- `{{ rejection_reason }}`: Motivo del rifiuto (se applicabile)

## Integrazione con <nome progetto>: Considerazioni Tecniche

Per garantire che il widget di registrazione funzioni correttamente nel contesto di <nome progetto>, è importante considerare alcuni aspetti tecnici specifici:

1. **Gestione Multi-Tenant**: <nome progetto> utilizza un'architettura multi-tenant, quindi il widget deve essere configurato per creare utenti nel tenant corretto

2. **Integrazione con Filament**: Il widget deve integrarsi con l'interfaccia Filament utilizzata in <nome progetto>, mantenendo la coerenza visiva e funzionale

3. **Localizzazione**: <nome progetto> supporta italiano e inglese, quindi il widget deve utilizzare il sistema di localizzazione per adattarsi alla lingua dell'utente

4. **Sicurezza**: Implementare le validazioni appropriate per garantire la sicurezza dei dati, specialmente per i dottori che caricano documenti di certificazione

5. **Tracciabilità**: Registrare le azioni di registrazione nel sistema di log per consentire l'audit e il debugging

## Vantaggi dell'Integrazione in <nome progetto>

1. **Esperienza Utente Unificata**: Processo di registrazione coerente per tutti i tipi di utenti

2. **Flusso di Moderazione Controllato**: I dottori passano attraverso un processo di moderazione ben definito prima di poter accedere al sistema

3. **Comunicazione Automatizzata**: Gli utenti ricevono automaticamente email appropriate in base al loro tipo e allo stato della registrazione

4. **Gestione Stati Type-Safe**: L'utilizzo di `spatie/laravel-model-states` garantisce transizioni di stato sicure e prevedibili

5. **Facilità di Manutenzione**: La separazione delle responsabilità tra widget, resource e azioni rende il codice più manutenibile

## Collegamenti Bidirezionali

- [Email Doctor Registration](/var/www/html/<nome progetto>/docs/email-doctor-registration.md)
- [Registrazione Odontoiatra](/var/www/html/<nome progetto>/docs/roadmap_frontoffice/13-registrazione-odontoiatra.md)
- [DoctorResource](/var/www/html/<nome progetto>/laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php)
- [RegistrationWidget](/var/www/html/<nome progetto>/laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php)
