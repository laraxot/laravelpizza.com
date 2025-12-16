<?php

declare(strict_types=1);

?>
<div>
    {{-- <x-filament::section></x-filament::section>
    <x-filament::section>
        <x-slot name="title">Job Status</x-slot>
        <x-slot name="txt">
            <pre>{!! $out !!}</pre>

            <x-filament::input type="select" name="conn" :options="['sync' => 'sync', 'database' => 'database']" wire.model.lazy="form_data.conn" />

        </x-slot>
        <x-slot name="footer">
            <button class="btn btn-secondary" wire:click="dummyAction()">1000 Dummy Action</button>
            @foreach ($acts as $act)
                <button class="btn btn-primary" wire:click="artisan('{{ $act->name }}')">{{ $act->name }}
                </button>
            @endforeach
        </x-slot>
    </x-filament::section> --}}

    <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
        @if (session()->has('message'))
            <div role="alert">
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                  <p>{{ session()->get('message') }}</p>
                </div>
            </div>
        @endif
    </div>



    <div class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Job Status</h5>

        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            <pre>{!! $out !!}</pre>
        </p>

        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">conn</x-filament-forms::field-wrapper.label>
        <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        wire.model.lazy="form_data.conn">
            <option selected>Choose a country</option>
            <option value="sync">sync</option>
            <option value="database">database</option>
        </select>
    </div>

    <div class="max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
        wire:click="dummyAction()">
            1000 Dummy Action
        </button>
        @foreach ($acts as $act)
            <button class="btn btn-primarybg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
            wire:click="artisan('{{ $act->name }}')">
                {{ $act->name }}
            </button>
        @endforeach
    </div>
</div>
