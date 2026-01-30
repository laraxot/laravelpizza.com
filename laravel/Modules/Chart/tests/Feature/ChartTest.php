<?php

declare(strict_types=1);

uses(\Modules\Chart\Tests\TestCase::class);

use Modules\Chart\Models\Chart;

it('can create a chart with valid data', function () {
    $chartData = [
        'post_id' => 1,
        'post_type' => 'report',
        'type' => 'bar',
        'width' => 800,
        'height' => 600,
        'color' => '#FF0000',
        'bg_color' => '#FFFFFF',
        'font_family' => 15,
        'font_size' => 12,
        'font_style' => 0,
        'y_grace' => 10,
        'yaxis_hide' => false,
        'list_color' => '#00FF00',
        'grace' => 5,
        'x_label_angle' => 45,
        'show_box' => true,
        'x_label_margin' => 10,
        'plot_perc_width' => 80,
        'plot_value_show' => true,
        'plot_value_format' => 'integer',
        'plot_value_pos' => false,
        'plot_value_color' => '#0000FF',
        'group_by' => 'category',
        'sort_by' => 'name',
        'transparency' => 0.5,
    ];

    $chart = Chart::create($chartData);

    expect($chart)->toBeInstanceOf(Chart::class);
    expect($chart->post_id)->toBe(1);
    expect($chart->type)->toBe('bar');
    expect($chart->width)->toBe(800);
    expect($chart->color)->toBe('#FF0000');
});

it('can update a chart', function () {
    $chart = Chart::factory()->create();
    $chart->update(['width' => 1024]);

    expect($chart->fresh()->width)->toBe(1024);
});

it('can delete a chart', function () {
    $chart = Chart::factory()->create();
    $chartId = $chart->id;
    $chart->delete();

    expect(Chart::find($chartId))->toBeNull();
});
