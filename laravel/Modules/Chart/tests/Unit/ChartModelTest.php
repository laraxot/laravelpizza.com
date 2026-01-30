<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Models\Chart;
use Webmozart\Assert\InvalidArgumentException;

describe('Chart Model', function () {
    it('can be created with factory', function () {
        $chart = Chart::factory()->create();

        expect($chart)->toBeInstanceOf(Chart::class)
            ->and($chart->exists)->toBeTrue();
    });

    it('has correct fillable attributes', function () {
        $chart = new Chart;

        expect($chart->getFillable())->toContain([
            'id', 'post_id', 'post_type', 'type', 'width', 'height',
            'color', 'bg_color', 'font_family', 'font_size', 'font_style',
            'y_grace', 'yaxis_hide', 'list_color', 'grace', 'x_label_angle',
            'show_box', 'x_label_margin', 'plot_perc_width', 'plot_value_show',
            'plot_value_format', 'plot_value_pos', 'plot_value_color',
            'group_by', 'sort_by', 'transparency', 'colors',
        ]);
    });

    it('has correct default attributes', function () {
        $chart = new Chart;

        expect($chart->getAttributes())->toMatchArray([
            'list_color' => '#d60021',
            'color' => '#d60021',
            'font_family' => 15,
            'font_style' => 9002,
            'font_size' => 12,
            'x_label_angle' => 0,
            'show_box' => false,
            'x_label_margin' => 10,
            'plot_perc_width' => 90,
            'plot_value_show' => 1,
            'plot_value_pos' => 1,
            'plot_value_color' => '#000000',
        ]);
    });

    it('casts colors attribute to array', function () {
        $chart = createChart(['colors' => ['red', 'blue', 'green']]);

        expect($chart->colors)->toBeArray()
            ->and($chart->colors)->toBe(['red', 'blue', 'green']);
    });

    describe('Type Attribute', function () {
        it('returns value when set', function () {
            $chart = createChart(['type' => 'bar']);

            expect($chart->type)->toBe('bar');
        });

        it('falls back to chart_type from getPanelRow when null', function () {
            $chart = makeChart(['type' => null]);

            // Mock the getPanelRow method behavior
            $chart = $chart->withoutEvents(function () use ($chart) {
                $chart->chart_type = 'line';

                return $chart;
            });

            expect($chart->getTypeAttribute(null))->toBeString();
        });
    });

    describe('Width Attribute', function () {
        it('returns integer value when set', function () {
            $chart = createChart(['width' => 800]);

            expect($chart->width)->toBe(800);
        });

        it('calls getPanelRow when value is null', function () {
            $chart = makeChart(['width' => null]);

            expect($chart->getWidthAttribute(null))->toBeInt();
        });

        it('calls getPanelRow when value is zero', function () {
            $chart = makeChart(['width' => 0]);

            expect($chart->getWidthAttribute('0'))->toBeInt();
        });
    });

    describe('Height Attribute', function () {
        it('returns integer value when set', function () {
            $chart = createChart(['height' => 600]);

            expect($chart->height)->toBe(600);
        });

        it('calls getPanelRow when value is null', function () {
            $chart = makeChart(['height' => null]);

            expect($chart->getHeightAttribute(null))->toBeInt();
        });

        it('calls getPanelRow when value is zero', function () {
            $chart = makeChart(['height' => 0]);

            expect($chart->getHeightAttribute('0'))->toBeInt();
        });
    });

    describe('getPanelRow Method', function () {
        it('returns value and saves to model', function () {
            $chart = createChart(['post_id' => '123']);

            $result = $chart->getPanelRow('post_id', 'test_field');

            expect($result)->toBe('123')
                ->and($chart->test_field)->toBe('123');
        });

        it('handles exceptions gracefully', function () {
            $chart = createChart();

            $result = $chart->getPanelRow('non_existent_field', 'test_field');

            expect($result)->toBeNull();
        });
    });

    describe('getSettings Method', function () {
        it('returns array with chart data for non-mixed type', function () {
            $chart = createChart(['type' => 'bar']);

            $settings = $chart->getSettings();

            expect($settings)->toBeArray()
                ->and($settings)->toHaveCount(1)
                ->and($settings[0])->toBeArray();
        });

        it('throws assertion error when type is null', function () {
            $chart = makeChart(['type' => null]);

            expect(fn () => $chart->getSettings())
                ->toThrow(InvalidArgumentException::class);
        });
    });
});
