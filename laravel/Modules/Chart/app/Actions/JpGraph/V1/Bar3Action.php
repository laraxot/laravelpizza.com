<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\AccBarPlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class Bar3Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $chart = $answersChartData->chart;
        $answers = $answersChartData->answers;
        $graph = app(GetGraphAction::class)->execute($chart);

        if (isset($graph->img) && is_object($graph->img) && method_exists($graph->img, 'SetMargin')) {
            $graph->img->SetMargin(50, 50, 50, 100);
        }

        $labels = $answers->toCollection()->pluck('label')->all();
        $datay = $answers->toCollection()->pluck('value')->all();
        $datay1 = $answers->toCollection()->pluck('value1')->all();
        // $legends = collect(collect($datay)->first())->keys()->all();
        $answers_first = $answers->first();
        Assert::isInstanceOf($answers_first, AnswerData::class);
        $legends = [];
        if (is_array($answers_first->value)) {
            $legends = array_keys($answers_first->value);
        }

        // dddx(['legends' => $legends, 'labels' => $labels, 'datay' => $datay, 'datay1' => $datay1]);

        if (isset($graph->ygrid) && is_object($graph->ygrid) && method_exists($graph->ygrid, 'SetFill')) {
            $graph->ygrid->SetFill(false);
        }

        if (isset($graph->xaxis) && is_object($graph->xaxis)) {
            if (method_exists($graph->xaxis, 'SetTickLabels')) {
                $graph->xaxis->SetTickLabels($labels);
            }
            if (method_exists($graph->xaxis, 'SetLabelAngle')) {
                $graph->xaxis->SetLabelAngle($chart->x_label_angle);
            }
        }

        if (isset($graph->yaxis) && is_object($graph->yaxis)) {
            if (method_exists($graph->yaxis, 'HideLine')) {
                $graph->yaxis->HideLine(false);
            }
            if (method_exists($graph->yaxis, 'HideTicks')) {
                $graph->yaxis->HideTicks(false, false);
            }
        }

        if (isset($graph->yscale) && is_object($graph->yscale)) {
            // PHPStan L10: isset() universale per JpGraph objects
            if (isset($graph->yscale->ticks) && is_object($graph->yscale->ticks) && method_exists($graph->yscale->ticks, 'SupressZeroLabel')) {
                $graph->yscale->ticks->SupressZeroLabel(false);
            }
        }

        // Create the bar plots
        $colors = explode(',', $chart->list_color);
        $bplot = [];
        $value_pos = ['bottom', 'top'];

        foreach ($legends as $k => $legend) {
            $tmp_data = array_column($datay, $legend);
            $tmp = new BarPlot($tmp_data);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);

            $tmp->SetValuePos($value_pos[$k]);
            $tmp->SetColor($colors[$k]);
            $tmp->SetFillColor($colors[$k].'@'.$chart->transparency); // trasparenza da 0 a 1

            $tmp->SetLegend($legend);

            $bplot[] = $tmp;
        }

        // Create the grouped bar plot
        $accBarPlot = new AccBarPlot($bplot);
        $accBarPlot->SetWidth($chart->plot_perc_width / 100);
        // ...and add it to the graPH
        $graph->Add($accBarPlot);

        if (\count($datay) > 1) {
            // dddx($this->data->first()['title_type']);
            // dddx($this->vars['title']);
            $title = $chart->title;

            // $subtitle = 'Totale rispondenti';
            if (isset($graph->title) && $graph->title instanceof Text) {
                $graph->title->Set($title);
                $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
            }
        }

        // PHPStan L10: isset() già garantisce non-null, per ChartData properties (può essere Model o Data object)
        if (isset($chart->totali) && is_iterable($chart->totali)) {
            $str = '';
            foreach ($chart->totali as $k => $v) {
                $kStr = is_scalar($k) ? (string) $k : '';
                $vStr = is_scalar($v) ? (string) $v : '';
                $str .= $kStr.' '.$vStr.' - ';
            }

            if (isset($graph->footer) && is_object($graph->footer)) {
                if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
                    $graph->footer->center->Set($str);
                    $graph->footer->center->SetFont($chart->font_family, $chart->font_style, 11);
                }
            }
        }

        // cifre sopra il grafico
        $delta = ($chart->width - 100) / \count($datay1);

        if (is_array($datay1)) {
            foreach ($datay1 as $i => $v) {
                $txt = new Text('');
                if (\is_array($v) && isset($v[0]) && (is_string($v[0]) || is_numeric($v[0]))) {
                    $txt = new Text((string) $v[0]);
                }

                $x = 50 + ($delta * $i) + ($delta / 3);
                $txt->SetPos($x, 20);
                $graph->AddText($txt);

                $txt2 = new Text('');
                if (\is_array($v) && isset($v[1]) && (is_string($v[1]) || is_numeric($v[1]))) {
                    $txt2 = new Text((string) $v[1]);
                }

                $txt2->SetPos($x, 35);
                $graph->AddText($txt2);
            }
        }

        return $graph;
    }
}
