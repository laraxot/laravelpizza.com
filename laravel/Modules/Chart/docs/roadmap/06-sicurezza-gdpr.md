# Sicurezza e Conformità GDPR

## Stato Attuale

Il progetto il progetto, trattando dati sensibili di pazienti gestanti in condizione di vulnerabilità socio-economica, richiede un'attenta implementazione delle misure di sicurezza e conformità al GDPR. Il modulo GDPR è stato installato ma necessita di configurazione specifica.

### Componenti Implementati ✅
- Modulo GDPR di Laraxot integrato
- Struttura base per logging delle attività

### Componenti Da Implementare ⏳
- Configurazione consensi specifici per il progetto
- Implementazione registro trattamenti
- Misure di sicurezza per dati sanitari
- Privacy by design e by default

## Attività da Completare

### 1. Registro dei Trattamenti (P0)

#### Descrizione
Implementare il registro dei trattamenti come richiesto dall'art. 30 del GDPR, con le specifiche relative al trattamento dei dati sanitari.

#### Implementazione
1. **Definire le finalità dei trattamenti**:
   ```php
   // config/gdpr/treatments.php
   return [
       'patient_registration' => [
           'title' => 'Registrazione Paziente',
           'description' => 'Raccolta dati personali e sanitari delle gestanti per l\'accesso al servizio',
           'legal_basis' => 'consent', // Base giuridica (consenso)
           'data_categories' => ['personal', 'health', 'socio-economic'],
           'retention_period' => '10 years', // Periodo conservazione
           'recipients' => ['staff', 'dentists'],
           'transfers' => [], // Trasferimenti a terzi
           'security_measures' => [
               'encryption',
               'access_control',
               'logging',
               'pseudonymization',
           ],
       ],
       'appointment_management' => [
           'title' => 'Gestione Appuntamenti',
           'description' => 'Gestione degli appuntamenti tra pazienti e odontoiatri',
           'legal_basis' => 'consent',
           'data_categories' => ['personal', 'health'],
           'retention_period' => '5 years',
           'recipients' => ['staff', 'dentists'],
           'transfers' => [],
           'security_measures' => [
               'encryption',
               'access_control',
               'logging',
           ],
       ],
       'dentist_management' => [
           'title' => 'Gestione Odontoiatri',
           'description' => 'Gestione dei dati degli odontoiatri aderenti al progetto',
           'legal_basis' => 'contract',
           'data_categories' => ['personal', 'professional', 'financial'],
           'retention_period' => '10 years',
           'recipients' => ['staff'],
           'transfers' => [],
           'security_measures' => [
               'encryption',
               'access_control',
               'logging',
           ],
       ],
   ];
   ```

2. **Implementare interfaccia di visualizzazione**:
   Creare una dashboard per il DPO che mostri il registro dei trattamenti aggiornato.

3. **Automatizzare aggiornamenti registro**:
   Implementare meccanismi di aggiornamento automatico del registro in base alle attività del sistema.

### 2. Consensi Informati (P0)

#### Descrizione
Implementare un sistema robusto per la raccolta e gestione dei consensi GDPR, con particolare attenzione al trattamento di dati sanitari.

#### Implementazione
1. **Definire i tipi di consenso**:
   ```php
   // config/gdpr/consents.php
   return [
       'privacy_policy' => [
           'title' => 'Informativa sulla Privacy',
           'description' => 'Informativa generale sul trattamento dei dati personali',
           'required' => true,
           'version' => '1.0',
           'text_file' => 'gdpr/privacy_policy.md',
       ],
       'health_data' => [
           'title' => 'Trattamento Dati Sanitari',
           'description' => 'Consenso al trattamento dei dati relativi alla salute',
           'required' => true,
           'version' => '1.0',
           'text_file' => 'gdpr/health_data.md',
       ],
       'third_party_sharing' => [
           'title' => 'Condivisione con Terze Parti',
           'description' => 'Consenso alla condivisione dei dati con odontoiatri e personale sanitario',
           'required' => true,
           'version' => '1.0',
           'text_file' => 'gdpr/third_party.md',
       ],
       'marketing' => [
           'title' => 'Marketing e Comunicazioni',
           'description' => 'Consenso all\'invio di comunicazioni non essenziali',
           'required' => false,
           'version' => '1.0',
           'text_file' => 'gdpr/marketing.md',
       ],
   ];
   ```

2. **Implementare formulari di consenso**:
   Form con testi informativi completi e checkbox espliciti per ogni consenso.

3. **Tracciare versioni e rinnovi consensi**:
   Sistema per tracciare versioni dei consensi e richiedere rinnovo quando necessario.

### 3. Diritti degli Interessati (P0)

#### Descrizione
Implementare procedure e interfacce per consentire agli utenti di esercitare i propri diritti GDPR (accesso, rettifica, cancellazione, portabilità, ecc.).

#### Implementazione
1. **Interfaccia per richieste diritti**:
   Form per la richiesta di esercizio dei diritti con autenticazione.

2. **Sistema di esportazione dati**:
   ```php
   // Modules/Gdpr/app/Actions/ExportUserData.php
   namespace Modules\Gdpr\Actions;
   
   use Modules\User\Models\User;
   use Illuminate\Support\Facades\Storage;
   
   class ExportUserData
   {
       public function handle(User $user): string
       {
           // Raccolta dati personali
           $personalData = $user->toArray();
           unset($personalData['password']);
           
           // Raccolta dati paziente
           $patientData = $user->patient ? $user->patient->toArray() : null;
           
           // Raccolta appuntamenti
           $appointmentsData = $user->patient 
               ? $user->patient->appointments()->with('dentist')->get()->toArray() 
               : [];
           
           // Raccolta consensi
           $consentsData = $user->consents()->get()->toArray();
           
           // Esportazione completa
           $data = [
               'user' => $personalData,
               'patient' => $patientData,
               'appointments' => $appointmentsData,
               'consents' => $consentsData,
               'export_date' => now()->toIso8601String(),
           ];
           
           // Creazione file JSON
           $filename = 'user_data_' . $user->id . '_' . now()->format('Ymd_His') . '.json';
           $path = 'exports/' . $filename;
           
           Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));
           
           // Log dell'operazione
           activity()
               ->causedBy($user)
               ->log('User data exported');
           
           return Storage::url($path);
       }
   }
   ```

3. **Sistema di cancellazione/anonimizzazione**:
   Implementare procedure per anonimizzare i dati degli utenti che richiedono la cancellazione.

### 4. Data Protection by Design (P1)

#### Descrizione
Implementare misure tecniche per garantire la privacy by design e by default nel sistema.

#### Implementazione
1. **Implementare pseudonimizzazione**:
   ```php
   // Modules/Patient/app/Models/Patient.php
   public function getAnonymizedAttributes(): array
   {
       return [
           'name' => 'ANONIMIZZATO',
           'surname' => 'ANONIMIZZATO',
           'fiscal_code' => 'XXXXXXXXXXXXXXXX',
           'birth_place' => 'ANONIMIZZATO',
           'address' => 'ANONIMIZZATO',
           'phone' => 'XXXXXXXXXXXX',
           'health_card_number' => 'XXXXXXXXXXXX',
       ];
   }
   
   public function anonymize(): self
   {
       $this->update($this->getAnonymizedAttributes());
       
       return $this;
   }
   ```

2. **Minimizzazione dati**:
   Implementare procedure per raccogliere solo i dati strettamente necessari.

3. **Limitazione accesso**:
   Configurare policy per limitare l'accesso ai dati in base al ruolo.

### 5. Sicurezza dei Dati (P0)

#### Descrizione
Implementare misure di sicurezza appropriate per proteggere i dati personali, specialmente quelli sanitari.

#### Implementazione
1. **Configurare crittografia**:
   ```php
   // Modules/Patient/app/Models/Patient.php
   use Illuminate\Database\Eloquent\Casts\Attribute;
   
   // Attribute per crittografare campi sensibili
   protected function healthData(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => $value ? decrypt($value) : null,
           set: fn ($value) => $value ? encrypt($value) : null,
       );
   }
   ```

2. **Implementare logging avanzato**:
   ```php
   // app/Providers/EventServiceProvider.php
   use Illuminate\Auth\Events\Login;
   use Illuminate\Auth\Events\Failed;
   use Illuminate\Auth\Events\Logout;
   use App\Listeners\LogAuthenticationActivity;
   
   protected $listen = [
       Login::class => [
           LogAuthenticationActivity::class,
       ],
       Failed::class => [
           LogAuthenticationActivity::class,
       ],
       Logout::class => [
           LogAuthenticationActivity::class,
       ],
   ];
   ```

3. **Configurare policy di sicurezza**:
   Implementare middleware per proteggere le risorse sensibili.

### 6. Documentazione GDPR (P1)

#### Descrizione
Preparare tutta la documentazione GDPR necessaria per il progetto.

#### Implementazione
1. **Informative privacy**:
   Redigere informative privacy complete per tutte le categorie di interessati.

2. **Procedure di data breach**:
   Documentare le procedure da seguire in caso di violazione dei dati.

3. **Valutazioni d'impatto (DPIA)**:
   Eseguire e documentare la DPIA per i trattamenti ad alto rischio.

### 7. Formazione Staff (P2)

#### Descrizione
Preparare materiale formativo per il personale che avrà accesso ai dati.

#### Implementazione
1. **Documentazione formativa**:
   Creare guide e manuali per il personale.

2. **Procedure operative**:
   Documentare le procedure da seguire per garantire la sicurezza dei dati.

## Controlli di Sicurezza

### Controlli Tecnici
- ✅ Crittografia dati sensibili a riposo e in transito
- ✅ Autenticazione a due fattori per gli utenti con accesso privilegiato
- ✅ Logging comprensivo di tutte le attività rilevanti
- ✅ Protezione contro attacchi web comuni (CSRF, XSS, SQLi)
- ✅ Backup regolari e procedure di disaster recovery
- ✅ Gestione robusti dei token di sessione

### Controlli Organizzativi
- ✅ Definizione ruoli e responsabilità
- ✅ Procedure per gestione data breach
- ✅ Formazione del personale su sicurezza e privacy
- ✅ Audit periodici di conformità

## Criteri di Accettazione

- ✅ Il sistema è completamente conforme al GDPR
- ✅ I consensi sono raccolti e gestiti correttamente
- ✅ Gli interessati possono esercitare i propri diritti
- ✅ I dati sensibili sono adeguatamente protetti
- ✅ Il registro dei trattamenti è completo e aggiornato
- ✅ Le procedure di data breach sono documentate e testate

## Dipendenze e Prerequisiti
- Modulo GDPR di Laraxot correttamente installato
- Modulo Activity per il logging delle attività
- Sistema di autenticazione robusto
