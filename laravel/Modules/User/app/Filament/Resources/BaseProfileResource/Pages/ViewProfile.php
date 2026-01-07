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
     * @return array<string, Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            'profile_info' => Section::make()->schema([
                'profile_flex' => Flex::make([
                    'profile_grid' => Grid::make(2)->schema([
                        'profile_group' => Group::make([
                            'email' => TextEntry::make('email'),
                            'first_name' => TextEntry::make('first_name'),
                            'last_name' => TextEntry::make('last_name'),
                            'created_at' => TextEntry::make('created_at')
                                ->badge()
                                ->date()
                                ->color('success'),
                        ]),
                    ]),
                    'image' => ImageEntry::make('image')->hiddenLabel()->grow(false),
                ])->from('lg'),
            ]),
            'content' => Section::make('Content')
                ->schema([
                    'content_text' => TextEntry::make('content')
                        ->prose()
                        ->markdown()
                        ->hiddenLabel(),
                ])
                ->collapsible(),
        ];
    }
}
