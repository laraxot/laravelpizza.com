<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Ptv\Enums\ComparisonOperatorEnum;
use Modules\Ptv\Enums\CriteriEsclusioneEnum;
use Modules\Ptv\Enums\RuleValueTypeEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

abstract class BaseCriteriEsclusioneForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'name' => Select::make('name')->options(CriteriEsclusioneEnum::class),
            'field_name' => TextInput::make('field_name'),
            'op' => Select::make('op')->options(ComparisonOperatorEnum::class),
            'value' => TextInput::make('value')->required(),
            'type' => Select::make('type')->options(RuleValueTypeEnum::class),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }
}
