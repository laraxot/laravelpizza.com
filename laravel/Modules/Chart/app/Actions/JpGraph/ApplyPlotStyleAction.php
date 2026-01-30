<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class ApplyPlotStyleAction
{
    use QueueableAction;

    public function execute(BarPlot $barPlot, ChartData $chartData): BarPlot
    {
        // $plot->SetFillColor($colors); // trasparenza, da 0 a 1

        // $plot->SetFillColor($this->data[5]['color'].'@'.$this->vars['transparency']); // trasparenza, da 0 a 1
        $barPlot->SetFillColor($chartData->list_color ?? 'red@'.$chartData->transparency); // trasparenza, da 0 a 1

        // $bplot->SetShadow('darkgreen', 1, 1);
        // dddx([get_defined_vars(), $this->vars]);

        $barPlot->SetColor($chartData->list_color ?? 'red');

        // You can change the width of the bars if you like
        $barPlot->SetWidth($chartData->plot_perc_width / 100);
        // $plot->SetWidth(10);

        // We want to display the value of each bar at the top
        // se tolto non mostra i valori
        Assert::notNull($barPlot->value);
        $value = $barPlot->value;
        if (! ($value instanceof Text)) {
            return $barPlot;
        }

        if ($chartData->plot_value_show) {
            $value->Show();
        }

        $value->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
        $value->SetAlign('left', 'center');

        // colore del font che scrivi
        if ($chartData->plot_value_color !== null) {
            $value->SetColor($chartData->plot_value_color);
        } else {
            $value->SetColor('black');
        }

        // visualizza il risultato con % oppure no
        // SetFormat exists on subclasses, check dynamically
        if (method_exists($value, 'SetFormat')) {
            switch ($chartData->plot_value_format) {
                case 1:
                    /** @phpstan-ignore-next-line method.notFound */
                    $value->SetFormat('%.1f &#37;');
                    break;
                case 2:
                    /** @phpstan-ignore-next-line method.notFound */
                    $value->SetFormat('%.1f');
                    break;
                case 3:
                    /** @phpstan-ignore-next-line method.notFound */
                    $value->SetFormat('%.0f');
                    break;
                default:
                    /** @phpstan-ignore-next-line method.notFound */
                    $value->SetFormat('%.1f &#37;');
            }
        }

        // Center the values in the bar
        if ($chartData->plot_value_pos === 0) {
            $barPlot->SetValuePos('center');
        }

        $value->setAngle($chartData->x_label_angle);
        // $plot->value->setAngle(50);

        return $barPlot;
    }
}
