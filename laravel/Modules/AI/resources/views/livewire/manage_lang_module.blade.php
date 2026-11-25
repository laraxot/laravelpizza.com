<?php

declare(strict_types=1);
?>
<div>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('xot::manage_lang_module.fields.name.label') }}</th>
                <th>{{ __('xot::manage_lang_module.fields.size.label') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->getFilenameWithoutExtension() }}</td>
                    <td>{{ $file->getSize() }}</td>
                    <td><button wire:click="edit('{{ $file->getFilenameWithoutExtension() }}')"
                            class="btn btn-primary">{{ __('xot::manage_lang_module.actions.edit.label') }}</button></td>
                </tr>
            @endforeach
        <tbody>
    </table>
    {{--  da mettere il nuovo modal
    <livewire:modal.form_array data="test" bodyView="xot::livewire.manage_lang_module.edit" />
    --}}
</div>
