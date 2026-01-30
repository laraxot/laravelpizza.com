# Implementazione Modulo Patient

## Obiettivi
- Implementare CRUD pazienti con scoping tenant
- Creare sistema di gestione ISEE
- Implementare validazione dati
- Integrare sistema notifiche

## Passi Implementativi

### 1. Setup Base Modulo
1. Creare struttura moduli
   ```bash
   php artisan module:make Patient
   ```

2. Configurare provider
   ```php
   // Modules/Patient/Providers/PatientServiceProvider.php
   class PatientServiceProvider extends ServiceProvider
   {
       // Implementazione provider
   }
   ```

### 2. Implementazione CRUD
1. Creare modello Patient
   ```php
   // Modules/Patient/Models/Patient.php
   class Patient extends Model
   {
       use BelongsToTenant;
       // Implementazione modello
   }
   ```

2. Implementare controller
   ```php
   // Modules/Patient/Http/Controllers/PatientController.php
   class PatientController extends Controller
   {
       // Implementazione controller
   }
   ```

### 3. Gestione ISEE
1. Creare modello ISEE
   ```php
   // Modules/Patient/Models/ISEE.php
   class ISEE extends Model
   {
       use BelongsToTenant;
       // Implementazione modello
   }
   ```

2. Implementare validazione
   ```php
   // Modules/Patient/Http/Requests/ISEERequest.php
   class ISEERequest extends FormRequest
   {
       // Implementazione validazione
   }
   ```

### 4. Integrazione Notifiche
1. Creare notifiche
   ```php
   // Modules/Patient/Notifications/PatientNotification.php
   class PatientNotification extends Notification
   {
       // Implementazione notifica
   }
   ```

2. Configurare eventi
   ```php
   // Modules/Patient/Events/PatientEvent.php
   class PatientEvent
   {
       // Implementazione evento
   }
   ```

## Testing
1. Unit Tests
   ```php
   // Modules/Patient/Tests/Unit/PatientTest.php
   class PatientTest extends TestCase
   {
       // Implementazione test
   }
   ```

2. Feature Tests
   ```php
   // Modules/Patient/Tests/Feature/PatientTest.php
   class PatientTest extends TestCase
   {
       // Implementazione test
   }
   ```

## Sicurezza
1. Implementare policy
   ```php
   // Modules/Patient/Policies/PatientPolicy.php
   class PatientPolicy extends BasePolicy
   {
       // Implementazione policy
   }
   ```

2. Validazione dati
   ```php
   // Modules/Patient/Http/Requests/PatientRequest.php
   class PatientRequest extends FormRequest
   {
       // Implementazione validazione
   }
   ```

## Note Implementative
- Implementare soft deletes
- Gestire file allegati
- Implementare export dati
- Mantenere audit trail
- Implementare backup automatici 
## Collegamenti tra versioni di patient.md
* [patient.md](docs/moduli/patient.md)
* [patient.md](docs/roadmap/moduli/patient.md)
* [patient.md](laravel/Modules/Xot/docs/roadmap/bottlenecks/patient.md)

