<?php

declare(strict_types=1);

?>
<div>
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h4 class="uk-card-title uk-margin-remove">Tasks</h4>
        {!! Form::open([
            'id' => 'totem__search__form',
            'url' => Request::fullUrl(),
            'method' => 'GET',
            'class' => 'uk-display-inline uk-search uk-search-default',
        ]) !!}
        <span uk-search-icon></span>
        {!! Form::text('q', request('q'), ['class' => 'uk-search-input', 'placeholder' => 'Search...']) !!}
        {!! Form::close() !!}
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th name="description" />
                <th name="average_runtime" />
                <th name="last_ran_at" />
                <th>Next Run</th>
                <th class="uk-text-center"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks  as $task)
                <tr class="{{ $task->is_active ? '' : 'uk-text-danger' }}">
                    <td>
                        {{ $task->description }}
                    </td>
                    <td>
                        {{ $task->average_runtime }} seconds
                    </td>
                    <td>
                        {{-- $task->last_result --}}
                        {{ $task->last_ran_at }}
                    </td>
                    <td>
                        {{ $task->upcoming }}
                    </td>
                    <td class="uk-text-center@m">
                        {{--
                    <execute-button
                        :data-task="task"
                        :url="executeHref"
                        v-on:taskExecuted="refreshTask"
                        icon-name="play"
                        button-class="uk-button-link"
                    />
                    --}}
                        <x-filament::button wire:click="executeTask('{{ $task-> }}')">
                            <i class="fa-solid fa-play"></i>
                        </x-filament::button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="uk-text-center" colspan="5">
                        <p>No Tasks Found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="uk-flex uk-flex-between">
        <span>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: plus"
                href="{{-- route('totem.task.create') --}}"></a>

            <x-filament::button wire:click="taskCreate">New Task</x-filament::button>
        </span>
        -
        <span>
            <import-button url="{{-- route('totem.tasks.import') --}}"></import-button>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: cloud-download"
                href="{{-- route('totem.tasks.export') --}}"></a>
            <a class="uk-button uk-button-primary uk-button-small uk-visible@m" href="{{-- route('totem.tasks.export') --}}">Export</a>
        </span>
    </div>
    {{--
{{ $tasks->links('totem::partials.pagination', ['params' => '&' . http_build_query(array_filter(request()->except('page')))]) }}
--}}

</div>
