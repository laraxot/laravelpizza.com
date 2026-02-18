<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\BaseProfileResource;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * .
 */
class ListProfiles extends XotBaseListRecords
{
    protected static string $resource = BaseProfileResource::class;

    /**
     * @return array<string, Tables\Columns\Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'user.name' => TextColumn::make('user.name')
                ->sortable()
                ->searchable()
                ->default(function ($record) {
                    if (! is_object($record)) {
                        return '--';
                    }

                    // PHPStan Level 10: isset() invece di property_exists() per Eloquent relations/attributes
                    $userValue = $record->user ?? null;

                    if (null === $userValue) {
                        $emailValue = $record->email ?? null;

                        if (null === $emailValue) {
                            if (method_exists($record, 'update')) {
                                $record->update(['email' => fake()->email()]);
                            }
                            $emailValue = $record->email ?? '';
                        }

                        if (! is_string($emailValue)) {
                            return '--';
                        }

                        try {
                            $userValue = XotData::make()->getUserByEmail($emailValue);
                        } catch (\Exception $e) {
                            return '--';
                        }
                    }

                    if (! is_object($userValue)) {
                        return '--';
                    }

                    // PHPStan Level 10: isset() per magic properties di User model
                    $userId = $userValue->id ?? null;

                    if (null !== $userId && method_exists($record, 'update')) {
                        $record->update(['user_id' => $userId]);
                    }

                    $userName = $userValue->name ?? '--';

                    return is_string($userName) ? $userName : '--';
                }),
            'first_name' => TextColumn::make('first_name')->sortable()->searchable(),
            'last_name' => TextColumn::make('last_name')->sortable()->searchable(),
            'email' => TextColumn::make('email')->sortable()->searchable(),
            'is_active' => IconColumn::make('is_active')->boolean(),
            'photo' => SpatieMediaLibraryImageColumn::make('photo')->collection('profile'),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    #[\Override]
    public function getTableFilters(): array
    {
        return [
            'is_active' => TernaryFilter::make('is_active')
                ->placeholder(static::trans('filters.is_active.all'))
                ->trueLabel(static::trans('filters.is_active.active'))
                ->falseLabel(static::trans('filters.is_active.inactive'))
                ->queries(
                    true: static fn (Builder $query) => $query->where('is_active', '=', true),
                    false: static fn (Builder $query) => $query->where('is_active', '=', false),
                ),
        ];
    }
}
