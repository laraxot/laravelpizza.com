<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Modules\Chart\Actions\JpGraph\ApplyGraphStyleAction;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class Horizbar1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();

        $labels = $answersChartData->answers->toCollection()
            ->pluck('label')
            ->map(function ($item): string {
                Assert::string($item);

                return wordwrap($item, 25, PHP_EOL);
            })
            ->all();
        $chart = $answersChartData->chart;
        $graph = app(GetGraphAction::class)->execute($chart);

        $graph->SetScale('textlin');

        // Rotate graph 90 degrees and set margin
        $graph->Set90AndMargin(250, 20, 50, 30);

        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        if (isset($graph->xaxis) && is_object($graph->xaxis) && method_exists($graph->xaxis, 'SetTickLabels')) {
            $graph->xaxis->SetTickLabels($labels);
        }

        $bplot = new BarPlot($data);
        // $bplot = $this->applyPlotStyle($bplot);
        $bplot = app(ApplyPlotStyleAction::class)->execute($bplot, $chart);

        $colors = [];

        foreach ($labels as $k => $label) {
            if ($label === 'NR') {
                $colors[$k] = $chart->getColors()[1].'@'.$chart->transparency;
            } else {
                $colors[$k] = $chart->getColors()[0].'@'.$chart->transparency;
            }
        }

        $bplot->SetFillColor($colors); // trasparenza, da 0 a 1

        // Add the bar to the graph
        $graph->Add($bplot);

        return $graph;
    }
}
