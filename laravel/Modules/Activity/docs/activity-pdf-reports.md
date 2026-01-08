# Activity Log PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle attività utente utilizzando HTML2PDF con integrazione nativa nel modulo Activity.

---

## 🎯 Funzionalità PDF

### 1. Report Attività Utente

Genera report completi delle attività di un utente specifico:

```php
use Modules\Activity\Actions\GenerateActivityPdfAction;

// Generate PDF for user activities
$pdf = app(GenerateActivityPdfAction::class)->execute(
    user: $user,
    dateRange: [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    filters: [
        'event_types' => ['created', 'updated', 'deleted'],
        'subject_types' => ['App\Models\User', 'App\Models\Post'],
    ]
);
```

### 2. Report Dettaglio Record

Report delle attività per un record specifico:

```php
// Generate PDF for record activities
$pdf = app(GenerateActivityPdfAction::class)->execute(
    subject: $record,
    includeProperties: true,
    formatChanges: true
);
```

### 3. Report Audit Trail

Report completo di audit trail per compliance:

```php
// Generate audit trail PDF
$pdf = app(GenerateActivityPdfAction::class)->execute(
    auditTrail: true,
    dateRange: [
        'start' => now()->subYear(),
        'end' => now(),
    ],
    includeMetadata: true
);
```

---

## 🏗️ Architettura PDF

### 1. Service Class

```php
<?php

namespace Modules\Activity\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Modules\Activity\Models\Activity;
use Illuminate\Support\Collection;

class ActivityPdfService
{
    public function generateUserReport($user, array $options = []): string
    {
        try {
            $activities = $this->getUserActivities($user, $options);
            
            $html = view('activity::pdf.user-report', [
                'user' => $user,
                'activities' => $activities,
                'options' => $options,
                'generatedAt' => now(),
            ])->render();
            
            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);
            
            return $html2pdf->output('', 'S');
            
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new PdfGenerationException('Failed to generate activity PDF: ' . $e->getMessage());
        }
    }
    
    private function getUserActivities($user, array $options): Collection
    {
        $query = Activity::where('causer_id', $user->id)
                        ->where('causer_type', get_class($user));
        
        if (isset($options['date_range'])) {
            $query->whereBetween('created_at', $options['date_range']);
        }
        
        if (isset($options['event_types'])) {
            $query->whereIn('event', $options['event_types']);
        }
        
        return $query->with('subject')
                    ->orderBy('created_at', 'desc')
                    ->limit(1000)
                    ->get();
    }
}
```

### 2. Action Class

```php
<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Services\ActivityPdfService;
use Modules\Xot\Actions\Pdf\StreamDownloadPdfAction;

class GenerateActivityPdfAction
{
    private ActivityPdfService $pdfService;
    
    public function __construct(ActivityPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }
    
    public function execute(array $params): string
    {
        if (isset($params['user'])) {
            return $this->pdfService->generateUserReport($params['user'], $params);
        }
        
        if (isset($params['subject'])) {
            return $this->pdfService->generateSubjectReport($params['subject'], $params);
        }
        
        if ($params['audit_trail'] ?? false) {
            return $this->pdfService->generateAuditTrail($params);
        }
        
        throw new InvalidArgumentException('Invalid PDF generation parameters');
    }
}
```

---

## 📄 Template PDF

### 1. User Report Template

```blade
{{-- resources/views/pdf/activity-user-report.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">
                    <h1 style="font-size: 14pt; margin: 0;">
                        Report Attività Utente
                    </h1>
                    <p style="font-size: 10pt; margin: 3mm 0 0 0;">
                        {{ $user->name }} ({{ $user->email }})
                    </p>
                </td>
                <td style="width: 50%; text-align: right; font-size: 9pt;">
                    Generato il: {{ $generatedAt->format('d/m/Y H:i') }}<br>
                    Periodo: {{ $options['date_range']['start']->format('d/m/Y') }} - 
                              {{ $options['date_range']['end']->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <div style="border-bottom: 2px solid #2c3e50; margin-top: 5mm;"></div>
    </page_header>

    <div style="margin: 15mm 0;">
        <!-- Summary Statistics -->
        <div style="background-color: #f8f9fa; padding: 10mm; margin-bottom: 10mm;">
            <h2 style="font-size: 12pt; margin: 0 0 5mm 0;">Riepilogo Attività</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 25%; padding: 3mm;">
                        <strong>Totale Attività:</strong>
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        {{ $activities->count() }}
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        <strong>Eventi Creazione:</strong>
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        {{ $activities->where('event', 'created')->count() }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%; padding: 3mm;">
                        <strong>Eventi Modifica:</strong>
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        {{ $activities->where('event', 'updated')->count() }}
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        <strong>Eventi Cancellazione:</strong>
                    </td>
                    <td style="width: 25%; padding: 3mm;">
                        {{ $activities->where('event', 'deleted')->count() }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Activities List -->
        <h2 style="font-size: 12pt; margin-bottom: 8mm;">Dettaglio Attività</h2>
        
        @foreach($activities as $activity)
        <div style="margin-bottom: 8mm; padding: 8mm; border: 1px solid #dee2e6; background-color: {{ $loop->index % 2 == 0 ? '#ffffff' : '#f8f9fa' }};">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%; font-size: 9pt; color: #6c757d;">
                        {{ $activity->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td style="width: 20%; font-size: 9pt; font-weight: bold;">
                        {{ strtoupper($activity->event) }}
                    </td>
                    <td style="width: 60%; font-size: 10pt;">
                        {{ $activity->description }}
                    </td>
                </tr>
                @if($activity->subject)
                <tr>
                    <td colspan="3" style="font-size: 9pt; color: #6c757d; padding-top: 3mm;">
                        Risorsa: {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                        @if($activity->subject && method_exists($activity->subject, 'getName'))
                            - {{ $activity->subject->getName() }}
                        @endif
                    </td>
                </tr>
                @endif
                @if($activity->properties && isset($activity->properties['attributes']))
                <tr>
                    <td colspan="3" style="padding-top: 3mm;">
                        <div style="background-color: #e9ecef; padding: 5mm; font-size: 8pt;">
                            <strong>Cambiamenti:</strong>
                            @foreach($activity->properties['attributes'] as $key => $value)
                                {{ $key }}: {{ is_string($value) ? $value : json_encode($value) }}<br>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        @endforeach
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #6c757d;">
            <tr>
                <td style="width: 50%;">
                    Report generato da PTVX - Activity Module
                </td>
                <td style="width: 50%; text-align: right;">
                    Pagina [[page_cu]] di [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. Subject Report Template

```blade
{{-- resources/views/pdf/activity-subject-report.blade.php --}}
<page>
    <page_header>
        <h1 style="font-size: 16pt; text-align: center;">
            Report Attività - {{ class_basename($subject) }} #{{ $subject->id }}
        </h1>
    </page_header>

    <div style="margin: 15mm 0;">
        @if($subject && method_exists($subject, 'getDisplayName'))
        <div style="background-color: #f8f9fa; padding: 10mm; margin-bottom: 10mm;">
            <h2 style="font-size: 12pt; margin: 0 0 5mm 0;">Informazioni Record</h2>
            <p style="font-size: 10pt; margin: 0;">
                {{ $subject->getDisplayName() }}
            </p>
        </div>
        @endif

        <h2 style="font-size: 12pt; margin-bottom: 8mm;">Storico Modifiche</h2>
        
        @foreach($activities as $activity)
        <div style="margin-bottom: 10mm;">
            <div style="font-size: 10pt; font-weight: bold; margin-bottom: 3mm;">
                {{ $activity->created_at->format('d/m/Y H:i') }} - {{ $activity->description }}
            </div>
            
            @if($activity->properties)
            <div style="margin-left: 10mm; font-size: 9pt;">
                @if(isset($activity->properties['old']))
                <div style="margin-bottom: 3mm;">
                    <strong>Valori Precedenti:</strong>
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($activity->properties['old'] as $key => $value)
                        <tr>
                            <td style="width: 30%; padding: 2mm; background-color: #f8d7da;">
                                {{ $key }}
                            </td>
                            <td style="width: 70%; padding: 2mm; background-color: #f8d7da;">
                                {{ $value }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
                @if(isset($activity->properties['attributes']))
                <div>
                    <strong>Nuovi Valori:</strong>
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($activity->properties['attributes'] as $key => $value)
                        <tr>
                            <td style="width: 30%; padding: 2mm; background-color: #d4edda;">
                                {{ $key }}
                            </td>
                            <td style="width: 70%; padding: 2mm; background-color: #d4edda;">
                                {{ $value }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endforeach
    </div>
</page>
```

---

## 🔧 Filament Integration

### 1. PDF Action in Resource

```php
<?php

namespace Modules\Activity\Filament\Actions;

use Filament\Actions\Action;
use Modules\Activity\Actions\GenerateActivityPdfAction;

class ExportActivityPdfAction extends Action
{
    public static function make(string $name = 'export_pdf'): static
    {
        return parent::make($name)
            ->label('Esporta PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->action(function (array $data) {
                $user = auth()->user();
                
                $pdf = app(GenerateActivityPdfAction::class)->execute([
                    'user' => $user,
                    'date_range' => [
                        'start' => \Carbon\Carbon::parse($data['start_date']),
                        'end' => \Carbon\Carbon::parse($data['end_date']),
                    ],
                    'event_types' => $data['event_types'] ?? null,
                ]);
                
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "activity_report_{$user->id}.pdf");
            })
            ->form([
                \Filament\Forms\Components\DatePicker::make('start_date')
                    ->label('Data Inizio')
                    ->required()
                    ->default(now()->subMonth()),
                
                \Filament\Forms\Components\DatePicker::make('end_date')
                    ->label('Data Fine')
                    ->required()
                    ->default(now()),
                
                \Filament\Forms\Components\CheckboxList::make('event_types')
                    ->label('Tipi Evento')
                    ->options([
                        'created' => 'Creazione',
                        'updated' => 'Modifica',
                        'deleted' => 'Cancellazione',
                    ])
                    ->default(['created', 'updated', 'deleted']),
            ]);
    }
}
```

### 2. Resource Integration

```php
// In UserResource.php
public static function getTableActions(): array
{
    return [
        ExportActivityPdfAction::make(),
        // ... altre actions
    ];
}

// In ActivityResource.php
public static function getActions(): array
{
    return [
        ExportActivityPdfAction::make('export_subject_pdf')
            ->label('Esporta PDF Record')
            ->action(function (Activity $record) {
                $pdf = app(GenerateActivityPdfAction::class)->execute([
                    'subject' => $record->subject,
                    'includeProperties' => true,
                    'formatChanges' => true,
                ]);
                
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "activity_{$record->id}_report.pdf");
            }),
        // ... altre actions
    ];
}
```

---

## 🧪 Testing

### 1. Unit Tests

```php
<?php

namespace Modules\Activity\Tests\Unit;

use Tests\TestCase;
use Modules\Activity\Services\ActivityPdfService;
use Modules\Activity\Models\Activity;
use App\Models\User;

class ActivityPdfTest extends TestCase
{
    /** @test */
    public function it_generates_user_activity_pdf()
    {
        $user = User::factory()->create();
        Activity::factory()->count(10)->create([
            'causer_id' => $user->id,
            'causer_type' => User::class,
        ]);
        
        $service = app(ActivityPdfService::class);
        $pdfContent = $service->generateUserReport($user, [
            'date_range' => [
                'start' => now()->subMonth(),
                'end' => now(),
            ]
        ]);
        
        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(1000, strlen($pdfContent));
        $this->assertStringContainsString('Report Attività Utente', $pdfContent);
    }
    
    /** @test */
    public function it_handles_large_activity_sets()
    {
        $user = User::factory()->create();
        Activity::factory()->count(1500)->create([
            'causer_id' => $user->id,
            'causer_type' => User::class,
        ]);
        
        $service = app(ActivityPdfService::class);
        
        // Should limit to 1000 activities
        $pdfContent = $service->generateUserReport($user);
        
        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertStringContainsString('1000', $pdfContent); // Summary count
    }
}
```

### 2. Feature Tests

```php
/** @test */
public function user_can_export_activity_pdf()
{
    $user = User::factory()->create();
    Activity::factory()->count(5)->create([
        'causer_id' => $user->id,
        'causer_type' => User::class,
    ]);
    
    $response = $this->actingAs($user)
                    ->post('/activity/export-pdf', [
                        'start_date' => now()->subMonth()->format('Y-m-d'),
                        'end_date' => now()->format('Y-m-d'),
                    ]);
    
    $response->assertSuccessful();
    $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
}
```

---

## 📊 Performance Optimization

### 1. Caching Strategy

```php
class ActivityPdfService
{
    public function generateCachedUserReport($user, array $options = []): string
    {
        $cacheKey = 'activity_pdf_' . md5(json_encode([
            'user_id' => $user->id,
            'options' => $options,
            'last_activity' => $user->activities()->max('created_at'),
        ]));
        
        return Cache::remember($cacheKey, 3600, function () use ($user, $options) {
            return $this->generateUserReport($user, $options);
        });
    }
}
```

### 2. Memory Management

```php
private function optimizeHtmlForPdf(string $html): string
{
    // Remove unnecessary whitespace
    $html = preg_replace('/\s+/', ' ', $html);
    
    // Limit activity count for performance
    if (str_contains($html, '@foreach($activities')) {
        // Ensure activities are limited
        $html = str_replace(
            '$activities',
            '$activities->take(1000)',
            $html
        );
    }
    
    return $html;
}
```

---

## 🚀 Error Handling

### 1. PDF Generation Errors

```php
public function generateWithErrorHandling($user, array $options = []): string
{
    try {
        return $this->generateUserReport($user, $options);
        
    } catch (Html2PdfException $e) {
        Log::error('Activity PDF generation failed', [
            'user_id' => $user->id,
            'error' => $e->getMessage(),
            'options' => $options,
        ]);
        
        // Generate simplified fallback PDF
        return $this->generateFallbackPdf($user, $e);
        
    } catch (Exception $e) {
        Log::error('Unexpected error in activity PDF generation', [
            'user_id' => $user->id,
            'error' => $e->getMessage(),
        ]);
        
        throw new PdfGenerationException('Failed to generate activity PDF');
    }
}

private function generateFallbackPdf($user, Exception $e): string
{
    $html = view('activity::pdf.fallback', [
        'user' => $user,
        'error' => $e->getMessage(),
    ])->render();
    
    $html2pdf = new Html2Pdf();
    $html2pdf->writeHTML($html);
    
    return $html2pdf->output('', 'S');
}
```

---

## 📚 References

- [HTML2PDF Best Practices](../../Xot/docs/html2pdf-best-practices.md)
- [Activity Module README](./README.md)
- [Filament Actions Documentation](https://filamentphp.com/docs/3.x/actions/overview)
- [Spatie Activity Log](https://spatie.be/docs/laravel-activitylog)

---

**Last Updated:** 2025-12-09  
**Version:** 1.0.0  
 **HTML2PDF Version:** 5.2.x  
**PHPStan Level:** 10 ✅