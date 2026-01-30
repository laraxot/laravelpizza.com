# Funzionalità Avanzate Media

> [Torna alla Roadmap Principale](../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

Le funzionalità avanzate del modulo Media per la gestione dei documenti medici sono attualmente completate al 30%. Questo componente è fondamentale per la gestione efficiente e sicura di tutti i documenti clinici e amministrativi all'interno della piattaforma il progetto.

## Obiettivi dell'Implementazione

L'implementazione delle funzionalità avanzate Media mira a:

1. Fornire un sistema completo per la gestione dei documenti medici digitali
2. Garantire la conformità normativa nella gestione di documenti sensibili
3. Ottimizzare l'accesso e l'organizzazione dei documenti clinici
4. Implementare meccanismi avanzati di archiviazione e ricerca
5. Integrare con i workflow clinici e amministrativi esistenti

## Componenti Implementati (30%)

- ✅ Struttura base del modulo Media con gestione file
- ✅ Upload documenti con validazione formato e dimensione
- ✅ Categorizzazione documenti per tipologia
- ✅ Associazione documenti a pazienti e trattamenti
- ✅ Gestione permessi base per visualizzazione documenti
- ✅ Anteprima per formati comuni (PDF, immagini)

## Componenti da Implementare (70%)

- 🚧 Gestione avanzata documenti clinici (40%)
  - 🚧 Metadati specifici per documenti medici (diagnosi, tipo, data)
  - 🚧 Sistema di tagging e categorizzazione avanzata
  - 🚧 Versioning documenti per tracciabilità modifiche
  - 📅 OCR per documenti scansionati
- 🚧 Integrazione con workflow clinici (25%)
  - 🚧 Associazione automatica documenti a fasi di trattamento
  - 🚧 Generazione automatica documenti da template
  - 📅 Firme digitali per consensi informati
- 🚧 Sicurezza e compliance (35%)
  - 🚧 Crittografia documenti sensibili
  - 🚧 Audit trail completo per accessi ai documenti
  - 🚧 Gestione retention policy conformi a normative
  - 📅 Watermarking per documenti esportati
- 📅 Funzionalità di collaborazione
  - 📅 Annotazioni e commenti su documenti
  - 📅 Condivisione sicura con esterni
  - 📅 Notifiche per modifiche ai documenti

## Architettura del Sistema

Il sistema di gestione documenti è strutturato secondo un'architettura a livelli che separa storage, metadati e logica di business:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Interfaccia      │       │  Servizi Media    │       │  Storage          │
│  Utente           │◄─────►│  e Permessi       │◄─────►│  e Versioning     │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
          ┌───────────────────┐       ┌───────────────────┐       
          │                   │       │                   │       
          │  Integrazione     │◄─────►│  Sicurezza e      │       
          │  Workflow         │       │  Compliance       │       
          │                   │       │                   │       
          └───────────────────┘       └───────────────────┘       
```

## Modello dei Dati

```php
// Modules/Media/Models/Media.php
namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    /**
     * Attributi assegnabili.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinical_metadata',
        'is_sensitive',
        'retention_date',
        'document_type',
        'document_date',
        'version',
        'access_level',
        'is_template',
    ];
    
    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'clinical_metadata' => 'array',
        'is_sensitive' => 'boolean',
        'retention_date' => 'date',
        'document_date' => 'date',
        'is_template' => 'boolean',
    ];
    
    /**
     * Le versioni precedenti del documento.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(MediaVersion::class, 'original_media_id');
    }
    
    /**
     * Recupera gli accessi al documento.
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(MediaAccessLog::class);
    }
    
    /**
     * Crea una nuova versione del documento.
     */
    public function createNewVersion(array $attributes = []): self
    {
        // Crea una copia del documento come nuova versione
        // Incrementa il numero di versione
        // Aggiorna il documento corrente
    }
    
    /**
     * Verifica se l'utente ha accesso al documento.
     */
    public function canAccess($user): bool
    {
        // Implementa logica di verifica permessi basata su:
        // - Ruolo utente
        // - Proprietà del documento
        // - Relazioni (es. medico-paziente)
        // - Livello di accesso configurato
    }
}
```

## Implementazione in Filament

L'interfaccia di gestione documenti utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Media/Filament/Resources/MediaResource.php
namespace Modules\Media\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MediaResource extends XotBaseResource
{
    protected static ?string $model = Media::class;
    
    public static function getFormSchema(): array
    {
        return [
            'basic_info' => Forms\Components\Section::make('Informazioni Base')
                ->schema([
                    'name' => Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required(),
                    'file' => Forms\Components\FileUpload::make('file')
                        ->label('File')
                        ->directory('clinical-documents')
                        ->visibility('private')
                        ->acceptedFileTypes([
                            'application/pdf', 
                            'image/jpeg', 
                            'image/png',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                        ])
                        ->maxSize(10240),
                    'document_type' => Forms\Components\Select::make('document_type')
                        ->label('Tipo Documento')
                        ->options([
                            'clinical_report' => 'Referto Clinico',
                            'lab_result' => 'Risultato Laboratorio',
                            'consent_form' => 'Modulo Consenso',
                            'prescription' => 'Prescrizione',
                            'imaging' => 'Immagine Diagnostica',
                            'administrative' => 'Documento Amministrativo',
                        ])
                        ->required(),
                    'document_date' => Forms\Components\DatePicker::make('document_date')
                        ->label('Data Documento')
                        ->required(),
                ])
                ->columns(2),
                
            'clinical_metadata' => Forms\Components\Section::make('Metadati Clinici')
                ->schema([
                    'clinical_metadata.diagnosis' => Forms\Components\TextInput::make('clinical_metadata.diagnosis')
                        ->label('Diagnosi'),
                    'clinical_metadata.procedure' => Forms\Components\TextInput::make('clinical_metadata.procedure')
                        ->label('Procedura'),
                    'clinical_metadata.doctor' => Forms\Components\TextInput::make('clinical_metadata.doctor')
                        ->label('Medico'),
                ])
                ->columns(2),
                
            'security' => Forms\Components\Section::make('Sicurezza')
                ->schema([
                    'is_sensitive' => Forms\Components\Toggle::make('is_sensitive')
                        ->label('Documento Sensibile')
                        ->helperText('Attiva per documenti che contengono dati particolarmente sensibili')
                        ->default(true),
                    'access_level' => Forms\Components\Select::make('access_level')
                        ->label('Livello Accesso')
                        ->options([
                            'admin_only' => 'Solo Amministratori',
                            'medical_staff' => 'Staff Medico',
                            'patient_visible' => 'Visibile al Paziente',
                        ])
                        ->default('medical_staff')
                        ->required(),
                    'retention_date' => Forms\Components\DatePicker::make('retention_date')
                        ->label('Data Conservazione')
                        ->helperText('Data fino alla quale il documento deve essere conservato'),
                ])
                ->columns(2),
        ];
    }
    
    // Implementazione tabella e altre funzionalità...
}
```

## Integrazione con Moduli Esistenti

### 1. Integrazione con Modulo Patient

```php
// Modules/Patient/Models/Patient.php
public function clinicalDocuments()
{
    return $this->morphMany(config('media.model', \Modules\Media\Models\Media::class), 'model')
                ->where('collection_name', 'clinical_documents');
}

// Ottenere i documenti per tipologia
public function getDocumentsByType(string $type)
{
    return $this->clinicalDocuments()
                ->where('document_type', $type)
                ->orderBy('document_date', 'desc')
                ->get();
}
```

### 2. Integrazione con Modulo Dental

```php
// Modules/Dental/Models/ExecutedTreatment.php
public function attachments()
{
    return $this->morphMany(config('media.model', \Modules\Media\Models\Media::class), 'model')
                ->where('collection_name', 'treatment_attachments');
}

// Attach documento utilizzando Action pattern
class AttachDocumentToTreatmentAction
{
    use Spatie\QueueableAction\QueueableAction;
    
    public function execute(ExecutedTreatment $treatment, UploadedFile $file, array $metadata = []): Media
    {
        // Logica per allegare documento al trattamento
        // con metadati appropriati
    }
}
```

## Sicurezza e Compliance

La gestione documenti implementa misure avanzate per garantire sicurezza e conformità normativa:

1. **Crittografia**:
   - Crittografia a riposo per documenti sensibili
   - Crittografia in transito (TLS/SSL)
   - Chiavi di crittografia gestite in modo sicuro

2. **Audit Trail**:
   - Logging completo di tutte le operazioni sui documenti
   - Tracciamento accessi, visualizzazioni e modifiche
   - Impossibilità di cancellazione definitiva per documenti clinici

3. **Retention Policies**:
   - Gestione conservazione documenti in base a requisiti legali
   - Archiviazione automatica dopo periodi configurabili
   - Promemoria per rinnovo/aggiornamento

## API per Documenti

L'accesso ai documenti tramite API è sicuro e conforme alle best practice:

```php
// Modules/Media/Http/Controllers/Api/MediaController.php
public function show(Request $request, Media $media)
{
    // Verifica autorizzazioni
    if (!$media->canAccess($request->user())) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    // Registra accesso
    $media->accessLogs()->create([
        'user_id' => $request->user()->id,
        'action' => 'view',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);
    
    // Genera URL firmato temporaneo per il download
    return response()->json([
        'media' => new MediaResource($media),
        'download_url' => $media->getTemporaryUrl(
            now()->addMinutes(5),
            'file'
        ),
    ]);
}
```

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Metadati specifici | Luglio 2024 | Alta |
| Tagging avanzato | Luglio 2024 | Media |
| Versioning documenti | Luglio 2024 | Alta |
| Crittografia | Agosto 2024 | Alta |
| Audit trail | Agosto 2024 | Alta |
| Template documenti | Agosto 2024 | Media |
| OCR documenti | Settembre 2024 | Bassa |
| Firme digitali | Settembre 2024 | Media |

## Metriche di Successo

- Tempo di recupero documenti < 2 secondi
- Riduzione tempo gestione documentale del 60%
- Coverage conformità normativa 100%
- Score sicurezza documenti sensibili > 95%
- Soddisfazione utenti (medici e staff) > 4.5/5
