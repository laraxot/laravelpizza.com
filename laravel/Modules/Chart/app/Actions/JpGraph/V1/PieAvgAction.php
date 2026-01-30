<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\ApplyGraphStyleAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class PieAvgAction
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();

        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;
        if (isset($chart->max)) {
            Assert::numeric($sum = collect($data)->sum());
            Assert::numeric($chart->max);
            $other = $chart->max - $sum;
            // $other = $chart->max - $chart->avg;
            if ($other > 0.01) {
                // $color_array[1] = 'white';
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt ?? 'answer_value_no_txt';
                if (\count($labels) === 2 && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $chart->answer_value_txt;
                }
            }

            // $data = [$chart->avg, $other];
        }

        // A new pie graph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');

        // $graph = $this->applyGraphStyle($graph);
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create the pie plot
        $piePlotC = new PiePlotC($data);
        $piePlotC->SetStartAngle(180);

        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $chart->list_color);

        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@0.6';
        }

        // dddx($color_array);
        $piePlotC->SetSliceColors($color_array);

        // nasconde i label
        if (is_object($piePlotC->value) && method_exists($piePlotC->value, 'Show')) {
            $piePlotC->value->Show(false);
        }

        // Set color for mid circle
        $piePlotC->SetMidColor('white');

        // $p1->SetMidSize(0.8);
        $piePlotC->SetMidSize($chart->plot_perc_width / 100);

        if (isset($graph->title) && $graph->title instanceof Text) {
            $graph->title->Set($chart->title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }

        if (isset($graph->subtitle) && $graph->subtitle instanceof Text) {
            $graph->subtitle->Set($chart->subtitle);
            $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);
        }

        // 150    Cannot cast mixed to float.
        $footer_txt = 'Media N.D.';
        if (\is_array($data) && isset($data[0]) && \is_numeric($data[0])) {
            // $footer_txt = 'Media '.number_format((float) $chart->avg, 2);
            $footer_txt = 'Media '.number_format((float) $data[0], 2);
        }

        if (isset($graph->footer) && is_object($graph->footer)) {
            if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
                $graph->footer->center->Set($footer_txt);
                $graph->footer->center->SetFont($chart->font_family, $chart->font_style, $chart->font_size);
            }
        }

        // posiziona al centro del pie
        $y = $chart->height / 2 - 8; // 8 è il font_size
        if (isset($graph->footer) && is_object($graph->footer) && method_exists($graph->footer, 'SetMargin')) {
            $graph->footer->SetMargin(0, 0, $y);
        }

        // con 0 metto al centro la percentuale
        $piePlotC->SetLabelPos(0);

        // Add plot to pie graph
        $graph->Add($piePlotC);

        return $graph;
    }
}
