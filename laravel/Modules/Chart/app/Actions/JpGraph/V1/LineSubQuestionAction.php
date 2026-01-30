<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\Legend;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Text\Text;
use Illuminate\Support\Collection;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function collect;

final class LineSubQuestionAction
{
    use QueueableAction;

    private const COLOR_PALETTE = [
        '#55bbdd',
        '#aaaaaa',
        '#d60021',
        '#0baa90',
    ];

    /**
     * Marker identifiers recognized by JpGraph PlotMark.
     */
    private const MARKERS = [
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
        12,
    ];

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $chart = $this->extractChart($answersChartData);
        $graph = $this->makeGraph($chart);

        $answers = $this->getAnswers($answersChartData);
        $labels = $this->extractLabels($answers);
        $legends = $this->extractLegends($answers);
        $dataSets = $this->normalizeDataSets($answers, $legends);

        $this->configureAxes($graph, $labels, (int) $chart->x_label_angle);
        $this->addLinePlots($graph, $dataSets, $legends);
        $this->configureLegend($graph);
        $this->configureTitles($graph, $chart);
        $this->clearFooter($graph);

        return $graph;
    }

    private function extractChart(AnswersChartData $answersChartData): ChartData
    {
        return $answersChartData->chart;
    }

    private function makeGraph(ChartData $chart): Graph
    {
        $graph = app(GetGraphAction::class)->execute($chart);
        Assert::isInstanceOf($graph, Graph::class);

        $graph->SetScale('textlin');
        $graph->SetBox(false);

        return $graph;
    }

    /**
     * @return Collection<int, AnswerData>
     */
    private function getAnswers(AnswersChartData $answersChartData): Collection
    {
        /** @var Collection<int, AnswerData> $answers */
        $answers = collect($answersChartData->answers->items())->values();
        Assert::allIsInstanceOf($answers->all(), AnswerData::class);

        return $answers;
    }

    /**
     * @param Collection<int, AnswerData> $answers
     *
     * @return array<int, string>
     */
    private function extractLabels(Collection $answers): array
    {
        return $answers
            ->pluck('label')
            ->filter(static fn ($label): bool => is_scalar($label))
            ->map(static fn ($label): string => (string) $label)
            ->values()
            ->all();
    }

    /**
     * @param Collection<int, AnswerData> $answers
     *
     * @return array<int, string>
     */
    private function extractLegends(Collection $answers): array
    {
        $first = $answers->first();

        if (! $first instanceof AnswerData || ! is_array($first->value)) {
            return [];
        }

        return array_map(
            static fn ($legend): string => (string) $legend,
            array_keys($first->value)
        );
    }

    /**
     * @param Collection<int, AnswerData> $answers
     * @param array<int, string>          $legends
     *
     * @return array<int, array<int, float>>
     */
    private function normalizeDataSets(Collection $answers, array $legends): array
    {
        /** @var array<int, array<string, int|float|string|null>|null> $rawData */
        $rawData = $answers->pluck('value')->all();

        return array_map(
            fn (string $legend): array => $this->buildDataSeries($rawData, $legend),
            $legends
        );
    }

    /**
     * @param array<int, array<string, int|float|string|null>|null> $rawData
     *
     * @return array<int, float>
     */
    private function buildDataSeries(array $rawData, string $legend): array
    {
        $series = [];

        foreach ($rawData as $row) {
            $series[] = $this->extractNumericValue($row, $legend);
        }

        return $series;
    }

    /**
     * @param array<string, int|float|string|null>|null $row
     */
    private function extractNumericValue(?array $row, string $legend): float
    {
        if ($row !== null && array_key_exists($legend, $row)) {
            $value = $row[$legend];

            if (is_numeric($value)) {
                return (float) $value;
            }
        }

        return 0.0;
    }

    /**
     * @param array<int, string> $labels
     */
    private function configureAxes(Graph $graph, array $labels, int $angle): void
    {
        $this->configureYAxis($graph);
        $this->configureXAxis($graph, $labels, $angle);
        $this->configureYGrid($graph);
    }

    private function configureYAxis(Graph $graph): void
    {
        $yAxis = isset($graph->yaxis) && $graph->yaxis instanceof Axis ? $graph->yaxis : null;
        if (! $yAxis instanceof Axis) {
            return;
        }

        $yAxis->HideZeroLabel();
        $yAxis->HideLine(false);
        $yAxis->HideTicks(false, false);
    }

    /**
     * @param array<int, string> $labels
     */
    private function configureXAxis(Graph $graph, array $labels, int $angle): void
    {
        $xAxis = isset($graph->xaxis) && $graph->xaxis instanceof Axis ? $graph->xaxis : null;
        if (! $xAxis instanceof Axis) {
            return;
        }

        $xAxis->SetTickLabels($labels);
        $xAxis->SetLabelAngle($angle);
    }

    private function configureYGrid(Graph $graph): void
    {
        $yGrid = $graph->ygrid ?? null;
        if (! is_object($yGrid) || ! method_exists($yGrid, 'SetFill')) {
            return;
        }

        $yGrid->SetFill(false);
    }

    /**
     * @param array<int, array<int, float>> $dataSets
     * @param array<int, string>            $legends
     */
    private function addLinePlots(Graph $graph, array $dataSets, array $legends): void
    {
        foreach ($legends as $index => $legend) {
            $linePlot = new LinePlot($dataSets[$index] ?? []);
            $graph->Add($linePlot);

            $color = self::COLOR_PALETTE[$index % \count(self::COLOR_PALETTE)];
            $linePlot->SetColor($color);
            $linePlot->SetLegend($legend);
            $this->configureMarker($linePlot, $index, $color);

            $linePlot->SetCenter();
        }
    }

    private function configureMarker(LinePlot $linePlot, int $index, string $color): void
    {
        $mark = $linePlot->mark ?? null;
        if (! is_object($mark)) {
            return;
        }

        $marker = $this->resolveMarker($index);
        if ($marker !== null && method_exists($mark, 'SetType')) {
            $mark->SetType($marker, '', 1.2);
        }

        if (method_exists($mark, 'SetColor')) {
            $mark->SetColor($color);
        }
    }

    private function configureLegend(Graph $graph): void
    {
        $legend = isset($graph->legend) && $graph->legend instanceof Legend ? $graph->legend : null;
        if (! $legend instanceof Legend) {
            return;
        }

        $legend->SetFrameWeight(1);
        $legend->SetColor('#4E4E4E', '#00A78A');
        $legend->SetMarkAbsSize(8);
    }

    private function configureTitles(Graph $graph, ChartData $chart): void
    {
        $this->applyTextSettings(
            isset($graph->title) && $graph->title instanceof Text ? $graph->title : null,
            $chart->title,
            $chart->font_family,
            $chart->font_style
        );

        $this->applyTextSettings(
            isset($graph->subtitle) && $graph->subtitle instanceof Text ? $graph->subtitle : null,
            $chart->subtitle,
            $chart->font_family,
            $chart->font_style
        );
    }

    private function clearFooter(Graph $graph): void
    {
        $footer = $graph->footer ?? null;
        if (! is_object($footer) || ! isset($footer->center)) {
            return;
        }

        $center = $footer->center instanceof Text ? $footer->center : null;
        if ($center !== null) {
            $center->Set('');
        }
    }

    private function resolveMarker(int $index): ?int
    {
        $marker = self::MARKERS[$index % \count(self::MARKERS)] ?? null;

        return is_int($marker) ? $marker : null;
    }

    private function applyTextSettings(?Text $component, ?string $text, string $fontFamily, string $fontStyle): void
    {
        if ($component === null || $text === null) {
            return;
        }

        $component->Set($text);
        $component->SetFont($fontFamily, $fontStyle, 11);
    }
}
