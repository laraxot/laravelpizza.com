# Moderazione e Wizard di Registrazione Generici per User

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
