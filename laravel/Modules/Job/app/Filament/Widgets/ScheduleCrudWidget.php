<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Widgets;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Modules\Job\Actions\ExecuteTaskAction;
use Modules\Job\Models\Task;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Symfony\Component\Console\Command\Command;
use Webmozart\Assert\Assert;

/**
 * Gemello Filament del ritirato Http\Livewire\Schedule\Crud.
 *
 * Elenco Task paginato + azione "esegui ora", stesso contratto del
 * componente Livewire originale (tag <livewire:schedule.crud />).
 */
class ScheduleCrudWidget extends XotBaseWidget
{
    /** @var view-string */
    protected string $view = 'job::filament.widgets.schedule-crud';

    protected int|string|array $columnSpan = 'full';

    /**
     * @return LengthAwarePaginator<int, Task>
     */
    public function getTasks(): LengthAwarePaginator
    {
        return Task::query()->paginate(20);
    }

    /**
     * @return array<string, mixed>
     */
    public static function getFrequencies(): array
    {
        $res = config('totem.frequencies');
        if (is_array($res)) {
            $frequencies = [];
            foreach ($res as $key => $value) {
                if (! is_string($key)) {
                    continue;
                }
                $frequencies[$key] = $value;
            }

            return $frequencies;
        }

        throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
    }

    /**
     * Collezione di comandi Artisan disponibili per la creazione di una task.
     *
     * @return Collection<string, Command>
     */
    public function getCommands(): Collection
    {
        /** @var Collection<string, Command> $all_commands */
        $all_commands = collect(Artisan::all());

        return $all_commands->sortBy(
            static function (Command $command): string {
                Assert::string($name = $command->getName());

                if (mb_strpos($name, ':') === false) {
                    return ':'.$name;
                }

                return $name;
            },
        );
    }

    public function taskCreate(): void
    {
        // Nota: nessun listener ascolta 'modal.schedule.create' — gap gia'
        // presente nel componente Livewire originale (Schedule\Crud),
        // non introdotto da questa conversione. Vedi story 12.1.
        $this->dispatch('modal.open', 'modal.schedule.create');
    }

    public function executeTask(string $task_id): void
    {
        app(ExecuteTaskAction::class)->execute($task_id);

        session()->flash('message', 'task ['.$task_id.'] executed at '.now());
    }
}
