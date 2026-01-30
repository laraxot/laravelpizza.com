<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Datas\ChartData;
use Spatie\LaravelData\Data;

describe('ChartData', function () {
    it('can be created from array', function () {
        $data = [
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
        ];

        $chartData = ChartData::from($data);

        expect($chartData)->toBeInstanceOf(ChartData::class)
            ->and($chartData->type)->toBe('bar1')
            ->and($chartData->max)->toBe(100.0)
            ->and($chartData->min)->toBe(0.0)
            ->and($chartData->height)->toBe(400)
            ->and($chartData->list_color)->toBe('#ff0000');
    });

    it('has correct property types', function () {
        $chartData = ChartData::from([
            'type' => 'pie1',
            'max' => 50.5,
            'min' => 10.2,
            'height' => 300,
            'list_color' => '#00ff00',
            'font_family' => 'Helvetica',
            'font_size' => '14',
            'font_style' => 'bold',
            'x_label_angle' => '45',
            'show_box' => 0,
            'x_label_margin' => 15,
            'plot_perc_width' => 80,
            'plot_value_show' => false,
            'plot_value_pos' => 2,
            'plot_value_color' => '#ffffff',
        ]);

        expect($chartData->type)->toBeString()
            ->and($chartData->max)->toBeFloat()
            ->and($chartData->min)->toBeFloat()
            ->and($chartData->height)->toBeInt()
            ->and($chartData->plot_value_show)->toBeBool();
    });

    it('can handle optional properties', function () {
        $chartData = ChartData::from([
            'type' => 'line',
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
            'title' => 'Test Title',
            'subtitle' => 'Test Subtitle',
            'width' => 800,
        ]);

        expect($chartData->title)->toBe('Test Title')
            ->and($chartData->subtitle)->toBe('Test Subtitle')
            ->and($chartData->width)->toBe(800);
    });

    it('can be converted to array', function () {
        $originalData = [
            'type' => 'doughnut',
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
        ];

        $chartData = ChartData::from($originalData);
        $arrayData = $chartData->toArray();

        expect($arrayData)->toBeArray()
            ->and($arrayData['type'])->toBe('doughnut')
            ->and($arrayData['max'])->toBe(100.0)
            ->and($arrayData['height'])->toBe(400);
    });

    it('validates required properties', function () {
        // Test with minimal required data
        $minimalData = [
            'type' => 'bar',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#000000',
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
        ];

        $chartData = ChartData::from($minimalData);

        expect($chartData)->toBeInstanceOf(ChartData::class)
            ->and($chartData->type)->toBe('bar');
    });

    it('can handle different chart types', function () {
        $chartTypes = ['bar1', 'bar2', 'bar3', 'pie1', 'pieAvg', 'horizbar1', 'lineSubQuestion'];

        foreach ($chartTypes as $type) {
            $chartData = ChartData::from([
                'type' => $type,
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

            expect($chartData->type)->toBe($type);
        }
    });

    it('validates numeric properties', function () {
        $chartData = ChartData::from([
            'type' => 'test',
            'max' => 150.75,
            'min' => 25.25,
            'height' => 500,
            'list_color' => '#ff0000',
            'font_family' => 'Arial',
            'font_size' => '16',
            'font_style' => 'normal',
            'x_label_angle' => '90',
            'show_box' => 1,
            'x_label_margin' => 20,
            'plot_perc_width' => 85,
            'plot_value_show' => true,
            'plot_value_pos' => 3,
            'plot_value_color' => '#000000',
        ]);

        expect($chartData->max)->toBe(150.75)
            ->and($chartData->min)->toBe(25.25)
            ->and($chartData->height)->toBe(500)
            ->and($chartData->x_label_margin)->toBe(20)
            ->and($chartData->plot_perc_width)->toBe(85);
    });

    it('validates boolean properties', function () {
        $chartData = ChartData::from([
            'type' => 'test',
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
            'plot_value_show' => false,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
        ]);

        expect($chartData->plot_value_show)->toBeFalse();
    });

    it('can handle color properties', function () {
        $chartData = ChartData::from([
            'type' => 'test',
            'max' => 100.0,
            'min' => 0.0,
            'height' => 400,
            'list_color' => '#ff5733',
            'font_family' => 'Arial',
            'font_size' => '12',
            'font_style' => 'normal',
            'x_label_angle' => '0',
            'show_box' => 1,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => true,
            'plot_value_pos' => 1,
            'plot_value_color' => '#ffffff',
            'bg_color' => '#000000',
        ]);

        expect($chartData->list_color)->toBe('#ff5733')
            ->and($chartData->plot_value_color)->toBe('#ffffff')
            ->and($chartData->bg_color)->toBe('#000000');
    });

    it('extends Spatie Laravel Data', function () {
        expect($this->action)->toBeInstanceOf(GetTaskFrequenciesAction::class);

        // Check that ChartData extends Data
        $chartData = ChartData::from([
            'type' => 'test',
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

        expect($chartData)->toBeInstanceOf(Data::class);
    });
});
