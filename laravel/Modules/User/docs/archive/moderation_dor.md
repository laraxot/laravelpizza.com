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
