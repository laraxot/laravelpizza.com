<?php

declare(strict_types=1);

namespace Modules\Incentivi\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

class PdfDownloadController extends Controller
{
    public function download(Project $project): PdfBuilder
    {
        $view = 'incentivi::filament.pdf.pdf-project-report';
        $rupActivity = $project->activities()->where('nome', 'Responsabile Unico del Progetto')->first();

        // Soluzione più robusta e KISS: usa null coalescing e early return
        $rupEmployees = isset($rupActivity->employees) ? $rupActivity->employees : collect();
        /** @var \Illuminate\Support\Collection $rupEmployees */
        $firstEmployee = $rupEmployees->first();
        $rupActivityEmployee = 'Non definito';
        if ($firstEmployee !== null && is_object($firstEmployee)) {
            /** @var object{nome?: string, cognome?: string} $firstEmployee */
            $nome = isset($firstEmployee->nome) ? (string) $firstEmployee->nome : '';
            $cognome = isset($firstEmployee->cognome) ? (string) $firstEmployee->cognome : '';
            if ($nome !== '' && $cognome !== '') {
                $rupActivityEmployee = $nome.' '.$cognome;
            }
        }

        // Soluzione più robusta e KISS: usa null coalescing
        $workgroupEmployees = (isset($project->workgroup) && isset($project->workgroup->employees)) ? $project->workgroup->employees : collect();

        $viewParams = [
            'project' => $project,
            'activities' => $project->activities,
            'employees' => $workgroupEmployees,
            'rup' => $rupActivityEmployee,
            'liquidazione' => $this->liquidazione($project),
        ];

        return pdf()
            ->view($view, $viewParams)
            ->orientation(Orientation::Portrait)
            ->format(Format::A4)
            ->margins(10, 10, 20, 0, Unit::Pixel)
            ->name(str_slug($project->nome).'-REPORT.pdf');
    }

    public function sumActivities(Employee $employee): int
    {
        $sum = 0;
        foreach ($employee->activities as $activity) {
            /** @var object{pivot?: object{importo_attivita_dipendente?: float|int|string}} $activity */
            if (isset($activity->pivot) && is_object($activity->pivot)) {
                $importo = $activity->pivot->importo_attivita_dipendente ?? 0;
                $sum += is_numeric($importo) ? (int) $importo : 0;
            }
        }

        return $sum;
    }

    public function sumActivitiesPerYear(Employee $employee, array $uniqueYears): array
    {
        $years = [];
        foreach ($uniqueYears as $year) {
            $yearSum = 0;
            foreach ($employee->activities->where('anno_competenza', $year) as $activity) {
                /** @var object{pivot?: object{importo_attivita_dipendente?: float|int|string}} $activity */
                if (isset($activity->pivot) && is_object($activity->pivot)) {
                    $importo = $activity->pivot->importo_attivita_dipendente ?? 0;
                    $yearSum += is_numeric($importo) ? (float) $importo : 0.0;
                }
            }
            $years[] = [
                'year' => $year,
                'total' => $yearSum,
            ];
        }

        return $years;
    }

    public static function sumPerColumn(Project $project, int $anno): float
    {
        $sum = 0;
        $activities = $project
            ->activities()->with('employees')->where('anno_competenza', $anno)->get();
        foreach ($activities as $activity) {
            // Soluzione più robusta e KISS: usa null coalescing
            $activityEmployees = isset($activity->employees) ? $activity->employees : collect();
            if ($activityEmployees instanceof \Illuminate\Support\Collection && ! $activityEmployees->isEmpty()) {
                foreach ($activityEmployees->where('tipologia', 'I') as $employee) {
                    /** @var object{pivot?: object{importo_attivita_dipendente?: float|int|string}} $employee */
                    if (isset($employee->pivot) && is_object($employee->pivot)) {
                        $importo = $employee->pivot->importo_attivita_dipendente ?? 0;
                        $sum += is_numeric($importo) ? (float) $importo : 0.0;
                    }
                }
            }
        }

        return $sum;
    }

    public function liquidazione(Project $project): array
    {
        $dipendenti = [];
        $years = [];

        $projectActivities = $project->activities;
        $uniqueYears = $projectActivities->pluck('anno_competenza')->unique()->toArray();

        // Soluzione più robusta e KISS: usa null coalescing
        if ($project->employees) {
            foreach ($project->employees->where('tipologia', 'I') as $employee => $value) {
                $dipendenti[$value->cognome] = [
                    'employee' => $value,
                    'totale' => $this->sumActivities($value),
                    'years' => $this->sumActivitiesPerYear($value, $uniqueYears),
                ];
            }
        }

        return $dipendenti;
    }
}
