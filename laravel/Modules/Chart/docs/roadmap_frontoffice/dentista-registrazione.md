# Registrazione Odontoiatra (Doctor)

## Introduzione
La registrazione dell'odontoiatra (doctor) è un processo centrale per garantire qualità, sicurezza e trasparenza nel sistema. Il flusso è progettato per essere rigoroso ma semplice, con attenzione a user experience, sicurezza, filosofia zen e collaborazione.

## Filosofia e Principi
- **Sicurezza e Verifica**: autenticità dei professionisti, protezione dati, verifica qualifiche
- **User Experience**: semplicità, feedback chiaro, assistenza
- **Efficienza**: automazione, riduzione tempi, workflow ottimizzato
- **Zen**: interfacce essenziali, focus su ciò che conta, niente superfluo
- **Collaborazione**: il professionista è partner, non solo utente

## Workflow di Registrazione
1. **Registrazione Iniziale**
   - Dati base (nome, email, telefono, documento, iscrizione albo)
   - Documenti professionali (laurea, iscrizione ordine, specializzazioni)
2. **Moderazione**
   - Verifica documenti, validazione dati, revisione team
3. **Completamento**
   - Email di conferma, link attivazione, configurazione profilo (studio, orari, tariffe)

## Implementazione Tecnica

### Pacchetti principali utilizzati
- **[tighten/parental](https://github.com/tighten/parental)** — Single Table Inheritance per User/Doctor
- **[spatie/laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/01-introduction)** — Gestione degli stati della registrazione
- **[spatie/laravel-queueable-action](https://spatie.be/docs/laravel-queueable-action/v2/introduction)** — Azioni asincrone
- **[filamentphp/filament](https://filamentphp.com/docs/3.x/panels/installation)** — UI e widget

### Gerarchia dei modelli aggiornata
- **BaseUser**: [BaseUser.php](../../laravel/Modules/User/app/Models/BaseUser.php) (estende Authenticatable)
- **User**: [User.php](../../laravel/Modules/Patient/app/Models/User.php) (**estende Modules\User\Models\BaseUser**)
- **Doctor**: [Doctor.php](../../laravel/Modules/Patient/app/Models/Doctor.php) (**estende User**, non Model/BaseModel)

> **Motivazione architetturale:**
> - Si usa tighten/parental per implementare la Single Table Inheritance (STI): tutti i tipi di utente (incluso Doctor) condividono la stessa tabella e la stessa logica base, ma possono avere comportamenti e proprietà specializzati.
> - La catena ereditaria garantisce coerenza, riuso, centralizzazione delle policy e delle relazioni, e semplifica la gestione dei permessi e delle query. **User di Patient estende BaseUser di User, Doctor estende User di Patient.**
> - **Mai estendere direttamente Model o BaseModel nei modelli child.**

#### Esempio di codice
```php
// Modules/User/app/Models/BaseUser.php
class BaseUser extends Authenticatable { /* ... */ }

// Modules/Patient/app/Models/User.php
namespace Modules\Patient\Models;
use Modules\User\Models\BaseUser;
class User extends BaseUser { /* ... */ }

// Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;
class Doctor extends User { /* ... */ }
```

Per approfondire: [Best Practices](../best-practices.md)

### File PHP principali
- **Widget Filament**: [RegistrationWidget.php](../../laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php)
- **Resource**: [DoctorResource.php](../../laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php)
- **Action**: [ProcessDoctorModerationAction.php](../../laravel/Modules/Patient/app/Actions/ProcessDoctorModerationAction.php)
- **Enum Stato**: [DoctorRegistrationState.php](../../laravel/Modules/Patient/app/States/DoctorRegistrationState.php)
- **Stati**: [Pending.php](../../laravel/Modules/Patient/app/States/Pending.php), [Approved.php](../../laravel/Modules/Patient/app/States/Approved.php), [Rejected.php](../../laravel/Modules/Patient/app/States/Rejected.php), [Active.php](../../laravel/Modules/Patient/app/States/Active.php)
- **Transizioni**: [ApproveDoctorTransition.php](../../laravel/Modules/Patient/app/States/Transitions/ApproveDoctorTransition.php), [RejectDoctorTransition.php](../../laravel/Modules/Patient/app/States/Transitions/RejectDoctorTransition.php)
- **Notifiche**: [RecordNotificationAction.php](../../laravel/Modules/Notify/app/Actions/RecordNotificationAction.php)
- **Traduzioni**: [LangServiceProvider.php](../../laravel/Modules/Dentist/app/Providers/LangServiceProvider.php)

### Come funziona
- **Single Table Inheritance** con Parental: Doctor estende User, User estende BaseUser
- **Stato della registrazione** gestito tramite Spatie Model States (classi PHP, transizioni, eventi)
- **Azioni asincrone** (validazione/moderazione) tramite QueueableAction
- **UI** realizzata con Filament Widget e Resource
- **Notifiche** inviate tramite RecordNotification
- **Traduzioni** gestite con LangServiceProvider

### Best Practice
- Ogni stato è una classe PHP
- Definire sempre le transizioni consentite
- Usare eventi per side-effect sulle transizioni
- Documentare la mappatura stato <-> classe
- Audit trail e trasparenza

### Link utili
- [Documentazione Spatie Model States](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [docs/spatie-model-states.md](../spatie-model-states.md)

### Esempio di implementazione aggiornata (Laravel 12+)
```php
use Spatie\ModelStates\HasStates;

class Doctor extends User
{
    use HasStates;

    protected function casts(): array
    {
        return [
            'registration_state' => DoctorRegistrationState::class,
        ];
    }
}
```
> **Nota:** Dal [manuale ufficiale Laravel 12.x](https://laravel.com/docs/12.x/eloquent-mutators), la proprietà `protected $casts` è deprecata. Usare sempre il metodo `protected function casts(): array` per definire i cast degli attributi.

## Possibile Evoluzione: Workflow Engine
Se in futuro la registrazione dovesse diventare un processo ancora più articolato (multi-step, ruoli, condizioni, scadenze, audit, ecc.), si potrà valutare l'introduzione di un workflow engine dedicato o una tabella separata per la gestione del processo.

## Percentuale di completamento
- Registrazione iniziale: 90%
- Moderazione: 95%
- Completamento: 90%

## Collegamenti
- [Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Dashboard Odontoiatra](./dentista-dashboard.md)
- [Documenti](./dentista-documenti.md)
- [Moderazione](./dentista-moderazione.md)
- [Disponibilità](./dentista-disponibilita.md)
- [Referti](./dentista-referti.md)
- [Rimborsi](./dentista-rimborsi.md)

## Note Tecniche e Best Practice
- Usare Filament per wizard e form
- Usare enum per tipi documento
- Usare RecordNotification per notifiche
- Gestire traduzioni con LangServiceProvider
- Validare dati e documenti in modo asincrono (QueueableAction)
- Gestire cache con Redis, queue per email, backup periodico
- Audit trail per tutte le operazioni
- GDPR compliance, crittografia documenti
- Approccio zen: semplicità, chiarezza, essenzialità
- Collaborazione: il professionista è parte attiva del sistema
- Consigli: documentare ogni step, testare UX, ascoltare feedback

## Gestione del Wizard: Interruzione e Ripresa tramite Link Email

### Flusso dettagliato
1. **Step 1:** Il dottore compila solo il primo step del wizard (dati base e documenti). Dopo l'invio, la registrazione si ferma e va in stato "pending" o "in moderazione".
2. **Moderazione:** Un moderatore verifica i dati/documenti. Se approvato, viene generato un token sicuro e inviato via email al dottore un link per continuare la registrazione.
3. **Ripresa:** Il dottore clicca il link ricevuto via email (con token). Il wizard si riapre dal secondo step (o dal punto in cui era stato fermato) e il dottore completa la registrazione.

### Implementazione tecnica in DoctorResource.php

```php
// Modules/Patient/app/Filament/Resources/DoctorResource.php

public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\Wizard::make([
            self::getPersonalInfoStep(),    // Step 0: dati base
            self::getModerationStep(),      // Step 1: moderazione
            self::getContactsStep(),        // Step 2: contatti
            self::getProfessionalStep(),    // Step 3: dati professionali
            self::getAvailabilityStep(),    // Step 4: disponibilità
        ])
        ->skippable(false)
        ->submitAction(new HtmlString(self::getSubmitButton()))
        ->columnSpan('full')
        ->persistStepInQueryString()
        ->startOnStep(
            fn () => request()->has('token')
                ? self::getStepFromToken(request('token'))
                : 0
        );
}

protected static function getStepFromToken(string $token): int
{
    $doctor = Doctor::where('registration_token', $token)->first();
    if ($doctor && $doctor->registration_state->equals(Approved::class)) {
        return 2; // Step contatti
    }
    return 0;
}
```

### Come funziona
- Dopo il primo step, la registrazione si ferma in stato "pending".
- Dopo la moderazione, se approvato, il dottore riceve una mail con link sicuro (token).
- Il link permette di riprendere la registrazione dal punto giusto.
- Il wizard di Filament usa `startOnStep` e una funzione custom per determinare lo step iniziale in base al token.

### Best practice
- Usare token sicuri e scadenza (es. signed URL, UUID, validità 48h).
- Validare sempre il token prima di permettere la continuazione.
- Salvare audit trail di ogni accesso e step completato.
- Inviare notifiche chiare e personalizzate.

### Collegamenti
- [Esempio implementazione Filament Wizard](../../laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php)
- [Documentazione Laravel Mutators/Casts](https://laravel.com/docs/12.x/eloquent-mutators)
- [Best Practices](../best-practices.md)

## Invio della mail con il link per continuare la registrazione

La mail con il link per continuare la registrazione viene inviata **dopo la moderazione**, quando il moderatore approva la richiesta del dottore.

### Flusso dettagliato
1. Il dottore compila il primo step del wizard e la registrazione va in stato "pending".
2. Un moderatore esamina i dati/documenti e, se tutto è corretto, approva la registrazione.
3. **Nel momento in cui la registrazione viene approvata**, viene generato un token sicuro (es. UUID) e salvato nel campo `registration_token` del modello Doctor.
4. Viene inviata una mail al dottore con un link del tipo:
   ```
   https://tuo-dominio/registrazione-dottore?token=TOKEN
   ```
5. Il dottore clicca il link e può continuare la registrazione dal punto giusto.

### File PHP coinvolto
- **Azione di moderazione**: [ProcessDoctorModerationAction.php](../../laravel/Modules/Patient/app/Actions/ProcessDoctorModerationAction.php)
  - In questo file, dopo l'approvazione, viene generato il token e inviata la mail tramite RecordNotification o una notifica custom.

### Esempio di codice (semplificato)
```php
// Modules/Patient/app/Actions/ProcessDoctorModerationAction.php
public function execute(Doctor $doctor, bool $approved, ...)
{
    if ($approved) {
        $doctor->registration_state->transitionTo(Approved::class);
        $doctor->registration_token = Str::uuid();
        $doctor->save();
        // Invio mail con link
        Notification::route('mail', $doctor->email)
            ->notify(new ContinueRegistrationNotification($doctor->registration_token));
    }
    // ...
}
```

### Best practice
- Il link deve essere sicuro, univoco e con scadenza.
- Salvare audit trail dell'invio e degli accessi tramite link.
- Personalizzare la mail con istruzioni chiare.

---

*Ultimo aggiornamento: {{date('d/m/Y')}}*
