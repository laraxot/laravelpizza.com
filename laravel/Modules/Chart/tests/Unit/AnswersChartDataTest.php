<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Filament\Support\RawJs;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\DataCollection;

describe('AnswersChartData', function () {
    beforeEach(function () {
        // Mock ChartData using from() method
        $this->chartData = ChartData::from([
            'type' => 'bar1',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#ff0000',
            'font_family' => 'Arial',
            'font_size' => '12',
            'font_style' => 'normal',
            'x_label_angle' => '0',
            'show_box' => 1,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => true,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
            'answer_value_no_txt' => 'No Answer',
            'answer_value_txt' => 'Yes Answer',
        ]);

        // Mock AnswerData collection
        $this->answerData = [
            AnswerData::from([
                'label' => 'Test Answer 1',
                'value' => 25,
                'avg' => 75.5,
            ]),
            AnswerData::from([
                'label' => 'Test Answer 2',
                'value' => 15,
                'avg' => 85.2,
            ]),
        ];

        $this->answersChartData = AnswersChartData::from([
            'tot' => 100,
            'title' => 'Test Chart',
            'footer' => 'Test Footer',
            'totalAnswered' => 40,
            'totalInvited' => 100,
            'answers' => new DataCollection(AnswerData::class, $this->answerData),
            'chart' => $this->chartData,
        ]);
    });

    it('can be instantiated', function () {
        expect($this->answersChartData)->toBeInstanceOf(AnswersChartData::class);
    });

    it('has correct properties', function () {
        expect($this->answersChartData->tot)->toBe(100)
            ->and($this->answersChartData->title)->toBe('Test Chart')
            ->and($this->answersChartData->footer)->toBe('Test Footer')
            ->and($this->answersChartData->totalAnswered)->toBe(40)
            ->and($this->answersChartData->totalInvited)->toBe(100);
    });

    it('returns correct chart js type for bar1', function () {
        expect($this->answersChartData->getChartJsType())->toBe('bar');
    });

    it('returns correct chart js type for pie1', function () {
        $chartData = ChartData::from([
            'type' => 'pie1',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#ff0000',
            'font_family' => 'Arial',
            'font_size' => '12',
            'font_style' => 'normal',
            'x_label_angle' => '0',
            'show_box' => 1,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => true,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
        ]);
        $answersChartData = AnswersChartData::from([
            'tot' => 100,
            'title' => 'Test',
            'footer' => 'Test',
            'totalAnswered' => 40,
            'totalInvited' => 100,
            'answers' => new DataCollection(AnswerData::class, $this->answerData),
            'chart' => $chartData,
        ]);

        expect($answersChartData->getChartJsType())->toBe('doughnut');
    });

    it('returns correct chart js type for lineSubQuestion', function () {
        $chartData = ChartData::from([
            'type' => 'lineSubQuestion',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#ff0000',
            'font_family' => 'Arial',
            'font_size' => '12',
            'font_style' => 'normal',
            'x_label_angle' => '0',
            'show_box' => 1,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => true,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
        ]);
        $answersChartData = AnswersChartData::from([
            'tot' => 100,
            'title' => 'Test',
            'footer' => 'Test',
            'totalAnswered' => 40,
            'totalInvited' => 100,
            'answers' => new DataCollection(AnswerData::class, $this->answerData),
            'chart' => $chartData,
        ]);

        expect($answersChartData->getChartJsType())->toBe('line');
    });

    it('returns correct chart js data structure', function () {
        $data = $this->answersChartData->getChartJsData();

        expect($data)->toHaveKeys(['datasets', 'labels'])
            ->and($data['datasets'])->toBeArray()
            ->and($data['labels'])->toBeArray()
            ->and($data['labels'])->toContain('Test Answer 1', 'Test Answer 2');
    });

    it('returns correct chart js options array structure', function () {
        $options = $this->answersChartData->getChartJsOptionsArray();

        expect($options)->toBeArray()
            ->and($options)->toHaveKey('plugins')
            ->and($options['plugins'])->toHaveKey('title');
    });

    it('handles title in options correctly', function () {
        $options = $this->answersChartData->getChartJsOptionsArray();

        expect($options['plugins']['title'])->toHaveKeys(['display', 'text', 'font'])
            ->and($options['plugins']['title']['text'])->toBe('Test Chart');
    });

    it('handles footer in options correctly', function () {
        $answersChartData = AnswersChartData::from([
            'tot' => 100,
            'title' => 'no_set',
            'footer' => 'Test Footer',
            'totalAnswered' => 40,
            'totalInvited' => 100,
            'answers' => new DataCollection(AnswerData::class, $this->answerData),
            'chart' => $this->chartData,
        ]);

        $options = $answersChartData->getChartJsOptionsArray();

        expect($options['plugins']['title'])->toHaveKeys(['display', 'text', 'position'])
            ->and($options['plugins']['title']['text'])->toBe('Test Footer')
            ->and($options['plugins']['title']['position'])->toBe('bottom');
    });

    it('handles horizontal bar chart type', function () {
        $chartData = ChartData::from([
            'type' => 'horizbar1',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#ff0000',
            'font_family' => 'Arial',
            'font_size' => '12',
            'font_style' => 'normal',
            'x_label_angle' => '0',
            'show_box' => 1,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => true,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
        ]);
        $answersChartData = AnswersChartData::from([
            'tot' => 100,
            'title' => 'Test',
            'footer' => 'no_set',
            'totalAnswered' => 40,
            'totalInvited' => 100,
            'answers' => new DataCollection(AnswerData::class, $this->answerData),
            'chart' => $chartData,
        ]);

        $options = $answersChartData->getChartJsOptionsArray();

        expect($options)->toHaveKey('indexAxis')
            ->and($options['indexAxis'])->toBe('y');
    });

    it('returns chart js options as RawJs', function () {
        $options = $this->answersChartData->getChartJsOptionsJs();

        expect($options)->toBeInstanceOf(RawJs::class);
    });

    it('handles bar options correctly', function () {
        $options = [];
        $result = $this->answersChartData->getChartJsBarOptionsArray($options);

        expect($result)->toHaveKey('plugins')
            ->and($result['plugins'])->toHaveKeys(['datalabels', 'legend'])
            ->and($result['plugins']['datalabels']['display'])->toBeTrue()
            ->and($result['plugins']['legend']['display'])->toBeFalse();
    });

    it('handles doughnut options correctly', function () {
        $options = [];
        $result = $this->answersChartData->getChartJsDoughnutOptionsArray($options);

        expect($result)->toHaveKeys(['scales', 'plugins'])
            ->and($result['scales'])->toHaveKeys(['x', 'y'])
            ->and($result['plugins'])->toHaveKeys(['datalabels', 'doughnutLabel'])
            ->and($result['plugins']['datalabels']['display'])->toBeFalse();
    });

    it('processes bar chart javascript correctly', function () {
        $js = $this->answersChartData->getChartJsBarOptionsJs();

        expect($js)->toBeString()
            ->and($js)->toContain('plugins')
            ->and($js)->toContain('datalabels')
            ->and($js)->toContain('legend');
    });

    it('processes doughnut chart javascript correctly', function () {
        $js = $this->answersChartData->getChartJsDoughnutOptionsJs();

        expect($js)->toBeString()
            ->and($js)->toContain('scales')
            ->and($js)->toContain('plugins')
            ->and($js)->toContain('doughnutLabel');
    });

    it('handles deprecated chart js options method', function () {
        $options = $this->answersChartData->getChartJsOptions();

        expect($options)->toBeArray()
            ->and($options)->toHaveKey('plugins');
    });
});
