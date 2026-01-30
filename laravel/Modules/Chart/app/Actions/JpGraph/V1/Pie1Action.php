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

use function Safe\define;

// JpGraph font constants - these are global constants defined by JpGraph
// We'll use them directly without namespace imports since they're global

// Fallback constant definitions for PHPStan compatibility
if (! defined('Amenadiel\\JpGraph\\FF_ARIAL')) {
    define('Amenadiel\\JpGraph\\FF_ARIAL', 1);
    define('Amenadiel\\JpGraph\\FS_BOLD', 1);
    define('Amenadiel\\JpGraph\\FS_NORMAL', 0);
}

class Pie1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;
        // dddx(['labels' => $labels, 'data' => $data, 'chart' => $chart]);

        if (isset($chart->max)) {
            Assert::numeric($sum = collect($data)->sum());
            Assert::numeric($chart->max);
            $other = $chart->max - $sum;
            // dddx([$sum, $other, $this->vars['max']]);
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt;

                if (\count($labels) === 2 && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $chart->answer_value_txt;
                }
            }
        }

        // A new pie graph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        // $graph = $this->getGraph();
        // $graph = $this->applyGraphStyle($graph);
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create the pie plot
        $piePlotC = new PiePlotC($data);

        // $p1->SetSliceColors(explode(',', $chart->list_color));
        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
        }

        $piePlotC->SetSliceColors($color_array);

        $piePlotC->SetLegends($labels);
        // $graph->legend->SetPos(0.5,0.98,'center','bottom');

        // Enable and set policy for guide-lines. Make labels line up vertically
        $piePlotC->SetGuideLines(true, false);
        $piePlotC->SetGuideLinesAdjust(1.5);

        // Use percentage values in the legends values (This is also the default)
        $piePlotC->SetLabelType(PIE_VALUE_PER);

        if (is_object($piePlotC->value) && method_exists($piePlotC->value, 'Show')) {
            $piePlotC->value->Show();
        }

        // $p1->SetMidSize(0.8);
        $piePlotC->SetMidSize($chart->plot_perc_width / 100);

        // $mandatory = $chart->mandatory;
        // if (null === $chart->mandatory) {
        //     $mandatory = 'null';
        // }

        if (isset($graph->title) && $graph->title instanceof Text) {
            $graph->title->Set($chart->title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }

        if (isset($graph->subtitle) && $graph->subtitle instanceof Text) {
            $graph->subtitle->Set($chart->subtitle);
            $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);
        }

        // Label font and color setup
        if (is_object($piePlotC->value)) {
            if (method_exists($piePlotC->value, 'SetFont')) {
                $piePlotC->value->SetFont(FF_ARIAL, FS_BOLD, 10);
            }
            if (method_exists($piePlotC->value, 'SetColor')) {
                $piePlotC->value->SetColor('black');
            }
            if (method_exists($piePlotC->value, 'SetFormat')) {
                $piePlotC->value->SetFormat('%2.1f%%');
            }
        }

        // Setup the title on the center circle
        if (is_object($piePlotC->midtitle)) {
            if (method_exists($piePlotC->midtitle, 'Set')) {
                $piePlotC->midtitle->Set('');
            }
            if (method_exists($piePlotC->midtitle, 'SetFont')) {
                $piePlotC->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);
            }
        }

        // Set color for mid circle
        $piePlotC->SetMidColor('white');

        // Add plot to pie graph
        $graph->Add($piePlotC);

        return $graph;
    }
}
