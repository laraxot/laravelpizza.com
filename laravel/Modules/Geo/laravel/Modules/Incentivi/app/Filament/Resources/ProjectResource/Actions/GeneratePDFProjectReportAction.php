<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\StabiDirigente;
use Modules\Xot\Actions\Export\PdfByViewAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GeneratePDFProjectReportAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Report Progetto')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function (Model $project): BinaryFileResponse {
                if (! $project instanceof Project) {
                    throw new InvalidArgumentException('Expected Project instance');
                }

                // spipu view selection based on project type
                switch ($project->tipo) {
                    case 'Lavori':
                        $view = 'incentivi::filament.pdf.report.report-lavori';
                        break;
                    case 'Servizi':
                        $view = 'incentivi::filament.pdf.report.report-servizi';
                        break;
                    case 'Misti':
                        $view = 'incentivi::filament.pdf.report.report-misti';
                        break;
                    default: throw new InvalidArgumentException('Errore tipo progetto non valido');
                }

                $rupEmployee = Employee::where('id', $project->rup)->first();
                $rup = $rupEmployee ? $rupEmployee->cognome.' '.$rupEmployee->nome : 'Non definito';

                $decEmployee = Employee::where('id', $project->dec)->first();
                $dec = $decEmployee ? $decEmployee->cognome.' '.$decEmployee->nome : 'Non definito';

                $activities = $project->activities ?? collect();
                // $rupActivity = $activities->where('nome', 'Responsabile Unico del Progetto')->first();
                // $rupActivityEmployee = $rupActivity && $rupActivity->employees->first() ?
                //     $rupActivity->employees->first()->nome.' '.$rupActivity->employees->first()->cognome :
                //     'Non definito';

                $stabiDirigente = StabiDirigente::where('stabi', $project->department_id ?? null)->first(); // @phpstan-ignore-line

                // parametri passati alla view
                $viewParams = [
                    'project' => $project,
                    'employees' => isset($project->employees) ? $project->employees : collect(),
                    'activities' => $activities,
                    'rup' => $rup,
                    'dec' => $dec,
                    'stabiDirigente' => $stabiDirigente,
                    'phases' => $project->phases ?? collect(),
                ];

                $out = view($view, $viewParams);
                $filename = 'report-id-progetto-'.$project->id.'-'.now()->format('d-m-Y-H-i').'.pdf';

                $result = app(PdfByViewAction::class)
                    ->execute($out, $filename, 'cache', 'download', 'P');

                /** @var \Symfony\Component\HttpFoundation\BinaryFileResponse $result */
                return $result;
            });
        // ->visible(fn (Model $record): bool => $record->getAttribute('stato')->value === 'concluso')
    }

    public static function getDefaultName(): ?string
    {
        return 'GeneratePDFProjectReportAction';
    }
}
