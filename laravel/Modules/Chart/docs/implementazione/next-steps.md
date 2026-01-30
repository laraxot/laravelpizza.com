# Prossimi Passi dell'Implementazione

## 1. Implementazione dei Controller
Creare i seguenti controller nella cartella `Modules/Patient/Http/Controllers`:

### Web Controllers
- `PatientController.php`: Gestione CRUD dei pazienti
- `DocumentController.php`: Gestione CRUD dei documenti
- `AnamnesisController.php`: Gestione CRUD delle anamnesi

### API Controllers
- `Api/PatientController.php`: API REST per i pazienti
- `Api/DocumentController.php`: API REST per i documenti
- `Api/AnamnesisController.php`: API REST per le anamnesi

## 2. Implementazione delle Risorse Filament
Creare le seguenti risorse nella cartella `Modules/Patient/Filament/Resources`:

- `PatientResource.php`: Gestione dei pazienti nell'interfaccia Filament
- `DocumentResource.php`: Gestione dei documenti nell'interfaccia Filament
- `AnamnesisResource.php`: Gestione delle anamnesi nell'interfaccia Filament

## 3. Implementazione delle Viste
Creare le seguenti viste nella cartella `Modules/Patient/Resources/views`:

### Layouts
- `layouts/app.blade.php`: Layout principale del modulo

### Views per Pazienti
- `patients/index.blade.php`: Lista dei pazienti
- `patients/create.blade.php`: Form di creazione paziente
- `patients/edit.blade.php`: Form di modifica paziente
- `patients/show.blade.php`: Dettaglio paziente

### Views per Documenti
- `documents/index.blade.php`: Lista dei documenti
- `documents/create.blade.php`: Form di creazione documento
- `documents/edit.blade.php`: Form di modifica documento
- `documents/show.blade.php`: Dettaglio documento

### Views per Anamnesi
- `anamnesis/index.blade.php`: Lista delle anamnesi
- `anamnesis/create.blade.php`: Form di creazione anamnesi
- `anamnesis/edit.blade.php`: Form di modifica anamnesi
- `anamnesis/show.blade.php`: Dettaglio anamnesi

## 4. Implementazione delle Traduzioni
Creare i file di traduzione nella cartella `Modules/Patient/Resources/lang`:

- `it/patient.php`: Traduzioni in italiano
- `en/patient.php`: Traduzioni in inglese

## 5. Implementazione dei Test
Creare i test nella cartella `Modules/Patient/Tests`:

### Unit Tests
- `PatientTest.php`: Test unitari per il modello Patient
- `DocumentTest.php`: Test unitari per il modello Document
- `AnamnesisTest.php`: Test unitari per il modello Anamnesis

### Feature Tests
- `PatientControllerTest.php`: Test funzionali per il PatientController
- `DocumentControllerTest.php`: Test funzionali per il DocumentController
- `AnamnesisControllerTest.php`: Test funzionali per l'AnamnesisController

### API Tests
- `Api/PatientControllerTest.php`: Test per le API dei pazienti
- `Api/DocumentControllerTest.php`: Test per le API dei documenti
- `Api/AnamnesisControllerTest.php`: Test per le API delle anamnesi

## 6. Implementazione delle Notifiche
Creare le notifiche nella cartella `Modules/Patient/Notifications`:

- `AppointmentReminder.php`: Notifica per i promemoria degli appuntamenti
- `DocumentExpiry.php`: Notifica per la scadenza dei documenti
- `IseeUpdate.php`: Notifica per gli aggiornamenti ISEE

## 7. Implementazione dei Jobs
Creare i job nella cartella `Modules/Patient/Jobs`:

- `ProcessDocumentUpload.php`: Job per l'elaborazione degli upload dei documenti
- `SendAppointmentReminders.php`: Job per l'invio dei promemoria degli appuntamenti
- `CheckDocumentExpiry.php`: Job per il controllo della scadenza dei documenti

## 8. Implementazione degli Eventi
Creare gli eventi nella cartella `Modules/Patient/Events`:

- `PatientCreated.php`: Evento per la creazione di un paziente
- `PatientUpdated.php`: Evento per l'aggiornamento di un paziente
- `PatientDeleted.php`: Evento per l'eliminazione di un paziente
- `DocumentUploaded.php`: Evento per l'upload di un documento
- `DocumentExpired.php`: Evento per la scadenza di un documento
- `IseeUpdated.php`: Evento per l'aggiornamento dell'ISEE

## 9. Implementazione dei Listeners
Creare i listener nella cartella `Modules/Patient/Listeners`:

- `SendWelcomeEmail.php`: Listener per l'invio dell'email di benvenuto
- `CreatePatientFolder.php`: Listener per la creazione della cartella del paziente
- `NotifyDocumentExpiry.php`: Listener per la notifica di scadenza documento
- `UpdatePatientStatus.php`: Listener per l'aggiornamento dello stato del paziente

## 10. Implementazione dei Middleware
Creare i middleware nella cartella `Modules/Patient/Http/Middleware`:

- `CheckPatientAccess.php`: Middleware per il controllo dell'accesso al paziente
- `CheckDocumentAccess.php`: Middleware per il controllo dell'accesso ai documenti
- `CheckAnamnesisAccess.php`: Middleware per il controllo dell'accesso alle anamnesi

## 11. Implementazione delle Policies
Creare le policies nella cartella `Modules/Patient/Policies`:

- `PatientPolicy.php`: Policy per la gestione dei pazienti
- `DocumentPolicy.php`: Policy per la gestione dei documenti
- `AnamnesisPolicy.php`: Policy per la gestione delle anamnesi

## 12. Implementazione delle Requests
Creare le request nella cartella `Modules/Patient/Http/Requests`:

- `StorePatientRequest.php`: Request per la creazione di un paziente
- `UpdatePatientRequest.php`: Request per l'aggiornamento di un paziente
- `StoreDocumentRequest.php`: Request per la creazione di un documento
- `UpdateDocumentRequest.php`: Request per l'aggiornamento di un documento
- `StoreAnamnesisRequest.php`: Request per la creazione di un'anamnesi
- `UpdateAnamnesisRequest.php`: Request per l'aggiornamento di un'anamnesi 