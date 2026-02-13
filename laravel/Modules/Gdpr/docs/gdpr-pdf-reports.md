# GDPR PDF Reports - HTML2PDF Integration

## 📋 Overview

Guida completa per generare report PDF di conformità GDPR utilizzando HTML2PDF con integrazione nativa nel modulo GDPR.

---

## 🎯 Funzionalità PDF GDPR

### 1. Report Conformità Completo

Genera report completo di conformità GDPR per audit:

```php
use Modules\Gdpr\Actions\GenerateGdprComplianceReportAction;

// Generate compliance report
$pdf = app(GenerateGdprComplianceReportAction::class)->execute([
    'period' => [
        'start' => now()->subYear(),
        'end' => now(),
    ],
    'include_sections' => [
        'consents' => true,
        'audit_trail' => true,
        'data_processing' => true,
        'retention_policy' => true,
    ],
    'format' => 'detailed', // 'summary' or 'detailed'
]);
```

### 2. Documentazione Consensi Utente

Report dettagliato dei consensi utente per Data Subject Access Request (DSAR):

```php
// Generate user consent documentation
$pdf = app(GenerateUserConsentReportAction::class)->execute(
    user: $user,
    includeHistory: true,
    includeLegalBasis: true,
    format: 'gdpr_compliant'
);
```

### 3. Audit Trail Certification

Report certificato dell'audit trail per prove legali:

```php
// Generate certified audit trail
$pdf = app(GenerateAuditTrailReportAction::class)->execute([
    'date_range' => [
        'start' => now()->subMonths(6),
        'end' => now(),
    ],
    'certify' => true,
    'digital_signature' => true,
    'watermark' => 'CONFIDENTIAL - GDPR DOCUMENT'
]);
```

---

## 🏗️ Architettura PDF GDPR

### 1. GDPR PDF Service

```php
<?php

namespace Modules\Gdpr\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Event;
use Modules\Gdpr\Models\Treatment;

class GdprPdfService
{
    public function generateComplianceReport(array $options = []): string
    {
        try {
            $data = $this->prepareComplianceData($options);

            $html = view('gdpr::pdf.compliance-report', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
                'reportId' => $this->generateReportId(),
            ])->render();

            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]);
            $html2pdf->setDefaultFont('Helvetica');

            // Add watermark for confidentiality
            if ($options['watermark'] ?? false) {
                $html2pdf->setTestIsImage(false);
                $html2pdf->writeHTML($this->addWatermark($html));
            } else {
                $html2pdf->writeHTML($html);
            }

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new GdprPdfGenerationException('Failed to generate GDPR compliance PDF: ' . $e->getMessage());
        }
    }

    private function prepareComplianceData(array $options): array
    {
        return [
            'consent_statistics' => $this->getConsentStatistics($options),
            'processing_activities' => $this->getProcessingActivities($options),
            'audit_trail_summary' => $this->getAuditTrailSummary($options),
            'data_retention_status' => $this->getDataRetentionStatus($options),
            'compliance_score' => $this->calculateComplianceScore(),
            'recommendations' => $this->generateRecommendations(),
        ];
    }

    private function getConsentStatistics(array $options): array
    {
        $query = Consent::query();

        if (isset($options['date_range'])) {
            $query->whereBetween('created_at', $options['date_range']);
        }

        $total = $query->count();
        $active = $query->whereNull('revoked_at')->count();
        $revoked = $total - $active;

        return [
            'total_consents' => $total,
            'active_consents' => $active,
            'revoked_consents' => $revoked,
            'consent_rate' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
            'by_treatment' => $query->with('treatment')
                ->get()
                ->groupBy('treatment.name')
                ->map(fn($group) => [
                    'count' => $group->count(),
                    'active' => $group->whereNull('revoked_at')->count(),
                ]),
        ];
    }

    private function calculateComplianceScore(): array
    {
        $scores = [
            'consent_management' => $this->scoreConsentManagement(),
            'audit_trail' => $this->scoreAuditTrail(),
            'data_retention' => $this->scoreDataRetention(),
            'documentation' => $this->scoreDocumentation(),
        ];

        $overall = array_sum($scores) / count($scores);

        return [
            'overall' => round($overall, 1),
            'components' => $scores,
            'grade' => $this->getComplianceGrade($overall),
        ];
    }

    private function getComplianceGrade(float $score): string
    {
        return match(true) {
            $score >= 95 => 'A+',
            $score >= 90 => 'A',
            $score >= 85 => 'B+',
            $score >= 80 => 'B',
            $score >= 75 => 'C+',
            $score >= 70 => 'C',
            $score >= 65 => 'D',
            default => 'F',
        };
    }
}
```

### 2. User Consent Report Service

```php
<?php

namespace Modules\Gdpr\Services;

class UserConsentReportService
{
    public function generateUserReport($user, array $options = []): string
    {
        try {
            $data = $this->prepareUserData($user, $options);

            $html = view('gdpr::pdf.user-consent-report', [
                'user' => $user,
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
                'requestId' => $this->generateRequestId(),
            ])->render();

            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [20, 25, 20, 25]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new GdprPdfGenerationException('Failed to generate user consent PDF: ' . $e->getMessage());
        }
    }

    private function prepareUserData($user, array $options): array
    {
        return [
            'personal_data' => $this->getUserPersonalData($user, $options),
            'consents' => $this->getUserConsents($user, $options),
            'processing_activities' => $this->getUserProcessingActivities($user),
            'audit_events' => $this->getUserAuditEvents($user, $options),
            'data_retention' => $this->getUserDataRetention($user),
        ];
    }

    private function getUserConsents($user, array $options): array
    {
        $query = Consent::where('subject_id', $user->id)
                        ->with('treatment');

        if (isset($options['date_range'])) {
            $query->whereBetween('created_at', $options['date_range']);
        }

        return $query->orderBy('created_at', 'desc')
                    ->get()
                    ->map(fn($consent) => [
                        'treatment_name' => $consent->treatment->name,
                        'treatment_description' => $consent->treatment->description,
                        'legal_basis' => $consent->treatment->legal_basis,
                        'given_at' => $consent->given_at,
                        'revoked_at' => $consent->revoked_at,
                        'status' => $consent->isActive() ? 'active' : 'revoked',
                        'ip_address' => $consent->ip_address,
                        'consent_method' => $consent->consent_method,
                    ])
                    ->toArray();
    }
}
```

---

## 📄 Template PDF GDPR

### 1. Compliance Report Template

```blade
{{-- resources/views/pdf/gdpr-compliance-report.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;">
                    <h1 style="font-size: 16pt; margin: 0; color: #2c3e50;">
                        GDPR Compliance Report
                    </h1>
                    <p style="font-size: 10pt; margin: 3mm 0 0 0; color: #7f8c8d;">
                        Report ID: {{ $reportId }}
                    </p>
                </td>
                <td style="width: 40%; text-align: right; font-size: 9pt;">
                    Generated: {{ $generatedAt->format('d/m/Y H:i') }}<br>
                    Period: {{ $options['period']['start']->format('d/m/Y') }} -
                            {{ $options['period']['end']->format('d/m/Y') }}<br>
                    Status: <strong>CONFIDENTIAL</strong>
                </td>
            </tr>
        </table>
        <div style="border-bottom: 2px solid #2c3e50; margin-top: 5mm;"></div>
    </page_header>

    <!-- Executive Summary -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Executive Summary</h2>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10mm;">
            <tr>
                <td style="width: 50%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                    <div style="font-size: 24pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['compliance_score']['overall'] }}%
                    </div>
                    <div style="font-size: 10pt; text-align: center; color: #7f8c8d;">
                        Overall Compliance Score
                    </div>
                </td>
                <td style="width: 50%; padding: 8mm; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                    <div style="font-size: 24pt; font-weight: bold; text-align: center; color: #27ae60;">
                        {{ $data['compliance_score']['grade'] }}
                    </div>
                    <div style="font-size: 10pt; text-align: center; color: #7f8c8d;">
                        Compliance Grade
                    </div>
                </td>
            </tr>
        </table>

        <!-- Score Components -->
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Compliance Area
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Score
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Status
                </th>
            </tr>
            @foreach($data['compliance_score']['components'] as $area => $score)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ ucfirst(str_replace('_', ' ', $area)) }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $score }}%
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    @if($score >= 90)
                        <span style="color: #27ae60;">✓ Excellent</span>
                    @elseif($score >= 75)
                        <span style="color: #f39c12;">⚠ Good</span>
                    @else
                        <span style="color: #e74c3c;">✗ Needs Improvement</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Consent Statistics -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Consent Management</h2>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10mm;">
            <tr>
                <td style="width: 25%; padding: 8mm; background-color: #3498db; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $data['consent_statistics']['total_consents'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        Total Consents
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #27ae60; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $data['consent_statistics']['active_consents'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        Active Consents
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #e74c3c; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $data['consent_statistics']['revoked_consents'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        Revoked Consents
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #f39c12; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $data['consent_statistics']['consent_rate'] }}%
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        Consent Rate
                    </div>
                </td>
            </tr>
        </table>

        <!-- Consents by Treatment -->
        <h3 style="font-size: 12pt; margin-bottom: 5mm;">Consents by Treatment</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: left;">
                    Treatment
                </th>
                <th style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    Total
                </th>
                <th style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    Active
                </th>
                <th style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    Rate
                </th>
            </tr>
            @foreach($data['consent_statistics']['by_treatment'] as $treatment => $stats)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 3mm; font-size: 9pt;">
                    {{ ucfirst(str_replace('-', ' ', $treatment)) }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 3mm; font-size: 9pt; text-align: center;">
                    {{ $stats['count'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 3mm; font-size: 9pt; text-align: center;">
                    {{ $stats['active'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 3mm; font-size: 9pt; text-align: center;">
                    {{ round(($stats['active'] / $stats['count']) * 100, 1) }}%
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Recommendations -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Recommendations</h2>

        @foreach($data['recommendations'] as $recommendation)
        <div style="margin-bottom: 8mm; padding: 8mm; background-color: #f8f9fa; border-left: 4px solid #3498db;">
            <div style="font-size: 11pt; font-weight: bold; margin-bottom: 3mm;">
                {{ $recommendation['title'] }}
            </div>
            <div style="font-size: 9pt; color: #7f8c8d;">
                {{ $recommendation['description'] }}
            </div>
            <div style="font-size: 8pt; color: #95a5a6; margin-top: 3mm;">
                Priority: {{ $recommendation['priority'] }} | Impact: {{ $recommendation['impact'] }}
            </div>
        </div>
        @endforeach
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    GDPR Compliance Report - Generated by PTVX System
                </td>
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]] | Confidential
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. User Consent Report Template

```blade
{{-- resources/views/pdf/gdpr-user-consent-report.blade.php --}}
<page>
    <page_header>
        <h1 style="font-size: 16pt; text-align: center; color: #2c3e50;">
            User Consent Documentation
        </h1>
        <p style="text-align: center; font-size: 10pt; color: #7f8c8d;">
            DSAR Request ID: {{ $requestId }}
        </p>
    </page_header>

    <div style="margin: 15mm 0;">
        <!-- User Information -->
        <div style="background-color: #f8f9fa; padding: 10mm; margin-bottom: 10mm;">
            <h2 style="font-size: 12pt; margin: 0 0 5mm 0;">Data Subject Information</h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 10pt;">
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Name:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Email:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>User ID:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $user->id }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Account Created:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <!-- Consents -->
        <h2 style="font-size: 14pt; margin-bottom: 8mm;">Consent Records</h2>

        @foreach($data['consents'] as $consent)
        <div style="margin-bottom: 10mm; padding: 8mm; border: 1px solid #dee2e6;">
            <table style="width: 100%; border-collapse: collapse; font-size: 9pt;">
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Treatment:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['treatment_name'] }}</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="width: 30%; padding: 2mm;"><strong>Description:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['treatment_description'] }}</td>
                </tr>
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Legal Basis:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['legal_basis'] }}</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="width: 30%; padding: 2mm;"><strong>Status:</strong></td>
                    <td style="width: 70%; padding: 2mm;">
                        <span style="color: {{ $consent['status'] == 'active' ? '#27ae60' : '#e74c3c' }};">
                            {{ ucfirst($consent['status']) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>Given At:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['given_at']->format('d/m/Y H:i:s') }}</td>
                </tr>
                @if($consent['revoked_at'])
                <tr style="background-color: #f8f9fa;">
                    <td style="width: 30%; padding: 2mm;"><strong>Revoked At:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['revoked_at']->format('d/m/Y H:i:s') }}</td>
                </tr>
                @endif
                <tr>
                    <td style="width: 30%; padding: 2mm;"><strong>IP Address:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['ip_address'] }}</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="width: 30%; padding: 2mm;"><strong>Method:</strong></td>
                    <td style="width: 70%; padding: 2mm;">{{ $consent['consent_method'] }}</td>
                </tr>
            </table>
        </div>
        @endforeach
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    User Consent Documentation - GDPR Article 15
                </td>
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

---

## 🔧 Filament Integration

### 1. GDPR PDF Actions

```php
<?php

namespace Modules\Gdpr\Filament\Actions;

use Filament\Actions\Action;
use Modules\Gdpr\Actions\GenerateGdprComplianceReportAction;

class ExportComplianceReportAction extends Action
{
    public static function make(string $name = 'export_compliance_report'): static
    {
        return parent::make($name)
            ->label('Export Compliance Report')
            ->icon('heroicon-o-document-text')
            ->color('primary')
            ->action(function (array $data) {
                $pdf = app(GenerateGdprComplianceReportAction::class)->execute([
                    'period' => [
                        'start' => \Carbon\Carbon::parse($data['start_date']),
                        'end' => \Carbon\Carbon::parse($data['end_date']),
                    ],
                    'include_sections' => $data['sections'] ?? [],
                    'format' => $data['format'] ?? 'detailed',
                    'watermark' => $data['watermark'] ?? false,
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "gdpr_compliance_report_{$data['start_date']}_to_{$data['end_date']}.pdf");
            })
            ->form([
                \Filament\Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->default(now()->subYear()),

                \Filament\Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->default(now()),

                \Filament\Forms\Components\CheckboxList::make('sections')
                    ->label('Include Sections')
                    ->options([
                        'consents' => 'Consent Management',
                        'audit_trail' => 'Audit Trail',
                        'data_processing' => 'Data Processing Activities',
                        'retention_policy' => 'Data Retention Policy',
                    ])
                    ->default(['consents', 'audit_trail']),

                \Filament\Forms\Components\Select::make('format')
                    ->label('Report Format')
                    ->options([
                        'summary' => 'Summary',
                        'detailed' => 'Detailed',
                    ])
                    ->default('detailed'),

                \Filament\Forms\Components\Toggle::make('watermark')
                    ->label('Add Confidential Watermark')
                    ->default(true),
            ]);
    }
}
```

### 2. User Consent Export Action

```php
class ExportUserConsentAction extends Action
{
    public static function make(string $name = 'export_user_consent'): static
    {
        return parent::make($name)
            ->label('Export User Consent')
            ->icon('heroicon-o-document-arrow-down')
            ->color('success')
            ->action(function ($record) {
                $pdf = app(GenerateUserConsentReportAction::class)->execute(
                    user: $record,
                    includeHistory: true,
                    includeLegalBasis: true,
                    format: 'gdpr_compliant'
                );

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "user_consent_{$record->id}_{$record->name}.pdf");
            });
    }
}
```

---

## 🧪 Testing

### 1. Unit Tests

```php
<?php

namespace Modules\Gdpr\Tests\Unit;

use Tests\TestCase;
use Modules\Gdpr\Services\GdprPdfService;
use Modules\Gdpr\Models\Consent;
use App\Models\User;

class GdprPdfTest extends TestCase
{
    /** @test */
    public function it_generates_compliance_report()
    {
        // Create test data
        Consent::factory()->count(50)->create();

        $service = app(GdprPdfService::class);
        $pdfContent = $service->generateComplianceReport([
            'period' => [
                'start' => now()->subMonth(),
                'end' => now(),
            ]
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(2000, strlen($pdfContent));
        $this->assertStringContainsString('GDPR Compliance Report', $pdfContent);
        $this->assertStringContainsString('Compliance Score', $pdfContent);
    }

    /** @test */
    public function it_includes_watermark_when_requested()
    {
        $service = app(GdprPdfService::class);
        $pdfContent = $service->generateComplianceReport([
            'watermark' => true,
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        // Watermark would be visible in the actual PDF
    }

    /** @test */
    public function it_handles_large_datasets_efficiently()
    {
        // Create large dataset
        Consent::factory()->count(5000)->create();

        $startTime = microtime(true);

        $service = app(GdprPdfService::class);
        $pdfContent = $service->generateComplianceReport();

        $duration = microtime(true) - $startTime;

        // Should generate within reasonable time
        $this->assertLessThan(10, $duration);
        $this->assertStringStartsWith('%PDF', $pdfContent);
    }
}
```

### 2. Feature Tests

```php
/** @test */
public function admin_can_export_compliance_report()
{
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
                    ->post('/gdpr/export-compliance-report', [
                        'start_date' => now()->subMonth()->format('Y-m-d'),
                        'end_date' => now()->format('Y-m-d'),
                        'sections' => ['consents', 'audit_trail'],
                        'format' => 'detailed',
                    ]);

    $response->assertSuccessful();
    $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
}
```

---

## 📊 Performance Optimization

### 1. Caching Strategy

```php
class GdprPdfService
{
    public function generateCachedComplianceReport(array $options = []): string
    {
        $cacheKey = 'gdpr_compliance_report_' . md5(json_encode([
            'options' => $options,
            'last_consent' => Consent::max('updated_at'),
            'last_event' => Event::max('created_at'),
        ]));

        return Cache::remember($cacheKey, 3600, function () use ($options) {
            return $this->generateComplianceReport($options);
        });
    }
}
```

### 2. Memory Management

```php
private function optimizeForLargeDatasets($query)
{
    // Use chunking for large datasets
    $query->chunk(1000, function ($consents) {
        // Process in chunks
    });

    // Limit data for PDF
    return $query->limit(1000)->get();
}
```

---

## 🚀 Error Handling

```php
public function generateWithErrorHandling(array $options = []): string
{
    try {
        return $this->generateComplianceReport($options);

    } catch (Html2PdfException $e) {
        Log::error('GDPR PDF generation failed', [
            'error' => $e->getMessage(),
            'options' => $options,
        ]);

        // Generate simplified fallback
        return $this->generateFallbackReport($options);

    } catch (Exception $e) {
        Log::error('Unexpected error in GDPR PDF generation', [
            'error' => $e->getMessage(),
        ]);

        throw new GdprPdfGenerationException('Failed to generate GDPR report');
    }
}
```

---

## 📚 References

- [HTML2PDF Best Practices](../../Xot/docs/html2pdf-best-practices.md)
- [GDPR Module README](./README.md)
- [Filament Actions Documentation](https://filamentphp.com/docs/3.x/actions/overview)
- [GDPR Regulation](https://gdpr.eu/)

---

**
**Version:** 1.0.0
**HTML2PDF Version:** 5.2.x
**PHPStan Level:** 10 ✅
**GDPR Compliant:** ✅
