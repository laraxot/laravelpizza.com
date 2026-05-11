<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Pages;

use Exception;
use Filament\Forms\Components\Field;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Enums\PaginationMode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Livewire\WithPagination;
use LogicException;
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Webmozart\Assert\Assert;

/**
 * Classe base per visualizzare lo storico delle attività di un record.
 *
 * ⚠️ IMPORTANTE: Estende XotBasePage da Resources/Pages/ (Resource Page)
 *                NON da Pages/ (Standalone Page)!
 *
 * Motivo: Questa classe è usata in getPages() delle Resources, quindi DEVE
 *         essere una Resource Page per avere il metodo route().
 *
 * @see XotBasePage
 * @see \Modules\Activity\docs\errori\route-method-does-not-exist.md
 */
abstract class ListLogActivities extends XotBasePage
{
    use CanPaginate;
    use InteractsWithFormActions;
    use InteractsWithRecord;
    use WithPagination {
        WithPagination::resetPage as resetLivewirePage;
    }

    protected string $view = 'activity::filament.pages.list-log-activities';

    protected static Collection $fieldLabelMap;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->recordsPerPage = $this->getDefaultRecordsPerPageSelectOption();
    }

    public function getBreadcrumb(): string
    {
        $breadcrumb = static::$breadcrumb ?? __('activity::activities.breadcrumb');

        // Convert to string (__() returns string|array|null)
        if (is_array($breadcrumb)) {
            return implode(' ', array_map(
                static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
                $breadcrumb
            ));
        }

        return (string) $breadcrumb;
    }

    public function getTitle(): string
    {
        // PHPStan Level 10: getRecordTitle returns string|Htmlable
        $recordTitle = $this->getRecordTitle();

        // Convert to string (handle Htmlable)
        $titleString = $recordTitle instanceof Htmlable
            ? $recordTitle->toHtml()
            : (string) $recordTitle;

        $title = __('activity::activities.title', ['record' => $titleString]);

        // __() returns string|array|null
        if (is_array($title)) {
            return implode(' ', array_map(
                static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
                $title
            ));
        }

        return (string) $title;
    }

    public function getActivities(): LengthAwarePaginator
    {
        // PHPStan Level 10: Type safety for Eloquent relations
        $record = $this->record;
        if (! $record instanceof Model) {
            throw new InvalidArgumentException('Record must be an Eloquent Model');
        }

        if (! method_exists($record, 'activities')) {
            throw new LogicException('Record must have activities relationship');
        }

        $relation = $record->activities();
        if (! $relation instanceof Relation) {
            throw new InvalidArgumentException('activities() must return a Relation');
        }

        $builderQuery = $relation
            ->with('causer')
            ->latest()
            ->getQuery();

        if (! $builderQuery instanceof Builder) {
            throw new InvalidArgumentException('Query must be an Eloquent Builder');
        }

        /** @var Builder<Activity> $builderQuery */
        $paginated = $this->paginateQuery($builderQuery);

        if (! $paginated instanceof LengthAwarePaginator) {
            throw new InvalidArgumentException('paginateQuery() with PaginationMode::Default must return LengthAwarePaginator');
        }

        return $paginated;
    }

    public function getPaginationMode(): PaginationMode
    {
        return PaginationMode::Default;
    }

    public function getFieldLabel(string $name): string
    {
        static::$fieldLabelMap ??= $this->createFieldLabelMap();

        $fieldLabel = static::$fieldLabelMap[$name] ?? $name;

        // PHPStan Level 10: Ensure string return type
        if (! \is_string($fieldLabel)) {
            return $name;
        }

        return $fieldLabel;
    }

    public function canRestoreActivity(): bool
    {
        $resource = static::getResource();
        if (! class_exists($resource) || ! method_exists($resource, 'canRestore')) {
            return false;
        }

        $canRestore = $resource::canRestore($this->record);

        return \is_bool($canRestore) ? $canRestore : false;
    }

    public function restoreActivity(int|string $key): void
    {
        if (! $this->canRestoreActivity()) {
            abort(403);
        }

        try {
            $activity = $this->resolveActivity($key);
            $oldProperties = $this->getOldProperties($activity);

            Assert::isInstanceOf($this->record, Model::class);
            app(RestoreActivityAction::class)->execute($this->record, $oldProperties);

            $this->sendRestoreSuccessNotification();
        } catch (Exception $e) {
            $this->sendRestoreFailureNotification($e->getMessage());
        }
    }

    /**
     * Create a map between field names and their labels.
     *
     * @return Collection<string, string>
     */
    protected function createFieldLabelMap(): Collection
    {
        $schema = static::getResource()::form(new Schema($this));

        // PHPStan Level 10: Type safety for schema components
        if (! $schema instanceof Schema) {
            throw new InvalidArgumentException('Form must return a Schema instance');
        }

        /** @var array<int|string, Component> $componentsArray */
        $componentsArray = $schema->getComponents();

        /** @var Collection<int, Component> $components */
        $components = collect($componentsArray);

        /** @var Collection<int, Component> $extracted */
        $extracted = collect();

        while (true) {
            /** @var Component|null $component */
            $component = $components->shift();

            if ($component === null) {
                break;
            }

            if ($component instanceof Field) {
                $extracted->push($component);

                continue;
            }

            // PHPStan Level 10: Type-safe child components
            if (method_exists($component, 'getChildComponents')) {
                $children = $component->getDefaultChildComponents();

                if (\is_array($children) && $children !== []) {
                    /** @var array<int|string, Component> $safeChildren */
                    $safeChildren = $children;
                    /** @var array<int, Component> $normalizedChildren */
                    $normalizedChildren = array_values($safeChildren);
                    $components = $components->merge($normalizedChildren);

                    continue;
                }
            }

            $extracted->push($component);
        }

        /** @var Collection<string, string> $labelMap */
        $labelMap = $extracted
            ->filter(static fn ($field): bool => $field instanceof Field)
            ->mapWithKeys(
                /** @param Field $field
                 * @return array<string, string>
                 */
                static function (Component $field): array {
                    $name = $field->getName();
                    $label = $field->getLabel();
                    $labelString = $label instanceof Htmlable ? $label->toHtml() : (string) $label;

                    return [$name => $labelString];
                }
            );

        return $labelMap;
    }

    protected function sendRestoreSuccessNotification(): Notification
    {
        $title = __('activity::activities.events.restore_successful');
        $titleString = is_array($title)
            ? implode(' ', array_map(
                static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
                $title
            ))
            : (string) $title;

        return Notification::make()
            ->title($titleString)
            ->success()
            ->send();
    }

    protected function sendRestoreFailureNotification(?string $message = null): Notification
    {
        $title = __('activity::activities.events.restore_failed');
        $titleString = is_array($title)
            ? implode(' ', array_map(
                static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
                $title
            ))
            : (string) $title;

        $notification = Notification::make()
            ->title($titleString)
            ->danger();

        if ($message !== null) {
            $notification->body($message);
        }

        return $notification->send();
    }

    private function resolveActivity(int|string $key): Activity
    {
        $record = $this->record;
        if (! $record instanceof Model) {
            throw new Exception('Invalid record');
        }

        if (! method_exists($record, 'activities')) {
            throw new LogicException('Record must have activities relationship');
        }

        $relation = $record->activities();
        if (! $relation instanceof Relation) {
            throw new Exception('Invalid activities relation');
        }

        /** @var Activity|null $activity */
        $activity = $relation->whereKey($key)->first();

        if (! $activity instanceof Activity) {
            throw new Exception('Activity not found');
        }

        return $activity;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOldProperties(Activity $activity): array
    {
        $old = data_get($activity, 'properties.old');

        if (! \is_array($old)) {
            throw new Exception('Invalid properties format in activity log');
        }

        /** @var array<string, mixed> $old */
        return $old;
    }
}
