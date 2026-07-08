<?php

declare(strict_types=1);

namespace Modules\Ptv\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Livewire\Wireable;
use Modules\Xot\Traits\EnumTrait;
use Spatie\LaravelData\Concerns\WireableData;

enum CriteriEsclusioneEnum: string implements HasColor, HasIcon, HasLabel, Wireable
{
    use EnumTrait;
    use WireableData;

    case min_gg_posiz_1_in_sede = 'min_gg_posiz_1_in_sede';
    case min_gg_propro = 'min_gg_propro';
    case min_gg_propro_posfun = 'min_gg_propro_posfun';
    case min_gg_cateco_posfun_no_asz = 'min_gg_cateco_posfun_no_asz';

    case min_gg_cateco_posfun_lavorati_in_sede = 'min_gg_cateco_posfun_lavorati_in_sede';

    case min_gg_anno = 'min_gg_anno';
    case lista_propro_posfun = 'lista_propro_posfun';
    case lista_propro = 'lista_propro';
    case lista_posiz = 'lista_posiz';
    case disci = 'disci';

    case lista_asz_tip_cod_escluso_subito = 'lista_asz_tip_cod_escluso_subito';
    case presenti_il_giorno = 'presenti_il_giorno';
    case min_gg_cateco_posfun_in_sede_no_asz = 'min_gg_cateco_posfun_in_sede_no_asz';

    case min_gg_integ_params = 'min_gg_integ_params';
    case min_gg_integ_params_no_asz = 'min_gg_integ_params_no_asz';
}
