<?php

declare(strict_types=1);

namespace Modules\Chart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Chart\Models\Chart;

class ChartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Chart::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $types = ['chart', 'graph', 'plot', 'diagram'];
        $charts = ['bar', 'line', 'pie', 'doughnut', 'radar', 'polarArea'];
        $fonts = ['Arial', 'Helvetica', 'Times New Roman', 'Courier New', 'Verdana'];
        $styles = ['normal', 'bold', 'italic', 'bold-italic'];
        $positions = ['above', 'below', 'inside', 'outside'];
        $groups = ['category', 'date', 'value', 'region'];
        $sorts = ['name', 'value', 'date', 'count'];
        $formats = ['%', 'decimal', 'integer', 'currency'];

        return [
            'id' => $this->faker->randomNumber(5),
            'post_id' => $this->faker->randomNumber(5),
            'post_type' => $types[array_rand($types)],
            'type' => $charts[array_rand($charts)],
            'width' => $this->faker->numberBetween(400, 1200),
            'height' => $this->faker->numberBetween(300, 800),
            'color' => '#' . str_pad(dechex(random_int(0, 16777215)), 6, '0', STR_PAD_LEFT),
            'bg_color' => '#' . str_pad(dechex(random_int(0, 16777215)), 6, '0', STR_PAD_LEFT),
            'font_family' => $fonts[array_rand($fonts)],
            'font_size' => $this->faker->numberBetween(8, 72),
            'font_style' => $styles[array_rand($styles)],
            'y_grace' => $this->faker->randomNumber(5),
            'yaxis_hide' => (bool) random_int(0, 1),
            'list_color' => '#' . str_pad(dechex(random_int(0, 16777215)), 6, '0', STR_PAD_LEFT),
            'grace' => $this->faker->randomNumber(5),
            'x_label_angle' => $this->faker->numberBetween(0, 360),
            'show_box' => (bool) random_int(0, 1),
            'x_label_margin' => $this->faker->numberBetween(0, 50),
            'plot_perc_width' => $this->faker->randomFloat(2, 0, 100),
            'plot_value_show' => (bool) random_int(0, 1),
            'plot_value_format' => $formats[array_rand($formats)],
            'plot_value_pos' => $positions[array_rand($positions)],
            'plot_value_color' => '#' . str_pad(dechex(random_int(0, 16777215)), 6, '0', STR_PAD_LEFT),
            'group_by' => $groups[array_rand($groups)],
            'sort_by' => $sorts[array_rand($sorts)],
            'transparency' => $this->faker->numberBetween(0, 100),
        ];
    }
}