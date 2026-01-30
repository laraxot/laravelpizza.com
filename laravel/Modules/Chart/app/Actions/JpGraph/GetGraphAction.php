<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Text\Text;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class GetGraphAction
{
    use QueueableAction;

    public function execute(ChartData $chartData): Graph
    {
        $graph = new Graph($chartData->width, $chartData->height, 'auto');
        $graph->SetScale('textlin');
        $graph->SetShadow();

        $universalTheme = new UniversalTheme;

        $graph->SetTheme($universalTheme);

        if (is_object($graph->yscale)) {
            if (isset($chartData->min) && method_exists($graph->yscale, 'SetAutoMin')) {
                $graph->yscale->SetAutoMin($chartData->min);
            }

            if (isset($chartData->max) && method_exists($graph->yscale, 'SetAutoMax')) {
                $graph->yscale->SetAutoMax($chartData->max);
            }
        }

        if ($chartData->title !== null && $graph->title instanceof Text) {
            $graph->title->Set($chartData->title);
            $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
        }

        if ($chartData->subtitle !== null && $graph->subtitle instanceof Text) {
            $graph->subtitle->Set($chartData->subtitle);
            $graph->subtitle->SetFont($chartData->font_family, $chartData->font_style, 11);
        }

        if ($chartData->footer !== null && is_object($graph->footer)) {
            // PHPStan L10: isset() universale - funziona per declared properties (JpGraph) E magic properties
            if (isset($graph->footer->center) && $graph->footer->center instanceof Text) {
                $graph->footer->center->Set($chartData->footer);
                $graph->footer->center->SetFont($chartData->font_family, $chartData->font_style, 10);
            }
        }

        $graph->SetBox($chartData->show_box);

        if (is_object($graph->footer)) {
            // PHPStan L10: isset() universale - funziona per declared properties (JpGraph) E magic properties
            if (isset($graph->footer->right) && $graph->footer->right instanceof Text) {
                $graph->footer->right->SetFont($chartData->font_family, $chartData->font_style);
            }
        }

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
