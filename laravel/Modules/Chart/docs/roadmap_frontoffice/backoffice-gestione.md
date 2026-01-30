# Backoffice: Gestione Documentazione

## Panoramica
Il modulo di gestione documentazione del backoffice permette agli amministratori di visualizzare, verificare e gestire tutti i documenti caricati dagli utenti (pazienti e odontoiatri). Questo sistema è fondamentale per il processo di verifica dell'identità, delle qualifiche professionali e dell'ISEE, garantendo la conformità con i requisiti normativi.

**Percentuale di completamento: 80%**

## Componenti Principali

### 1. Visualizzatore Documenti
- **Implementazione**: 85% completata
- **Descrizione**: Interfaccia avanzata per visualizzare documenti in vari formati (PDF, JPG, PNG) direttamente nel browser.
- **Funzionalità**:
  - Zoom e rotazione documenti
  - Anteprima multi-pagina per PDF
  - Annotazioni e commenti
  - Confronto documenti lato a lato
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Media/app/Http/Livewire/DocumentViewer.php
  namespace Modules\Media\Http\Livewire;
  
  use Livewire\Component;
  use Modules\Media\Models\Document;
  
  class DocumentViewer extends Component
  {
      public Document $document;
      public bool $isRotated = false;
      public int $zoom = 100;
      public array $annotations = [];
      
      public function mount(Document $document): void
      {
          $this->document = $document;
          $this->annotations = $document->annotations ?? [];
      }
      
      public function rotate(): void
      {
          $this->isRotated = !$this->isRotated;
      }
      
      public function zoomIn(): void
      {
          $this->zoom = min($this->zoom + 25, 200);
      }
      
      public function zoomOut(): void
      {
          $this->zoom = max($this->zoom - 25, 50);
      }
      
      public function saveAnnotation(string $text, array $position): void
      {
          $this->annotations[] = [
              'text' => $text,
              'position' => $position,
              'created_at' => now()->toIso8601String(),
              'user_id' => auth()->id(),
          ];
          
          $this->document->update(['annotations' => $this->annotations]);
      }
      
      public function render()
      {
          return view('media::livewire.document-viewer');
      }
  }
  ```

### 2. Verifica OCR
- **Implementazione**: 75% completata
- **Descrizione**: Sistema di OCR (Optical Character Recognition) per estrazione automatica di dati da documenti.
- **Funzionalità**:
  - Estrazione automatica dati da carte d'identità
  - Riconoscimento tessere Ordine dei Medici
  - Verifica automatica ISEE
  - Evidenziazione discrepanze con dati dichiarati
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Media/app/Actions/ExtractDataFromDocumentAction.php
  namespace Modules\Media\Actions;
  
  use Modules\Media\Models\Document;
  use Spatie\LaravelData\Data;
  
  class ExtractDataFromDocumentAction
  {
      protected $ocrService;
      
      public function __construct(OcrService $ocrService)
      {
          $this->ocrService = $ocrService;
      }
      
      public function handle(Document $document): DocumentData
      {
          // Seleziona il corretto estrattore in base al tipo di documento
          $extractor = match ($document->document_type) {
              'identity_card' => new IdentityCardExtractor($this->ocrService),
              'medical_license' => new MedicalLicenseExtractor($this->ocrService),
              'isee' => new IseeExtractor($this->ocrService),
              default => new GenericDocumentExtractor($this->ocrService),
          };
          
          // Esegui l'estrazione dei dati
          $data = $extractor->extract($document->getFilePath());
          
          // Salva i dati estratti nel documento
          $document->update([
              'extracted_data' => $data->toArray(),
              'ocr_processed_at' => now(),
          ]);
          
          return $data;
      }
  }
  ```

### 3. Gestione Versioni
- **Implementazione**: 70% completata
- **Descrizione**: Sistema per tenere traccia delle diverse versioni dei documenti caricati.
- **Funzionalità**:
  - Storico completo versioni
  - Differenze evidenziate tra versioni
  - Ripristino versioni precedenti
  - Note di revisione
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Media/app/Models/DocumentVersion.php
  namespace Modules\Media\Models;
  
  use Modules\Xot\Models\BaseModel;
  
  class DocumentVersion extends BaseModel
  {
      protected $fillable = [
          'document_id',
          'file_path',
          'mime_type',
          'file_size',
          'version_number',
          'created_by',
          'notes',
          'hash',
      ];
      
      protected $casts = [
          'file_size' => 'integer',
          'version_number' => 'integer',
          'created_at' => 'datetime',
      ];
      
      public function document()
      {
          return $this->belongsTo(Document::class);
      }
      
      public function creator()
      {
          return $this->belongsTo(User::class, 'created_by');
      }
  }
  ```

### 4. Validazione Documenti
- **Implementazione**: 85% completata
- **Descrizione**: Processo di validazione dei documenti con supporto per decisioni e feedback.
- **Flusso di Lavoro**:
  1. Upload documento da parte dell'utente
  2. Elaborazione OCR automatica
  3. Verifica manuale da parte dell'amministratore
  4. Decisione (approvato/rifiutato/richiesta integrazione)
  5. Notifica all'utente
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Actions/ValidateDocumentAction.php
  namespace Modules\Admin\Actions;
  
  use Modules\Media\Models\Document;
  use Modules\Admin\Enums\DocumentStatus;
  
  class ValidateDocumentAction
  {
      public function handle(Document $document, DocumentStatus $status, ?string $note = null, ?string $feedback = null): bool
      {
          // Aggiorna lo stato del documento
          $document->update([
              'status' => $status,
              'validated_at' => now(),
              'validated_by' => auth()->id(),
              'internal_note' => $note,
              'user_feedback' => $feedback,
          ]);
          
          // Se il documento è stato rifiutato o richiede integrazione, invia notifica
          if ($status === DocumentStatus::REJECTED || $status === DocumentStatus::REQUIRES_ADDITIONAL_INFO) {
              $this->notifyUser($document, $status, $feedback);
          }
          
          // Se tutti i documenti di questo tipo sono stati approvati, aggiorna lo stato di verifica
          if ($status === DocumentStatus::APPROVED) {
              $this->checkAllDocumentsApproved($document);
          }
          
          return true;
      }
      
      protected function notifyUser(Document $document, DocumentStatus $status, ?string $feedback): void
      {
          // Invia notifica all'utente
      }
      
      protected function checkAllDocumentsApproved(Document $document): void
      {
          // Verifica se tutti i documenti sono stati approvati
      }
  }
  ```

### 5. Dashboard Documenti
- **Implementazione**: 80% completata
- **Descrizione**: Vista centralizzata per monitorare lo stato dei documenti in attesa di verifica.
- **Funzionalità**:
  - Filtri avanzati per tipo documento, stato, data
  - Code di approvazione con priorità
  - Metriche di completamento
  - Report di attività
- **File di Implementazione**:
  ```php
  // /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Filament/Resources/DocumentResource.php
  namespace Modules\Admin\Filament\Resources;
  
  use Filament\Tables\Columns\BadgeColumn;
  use Filament\Tables\Columns\TextColumn;
  use Filament\Tables\Filters\SelectFilter;
  use Modules\Admin\Enums\DocumentStatus;
  use Modules\Media\Models\Document;
  use Modules\Xot\Filament\Resources\XotBaseResource;
  
  class DocumentResource extends XotBaseResource
  {
      protected static ?string $model = Document::class;
      
      public static function getFormSchema(): array
      {
          // Schema form con tutti i campi
      }
      
      public static function getTableColumns(): array
      {
          return [
              'id' => TextColumn::make('id')
                  ->label(__('admin.documents.fields.id.label'))
                  ->sortable(),
                  
              'document_type' => TextColumn::make('document_type')
                  ->label(__('admin.documents.fields.document_type.label'))
                  ->sortable()
                  ->searchable(),
                  
              'file_name' => TextColumn::make('file_name')
                  ->label(__('admin.documents.fields.file_name.label'))
                  ->searchable(),
                  
              'status' => BadgeColumn::make('status')
                  ->label(__('admin.documents.fields.status.label'))
                  ->enum(DocumentStatus::class)
                  ->colors([
                      'gray' => DocumentStatus::PENDING->value,
                      'success' => DocumentStatus::APPROVED->value,
                      'danger' => DocumentStatus::REJECTED->value,
                      'warning' => DocumentStatus::REQUIRES_ADDITIONAL_INFO->value,
                  ]),
                  
              'uploaded_at' => DateTimeColumn::make('created_at')
                  ->label(__('admin.documents.fields.uploaded_at.label'))
                  ->sortable(),
                  
              'user.name' => TextColumn::make('user.name')
                  ->label(__('admin.documents.fields.user.label'))
                  ->searchable()
                  ->sortable(),
          ];
      }
      
      public static function getTableFilters(): array
      {
          return [
              SelectFilter::make('document_type')
                  ->label(__('admin.documents.filters.document_type.label'))
                  ->options([
                      'identity_card' => __('admin.documents.filters.document_type.options.identity_card'),
                      'medical_license' => __('admin.documents.filters.document_type.options.medical_license'),
                      'isee' => __('admin.documents.filters.document_type.options.isee'),
                      // Altri tipi...
                  ]),
                  
              SelectFilter::make('status')
                  ->label(__('admin.documents.filters.status.label'))
                  ->options(DocumentStatus::class),
                  
              // Altri filtri...
          ];
      }
      
      public static function getTableActions(): array
      {
          return [
              // Azioni per approvare, rifiutare o richiedere integrazioni
          ];
      }
  }
  ```

## OCR e Estrazione Dati

Esempio di implementazione dell'estrazione dati da carta d'identità:

```php
// /var/www/html/<nome progetto>/laravel/Modules/Media/app/Services/Extractors/IdentityCardExtractor.php
namespace Modules\Media\Services\Extractors;

use Modules\Media\Contracts\DocumentExtractor;
use Modules\Media\Data\IdentityCardData;
use Modules\Media\Services\OcrService;

class IdentityCardExtractor implements DocumentExtractor
{
    protected $ocrService;
    
    public function __construct(OcrService $ocrService)
    {
        $this->ocrService = $ocrService;
    }
    
    public function extract(string $filePath): IdentityCardData
    {
        // Esegui OCR sul documento
        $text = $this->ocrService->recognizeText($filePath);
        
        // Estrai i dati utilizzando pattern matching o NLP
        $data = $this->parseIdentityCardText($text);
        
        return new IdentityCardData(
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
            placeOfBirth: $data['place_of_birth'] ?? null,
            documentNumber: $data['document_number'] ?? null,
            issuedBy: $data['issued_by'] ?? null,
            issueDate: $data['issue_date'] ?? null,
            expiryDate: $data['expiry_date'] ?? null,
            fiscalCode: $data['fiscal_code'] ?? null,
            confidenceScore: $data['confidence_score'] ?? 0.0,
        );
    }
    
    protected function parseIdentityCardText(string $text): array
    {
        // Implementa la logica di parsing per estrarre i dati dal testo OCR
        // Utilizza regex, algoritmi di NLP o altre tecniche
        
        // Esempio semplificato con regex
        $data = [];
        
        // Estrai cognome
        if (preg_match('/COGNOME[:\s]+([^\n]+)/i', $text, $matches)) {
            $data['last_name'] = trim($matches[1]);
        }
        
        // Estrai nome
        if (preg_match('/NOME[:\s]+([^\n]+)/i', $text, $matches)) {
            $data['first_name'] = trim($matches[1]);
        }
        
        // Estrai data di nascita (formato GG/MM/AAAA)
        if (preg_match('/(?:NATO|NATA)(?:\sIL)?[:\s]+(\d{2}[\/\.\-]\d{2}[\/\.\-]\d{4})/i', $text, $matches)) {
            $data['date_of_birth'] = trim($matches[1]);
        }
        
        // Altri campi...
        
        return $data;
    }
}
```

## Interfaccia Utente

### Componente Validazione Documenti

```blade
{{-- /var/www/html/<nome progetto>/laravel/Modules/Admin/resources/views/components/document-validation-card.blade.php --}}
<div class="rounded-lg border border-gray-300 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold">{{ $document->document_type_label }}</h3>
        
        <span @class([
            'rounded-full px-3 py-1 text-xs font-semibold',
            'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' => $document->status === \Modules\Admin\Enums\DocumentStatus::PENDING,
            'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $document->status === \Modules\Admin\Enums\DocumentStatus::APPROVED,
            'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => $document->status === \Modules\Admin\Enums\DocumentStatus::REJECTED,
            'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' => $document->status === \Modules\Admin\Enums\DocumentStatus::REQUIRES_ADDITIONAL_INFO,
        ])>
            {{ $document->status_label }}
        </span>
    </div>
    
    <div class="mb-4 h-64 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
        @if ($document->isImage())
            <img src="{{ $document->url }}" alt="{{ $document->file_name }}" class="h-full w-full object-contain">
        @elseif ($document->isPdf())
            <iframe src="{{ $document->url }}#toolbar=0" class="h-full w-full"></iframe>
        @else
            <div class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-900">
                <x-filament::icon name="heroicon-o-document" class="h-16 w-16 text-gray-400" />
            </div>
        @endif
    </div>
    
    <div class="mb-4">
        <h4 class="mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('admin.documents.validation.extracted_data') }}</h4>
        
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
            @if (empty($document->extracted_data))
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.documents.validation.no_extracted_data') }}</p>
            @else
                <dl class="grid grid-cols-2 gap-x-4 gap-y-2">
                    @foreach ($document->extracted_data as $key => $value)
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $key }}</dt>
                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $value }}</dd>
                    @endforeach
                </dl>
            @endif
        </div>
    </div>
    
    <div class="mt-4 space-x-2">
        <x-filament::button
            wire:click="approveDocument({{ $document->id }})"
            color="success"
            :disabled="$document->status === \Modules\Admin\Enums\DocumentStatus::APPROVED"
        >
            {{ __('admin.documents.validation.approve') }}
        </x-filament::button>
        
        <x-filament::button
            wire:click="$set('showRejectModal', true)"
            wire:click.prevent="selectDocument({{ $document->id }})"
            color="danger"
            :disabled="$document->status === \Modules\Admin\Enums\DocumentStatus::REJECTED"
        >
            {{ __('admin.documents.validation.reject') }}
        </x-filament::button>
        
        <x-filament::button
            wire:click="$set('showRequestInfoModal', true)"
            wire:click.prevent="selectDocument({{ $document->id }})"
            color="warning"
            :disabled="$document->status === \Modules\Admin\Enums\DocumentStatus::REQUIRES_ADDITIONAL_INFO"
        >
            {{ __('admin.documents.validation.request_info') }}
        </x-filament::button>
    </div>
</div>
```

## Notifiche di Stato dei Documenti

```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/app/Notifications/DocumentStatusChangedNotification.php
namespace Modules\Admin\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Admin\Enums\DocumentStatus;
use Modules\Media\Models\Document;
use Modules\Notify\Actions\Email\SendSpatieEmailAction;

class DocumentStatusChangedNotification extends Notification
{
    public function __construct(
        public readonly Document $document,
        public readonly DocumentStatus $status,
        public readonly ?string $feedback = null
    ) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): SpatieEmail
    {
        $templateName = match($this->status) {
            DocumentStatus::APPROVED => 'document_approved',
            DocumentStatus::REJECTED => 'document_rejected',
            DocumentStatus::REQUIRES_ADDITIONAL_INFO => 'document_requires_info',
            default => 'document_status_changed',
        };
        
        $email = new SpatieEmail($templateName, [
            'name' => $notifiable->name,
            'document_type' => $this->document->document_type_label,
            'status' => $this->status->value,
            'feedback' => $this->feedback,
            'upload_url' => route('documents.upload', ['type' => $this->document->document_type]),
        ]);
        
        // Impostazione esplicita del destinatario (regola obbligatoria)
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }
    
    public function toDatabase($notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'document_type' => $this->document->document_type,
            'status' => $this->status->value,
            'feedback' => $this->feedback,
        ];
    }
}
```

## Test e Validazione

### Test Unitari
```php
// /var/www/html/<nome progetto>/laravel/Modules/Media/Tests/Unit/ExtractDataFromDocumentActionTest.php
namespace Modules\Media\Tests\Unit;

use Tests\TestCase;
use Modules\Media\Actions\ExtractDataFromDocumentAction;
use Modules\Media\Models\Document;
use Modules\Media\Services\OcrService;

class ExtractDataFromDocumentActionTest extends TestCase
{
    /** @test */
    public function it_extracts_data_from_identity_card()
    {
        // Implementazione test
    }
    
    /** @test */
    public function it_extracts_data_from_medical_license()
    {
        // Implementazione test
    }
}
```

### Test di Integrazione
```php
// /var/www/html/<nome progetto>/laravel/Modules/Admin/Tests/Feature/DocumentValidationTest.php
namespace Modules\Admin\Tests\Feature;

use Tests\TestCase;
use Modules\Admin\Actions\ValidateDocumentAction;
use Modules\Admin\Enums\DocumentStatus;
use Modules\Media\Models\Document;

class DocumentValidationTest extends TestCase
{
    /** @test */
    public function admin_can_approve_document()
    {
        // Implementazione test
    }
    
    /** @test */
    public function admin_can_reject_document_with_feedback()
    {
        // Implementazione test
    }
}
```

## Prossimi Sviluppi
1. Implementazione analisi documenti con AI per rilevamento frodi *(Priorità: Alta)*
2. Miglioramento precisione OCR per documenti di bassa qualità *(Priorità: Media)*
3. Aggiunta supporto per verifica documenti internazionali *(Priorità: Bassa)*
4. Implementazione confronto facciale con foto documento *(Priorità: Media)*
5. Dashboard analytics per tempi di verifica documenti *(Priorità: Bassa)*

## Collegamenti Correlati
- [Backoffice Verifica](./backoffice-verifica.md)
- [Backoffice Avvisi](./backoffice-avvisi.md)
- [Backoffice Rifiuti](./backoffice-rifiuti.md)
- [Iscrizione Odontoiatra](./09-iscrizione-odontoiatra.md)
- [Iscrizione Paziente](./06-iscrizione-paziente.md)
