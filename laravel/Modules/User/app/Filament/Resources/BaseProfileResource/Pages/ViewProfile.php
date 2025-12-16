<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Support\Components\Component;
use Modules\User\Filament\Resources\BaseProfileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewProfile extends XotBaseViewRecord
{
    protected static string $resource = BaseProfileResource::class;

    /**
     * @return array<int, Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            Section::make()->schema([
                Flex::make([
                    Grid::make(2)->schema([
                        Group::make([
                            TextEntry::make('email'),
                            TextEntry::make('first_name'),
                            TextEntry::make('last_name'),
                            TextEntry::make('created_at')
                                ->badge()
                                ->date()
                                ->color('success'),
                        ]),
                        /*
                         * Components\Group::make([
                         * Components\TextEntry::make('author.name'),
                         * Components\TextEntry::make('category.name'),
                         * Components\TextEntry::make('tags')
                         * ->badge()
                         * ->getStateUsing(fn () => ['one', 'two', 'three', 'four']),
                         * ]),
                         */
                    ]),
                    ImageEntry::make('image')->hiddenLabel()->grow(false),
                ])->from('lg'),
            ]),
            Section::make('Content')
                ->schema([
                    TextEntry::make('content')
                        ->prose()
                        ->markdown()
                        ->hiddenLabel(),
                ])
                ->collapsible(),
        ];
    }
}
