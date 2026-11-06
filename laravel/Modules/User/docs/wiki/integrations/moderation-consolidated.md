---
title: "moderation: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "moderation   consolidated documentation user"
---

# moderation: Consolidated Documentation

Consolidated from **8** individual files.

## Table of Contents

- [---](#moderation-actions)
- [---](#moderation-contracts)
- [---](#moderation-doctor)
- [---](#moderation-notifications)
- [---](#moderation-wizard-generic)
- [Moderazione Dentista dal Modulo User](#moderation_doctor)
- [Moderazione e Wizard di Registrazione Generici per User](#moderation_wizard_generic)
- [---](#moderationor)

---

## moderation-actions

*Consolidated from: `moderation-actions.md`*

description:
globs:
alwaysApply: false
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---
# Azioni di Moderazione (Action class)

## Introduzione
Tutte le operazioni di business logic relative alla moderazione sono implementate tramite Action class secondo [spatie/laravel-queueable-action](mdc:https:/github.com/spatie/laravel-queueable-action), mai tramite Service class.

## Pattern Consigliati
- Ogni azione (approvazione, rifiuto, richiesta integrazione, ecc.) deve essere una Action class
- Le action devono essere queueable per gestire carichi elevati
- Ogni action deve loggare l'attività tramite activitylog
- Le action devono accettare come parametro ModeratableUser

## Esempio di Action
```php
use Spatie\QueueableAction\QueueableAction;
use Spatie\Activitylog\Traits\LogsActivity;

class ApproveUserAction
{
    use QueueableAction;
    use LogsActivity;

    public function execute(ModeratableUser $user): void
    {
        $user->setState('approved');
        $user->save();
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['reason' => 'approved by moderator'])
            ->log('User approved');
        // notifica...
    }
}
```

## Errori Comuni da Evitare
- Usare Service class invece di Action class
- Non loggare l'attività
- Non accettare ModeratableUser come parametro

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)

---

## moderation-contracts

*Consolidated from: `moderation-contracts.md`*

description:
globs:
alwaysApply: false
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---
# Contratti e Interfacce per la Moderazione Utenti

## Introduzione
Per garantire la riusabilità e la neutralità del modulo User, tutte le entità moderabili devono implementare un contract/interfaccia comune.

## Esempio di Interfaccia
```php
interface ModeratableUser
{
    public function getModerationData(): array;
    public function setState(string $state): void;
    public function getType(): string;
}
```

## Motivazione
- Permette di gestire la moderazione in modo generico e centralizzato
- Facilita l'estensione a nuovi tipi di utente
- Consente l'integrazione con action, policy, notifiche e activitylog

## Best Practice
- Ogni model che può essere moderato deve implementare questa interfaccia
- Le action di moderazione devono accettare come parametro ModeratableUser

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Notifiche Moderazione](mdc:MODERATION_NOTIFICATIONS.mdc)

---

## moderation-doctor

*Consolidated from: `moderation-doctor.md`*

title: "Moderazione Dentista dal Modulo User"
type: concept
tags: [moderation, doctor]
created: 2026-07-14
updated: 2026-07-14
qmd: "moderation-doctor moderazione dentista dal modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Moderazione Dentista dal Modulo User

## Premessa
La moderazione del dentista, pur essendo più articolata rispetto ad altri utenti, può essere gestita direttamente dal modulo User, centralizzando la logica e mantenendo la coerenza con il sistema di autenticazione e gestione utenti.

## Flusso Proposto
1. **Registrazione Dentista**
   - Il dentista compila il form di registrazione (wizard multi-step).
   - Al termine del primo step, lo stato viene impostato su `pending_moderation`.
   - I dati vengono salvati in una tabella di workflow (es. `doctor_registration_workflows`).

2. **Moderazione**
   - Un moderatore riceve una notifica (email/dashboard) di nuova richiesta.
   - Il moderatore accede a una dashboard Filament (User Panel) e visualizza i dettagli del dentista.
   - Può approvare, rifiutare o richiedere integrazioni, aggiungendo note di moderazione.
   - La transizione di stato avviene tramite enum e azioni dedicate (es. `ApproveDoctorAction`, `RejectDoctorAction`).

3. **Notifiche e Ripresa Flusso**
   - Se approvato, il dentista riceve una email con link sicuro per riprendere la registrazione.
   - Se rifiutato, riceve una email con motivazione e possibilità di correggere i dati.
   - Il wizard verifica lo stato e consente la ripresa solo se `approved`.

## Struttura Tecnica
- **Enum Stato:** `DoctorStatus` (pending, approved, rejected)
- **Workflow Model:** `DoctorRegistrationWorkflow` (relazione 1:1 con User/Doctor)
- **Azioni:**
  - `ApproveDoctorAction`
  - `RejectDoctorAction`
  - `RequestIntegrationDoctorAction`
- **Notifiche:**
  - `DoctorApprovedNotification`
  - `DoctorRejectedNotification`
  - `DoctorIntegrationRequestedNotification`
- **Policy:**
  - Solo utenti con ruolo moderatore possono cambiare stato
- **Dashboard Filament:**
  - Lista richieste in attesa, dettagli, azioni rapide
- **Eventi/Listener:**
  - Eventi per transizioni di stato, listener per invio notifiche

## Percentuali di Riuso
- **Riuso logica e componenti:** 60-70% rispetto a una soluzione centralizzata (molta logica di moderazione è simile a quella di altri utenti, ma con step e dati specifici per i dentisti)
- **Duplicazione:** 30-40% (alcuni step, notifiche e validazioni sono specifici per i dentisti)

## Motivazioni della Scelta
- **Centralizzazione:** Tutta la logica di moderazione utenti (inclusi i dentisti) è gestita in User, facilitando audit, policy e gestione permessi.
- **Estendibilità:** In futuro, la logica può essere estratta in un modulo Moderation se la complessità cresce.
- **Coerenza UX:** Un'unica dashboard per la moderazione di tutti gli utenti.
- **Performance:** Meno query cross-modulo, gestione diretta delle relazioni User/Doctor.

## Esempio di Implementazione

```php
// Enum Stato
enum DoctorStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Action di approvazione
class ApproveDoctorAction {
    public function execute(Doctor $doctor): void {
        $doctor->status = DoctorStatus::APPROVED;
        $doctor->save();
        $doctor->notify(new DoctorApprovedNotification());
    }
}

// Policy
class DoctorPolicy {
    public function moderate(User $user): bool {
        return $user->hasRole('moderator');
    }
}
```

## Roadmap
1. Analisi flussi esistenti e refactoring azioni/modelli
2. Implementazione dashboard Filament per moderazione
3. Definizione policy e permessi
4. Test end-to-end e aggiornamento documentazione

---

**Nota:** Se la complessità della moderazione dovesse aumentare (es. moderazione multi-ruolo, workflow avanzati), valutare la migrazione verso un modulo Moderation dedicato. 

---

## moderation-notifications

*Consolidated from: `moderation-notifications.md`*

description:
globs:
alwaysApply: false
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---
# Notifiche Moderazione

## Introduzione
Tutte le notifiche relative alla moderazione (approvazione, rifiuto, richiesta integrazione, ecc.) devono essere implementate come Notification class Laravel, localizzate e prive di riferimenti hard-coded.

## Pattern Consigliati
- Ogni evento di moderazione deve generare una notifica specifica
- Le notifiche devono essere localizzate tramite i file lang
- Le notifiche devono essere inviate tramite action
- Le notifiche devono essere tracciate tramite activitylog

## Esempio di Notifica
```php
use Illuminate\Notifications\Notification;

class UserApprovedNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('user::notifications.approved.subject'))
            ->line(__('user::notifications.approved.body'));
    }
}
```

## Errori Comuni da Evitare
- Non localizzare i messaggi
- Inviare notifiche direttamente dal controller invece che tramite action
- Non tracciare l'invio tramite activitylog

## Collegamenti correlati
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Azioni di Moderazione](mdc:MODERATION_ACTIONS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)

---

## moderation-wizard-generic

*Consolidated from: `moderation-wizard-generic.md`*

module: theme
topic: moderation-wizard-generic
canonical: ../../../Themes/docs/shared-components/moderation-wizard-generic.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/moderation-wizard-generic.md

---

## moderation_doctor

*Consolidated from: `moderation_doctor.md`*


## Premessa
La moderazione del dentista, pur essendo più articolata rispetto ad altri utenti, può essere gestita direttamente dal modulo User, centralizzando la logica e mantenendo la coerenza con il sistema di autenticazione e gestione utenti.

## Flusso Proposto
1. **Registrazione Dentista**
   - Il dentista compila il form di registrazione (wizard multi-step).
   - Al termine del primo step, lo stato viene impostato su `pending_moderation`.
   - I dati vengono salvati in una tabella di workflow (es. `doctor_registration_workflows`).

2. **Moderazione**
   - Un moderatore riceve una notifica (email/dashboard) di nuova richiesta.
   - Il moderatore accede a una dashboard Filament (User Panel) e visualizza i dettagli del dentista.
   - Può approvare, rifiutare o richiedere integrazioni, aggiungendo note di moderazione.
   - La transizione di stato avviene tramite enum e azioni dedicate (es. `ApproveDoctorAction`, `RejectDoctorAction`).

3. **Notifiche e Ripresa Flusso**
   - Se approvato, il dentista riceve una email con link sicuro per riprendere la registrazione.
   - Se rifiutato, riceve una email con motivazione e possibilità di correggere i dati.
   - Il wizard verifica lo stato e consente la ripresa solo se `approved`.

## Struttura Tecnica
- **Enum Stato:** `DoctorStatus` (pending, approved, rejected)
- **Workflow Model:** `DoctorRegistrationWorkflow` (relazione 1:1 con User/Doctor)
- **Azioni:**
  - `ApproveDoctorAction`
  - `RejectDoctorAction`
  - `RequestIntegrationDoctorAction`
- **Notifiche:**
  - `DoctorApprovedNotification`
  - `DoctorRejectedNotification`
  - `DoctorIntegrationRequestedNotification`
- **Policy:**
  - Solo utenti con ruolo moderatore possono cambiare stato
- **Dashboard Filament:**
  - Lista richieste in attesa, dettagli, azioni rapide
- **Eventi/Listener:**
  - Eventi per transizioni di stato, listener per invio notifiche

## Percentuali di Riuso
- **Riuso logica e componenti:** 60-70% rispetto a una soluzione centralizzata (molta logica di moderazione è simile a quella di altri utenti, ma con step e dati specifici per i dentisti)
- **Duplicazione:** 30-40% (alcuni step, notifiche e validazioni sono specifici per i dentisti)

## Motivazioni della Scelta
- **Centralizzazione:** Tutta la logica di moderazione utenti (inclusi i dentisti) è gestita in User, facilitando audit, policy e gestione permessi.
- **Estendibilità:** In futuro, la logica può essere estratta in un modulo Moderation se la complessità cresce.
- **Coerenza UX:** Un'unica dashboard per la moderazione di tutti gli utenti.
- **Performance:** Meno query cross-modulo, gestione diretta delle relazioni User/Doctor.

## Esempio di Implementazione

```php
// Enum Stato
enum DoctorStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Action di approvazione
class ApproveDoctorAction {
    public function execute(Doctor $doctor): void {
        $doctor->status = DoctorStatus::APPROVED;
        $doctor->save();
        $doctor->notify(new DoctorApprovedNotification());
    }
}

// Policy
class DoctorPolicy {
    public function moderate(User $user): bool {
        return $user->hasRole('moderator');
    }
}
```

## Roadmap
1. Analisi flussi esistenti e refactoring azioni/modelli
2. Implementazione dashboard Filament per moderazione
3. Definizione policy e permessi
4. Test end-to-end e aggiornamento documentazione

---

**Nota:** Se la complessità della moderazione dovesse aumentare (es. moderazione multi-ruolo, workflow avanzati), valutare la migrazione verso un modulo Moderation dedicato. 

---

## moderation_wizard_generic

*Consolidated from: `moderation_wizard_generic.md`*


## Premessa
Nel contesto di un modulo User riutilizzabile in più progetti, ogni "tipo" di utente (es. paziente, dentista, operatore, admin) è rappresentato da un model che estende/parente il modello base User tramite pattern Single Table Inheritance (STI) o Parental. Di conseguenza, sia il wizard di registrazione che la moderazione devono essere progettati in modo generico, senza riferimenti a domini specifici.

## Analisi e Ragionamento
- **User è la radice di tutti i tipi di utente**: ogni flusso di registrazione e moderazione deve essere agnostico rispetto al tipo.
- **Il wizard di registrazione** deve essere configurabile (schema dinamico, step dinamici) in base al tipo di utente, ma la logica di base (validazione, salvataggio, avanzamento step, gestione stato) deve essere unica.
- **La moderazione** deve essere centralizzata: ogni utente può essere soggetto a moderazione, indipendentemente dal tipo. Le policy, le azioni, le notifiche e la dashboard devono essere generiche e configurabili.
- **Nessun riferimento hard-coded** a "paziente", "dentista" ecc. Tutto deve essere guidato da configurazione, enum, contract/interfacce.

## Struttura Tecnica Proposta
- **Enum Stato Generico:** `UserModerationStatus` (pending, approved, rejected, integration_requested, ...)
- **Workflow Model Generico:** `UserRegistrationWorkflow` (relazione 1:1 con User, campi generici: current_step, status, notes, started_at, completed_at, session_id)
- **Azioni Generiche:**
  - `ApproveUserAction`
  - `RejectUserAction`
  - `RequestIntegrationUserAction`
- **Notifiche Generiche:**
  - `UserApprovedNotification`
  - `UserRejectedNotification`
  - `UserIntegrationRequestedNotification`
- **Policy Generica:**
  - Solo utenti con ruolo moderatore possono cambiare stato
- **Dashboard Filament Generica:**
  - Lista richieste in attesa, dettagli, azioni rapide, filtro per tipo utente
- **Eventi/Listener Generici:**
  - Eventi per transizioni di stato, listener per invio notifiche
- **Wizard Generico:**
  - Step e schema configurabili tramite mapping per tipo utente
  - Validazione e salvataggio centralizzati

## Esempio di Interfaccia/Contract
```php
interface ModeratableUser
{
    public function getModerationData(): array;
    public function setModerationStatus(string $status): void;
    public function getType(): string; // es. 'patient', 'doctor', 'operator', ...
}
```

## Esempio di Enum Stato
```php
enum UserModerationStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case INTEGRATION_REQUESTED = 'integration_requested';
}
```

## Esempio di Action Generica
```php
class ApproveUserAction {
    public function execute(User $user): void {
        $user->moderation_status = UserModerationStatus::APPROVED;
        $user->save();
        $user->notify(new UserApprovedNotification());
    }
}
```

## Vantaggi
- **Riuso massimo**: la stessa logica serve per tutti i tipi di utente (riuso 90%+)
- **Configurabilità**: ogni progetto può definire i propri step, validazioni, notifiche tramite config o mapping
- **Manutenibilità**: bugfix, refactoring e nuove feature sono centralizzati
- **Coerenza UX**: dashboard unica per la moderazione, esperienza utente uniforme
- **Estendibilità**: aggiungere nuovi tipi di utente o step è semplice

## Roadmap
1. Analisi dei flussi di registrazione/moderazione esistenti nei progetti
2. Definizione di contract/interfacce e enum generici
3. Refactoring wizard e workflow per usare la struttura generica
4. Implementazione dashboard Filament generica (con filtri per tipo utente)
5. Test end-to-end e aggiornamento documentazione
6. Aggiornamento README e INDEX per i collegamenti

---

**Nota:**
- Tutte le label, i messaggi e le notifiche devono essere localizzati e privi di riferimenti hard-coded a domini specifici.
- La documentazione e gli esempi devono essere neutrali e riutilizzabili in qualsiasi progetto che utilizza il modulo User. 

---

## moderationor

*Consolidated from: `moderationor.md`*

title: "Moderazione Dentista dal Modulo User"
type: concept
tags: [moderationor]
created: 2026-07-14
updated: 2026-07-14
qmd: "moderationor moderazione dentista dal modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Moderazione Dentista dal Modulo User

## Premessa
La moderazione del dentista, pur essendo più articolata rispetto ad altri utenti, può essere gestita direttamente dal modulo User, centralizzando la logica e mantenendo la coerenza con il sistema di autenticazione e gestione utenti.

## Flusso Proposto
1. **Registrazione Dentista**
   - Il dentista compila il form di registrazione (wizard multi-step).
   - Al termine del primo step, lo stato viene impostato su `pending_moderation`.
   - I dati vengono salvati in una tabella di workflow (es. `doctor_registration_workflows`).

2. **Moderazione**
   - Un moderatore riceve una notifica (email/dashboard) di nuova richiesta.
   - Il moderatore accede a una dashboard Filament (User Panel) e visualizza i dettagli del dentista.
   - Può approvare, rifiutare o richiedere integrazioni, aggiungendo note di moderazione.
   - La transizione di stato avviene tramite enum e azioni dedicate (es. `ApproveDoctorAction`, `RejectDoctorAction`).

3. **Notifiche e Ripresa Flusso**
   - Se approvato, il dentista riceve una email con link sicuro per riprendere la registrazione.
   - Se rifiutato, riceve una email con motivazione e possibilità di correggere i dati.
   - Il wizard verifica lo stato e consente la ripresa solo se `approved`.

## Struttura Tecnica
- **Enum Stato:** `DoctorStatus` (pending, approved, rejected)
- **Workflow Model:** `DoctorRegistrationWorkflow` (relazione 1:1 con User/Doctor)
- **Azioni:**
  - `ApproveDoctorAction`
  - `RejectDoctorAction`
  - `RequestIntegrationDoctorAction`
- **Notifiche:**
  - `DoctorApprovedNotification`
  - `DoctorRejectedNotification`
  - `DoctorIntegrationRequestedNotification`
- **Policy:**
  - Solo utenti con ruolo moderatore possono cambiare stato
- **Dashboard Filament:**
  - Lista richieste in attesa, dettagli, azioni rapide
- **Eventi/Listener:**
  - Eventi per transizioni di stato, listener per invio notifiche

## Percentuali di Riuso
- **Riuso logica e componenti:** 60-70% rispetto a una soluzione centralizzata (molta logica di moderazione è simile a quella di altri utenti, ma con step e dati specifici per i dentisti)
- **Duplicazione:** 30-40% (alcuni step, notifiche e validazioni sono specifici per i dentisti)

## Motivazioni della Scelta
- **Centralizzazione:** Tutta la logica di moderazione utenti (inclusi i dentisti) è gestita in User, facilitando audit, policy e gestione permessi.
- **Estendibilità:** In futuro, la logica può essere estratta in un modulo Moderation se la complessità cresce.
- **Coerenza UX:** Un'unica dashboard per la moderazione di tutti gli utenti.
- **Performance:** Meno query cross-modulo, gestione diretta delle relazioni User/Doctor.

## Esempio di Implementazione

```php
// Enum Stato
enum DoctorStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Action di approvazione
class ApproveDoctorAction {
    public function execute(Doctor $doctor): void {
        $doctor->status = DoctorStatus::APPROVED;
        $doctor->save();
        $doctor->notify(new DoctorApprovedNotification());
    }
}

// Policy
class DoctorPolicy {
    public function moderate(User $user): bool {
        return $user->hasRole('moderator');
    }
}
```

## Roadmap
1. Analisi flussi esistenti e refactoring azioni/modelli
2. Implementazione dashboard Filament per moderazione
3. Definizione policy e permessi
4. Test end-to-end e aggiornamento documentazione

---

**Nota:** Se la complessità della moderazione dovesse aumentare (es. moderazione multi-ruolo, workflow avanzati), valutare la migrazione verso un modulo Moderation dedicato. 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
