<?php

declare(strict_types=1);
/*
 * Un livello dell'albero dei file di log: prima le sottocartelle (ricorsivo), poi i file.
 *
 * @var \Modules\Activity\Datas\LogTreeData $node          cartella da disegnare
 * @var list<string> $expanded                               cartelle aperte
 * @var string $selected                                     percorso del file scelto
 *
 * Nessun `use` qui: il partial si include ricorsivamente e si usano nomi completi.
 * I percorsi passati a wire:click passano da Js::from(), che li rende una stringa JS sicura anche se
 * contengono apici o virgolette.
 *
 * ponytail: stili in linea, vedi il commento in log-viewer.blade.php (nessun tema Vite nel pannello Activity).
 */
$iconStyle = 'width:1.1rem;height:1.1rem;flex:none;';
?>
@foreach ($node->folders as $folder)
    @php($isOpen = in_array($folder->path, $expanded, true))
    <div wire:key="log-folder-{{ $folder->path }}">
        <button
            type="button"
            class="log-tree-btn"
            wire:click="toggleFolder({{ \Illuminate\Support\Js::from($folder->path) }})"
            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        >
            <x-filament::icon :icon="$isOpen ? 'heroicon-o-chevron-down' : 'heroicon-o-chevron-right'" style="{{ $iconStyle }}opacity:.6;" />
            <x-filament::icon :icon="$isOpen ? 'heroicon-o-folder-open' : 'heroicon-o-folder'" style="{{ $iconStyle }}" />
            <span style="min-width:0;word-break:break-all;">{{ $folder->name }}</span>
            <span style="opacity:.55;font-size:.75rem;margin-left:auto;padding-left:.5rem;">{{ $folder->count }}</span>
        </button>

        @if ($isOpen)
            <div style="margin-left:1.1rem;padding-left:.4rem;border-left:1px solid rgba(128,128,128,.3);">
                @include('activity::filament.pages.partials.log-tree-node', ['node' => $folder, 'expanded' => $expanded, 'selected' => $selected])
            </div>
        @endif
    </div>
@endforeach

@foreach ($node->files as $item)
    <button
        type="button"
        class="log-tree-btn"
        wire:key="log-file-{{ $item->path }}"
        wire:click="selectFile({{ \Illuminate\Support\Js::from($item->path) }})"
        title="{{ $item->path }}"
        @if ($selected === $item->path) aria-current="true" style="background:rgba(128,128,128,.25);font-weight:600;" @endif
    >
        <span style="{{ $iconStyle }}"></span>
        <x-filament::icon icon="heroicon-o-document-text" style="{{ $iconStyle }}" />
        <span style="min-width:0;word-break:break-all;">{{ $item->name }}</span>
        <span style="opacity:.55;font-size:.75rem;margin-left:auto;padding-left:.5rem;white-space:nowrap;">{{ \Illuminate\Support\Number::fileSize($item->size) }}</span>
    </button>
@endforeach
