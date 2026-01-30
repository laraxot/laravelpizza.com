<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Illuminate\Support\Str;
use Spatie\Color\Hex;
use Spatie\LaravelData\Data;

class ChartData extends Data
{
    public string $type; // horizbar1, pie ecc

    public float $max;

    public float $min;

    public ?int $width = null;

    public int $height;

    public ?string $title = null;

    public ?string $subtitle = null;

    public string $list_color;

    // public string $color; // #000000 // non si deve più usare, sostituito da list_color
    public ?string $bg_color = null; // #000000

    public string $font_family;

    public string $font_size;

    public string $font_style;

    public ?int $y_grace = null;

    public ?int $yaxis_hide = null;

    public string $x_label_angle;

    public int $show_box;

    public int $x_label_margin;

    public int $plot_perc_width;

    public bool $plot_value_show;

    public ?string $plot_value_format = null;

    public ?string $plot_value_color = '#000000';

    public string $transparency;

    public ?string $engine_type = null;

    public ?string $footer = null;

    public int $plot_value_pos = 0;

    public ?string $answer_value_no_txt = null;

    public ?string $answer_value_txt = null;

    // public ?string $legend;
    /** @var array<string, mixed>|null */
    public ?array $legend = null;

    /** @var array<int, string>|null */
    public ?array $sublabels = null;

    public ?float $avg = null;

    /**
     * @return array<int, string>
     */
    public function getColors(): array
    {
        return explode(',', $this->list_color);
    }

    /**
     * @return array<int, string>
     */
    public function getColorsRgba(float $alpha = 1): array
    {
        $colors = $this->getColors();

        return collect($colors)->map(function ($item) use ($alpha) {
            if (! Str::startsWith($item, '#')) {
                return $item;
            }

            $hex = Hex::fromString($item);

            if (is_object($hex) && method_exists($hex, 'toRgba')) {
                return (string) $hex->toRgba($alpha);
            }

            return (string) $item;
        })->all();
    }

    public function getActionClass(): string
    {
        $type = $this->type;
        $engine = 'JpGraph\V1';
        $action = Str::studly($type).'Action';

        return '\Modules\Chart\Actions\\'.$engine.'\\'.$action;
    }
}
