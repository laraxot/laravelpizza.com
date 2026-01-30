# Modulo Reporting il progetto

## Panoramica
Il modulo Reporting gestisce la generazione e visualizzazione di report e statistiche per il sistema il progetto, fornendo strumenti analitici per la gestione clinica e finanziaria.

## Configurazione

### Installazione
```bash

# Creazione del modulo
php artisan module:make Reporting

# Pubblicazione configurazione
php artisan vendor:publish --tag=reporting-config
```

### Dipendenze
- module_xot_fila3
- module_tenant_fila3
- module_user_fila3
- module_patient_fila3
- module_dental_fila3
- module_media_fila3
- module_chart_fila3

## Architettura

### Componenti
```
Reporting/
├── Reports/            # Report generatori
│   ├── Clinical/       # Report clinici
│   ├── Financial/      # Report finanziari
│   └── Operational/    # Report operativi
├── Exports/            # Esportazione (Excel, PDF, CSV)
├── Charts/             # Grafici e visualizzazioni
└── Dashboards/         # Dashboard personalizzabili
```

### Sistema di Report

Utilizziamo un'architettura basata su:
1. **Report Builders**: Creano le query e aggregano i dati
2. **Report Presenters**: Formattano i dati per la visualizzazione
3. **Report Exporters**: Esportano i report in vari formati

## Report Principali

### Report Clinici

#### PatientVisitReport
```php
namespace Modules\Reporting\Reports\Clinical;

use Modules\Xot\Reports\BaseReport;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PatientVisitReport extends BaseReport
{
    protected int $patientId;
    protected ?Carbon $startDate = null;
    protected ?Carbon $endDate = null;
    
    public function __construct(int $patientId, ?Carbon $startDate = null, ?Carbon $endDate = null)
    {
        $this->patientId = $patientId;
        $this->startDate = $startDate ?? Carbon::now()->subYear();
        $this->endDate = $endDate ?? Carbon::now();
    }
    
    public function generate(): Collection
    {
        return Appointment::query()
            ->with(['doctor', 'patientTreatments.treatment'])
            ->where('patient_id', $this->patientId)
            ->where('status', AppointmentStatus::COMPLETED)
            ->whereBetween('start_time', [$this->startDate, $this->endDate])
            ->orderBy('start_time')
            ->get()
            ->map(function (Appointment $appointment) {
                $treatments = $appointment->patientTreatments->map(function ($pt) {
                    return [
                        'id' => $pt->id,
                        'name' => $pt->treatment->name,
                        'category' => $pt->treatment->category->label(),
                        'price' => $pt->price,
                        'status' => $pt->status->label(),
                    ];
                });
                
                return [
                    'id' => $appointment->id,
                    'date' => $appointment->start_time->format('d/m/Y'),
                    'time' => $appointment->start_time->format('H:i'),
                    'doctor' => $appointment->doctor->name,
                    'title' => $appointment->title,
                    'description' => $appointment->description,
                    'notes' => $appointment->notes,
                    'treatments' => $treatments,
                    'treatments_count' => $treatments->count(),
                    'treatments_total' => $treatments->sum('price'),
                ];
            });
    }
    
    public function getSummary(): array
    {
        $data = $this->generate();
        
        return [
            'patient_id' => $this->patientId,
            'start_date' => $this->startDate->format('d/m/Y'),
            'end_date' => $this->endDate->format('d/m/Y'),
            'total_visits' => $data->count(),
            'total_treatments' => $data->sum('treatments_count'),
            'total_cost' => $data->sum('treatments_total'),
            'visits_by_month' => $data
                ->groupBy(fn ($item) => Carbon::parse($item['date'])->format('Y-m'))
                ->map(fn ($items) => $items->count())
                ->toArray(),
        ];
    }
}
```

#### TreatmentAnalysisReport
```php
namespace Modules\Reporting\Reports\Clinical;

use Modules\Xot\Reports\BaseReport;
use Modules\Dental\Models\PatientTreatment;
use Modules\Dental\Enums\PatientTreatmentStatus;
use Modules\Dental\Enums\TreatmentCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TreatmentAnalysisReport extends BaseReport
{
    protected ?Carbon $startDate = null;
    protected ?Carbon $endDate = null;
    protected ?TreatmentCategory $category = null;
    
    public function __construct(?Carbon $startDate = null, ?Carbon $endDate = null, ?TreatmentCategory $category = null)
    {
        $this->startDate = $startDate ?? Carbon::now()->startOfYear();
        $this->endDate = $endDate ?? Carbon::now();
        $this->category = $category;
    }
    
    public function generate(): Collection
    {
        $query = PatientTreatment::query()
            ->join('treatments', 'patient_treatments.treatment_id', '=', 'treatments.id')
            ->where('patient_treatments.status', PatientTreatmentStatus::COMPLETED)
            ->whereBetween('patient_treatments.completed_date', [$this->startDate, $this->endDate]);
            
        if ($this->category) {
            $query->where('treatments.category', $this->category);
        }
        
        return $query->select([
                'treatments.id',
                'treatments.name',
                'treatments.category',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(patient_treatments.price) as avg_price'),
                DB::raw('SUM(patient_treatments.price) as total_revenue'),
            ])
            ->groupBy('treatments.id', 'treatments.name', 'treatments.category')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                $item->category_label = TreatmentCategory::from($item->category)->label();
                return $item;
            });
    }
    
    public function getByCategoryBreakdown(): array
    {
        return $this->generate()
            ->groupBy('category')
            ->map(function ($items, $category) {
                $categoryEnum = TreatmentCategory::from($category);
                
                return [
                    'category' => $category,
                    'category_label' => $categoryEnum->label(),
                    'count' => $items->sum('count'),
                    'percentage' => $items->sum('count') / $this->generate()->sum('count') * 100,
                    'total_revenue' => $items->sum('total_revenue'),
                    'top_treatments' => $items->sortByDesc('count')->take(3)->values(),
                ];
            })
            ->values()
            ->toArray();
    }
}
```

### Report Finanziari

#### RevenueReport
```php
namespace Modules\Reporting\Reports\Financial;

use Modules\Xot\Reports\BaseReport;
use Modules\Dental\Models\PatientTreatment;
use Modules\Dental\Enums\PatientTreatmentStatus;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueReport extends BaseReport
{
    protected ?Carbon $startDate = null;
    protected ?Carbon $endDate = null;
    protected string $groupBy = 'month';
    
    public function __construct(?Carbon $startDate = null, ?Carbon $endDate = null, string $groupBy = 'month')
    {
        $this->startDate = $startDate ?? Carbon::now()->startOfYear();
        $this->endDate = $endDate ?? Carbon::now();
        $this->groupBy = $groupBy;
    }
    
    public function generate(): array
    {
        $format = $this->getDateFormat();
        $datePeriods = $this->getDatePeriods();
        
        $query = PatientTreatment::query()
            ->select([
                DB::raw("DATE_FORMAT(completed_date, '{$format}') as period"),
                DB::raw('SUM(price) as revenue'),
                DB::raw('COUNT(*) as count'),
            ])
            ->where('status', PatientTreatmentStatus::COMPLETED)
            ->whereBetween('completed_date', [$this->startDate, $this->endDate])
            ->groupBy('period')
            ->orderBy('period');
            
        $results = $query->get()->keyBy('period');
        
        // Fill in missing periods with zero values
        $data = [];
        foreach ($datePeriods as $period) {
            $periodKey = $period->format($this->getPhpDateFormat());
            
            $data[] = [
                'period' => $periodKey,
                'period_label' => $this->getPeriodLabel($period),
                'revenue' => $results[$periodKey]['revenue'] ?? 0,
                'count' => $results[$periodKey]['count'] ?? 0,
            ];
        }
        
        return [
            'start_date' => $this->startDate->format('Y-m-d'),
            'end_date' => $this->endDate->format('Y-m-d'),
            'group_by' => $this->groupBy,
            'total_revenue' => collect($data)->sum('revenue'),
            'total_count' => collect($data)->sum('count'),
            'data' => $data,
        ];
    }
    
    protected function getDateFormat(): string
    {
        return match($this->groupBy) {
            'day' => '%Y-%m-%d',
            'week' => '%x-W%v',
            'month' => '%Y-%m',
            'quarter' => '%Y-Q%q',
            'year' => '%Y',
            default => '%Y-%m',
        };
    }
    
    protected function getPhpDateFormat(): string
    {
        return match($this->groupBy) {
            'day' => 'Y-m-d',
            'week' => 'o-\WW',
            'month' => 'Y-m',
            'quarter' => 'Y-\QQ',
            'year' => 'Y',
            default => 'Y-m',
        };
    }
    
    protected function getDatePeriods(): array
    {
        $intervals = match($this->groupBy) {
            'day' => CarbonPeriod::create($this->startDate, '1 day', $this->endDate),
            'week' => CarbonPeriod::create($this->startDate->startOfWeek(), '1 week', $this->endDate),
            'month' => CarbonPeriod::create($this->startDate->startOfMonth(), '1 month', $this->endDate),
            'quarter' => CarbonPeriod::create($this->startDate->startOfQuarter(), '3 months', $this->endDate),
            'year' => CarbonPeriod::create($this->startDate->startOfYear(), '1 year', $this->endDate),
            default => CarbonPeriod::create($this->startDate->startOfMonth(), '1 month', $this->endDate),
        };
        
        return iterator_to_array($intervals);
    }
    
    protected function getPeriodLabel(Carbon $date): string
    {
        return match($this->groupBy) {
            'day' => $date->format('d/m/Y'),
            'week' => "Sett. {$date->weekOfYear} {$date->year}",
            'month' => $date->locale('it')->monthName . ' ' . $date->year,
            'quarter' => "Q{$date->quarter} {$date->year}",
            'year' => (string)$date->year,
            default => $date->locale('it')->monthName . ' ' . $date->year,
        };
    }
}
```

### Dashboard

#### DashboardService
```php
namespace Modules\Reporting\Services;

use Modules\Reporting\Reports\Clinical\TreatmentAnalysisReport;
use Modules\Reporting\Reports\Financial\RevenueReport;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;

class DashboardService
{
    public function getAdminDashboardData(): array
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $treatmentReport = new TreatmentAnalysisReport(
            $currentMonth->copy()->subMonths(6),
            Carbon::now()
        );
        
        $revenueReport = new RevenueReport(
            $currentMonth->copy()->subMonths(12),
            Carbon::now()
        );
        
        $currentMonthAppointments = Appointment::whereBetween('start_time', [
            $currentMonth, 
            $currentMonth->copy()->endOfMonth()
        ])->count();
        
        $previousMonthAppointments = Appointment::whereBetween('start_time', [
            $previousMonth, 
            $previousMonth->copy()->endOfMonth()
        ])->count();
        
        $appointmentChange = $previousMonthAppointments > 0 
            ? (($currentMonthAppointments - $previousMonthAppointments) / $previousMonthAppointments) * 100 
            : 0;
            
        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('start_time', '>=', Carbon::now())
            ->where('start_time', '<=', Carbon::now()->addDays(7))
            ->orderBy('start_time')
            ->take(5)
            ->get();
            
        $newPatients = Patient::where('created_at', '>=', $currentMonth)
            ->count();
            
        return [
            'appointments' => [
                'total' => $currentMonthAppointments,
                'change' => round($appointmentChange, 1),
                'upcoming' => $upcomingAppointments,
                'completed' => Appointment::where('status', AppointmentStatus::COMPLETED)
                    ->where('start_time', '>=', $currentMonth)
                    ->count(),
                'cancelled' => Appointment::where('status', AppointmentStatus::CANCELLED)
                    ->where('start_time', '>=', $currentMonth)
                    ->count(),
            ],
            'patients' => [
                'total' => Patient::count(),
                'new' => $newPatients,
                'active' => Patient::whereHas('appointments', function ($query) {
                    $query->where('start_time', '>=', Carbon::now()->subMonths(6));
                })->count(),
            ],
            'treatments' => [
                'by_category' => $treatmentReport->getByCategoryBreakdown(),
                'top' => $treatmentReport->generate()->take(5),
            ],
            'revenue' => $revenueReport->generate(),
        ];
    }
}
```

## Esportazioni

### Excel
```php
namespace Modules\Reporting\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class PatientVisitsExport implements FromCollection, WithHeadings, WithStyles
{
    protected Collection $data;
    protected array $headings;
    
    public function __construct(Collection $data, array $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }
    
    public function collection(): Collection
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        return $this->headings;
    }
    
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
```

### PDF
```php
namespace Modules\Reporting\Exports;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PatientReportPdfExport
{
    protected array $data;
    protected array $options;
    
    public function __construct(array $data, array $options = [])
    {
        $this->data = $data;
        $this->options = array_merge([
            'title' => 'Report Paziente',
            'orientation' => 'portrait',
            'page_size' => 'A4',
        ], $options);
    }
    
    public function download(string $filename): \Illuminate\Http\Response
    {
        return $this->getPdf()->download($filename);
    }
    
    public function stream(): \Illuminate\Http\Response
    {
        return $this->getPdf()->stream();
    }
    
    public function save(string $path): void
    {
        $this->getPdf()->save($path);
    }
    
    protected function getPdf(): \Barryvdh\DomPDF\PDF
    {
        $view = View::make('reporting::pdf.patient-report', [
            'data' => $this->data,
            'options' => $this->options,
        ]);
        
        return Pdf::loadHTML($view->render())
            ->setPaper($this->options['page_size'], $this->options['orientation'])
            ->setWarnings(false);
    }
}
```

## Filament Resources

### DashboardPage
```php
namespace Modules\Reporting\Filament\Pages;

use Filament\Pages\Page;
use Modules\Reporting\Services\DashboardService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Illuminate\Support\Carbon;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'reporting::filament.pages.dashboard';
    
    public ?array $data = null;
    public Carbon $startDate;
    public Carbon $endDate;
    public string $groupBy = 'month';
    
    public function mount(): void
    {
        $this->startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $this->endDate = Carbon::now()->endOfMonth();
        $this->refreshData();
    }
    
    public function refreshData(): void
    {
        $service = app(DashboardService::class);
        $this->data = $service->getAdminDashboardData();
    }
    
    public function getFormSchema(): array
    {
        return [
            Section::make('Filtri')
                ->schema([
                    DatePicker::make('startDate')
                        ->label('Data Inizio')
                        ->required(),
                    DatePicker::make('endDate')
                        ->label('Data Fine')
                        ->required()
                        ->after('startDate'),
                    Select::make('groupBy')
                        ->label('Raggruppa per')
                        ->options([
                            'day' => 'Giorno',
                            'week' => 'Settimana',
                            'month' => 'Mese',
                            'quarter' => 'Trimestre',
                            'year' => 'Anno',
                        ])
                        ->required(),
                ])
                ->columns(3),
        ];
    }
    
    public function submit(): void
    {
        $this->refreshData();
    }
}
```

## API

### Endpoints
| Metodo | URI                                    | Azione                              |
|--------|-----------------------------------------|-------------------------------------|
| GET    | `/api/reports/dashboard`                | Dati dashboard                      |
| GET    | `/api/reports/patient/{patient}`        | Report paziente                     |
| GET    | `/api/reports/revenue`                  | Report ricavi                       |
| GET    | `/api/reports/treatments`               | Report trattamenti                  |
| GET    | `/api/reports/export/patient/{patient}` | Esportazione report paziente (PDF)  |
| GET    | `/api/reports/export/revenue`          | Esportazione report ricavi (Excel)  |

### ReportingController
```php
namespace Modules\Reporting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Xot\Http\Controllers\BaseController;
use Modules\Reporting\Services\DashboardService;
use Modules\Reporting\Reports\Clinical\PatientVisitReport;
use Modules\Reporting\Reports\Financial\RevenueReport;
use Modules\Reporting\Exports\PatientReportPdfExport;
use Modules\Reporting\Exports\PatientVisitsExport;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportingController extends BaseController
{
    public function dashboard(Request $request)
    {
        $service = app(DashboardService::class);
        $data = $service->getAdminDashboardData();
        
        return response()->json(['data' => $data]);
    }
    
    public function patientReport(Request $request, Patient $patient)
    {
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->subYear();
            
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();
            
        $report = new PatientVisitReport($patient->id, $startDate, $endDate);
        $data = $report->generate();
        $summary = $report->getSummary();
        
        return response()->json([
            'data' => $data,
            'summary' => $summary,
        ]);
    }
    
    public function exportPatientReport(Request $request, Patient $patient)
    {
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->subYear();
            
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();
            
        $report = new PatientVisitReport($patient->id, $startDate, $endDate);
        $data = $report->generate();
        $summary = $report->getSummary();
        
        $export = new PatientReportPdfExport([
            'patient' => $patient,
            'data' => $data,
            'summary' => $summary,
        ], [
            'title' => "Report Paziente: {$patient->full_name}",
        ]);
        
        return $export->download("report-paziente-{$patient->id}.pdf");
    }
    
    public function revenueReport(Request $request)
    {
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->startOfYear();
            
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();
            
        $groupBy = $request->input('group_by', 'month');
        
        $report = new RevenueReport($startDate, $endDate, $groupBy);
        $data = $report->generate();
        
        return response()->json(['data' => $data]);
    }
    
    public function exportRevenueReport(Request $request)
    {
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->startOfYear();
            
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();
            
        $groupBy = $request->input('group_by', 'month');
        
        $report = new RevenueReport($startDate, $endDate, $groupBy);
        $data = $report->generate();
        
        $export = new PatientVisitsExport(
            collect($data['data']), 
            ['Periodo', 'Descrizione', 'Ricavi (€)', 'Trattamenti']
        );
        
        return Excel::download(
            $export, 
            "report-ricavi-{$startDate->format('Y-m-d')}-{$endDate->format('Y-m-d')}.xlsx"
        );
    }
}
```

## Unit Tests

```php
namespace Modules\Reporting\Tests\Unit;

use Tests\TestCase;
use Modules\Reporting\Reports\Financial\RevenueReport;
use Modules\Dental\Models\PatientTreatment;
use Modules\Dental\Enums\PatientTreatmentStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RevenueReportTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_generates_correct_revenue_data()
    {
        // Setup
        $now = Carbon::now();
        $startDate = $now->copy()->subMonths(3)->startOfMonth();
        $endDate = $now->copy()->endOfMonth();
        
        // Create test data
        PatientTreatment::factory()->count(5)
            ->create([
                'status' => PatientTreatmentStatus::COMPLETED,
                'completed_date' => $now->copy()->subMonths(2)->setDay(15),
                'price' => 100.00,
            ]);
            
        PatientTreatment::factory()->count(3)
            ->create([
                'status' => PatientTreatmentStatus::COMPLETED,
                'completed_date' => $now->copy()->subMonths(1)->setDay(10),
                'price' => 150.00,
            ]);
            
        PatientTreatment::factory()->count(2)
            ->create([
                'status' => PatientTreatmentStatus::COMPLETED,
                'completed_date' => $now->copy()->setDay(5),
                'price' => 200.00,
            ]);
        
        // Run report
        $report = new RevenueReport($startDate, $endDate, 'month');
        $result = $report->generate();
        
        // Assertions
        $this->assertEquals($startDate->format('Y-m-d'), $result['start_date']);
        $this->assertEquals($endDate->format('Y-m-d'), $result['end_date']);
        $this->assertEquals('month', $result['group_by']);
        
        // Total revenue should be: (5 * 100) + (3 * 150) + (2 * 200) = 1050
        $this->assertEquals(1050, $result['total_revenue']);
        
        // Total count should be: 5 + 3 + 2 = 10
        $this->assertEquals(10, $result['total_count']);
        
        // Should have 4 periods (current month and 3 previous)
        $this->assertCount(4, $result['data']);
        
        // Check month-specific data
        $twoMonthsAgoKey = $now->copy()->subMonths(2)->format('Y-m');
        $oneMonthAgoKey = $now->copy()->subMonths(1)->format('Y-m');
        $currentMonthKey = $now->format('Y-m');
        
        $twoMonthsAgoData = collect($result['data'])->firstWhere('period', $twoMonthsAgoKey);
        $oneMonthAgoData = collect($result['data'])->firstWhere('period', $oneMonthAgoKey);
        $currentMonthData = collect($result['data'])->firstWhere('period', $currentMonthKey);
        
        $this->assertEquals(500, $twoMonthsAgoData['revenue']); // 5 * 100
        $this->assertEquals(450, $oneMonthAgoData['revenue']); // 3 * 150
        $this->assertEquals(400, $currentMonthData['revenue']); // 2 * 200
        
        $this->assertEquals(5, $twoMonthsAgoData['count']);
        $this->assertEquals(3, $oneMonthAgoData['count']);
        $this->assertEquals(2, $currentMonthData['count']);
    }
}
``` 

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

