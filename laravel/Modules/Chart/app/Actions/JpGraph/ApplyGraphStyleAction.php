<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class ApplyGraphStyleAction
{
    use QueueableAction;

    public function execute(Graph &$graph, ChartData $chartData): Graph
    {
        // Nice shadow
        $graph->SetShadow();

        $graph->SetBox($chartData->show_box);

        // Ensure footer->right is a Text object
        if (is_object($graph->footer)) {
            $footer = $graph->footer;
            if (isset($footer->right) && $footer->right instanceof Text) {
                $footer->right->SetFont($chartData->font_family, $chartData->font_style);
            }
        }

        // $graph->footer->right->Set('Totale Risposte '.$this->vars['tot']);
        if ($graph->xaxis instanceof Axis) {
            $this->applyGraphXStyle($graph->xaxis, $chartData);
        }

        if ($graph->yaxis instanceof Axis) {
            $this->applyGraphYStyle($graph->yaxis, $chartData);
        }

        return $graph;
    }

    public function applyGraphXStyle(Axis &$axis, ChartData $chartData): void
    {
        $axis->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
        $axis->SetLabelAngle($chartData->x_label_angle);
        // Some extra margin looks nicer
        $axis->SetLabelMargin($chartData->x_label_margin);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle(Axis &$axis, ChartData $chartData): void
    {
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        if (is_object($axis->scale) && method_exists($axis->scale, 'SetGrace')) {
            $axis->scale->SetGrace($chartData->y_grace);
        }
        // dddx($style['yaxis_hide']);
        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        // if (null == $data->yaxis_hide || 0 == $data->yaxis_hide) {
        if ($chartData->yaxis_hide) {
            $axis->Hide();
        }

        $axis->HideZeroLabel();
        $axis->HideLine(false);
        $axis->HideTicks(false, false);
    }
}
