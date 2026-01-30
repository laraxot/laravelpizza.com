# Integrazione Avanzata Trattamenti Odontoiatrici

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

L'integrazione avanzata dei trattamenti odontoiatrici nella piattaforma il progetto è attualmente completata al 70%. Questo componente è fondamentale per gestire in modo efficace i trattamenti dentali offerti alle pazienti in gravidanza, garantendo un servizio di qualità conforme alle linee guida ministeriali.

## Obiettivi dell'Implementazione

L'integrazione avanzata dei trattamenti odontoiatrici mira a:

1. Fornire un catalogo completo di trattamenti dentali destinati alle pazienti in gravidanza
2. Implementare workflow clinici specifici per ogni tipo di trattamento
3. Gestire le controindicazioni e le precauzioni in base allo stato di gravidanza
4. Tracciare l'evoluzione dei trattamenti e i risultati clinici
5. Supportare la generazione di documentazione clinica standardizzata

## Componenti Implementati (70%)

- ✅ Modello dati completo per i trattamenti odontoiatrici
- ✅ Categorizzazione e classificazione dei trattamenti
- ✅ Gestione prezzi e coperture per pazienti idonee
- ✅ Integrazione con anagrafica dentisti e specializzazioni
- ✅ Timeline trattamenti per paziente
- ✅ Documentazione clinica base per singolo trattamento
- ✅ Gestione materiali utilizzati nei trattamenti

## Componenti da Implementare (30%)

- 🚧 Protocolli clinici avanzati per pazienti in gravidanza (50%)
- 🚧 Sistema di follow-up post-trattamento configurabile (40%)
- 🚧 Integrazione completa con sistema di imaging dentale (30%)
- 🚧 Modulo di consenso informato specifico per trattamento (60%)
- 🚧 Dashboard clinica per monitoraggio outcomes (25%)
- 📅 Integrazione con linee guida cliniche automatizzate
- 📅 Sistema di alert per interazioni farmacologiche

## Architettura del Sistema

Il sistema di gestione trattamenti è strutturato secondo un'architettura modulare che integra le funzionalità cliniche con i processi amministrativi:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Catalogo         │       │  Protocolli       │       │  Piano            │
│  Trattamenti      │◄─────►│  Clinici          │◄─────►│  Trattamento      │
│                   │       │                   │       │                   │
└─────────┬─────────┘       └───────────────────┘       └─────────┬─────────┘
          │                                                       │
          │                                                       │
          ▼                                                       ▼
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Appuntamenti     │◄─────►│  Esecuzione       │◄─────►│  Documentazione   │
│                   │       │  Trattamento      │       │  Clinica          │
│                   │       │                   │       │                   │
└───────────────────┘       └─────────┬─────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
                            ┌───────────────────┐
                            │                   │
                            │  Follow-up        │
                            │  Risultati        │
                            │                   │
                            └───────────────────┘
```

## Modello dei Dati

### Trattamento

```php
// Modules/Dental/Models/Treatment.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    use HasFactory;
    
    /**
     * Gli attributi assegnabili in massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'duration_minutes',
        'base_price',
        'is_active',
        'pregnancy_safe',
        'pregnancy_trimester_restrictions',
        'preparation_instructions',
        'post_treatment_instructions',
        'medical_warnings',
        'materials_needed',
    ];
    
    /**
     * Gli attributi che devono essere castati.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pregnancy_trimester_restrictions' => 'array',
        'materials_needed' => 'array',
        'is_active' => 'boolean',
        'pregnancy_safe' => 'boolean',
    ];
    
    /**
     * Recupera la categoria del trattamento.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TreatmentCategory::class, 'category_id');
    }
    
    /**
     * Recupera le specializzazioni richieste per il trattamento.
     */
    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }
    
    /**
     * Recupera i trattamenti eseguiti basati su questo tipo.
     */
    public function executedTreatments(): HasMany
    {
        return $this->hasMany(ExecutedTreatment::class);
    }
    
    /**
     * Verifica se il trattamento è sicuro per il trimestre specificato.
     */
    public function isSafeForTrimester(int $trimester): bool
    {
        if (!$this->pregnancy_safe) {
            return false;
        }
        
        $restrictions = $this->pregnancy_trimester_restrictions ?? [];
        
        return !in_array($trimester, $restrictions);
    }
}
```

### Esecuzione Trattamento

```php
// Modules/Dental/Models/ExecutedTreatment.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Patient\Models\Patient;

class ExecutedTreatment extends Model
{
    use HasFactory;
    
    /**
     * Gli attributi assegnabili in massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'treatment_id',
        'patient_id',
        'dentist_id',
        'appointment_id',
        'execution_date',
        'status',
        'notes',
        'clinical_description',
        'materials_used',
        'follow_up_needed',
        'follow_up_date',
        'tooth_number',
        'quadrant',
        'price',
        'isee_covered',
    ];
    
    /**
     * Gli attributi che devono essere castati.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'execution_date' => 'datetime',
        'follow_up_date' => 'datetime',
        'materials_used' => 'array',
        'follow_up_needed' => 'boolean',
        'isee_covered' => 'boolean',
    ];
    
    /**
     * Possibili stati del trattamento.
     */
    public const STATUS_PLANNED = 'planned';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    
    /**
     * Recupera il trattamento associato.
     */
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
    
    /**
     * Recupera il paziente associato.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    
    /**
     * Recupera il dentista associato.
     */
    public function dentist(): BelongsTo
    {
        return $this->belongsTo(Dentist::class);
    }
    
    /**
     * Recupera l'appuntamento associato.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    
    /**
     * Recupera i documenti clinici associati.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    
    /**
     * Verifica se il follow-up è scaduto.
     */
    public function isFollowUpOverdue(): bool
    {
        return $this->follow_up_needed && 
               $this->follow_up_date && 
               $this->follow_up_date->isPast() && 
               $this->status !== self::STATUS_CANCELLED;
    }
}
```

## Protocolli Clinici

I protocolli clinici per pazienti in gravidanza (in fase di implementazione) includono:

1. **Linee Guida per Trimestre**:
   - Primo trimestre: trattamenti essenziali solo
   - Secondo trimestre: periodo ottimale per trattamenti
   - Terzo trimestre: evitare procedure lunghe, posizione semi-supina

2. **Procedure di Emergenza**:
   - Protocolli per gestione dolore acuto
   - Adattamenti anestesia per gravidanza
   - Comunicazione con ginecologo

3. **Farmacologia Adattata**:
   - Elenco farmaci sicuri per trimestre
   - Alternative per antibiotici controindicati
   - Dosaggi adattati per stato gravidanza

## Interfaccia in Filament

L'interfaccia di gestione trattamenti utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Dental/Filament/Resources/TreatmentResource.php
namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Dental\Models\Treatment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TreatmentResource extends XotBaseResource
{
    protected static ?string $model = Treatment::class;
    
    public static function getFormSchema(): array
    {
        return [
            'basic_info' => Forms\Components\Section::make('Informazioni Base')
                ->schema([
                    'code' => Forms\Components\TextInput::make('code')
                        ->label('Codice')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(20),
                    'name' => Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(100),
                    'category_id' => Forms\Components\Select::make('category_id')
                        ->label('Categoria')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable(),
                    'duration_minutes' => Forms\Components\TextInput::make('duration_minutes')
                        ->label('Durata (minuti)')
                        ->required()
                        ->numeric()
                        ->minValue(5)
                        ->maxValue(240),
                    'base_price' => Forms\Components\TextInput::make('base_price')
                        ->label('Prezzo Base')
                        ->required()
                        ->numeric()
                        ->prefix('€'),
                    'is_active' => Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true),
                ])
                ->columns(2),
                
            'pregnancy_info' => Forms\Components\Section::make('Informazioni Gravidanza')
                ->schema([
                    'pregnancy_safe' => Forms\Components\Toggle::make('pregnancy_safe')
                        ->label('Sicuro in gravidanza')
                        ->default(true)
                        ->reactive(),
                    'pregnancy_trimester_restrictions' => Forms\Components\CheckboxList::make('pregnancy_trimester_restrictions')
                        ->label('Restrizioni per trimestre')
                        ->options([
                            1 => 'Primo trimestre',
                            2 => 'Secondo trimestre',
                            3 => 'Terzo trimestre',
                        ])
                        ->hidden(fn (Forms\Get $get) => !$get('pregnancy_safe')),
                    'medical_warnings' => Forms\Components\Textarea::make('medical_warnings')
                        ->label('Avvertenze Mediche')
                        ->rows(3),
                ])
                ->columns(2),
                
            'instructions' => Forms\Components\Section::make('Istruzioni')
                ->schema([
                    'preparation_instructions' => Forms\Components\Textarea::make('preparation_instructions')
                        ->label('Istruzioni di Preparazione')
                        ->rows(3),
                    'post_treatment_instructions' => Forms\Components\Textarea::make('post_treatment_instructions')
                        ->label('Istruzioni Post-Trattamento')
                        ->rows(3),
                ]),
                
            'materials' => Forms\Components\Section::make('Materiali')
                ->schema([
                    'materials_needed' => Forms\Components\TagsInput::make('materials_needed')
                        ->label('Materiali Necessari'),
                ]),
                
            'description' => Forms\Components\Section::make('Descrizione')
                ->schema([
                    'description' => Forms\Components\RichEditor::make('description')
                        ->label('Descrizione Completa')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('treatments')
                        ->toolbarButtons([
                            'blockquote',
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ]),
                ]),
        ];
    }
    
    // Implementazione tabella e altre funzionalità...
}
```

## Integrazione con Sistema di Imaging

L'integrazione con il sistema di imaging dentale (30% completata) prevede:

1. **Storage Immagini**:
   - PACS integrato per conservazione a lungo termine
   - Viewer DICOM integrato nell'interfaccia
   - Supporto per radiografie panoramiche e periapicali

2. **Workflow Immagini**:
   - Acquisizione (diretta o importazione)
   - Elaborazione e miglioramento
   - Refertazione e annotazioni
   - Archiviazione sicura

## Sistema di Consenso Informato

Il modulo di consenso informato specifico per trattamento (60% completato) include:

1. **Template Dinamici**:
   - Personalizzati per tipologia trattamento
   - Adattati per stato di gravidanza
   - Multilingua per accessibilità

2. **Processo di Acquisizione**:
   - Firma elettronica integrata
   - Archiviazione a norma di legge
   - Tracciamento versioni e revisioni

```php
// Modules/Dental/Models/InformedConsent.php
class InformedConsent extends Model
{
    protected $fillable = [
        'patient_id',
        'treatment_id',
        'dentist_id',
        'appointment_id',
        'template_version',
        'content',
        'signature_data',
        'signature_date',
        'witness_id',
        'is_signed',
        'revoked_at',
        'revocation_reason',
    ];
    
    protected $casts = [
        'signature_date' => 'datetime',
        'revoked_at' => 'datetime',
        'is_signed' => 'boolean',
        'signature_data' => 'array',
    ];
    
    // Relazioni e metodi...
}
```

## Dashboard Clinica

La dashboard clinica per monitoraggio outcomes (25% completata) include:

1. **KPI Clinici**:
   - Tasso di successo trattamenti
   - Complicazioni per tipologia
   - Follow-up completati vs. pianificati

2. **Visualizzazioni**:
   - Distribuzione trattamenti per categoria
   - Trend temporali risultati clinici
   - Heat map problematiche ricorrenti

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Protocolli clinici | Maggio 2024 | Alta |
| Sistema follow-up | Maggio 2024 | Alta |
| Integrazione imaging | Giugno 2024 | Media |
| Consensi informati | Maggio 2024 | Alta |
| Dashboard clinica | Giugno 2024 | Media |
| Linee guida automatizzate | Luglio 2024 | Bassa |
| Alert interazioni | Luglio 2024 | Media |

## Integrazione con Altri Moduli

L'integrazione avanzata dei trattamenti si collega con:

1. **Modulo Patient**:
   - Storico trattamenti paziente
   - Valutazione idoneità per stato gravidanza

2. **Modulo Appointment**:
   - Pianificazione in base a tipo trattamento
   - Sequenze di appuntamenti per piani terapia

3. **Modulo ISEE**:
   - Valutazione copertura trattamenti
   - Calcolo quota a carico paziente

4. **Modulo Reporting**:
   - Statistiche cliniche
   - Report per enti finanziatori

## Considerazioni di Qualità Clinica

Il sistema implementa misure per garantire elevati standard qualitativi:

1. **Monitoraggio Outcomes**:
   - Tracking risultati clinici
   - Confronto con benchmark di settore
   - Analisi cause insuccessi

2. **Formazione Continua**:
   - Collegamento con protocolli aggiornati
   - Suggerimenti basati su linee guida
   - Alert per nuove raccomandazioni

## Metriche di Successo

- Riduzione complicazioni durante gravidanza del 40%
- Tasso completamento trattamenti > 95%
- Riduzione tempo documentazione clinica del 30%
- Soddisfazione pazienti > 4.5/5
- Conformità linee guida ministeriali 100%
