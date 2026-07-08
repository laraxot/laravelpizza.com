<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Arr;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Webmozart\Assert\Assert;

class IconPicker extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $icons = app(GetAllIconsAction::class)->execute();

        $packs = array_keys($icons);
        /** @var list<int|string> $packsKeys */
        $packsKeys = $packs;
        $packsCombined = array_combine($packsKeys, $packsKeys);
        /** @var array<string, string> $packs */
        $packs = $packsCombined ?: [];

        $this->suffixAction(
            Action::make('icon')
                ->icon(static fn (?string $state) => $state)
                ->schema([
                    Select::make('pack')
                        ->options(static function () use ($packs): array {
                            return $packs;
                        })
                        ->reactive()
                        ->live(),
                    RadioIcon::make('newstate')
                        ->options(function (Get $get) use ($icons): array {
                            $pack = $get('pack');
                            if (! \is_string($pack)) {
                                return [];
                            }
                            $key = $pack.'.icons';
                            $optsRaw = Arr::get($icons, $key, []);
                            Assert::isArray(
                                $optsRaw,
                                '['.__LINE__.']['.class_basename($this).']',
                            );
                            /** @var array<int|string, mixed> $optsRaw */
                            $optsValues = array_map(
                                static fn ($v) => SafeStringCastAction::cast($v),
                                array_values($optsRaw),
                            );
                            /** @var array<int|string> $optsKeys */
                            $optsKeys = array_map(
                                static fn ($k) => SafeStringCastAction::cast($k),
                                array_keys($optsRaw),
                            );
                            $optsCombined = array_combine($optsKeys, $optsValues);

                            return $optsCombined ? $optsCombined : [];
                        })
                        ->inline()
                        ->inlineLabel(false),
                ])
                ->action(static function (array $data, Set $set): void {
                    $set('icon', $data['newstate']);
                }),
        );
    }
}
