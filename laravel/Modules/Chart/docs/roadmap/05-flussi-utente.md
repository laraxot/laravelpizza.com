# Flussi Utente

## Stato Attuale

I flussi utente sono la componente centrale del progetto il progetto, in quanto definiscono l'esperienza completa delle gestanti, degli odontoiatri e del personale di back office. Questi flussi sono stati definiti nel documento di progetto ma richiedono implementazione tecnica.

### Componenti Implementati ✅
- Architettura di base per la gestione dei flussi
- Modelli dati per le entità principali

### Componenti Da Implementare ⏳
- Flusso registrazione e validazione gestanti
- Flusso ricerca e prenotazione appuntamenti
- Flusso registrazione e validazione odontoiatri
- Flusso gestione appuntamenti e referti
- Flusso back office per approvazioni e rimborsi

## Attività da Completare

### 1. Flusso Paziente - Registrazione (P0)

#### Descrizione
Implementare il flusso di registrazione per le pazienti gestanti, includendo la raccolta dei dati personali, upload documenti, e consensi GDPR.

#### Implementazione
1. **Creare modello di dati**:
   ```php
   // Modules/Patient/app/Models/Patient.php
   
   namespace Modules\Patient\Models;
   
   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Relations\BelongsTo;
   use Modules\User\Models\User;
   
   class Patient extends Model
   {
       protected $fillable = [
           'user_id',
           'name',
           'surname',
           'fiscal_code',
           'birth_date',
           'birth_place',
           'address',
           'city',
           'postal_code',
           'province',
           'phone',
           'isee_value',
           'pregnancy_status',
           'expected_delivery_date',
           'has_health_card',
           'health_card_number',
           'has_stp',
           'stp_code',
           'education_level',
           'status', // pending, approved, rejected
       ];
       
       protected $casts = [
           'birth_date' => 'date',
           'expected_delivery_date' => 'date',
           'isee_value' => 'decimal:2',
           'has_health_card' => 'boolean',
           'has_stp' => 'boolean',
       ];
       
       public function user(): BelongsTo
       {
           return $this->belongsTo(User::class);
       }
       
       public function documents()
       {
           return $this->morphMany(Document::class, 'documentable');
       }
   }
   ```

2. **Creare form multi-step**:
   ```php
   // Modules/Patient/app/Livewire/RegistrationForm.php
   
   use Livewire\Component;
   use Livewire\WithFileUploads;
   
   class RegistrationForm extends Component
   {
       use WithFileUploads;
       
       public $step = 1;
       public $totalSteps = 4;
       
       // Step 1 - Dati personali
       public $name;
       public $surname;
       public $fiscal_code;
       // ... altri campi
       
       // Step 2 - Documenti
       public $health_card;
       public $isee_document;
       public $pregnancy_document;
       
       // Step 3 - Questionario anamnestico
       public $questionnaire = [];
       
       // Step 4 - Consensi GDPR
       public $privacy_consent = false;
       public $processing_consent = false;
       public $medical_data_consent = false;
       public $marketing_consent = false;
       
       // Regole di validazione per step
       protected function rules()
       {
           return [
               // Regole per step 1
               'name' => 'required|string|max:255',
               'surname' => 'required|string|max:255',
               // ... altre regole
           ];
       }
       
       public function nextStep()
       {
           $this->validateStep();
           $this->step++;
       }
       
       public function prevStep()
       {
           $this->step--;
       }
       
       public function validateStep()
       {
           // Validazione specifica per lo step corrente
       }
       
       public function submit()
       {
           // Creazione utente
           $user = User::create([
               'email' => $this->email,
               'password' => Hash::make($this->password),
               'role' => 'patient',
           ]);
           
           // Creazione paziente
           $patient = Patient::create([
               'user_id' => $user->id,
               // ... altri dati
               'status' => 'pending', // In attesa di approvazione
           ]);
           
           // Upload documenti
           if ($this->health_card) {
               $path = $this->health_card->store('documents/health_cards');
               $patient->documents()->create([
                   'type' => 'health_card',
                   'path' => $path,
               ]);
           }
           
           // ... altri upload
           
           // Salvataggio consensi GDPR
           foreach (['privacy', 'processing', 'medical_data', 'marketing'] as $consentType) {
               $property = "{$consentType}_consent";
               if ($this->{$property}) {
                   $user->consents()->create([
                       'type' => $consentType,
                       'given_at' => now(),
                   ]);
               }
           }
           
           // Notifica back office
           event(new PatientRegistered($patient));
           
           return redirect()->route('registration.complete');
       }
   }
   ```

3. **Creare visualizzazione form**:
   Template blade con progressione step by step e validazione in tempo reale.

### 2. Flusso Paziente - Ricerca e Prenotazione (P1)

#### Descrizione
Implementare il flusso di ricerca dentisti e prenotazione appuntamenti per le pazienti approvate.

#### Implementazione
1. **Creare funzionalità di ricerca**:
   Implementare ricerca per località e distanza degli studi odontoiatrici.

2. **Implementare selezione slot disponibili**:
   Sistema di visualizzazione e selezione degli slot disponibili per ogni odontoiatra.

3. **Sistema di conferma appuntamento**:
   Procedura di richiesta e conferma appuntamento con notifiche.

### 3. Flusso Odontoiatra - Registrazione (P1)

#### Descrizione
Implementare il flusso di registrazione per gli odontoiatri, includendo verifica credenziali professionali.

#### Implementazione
1. **Creare modello di dati**:
   Definire il modello per gli odontoiatri con campi per dati professionali e bancari.

2. **Implementare form di registrazione**:
   Form multi-step per raccolta informazioni e documenti professionali.

3. **Sistema di approvazione**:
   Processo di verifica e approvazione da parte del back office.

### 4. Flusso Odontoiatra - Gestione Appuntamenti (P1)

#### Descrizione
Implementare il flusso di gestione appuntamenti, refertazione e richiesta rimborsi.

#### Implementazione
1. **Dashboard appuntamenti**:
   Interfaccia per visualizzazione e gestione appuntamenti ricevuti.

2. **Sistema di refertazione**:
   Form per la compilazione del referto post-visita.

3. **Processo di rimborso**:
   Generazione automatica richieste di rimborso post-refertazione.

### 5. Flusso Back Office - Validazione Utenti (P1)

#### Descrizione
Implementare il flusso di validazione degli utenti (pazienti e odontoiatri) per il personale di back office.

#### Implementazione
1. **Interfaccia di gestione richieste**:
   Dashboard per visualizzare e gestire richieste di registrazione pendenti.

2. **Processo di verifica documenti**:
   Sistema per la verifica dei documenti caricati dagli utenti.

3. **Gestione approvazioni/rifiuti**:
   Funzionalità per approvare o rifiutare registrazioni con motivazione.

### 6. Flusso Back Office - Gestione Rimborsi (P1)

#### Descrizione
Implementare il flusso di gestione rimborsi per il personale di back office.

#### Implementazione
1. **Dashboard rimborsi**:
   Interfaccia per visualizzare e gestire richieste di rimborso.

2. **Processo di verifica e approvazione**:
   Sistema per la verifica e approvazione dei rimborsi.

3. **Generazione reportistica**:
   Funzionalità per generare report sui rimborsi per periodo/odontoiatra.

### 7. Flusso Notifiche (P2)

#### Descrizione
Implementare un sistema di notifiche per tutti gli utenti del sistema.

#### Implementazione
1. **Sistema di notifiche in-app**:
   Utilizzo del modulo Notify per notifiche all'interno dell'applicazione.

2. **Notifiche email**:
   Configurazione del sistema di invio email per eventi chiave.

3. **Gestione preferenze notifiche**:
   Interfaccia per la gestione delle preferenze di notifica per gli utenti.

## Diagrammi dei Flussi

### Flusso Registrazione Paziente
```
Inizio
  ↓
[Homepage] → [Registrazione]
  ↓
[Step 1: Dati Personali] → Validazione
  ↓
[Step 2: Upload Documenti] → Validazione
  ↓
[Step 3: Questionario] → Validazione
  ↓
[Step 4: Consensi GDPR] → Validazione
  ↓
[Invio Richiesta] → Notifica Back Office
  ↓
[Attesa Approvazione]
  ↓
[Notifica Esito]
  ↓
Fine
```

### Flusso Prenotazione Appuntamento
```
Inizio
  ↓
[Dashboard Paziente] → [Trova Dentista]
  ↓
[Ricerca per Area] → [Lista Dentisti]
  ↓
[Selezione Dentista] → [Calendario Disponibilità]
  ↓
[Selezione Slot] → [Conferma Prenotazione]
  ↓
[Invio Richiesta] → Notifica Dentista
  ↓
[Attesa Conferma]
  ↓
[Notifica Esito]
  ↓
Fine
```

## Criteri di Accettazione

- ✅ Tutti i flussi utente sono implementati come specificato
- ✅ Le interfacce sono intuitive e guidano l'utente nel processo
- ✅ La validazione dati è robusta e fornisce feedback appropriato
- ✅ Le notifiche vengono inviate correttamente agli attori coinvolti
- ✅ I consensi GDPR sono raccolti e gestiti in modo conforme

## Dipendenze e Prerequisiti

- Backend API completamente funzionante
- Sistema di autenticazione implementato
- Modulo GDPR configurato
- Sistema di notifiche configurato
