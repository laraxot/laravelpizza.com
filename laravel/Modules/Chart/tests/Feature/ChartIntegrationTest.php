<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Models\Chart;
use Modules\Chart\Models\MixedChart;

describe('Chart Integration', function () {
    it('can create chart with all required fields', function () {
        $chartData = [
            'type' => 'bar',
            'width' => 800,
            'height' => 600,
            'color' => '#ff0000',
            'bg_color' => '#ffffff',
            'post_id' => '123',
            'post_type' => 'report',
        ];

        $chart = Chart::factory()->create($chartData);

        expect($chart->type)->toBe('bar')
            ->and($chart->width)->toBe(800)
            ->and($chart->height)->toBe(600)
            ->and($chart->color)->toBe('#ff0000')
            ->and($chart->bg_color)->toBe('#ffffff')
            ->and($chart->post_id)->toBe('123')
            ->and($chart->post_type)->toBe('report');
    });

    it('applies default attributes when creating chart', function () {
        $chart = new Chart();

        expect($chart->list_color)->toBe('#d60021')
            ->and($chart->color)->toBe('#d60021')
            ->and($chart->font_family)->toBe(15)
            ->and($chart->font_size)->toBe(12)
            ->and($chart->plot_perc_width)->toBe(90);
    });

    it('handles mixed chart type correctly', function () {
        // Create a mixed chart first
        $mixedChart = MixedChart::factory()->create();

        $chart = Chart::factory()->create([
            'type' => 'mixed:'.$mixedChart->id,
        ]);

        // This should not throw an exception
        expect(fn () => $chart->getSettings())->not->toThrow(Exception::class);
    });

    it('can update chart properties', function () {
        $chart = Chart::factory()->create(['width' => 400]);

        $chart->update(['width' => 800, 'height' => 600]);

        expect($chart->fresh()->width)->toBe(800)
            ->and($chart->fresh()->height)->toBe(600);
    });

    it('persists colors array correctly', function () {
        $colors = ['#ff0000', '#00ff00', '#0000ff'];
        $chart = Chart::factory()->create(['colors' => $colors]);

        $freshChart = Chart::find($chart->id);

        expect($freshChart->colors)->toBe($colors)
            ->and($freshChart->colors)->toHaveCount(3);
    });
});
