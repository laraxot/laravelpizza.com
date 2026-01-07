<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Support;

use Carbon\Carbon;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

/**
 * Builder for common Filament table columns.
 *
 * Provides pre-configured column definitions to reduce boilerplate.
 * Implements the strategy documented in METODI_DUPLICATI_ANALISI.md
 *
 * Usage:
 * ```php
 * public static function getTableColumns(): array
 * {
 *     return array_merge(
 *         ColumnBuilder::timestamps(),
 *         [
 *             'name' => ColumnBuilder::name(),
 *             'email' => ColumnBuilder::email(),
 *         ]
 *     );
 * }
 * ```
 *
 * @see docs/METODI_DUPLICATI_ANALISI.md - Proposta 2: Column/Filter Builders
 */
class ColumnBuilder
{
    /**
     * Standard ID column (sortable, searchable).
     *
     * Found in 77 resources (25% identical pattern).
     */
    public static function id(): TextColumn
    {
        return TextColumn::make('id')
            ->label(__('xot::fields.id.label'))
            ->sortable()
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * Standard name column (sortable, searchable).
     *
     * Found in 77 resources (common pattern).
     */
    public static function name(): TextColumn
    {
        return TextColumn::make('name')
            ->label(__('xot::fields.name.label'))
            ->sortable()
            ->searchable()
            ->toggleable();
    }

    /**
     * Standard title column (sortable, searchable).
     */
    public static function title(): TextColumn
    {
        return TextColumn::make('title')
            ->label(__('xot::fields.title.label'))
            ->sortable()
            ->searchable()
            ->limit(50)
            ->tooltip(static fn ($record) => \is_object($record) && isset($record->title) ? (string) $record->title : '')
            ->toggleable();
    }

    /**
     * Standard slug column (sortable, searchable, copyable).
     */
    public static function slug(): TextColumn
    {
        return TextColumn::make('slug')
            ->label(__('xot::fields.slug.label'))
            ->sortable()
            ->searchable()
            ->copyable()
            ->toggleable();
    }

    /**
     * Standard email column (sortable, searchable, copyable).
     */
    public static function email(): TextColumn
    {
        return TextColumn::make('email')
            ->label(__('xot::fields.email.label'))
            ->sortable()
            ->searchable()
            ->copyable()
            ->icon('heroicon-o-envelope')
            ->toggleable();
    }

    /**
     * Standard description column (limit, tooltip).
     */
    public static function description(int $limit = 50): TextColumn
    {
        return TextColumn::make('description')
            ->label(__('xot::fields.description.label'))
            ->limit($limit)
            ->tooltip(static fn ($record) => \is_object($record) && isset($record->description) ? (string) $record->description : '')
            ->toggleable();
    }

    /**
     * Standard status column with badge.
     */
    public static function status(): TextColumn
    {
        return TextColumn::make('status')
            ->label(__('xot::fields.status.label'))
            ->badge()
            ->color(static fn (string $state): string => match ($state) {
                'published' => 'success',
                'draft' => 'warning',
                'archived' => 'danger',
                default => 'gray',
            })
            ->sortable()
            ->toggleable();
    }

    /**
     * Standard created_at column (date-time, sortable).
     *
     * Found in 77 resources (85% identical pattern).
     */
    public static function createdAt(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label(__('xot::fields.created_at.label'))
            ->dateTime()
            ->sortable()
            ->toggleable();
    }

    /**
     * Standard updated_at column (date-time, sortable).
     *
     * Found in 77 resources (85% identical pattern).
     */
    public static function updatedAt(): TextColumn
    {
        return TextColumn::make('updated_at')
            ->label(__('xot::fields.updated_at.label'))
            ->dateTime()
            ->sortable()
            ->since()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * Standard deleted_at column (date-time, sortable).
     *
     * For models using SoftDeletes.
     */
    public static function deletedAt(): TextColumn
    {
        return TextColumn::make('deleted_at')
            ->label(__('xot::fields.deleted_at.label'))
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * Standard published_at column (date-time, sortable).
     */
    public static function publishedAt(): TextColumn
    {
        return TextColumn::make('published_at')
            ->label(__('xot::fields.published_at.label'))
            ->dateTime()
            ->sortable()
            ->badge()
            ->color(static function ($record) {
                if (! \is_object($record) || ! isset($record->published_at)) {
                    return 'warning';
                }

                $publishedAt = $record->published_at;

                if ($publishedAt instanceof Carbon && $publishedAt->isPast()) {
                    return 'success';
                }

                return 'warning';
            })
            ->toggleable();
    }

    /**
     * Standard is_active boolean column (sortable).
     */
    public static function isActive(): BooleanColumn
    {
        return BooleanColumn::make('is_active')
            ->label(__('xot::fields.is_active.label'))
            ->sortable()
            ->toggleable();
    }

    /**
     * Standard avatar/image column.
     */
    public static function avatar(string $field = 'avatar'): ImageColumn
    {
        return ImageColumn::make($field)
            ->label(__('xot::fields.'.$field.'.label'))
            ->circular()
            ->defaultImageUrl(url('/images/default-avatar.png'))
            ->toggleable();
    }

    /**
     * Standard image column.
     */
    public static function image(string $field = 'image'): ImageColumn
    {
        return ImageColumn::make($field)
            ->label(__('xot::fields.'.$field.'.label'))
            ->square()
            ->toggleable();
    }

    /**
     * Created by column (with user relationship).
     */
    public static function createdBy(): TextColumn
    {
        return TextColumn::make('creator.name')
            ->label(__('xot::fields.created_by.label'))
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * Updated by column (with user relationship).
     */
    public static function updatedBy(): TextColumn
    {
        return TextColumn::make('updater.name')
            ->label(__('xot::fields.updated_by.label'))
            ->sortable()
            ->since()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    /**
     * Get all timestamp columns (created_at, updated_at).
     *
     * Found in 85% of resources - EXACT same pattern.
     *
     * @return array<string, TextColumn>
     */
    public static function timestamps(): array
    {
        return [
            'created_at' => self::createdAt(),
            'updated_at' => self::updatedAt(),
        ];
    }

    /**
     * Get common audit columns (created_at, updated_at, created_by, updated_by).
     *
     * For models using Updater trait.
     *
     * @return array<string, TextColumn>
     */
    public static function auditColumns(): array
    {
        return [
            'created_at' => self::createdAt(),
            'updated_at' => self::updatedAt(),
            'created_by' => self::createdBy(),
            'updated_by' => self::updatedBy(),
        ];
    }

    /**
     * Get soft delete columns (deleted_at, created_at, updated_at).
     *
     * For models using SoftDeletes trait.
     *
     * @return array<string, TextColumn>
     */
    public static function softDeleteColumns(): array
    {
        return [
            'created_at' => self::createdAt(),
            'updated_at' => self::updatedAt(),
            'deleted_at' => self::deletedAt(),
        ];
    }
}
