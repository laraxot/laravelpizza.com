# Completamento Workflow Pazienti

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

Il completamento del workflow pazienti è attualmente implementato all'85%. Questo componente è fondamentale per gestire l'intero ciclo di vita del paziente all'interno della piattaforma il progetto, dalla registrazione alla gestione appuntamenti e trattamenti.

## Obiettivi dell'Implementazione

Il completamento del workflow pazienti mira a:

1. Fornire un sistema completo per la gestione del ciclo di vita del paziente
2. Automatizzare i processi amministrativi legati alla gestione pazienti
3. Migliorare l'esperienza utente sia per gli operatori che per i pazienti
4. Garantire la conformità GDPR nella gestione dei dati sensibili
5. Integrare tutti i touchpoint del paziente in un unico sistema coerente

## Componenti Implementati (85%)

- ✅ Registrazione paziente con validazione dati completa
- ✅ Gestione anagrafica e dati personali
- ✅ Consensi privacy e autorizzazioni trattamento dati
- ✅ Cartella clinica elettronica base
- ✅ Storico appuntamenti e trattamenti
- ✅ Integrazione base con modulo Dental
- ✅ Sistema di notifiche per appuntamenti
- ✅ Gestione documenti paziente (caricamento/visualizzazione)

## Componenti da Implementare (15%)

- 🚧 Integrazione completa ISEE nel profilo paziente (60%)
- 🚧 Dashboard paziente personalizzata (70%)
- 🚧 Sistema avanzato di follow-up post-trattamento (40%)
- 🚧 Integrazioni con dispositivi medici per dati biometrici (20%)
- 📅 Area riservata pazienti con accesso diretto alla documentazione
- 📅 Integrazione pagamenti online per servizi

## Architettura del Workflow

Il workflow paziente si basa su un'architettura a stati che traccia l'evoluzione del paziente nel sistema:

```
┌──────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│              │    │              │    │              │    │              │
│ Registrazione│───►│  Screening   │───►│ Trattamento  │───►│  Follow-up   │
│              │    │              │    │              │    │              │
└──────────────┘    └──────────────┘    └──────────────┘    └──────────────┘
       │                   │                   │                   │
       │                   │                   │                   │
       ▼                   ▼                   ▼                   ▼
┌──────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│              │    │              │    │              │    │              │
│ Form Paziente│    │  Verifica    │    │  Workflow    │    │  Sistema     │
│              │    │  Idoneità    │    │  Appuntamenti│    │  Notifiche   │
│              │    │              │    │              │    │              │
└──────────────┘    └──────────────┘    └──────────────┘    └──────────────┘
```

## Moduli Coinvolti

Il workflow paziente coinvolge diversi moduli del sistema:

1. **Modulo Patient**:
   - Gestione anagrafica
   - Gestione consensi
   - Documenti paziente

2. **Modulo Dental**:
   - Cartella clinica dentale
   - Piano di trattamento
   - Storico procedure

3. **Modulo Activity**:
   - Tracciamento interazioni
   - Audit trail modifiche dati sensibili

4. **Modulo Notify**:
   - Notifiche appuntamenti
   - Promemoria follow-up
   - Comunicazioni amministrative

## Implementazione con Filament

L'interfaccia amministrativa utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Patient/Filament/Resources/PatientResource.php
namespace Modules\Patient\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Patient\Models\Patient;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    
    public static function getFormSchema(): array
    {
        return [
            'personal_info' => Forms\Components\Section::make('Informazioni Personali')
                ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')
                        ->label('Nome')
                        ->required(),
                    'last_name' => Forms\Components\TextInput::make('last_name')
                        ->label('Cognome')
                        ->required(),
                    'birth_date' => Forms\Components\DatePicker::make('birth_date')
                        ->label('Data di nascita')
                        ->required(),
                    'fiscal_code' => Forms\Components\TextInput::make('fiscal_code')
                        ->label('Codice Fiscale')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->length(16),
                    // Altri campi...
                ])
                ->columns(2),
            
            'contact_info' => Forms\Components\Section::make('Contatti')
                ->schema([
                    'email' => Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    'phone' => Forms\Components\TextInput::make('phone')
                        ->label('Telefono')
                        ->tel()
                        ->required(),
                    // Altri campi...
                ])
                ->columns(2),
            
            'medical_info' => Forms\Components\Section::make('Informazioni Mediche')
                ->schema([
                    'pregnancy_status' => Forms\Components\Toggle::make('pregnancy_status')
                        ->label('Stato di gravidanza')
                        ->helperText('Indica se la paziente è in stato di gravidanza'),
                    'allergies' => Forms\Components\Textarea::make('allergies')
                        ->label('Allergie')
                        ->rows(3),
                    // Altri campi...
                ]),
            
            'privacy' => Forms\Components\Section::make('Privacy e Consensi')
                ->schema([
                    'privacy_consent' => Forms\Components\Checkbox::make('privacy_consent')
                        ->label('Consenso al trattamento dati personali')
                        ->required()
                        ->helperText('Il paziente acconsente al trattamento dei dati personali secondo GDPR'),
                    'marketing_consent' => Forms\Components\Checkbox::make('marketing_consent')
                        ->label('Consenso comunicazioni marketing')
                        ->helperText('Il paziente acconsente a ricevere comunicazioni promozionali'),
                    // Altri consensi...
                ]),
        ];
    }
    
    // Implementazione tabella e altre funzionalità...
}
```

## Workflow Appuntamenti Integrato

Il workflow paziente si integra con il sistema di appuntamenti:

```php
// Modules/Patient/Actions/BookAppointmentAction.php
namespace Modules\Patient\Actions;

use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Patient\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

class BookAppointmentAction
{
    use QueueableAction;
    
    public function execute(Patient $patient, array $appointmentData): AppointmentWorkflow
    {
        // Crea un nuovo workflow di appuntamento
        $workflow = AppointmentWorkflow::create([
            'patient_id' => $patient->id,
            'tenant_id' => $patient->tenant_id,
            'status' => AppointmentWorkflow::STATUS_PATIENT_INFO,
            'step' => 'patient_info',
            'step_data' => [
                'patient_info' => [
                    'first_name' => $patient->first_name,
                    'last_name' => $patient->last_name,
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                    'fiscal_code' => $patient->fiscal_code,
                ],
            ],
        ]);
        
        // Registra l'attività
        activity()
            ->performedOn($workflow)
            ->causedBy(auth()->user())
            ->log('Iniziato workflow appuntamento per il paziente: ' . $patient->full_name);
            
        return $workflow;
    }
}
```

## Integrazione ISEE

L'integrazione ISEE nel profilo paziente è in via di completamento (60%):

```php
// Modules/Patient/Models/Patient.php
public function isee()
{
    return $this->hasOne(PatientIsee::class)->latest();
}

// Helper per verificare idoneità
public function isEligibleForProgram(): bool
{
    if (!$this->pregnancy_status) {
        return false;
    }
    
    $isee = $this->isee;
    if (!$isee || !$isee->is_valid || $isee->value > 20000) {
        return false;
    }
    
    return true;
}
```

## Dashboard Paziente

La dashboard paziente personalizzata (70% completata) include:

1. **Riepilogo Informazioni**:
   - Dati anagrafici
   - Stato ISEE e idoneità
   - Prossimi appuntamenti

2. **Indicatori Clinici**:
   - Stato trattamenti in corso
   - Appuntamenti completati
   - Documentazione mancante

3. **Timeline Attività**:
   - Storico interazioni
   - Comunicazioni ricevute
   - Pagamenti effettuati

## Integrazione con Dispositivi Medici

L'integrazione con dispositivi medici (20% completata) prevede:

1. **Connettori Standardizzati**:
   - HL7 FHIR per integrazione con sistemi medici
   - API per dispositivi di monitoraggio remoto

2. **Tipologie di Dati**:
   - Immagini diagnostiche
   - Parametri vitali
   - Risultati di laboratorio

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Integrazione ISEE | Maggio 2024 | Alta |
| Dashboard paziente | Maggio 2024 | Alta |
| Sistema follow-up | Giugno 2024 | Media |
| Integrazione dispositivi | Luglio 2024 | Bassa |
| Area riservata pazienti | Agosto 2024 | Media |
| Pagamenti online | Settembre 2024 | Bassa |

## Considerazioni sulla Privacy

In accordo con il GDPR, il workflow paziente implementa:

1. **Privacy by Design**:
   - Minimizzazione dei dati raccolti
   - Periodi di conservazione definiti
   - Pseudonimizzazione dove applicabile

2. **Diritti dell'Interessato**:
   - Accesso ai propri dati
   - Portabilità dati
   - Cancellazione (diritto all'oblio)

3. **Sicurezza**:
   - Crittografia dati sensibili
   - Logging accessi ai dati
   - Compartimentazione informazioni

## Metriche di Successo

- Tempo di registrazione nuovo paziente < 5 minuti
- Riduzione errori amministrativi del 80%
- Aumento produttività operatori del 30%
- Soddisfazione pazienti > 4.5/5
- Conformità GDPR 100%
