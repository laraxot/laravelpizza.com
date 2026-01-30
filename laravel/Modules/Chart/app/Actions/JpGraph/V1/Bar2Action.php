<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;

class Bar2Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $data1 = $answersChartData->answers->toCollection()->pluck('value')->all();
        $legends = [0];
        if (isset($data1[0]) && is_array($data1[0])) { // questionario multiplo
            $legends = array_keys($data1[0]);
            $data = $answersChartData->answers->toCollection()->pluck('value')->all();
            $data1 = $answersChartData->answers->toCollection()->pluck('avg')->all();
        }

        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $chart = $answersChartData->chart;
        $graph = app(GetGraphAction::class)->execute($chart);

        // Type narrowing for JpGraph properties
        if (is_object($graph->img) && method_exists($graph->img, 'SetMargin')) {
            $graph->img->SetMargin(50, 50, 50, 100);
        }

        if (is_object($graph->ygrid) && method_exists($graph->ygrid, 'SetFill')) {
            $graph->ygrid->SetFill(false);
        }

        if (is_object($graph->xaxis)) {
            if (method_exists($graph->xaxis, 'SetTickLabels')) {
                $graph->xaxis->SetTickLabels($labels);
            }
            if (method_exists($graph->xaxis, 'SetLabelAngle')) {
                $graph->xaxis->SetLabelAngle($chart->x_label_angle);
            }
        }

        if (is_object($graph->yaxis)) {
            if (method_exists($graph->yaxis, 'HideLine')) {
                $graph->yaxis->HideLine(false);
            }
            if (method_exists($graph->yaxis, 'HideTicks')) {
                $graph->yaxis->HideTicks(false, false);
            }
        }

        if (is_object($graph->yscale)) {
            // PHPStan L10: isset() universale per JpGraph yscale->ticks
            if (isset($graph->yscale->ticks) && is_object($graph->yscale->ticks) && method_exists($graph->yscale->ticks, 'SupressZeroLabel')) {
                $graph->yscale->ticks->SupressZeroLabel(false);
            }
        }

        /*
        $bplot = new BarPlot($data);
        // $bplot = $this->applyPlotStyle($bplot);
        $bplot = app(ApplyPlotStyleAction::class)->execute($bplot, $chart);

        $colors = [];

        foreach ($labels as $k => $label) {
            if ('NR' == $label) {
                $colors[$k] = $chart->getColors()[1].'@'.$chart->transparency;
            } else {
                $colors[$k] = $chart->getColors()[0].'@'.$chart->transparency;
            }
        }
        $bplot->SetFillColor($colors); // trasparenza, da 0 a 1
        */
        $colors = explode(',', $chart->list_color);
        $bplot = [];

        foreach ($legends as $i => $legend) {
            $tmp_data = $legend === 0 ? $data : array_column($data, $legend);

            // dddx(['data' => $data, 'tmp_data' => $tmp_data]);
            $tmp = new BarPlot($tmp_data);
            // $tmp = $this->applyPlotStyle($tmp);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);
            $tmp->SetColor($colors[$i]);
            $tmp->SetFillColor($colors[$i].'@'.$chart->transparency); // trasparenza da 0 a 1

            // PHPStan L10: isset() universale per JpGraph Plot->value
            if (isset($tmp->value) && is_object($tmp->value) && method_exists($tmp->value, 'Show')) {
                $tmp->value->Show();
            }
            // $tmp->SetFillColor($colors[$k]);
            /*
            if (isset($chart->legend)) {
                $str = $chart->legend[$k] ?? '--no set';
                $tmp->SetLegend($str);
            }
            */
            if ($legend !== 0) {
                $tmp->SetLegend($legend);
            }

            $bplot[] = $tmp;
            $i++;
        }

        // Create the grouped bar plot
        $groupBarPlot = new GroupBarPlot($bplot);
        // ...and add it to the graPH
        $graph->Add($groupBarPlot);

        // $graph->Add($bplot);

        $delta = ($chart->width - 100) / \count($data1);

        foreach ($data1 as $i => $v) {
            $txtValue = is_scalar($v) ? (string) $v : '';
            $txt = new Text($txtValue);

            $x = 50 + ($delta * $i) + ($delta / 3);

            $txt->SetPos($x, 25);

            $graph->AddText($txt);
        }

        return $graph;
    }
}
