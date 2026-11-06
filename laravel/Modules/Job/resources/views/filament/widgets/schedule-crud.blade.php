<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">{{ __('job::schedule_crud_widget.sections.tasks.title') }}</x-slot>

        <x-slot name="afterHeader">
            <x-filament::button wire:click="taskCreate" size="sm">
                {{ __('job::schedule_crud_widget.actions.create.label') }}
            </x-filament::button>
        </x-slot>

        @php($tasks = $this->getTasks())

        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left">{{ __('job::schedule_crud_widget.fields.description.label') }}</th>
                    <th class="text-left">{{ __('job::schedule_crud_widget.fields.average_runtime.label') }}</th>
                    <th class="text-left">{{ __('job::schedule_crud_widget.fields.last_run.label') }}</th>
                    <th class="text-left">{{ __('job::schedule_crud_widget.fields.next_run.label') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr class="{{ $task->is_active ? '' : 'text-danger-600' }}">
                        <td>{{ $task->description }}</td>
                        <td>{{ __('job::schedule_crud_widget.messages.runtime_seconds.message', ['seconds' => $task->average_runtime]) }}</td>
                        <td>{{ $task->last_ran_at }}</td>
                        <td>{{ $task->upcoming }}</td>
                        <td class="text-right">
                            <x-filament::icon-button
                                icon="heroicon-o-play"
                                label="{{ __('job::schedule_crud_widget.actions.run_now.label') }}"
                                wire:click="executeTask('{{ $task->id }}')"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">{{ __('job::schedule_crud_widget.messages.no_tasks.message') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $tasks->links() }}
    </x-filament::section>
</x-filament-widgets::widget>
