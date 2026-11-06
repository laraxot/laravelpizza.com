<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Builders;

use Carbon\Carbon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Column Builder for common Filament table columns.
 *
 * Provides standardized column definitions to reduce code duplication
 * across List pages in all modules.
 *
 * Usage:
 * ```php
 * public function getTableColumns(): array
 * {
 *     return [
 *         ColumnBuilder::id(),
 *         ColumnBuilder::name(),
 *         ...ColumnBuilder::timestamps(),
 *     ];
 * }
 * ```
 */
class ColumnBuilder
{
    /**
     * Standard ID column.
     */
    public static function id(bool $sortable = true, bool $searchable = true): TextColumn
    {
        return IDColumn::make('id')
            ->sortable($sortable)
            ->searchable($searchable)
            ->label('ID');
    }

    /**
     * Standard name column.
     */
    public static function name(bool $searchable = true, bool $sortable = true, bool $wrap = false): TextColumn
    {
        $column = TextColumn::make('name')
            ->searchable($searchable)
            ->sortable($sortable)
            ->label(__('xot::fields.name.label'))
            ->toggleable();

        if ($wrap) {
            $column->wrap();
        }

        return $column;
    }

    /**
     * Standard title column.
     */
    public static function title(bool $searchable = true, bool $sortable = true, bool $wrap = true): TextColumn
    {
        $column = TextColumn::make('title')
            ->searchable($searchable)
            ->sortable($sortable)
            ->label(__('xot::fields.title.label'))
            ->limit(50)
            ->tooltip(static fn (mixed $record): string => \is_object($record) && isset($record->title) ? SafeStringCastAction::cast($record->title) : '')
            ->toggleable();

        if ($wrap) {
            $column->wrap();
        }

        return $column;
    }

    /**
     * Standard email column with copyable.
     */
    public static function email(bool $searchable = true, bool $sortable = true): TextColumn
    {
        return TextColumn::make('email')
            ->searchable($searchable)
            ->sortable($sortable)
            ->copyable()
            ->label(__('xot::fields.email.label'))
            ->icon('heroicon-o-envelope')
            ->toggleable();
    }

    /**
     * Standard description column.
     */
    public static function description(int $limit = 50, bool $searchable = true): TextColumn
    {
        return TextColumn::make('description')
            ->limit($limit)
            ->searchable($searchable)
            ->wrap()
            ->label(__('xot::fields.description.label'))
            ->tooltip(static fn (mixed $record): string => \is_object($record) && isset($record->description) ? SafeStringCastAction::cast($record->description) : '')
            ->toggleable();
    }

    /**
     * Status badge column with standard colors.
     *
     * @param  array<string, string>  $customColors  Custom color mappings
     */
    public static function statusBadge(array $customColors = []): TextColumn
    {
        $defaultColors = [
            'danger' => 'open',
            'warning' => 'in_progress',
            'success' => 'resolved',
            'secondary' => 'closed',
        ];

        return TextColumn::make('status')
            ->badge()
            ->colors(array_merge($defaultColors, $customColors));
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
     * Priority badge column.
     *
     * @param  array<string, string>  $customColors  Custom color mappings
     */
    public static function priorityBadge(array $customColors = []): TextColumn
    {
        $defaultColors = [
            'secondary' => 'low',
            'primary' => 'medium',
            'warning' => 'high',
            'danger' => 'critical',
        ];

        return TextColumn::make('priority')
            ->badge()
            ->colors(array_merge($defaultColors, $customColors));
    }

    /**
     * Boolean icon column.
     */
    public static function booleanIcon(string $column = 'is_active', bool $sortable = true): IconColumn
    {
        return IconColumn::make($column)
            ->boolean()
            ->sortable($sortable);
    }

    /**
     * Active/Inactive icon column.
     */
    public static function isActive(bool $sortable = true): IconColumn
    {
        return self::booleanIcon('is_active', $sortable)
            ->label(__('xot::fields.is_active.label'))
            ->toggleable();
    }

    /**
     * Published icon column.
     */
    public static function isPublished(bool $sortable = true): IconColumn
    {
        return self::booleanIcon('is_published', $sortable);
    }

    /**
     * Featured icon column.
     */
    public static function isFeatured(bool $sortable = true): IconColumn
    {
        return self::booleanIcon('is_featured', $sortable);
    }

    /**
     * Created at timestamp column.
     */
    public static function createdAt(bool $sortable = true, bool $dateTime = true): TextColumn
    {
        $column = TextColumn::make('created_at')
            ->sortable($sortable);

        if ($dateTime) {
            $column->dateTime();
        } else {
            $column->date();
        }

        return $column;
    }

    /**
     * Updated at timestamp column (toggleable by default).
     */
    public static function updatedAt(
        bool $sortable = true,
        bool $dateTime = true,
        bool $toggleable = true,
        bool $hiddenByDefault = true,
    ): TextColumn {
        $column = TextColumn::make('updated_at')
            ->sortable($sortable);

        if ($dateTime) {
            $column->dateTime();
        } else {
            $column->date();
        }

        if ($toggleable) {
            $column->toggleable(isToggledHiddenByDefault: $hiddenByDefault);
        }

        return $column
            ->label(__('xot::fields.updated_at.label'))
            ->since();
    }

    /**
     * Published at timestamp column.
     */
    public static function publishedAt(bool $sortable = true, bool $dateTime = true): TextColumn
    {
        $column = TextColumn::make('published_at')
            ->sortable($sortable);

        if ($dateTime) {
            $column->dateTime();
        } else {
            $column->date();
        }

        return $column
            ->label(__('xot::fields.published_at.label'))
            ->badge()
            ->color(static function (mixed $record): string {
                if (! \is_object($record) || ! isset($record->published_at)) {
                    return 'warning';
                }

                return $record->published_at instanceof Carbon && $record->published_at->isPast()
                    ? 'success'
                    : 'warning';
            })
            ->toggleable();
    }

    /**
     * Standard timestamps (created_at, updated_at).
     *
     * @return array<string, TextColumn>
     */
    public static function timestamps(bool $hideUpdated = true): array
    {
        return [
            'created_at' => self::createdAt(),
            'updated_at' => self::updatedAt(hiddenByDefault: $hideUpdated),
        ];
    }

    /**
     * Slug column.
     */
    public static function slug(bool $searchable = true, bool $sortable = true): TextColumn
    {
        return TextColumn::make('slug')
            ->searchable($searchable)
            ->sortable($sortable)
            ->copyable()
            ->label(__('xot::fields.slug.label'))
            ->toggleable();
    }

    /**
     * UUID column.
     */
    public static function uuid(bool $searchable = true, bool $copyable = true): TextColumn
    {
        $column = TextColumn::make('uuid')
            ->searchable($searchable);

        if ($copyable) {
            $column->copyable();
        }

        return $column;
    }

    /**
     * Count column (for relationships).
     */
    public static function count(string $relationship, bool $sortable = true): TextColumn
    {
        return TextColumn::make($relationship.'_count')
            ->counts($relationship)
            ->sortable($sortable);
    }

    /**
     * User/Author column.
     */
    public static function user(string $column = 'user', bool $searchable = true): TextColumn
    {
        return TextColumn::make($column.'.name')
            ->searchable($searchable)
            ->sortable();
    }

    /**
     * Owner column.
     */
    public static function owner(bool $searchable = true): TextColumn
    {
        return self::user('owner', $searchable);
    }

    /**
     * Creator column (audit).
     */
    public static function creator(bool $searchable = true): TextColumn
    {
        return self::user('creator', $searchable);
    }

    /**
     * Updater column (audit).
     */
    public static function updater(bool $searchable = true, bool $toggleable = true): TextColumn
    {
        $column = self::user('updater', $searchable);

        if ($toggleable) {
            $column->toggleable(isToggledHiddenByDefault: true);
        }

        return $column;
    }

    /**
     * Standard deleted_at column.
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
     * Get common audit columns.
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
     * Get soft delete columns.
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
