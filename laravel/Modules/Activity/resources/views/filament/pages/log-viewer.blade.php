<?php

declare(strict_types=1);
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Modules\Activity\Enums\LogLevelEnum;

/*
 * ponytail: stili di layout in linea (style="...") e un <style> locale al posto di classi Tailwind, perche' il pannello
 * Activity non ha un tema Vite proprio e le utility non gia' usate da Filament non verrebbero compilate.
 * Scostamento noto dalla regola Blade «no inline CSS»: via d'uscita conforme = asset CSS costruito con Vite
 * (Vite::asset('resources/css/app.css', 'assets/activity') in un FilamentAsset::register, come Chart e Geo), che richiede
 * build e deploy degli asset del modulo. Xot pubblica header-actions-wrap.css solo per il wrap delle azioni Filament: non e' un precedente per gli stili di questa pagina.
 *
 * Il testo dei log e' sempre passato da {{ }} (escape): un log puo' contenere HTML/JS arrivato da input esterni.
 */

/** @var \Modules\Activity\Filament\Pages\LogViewer $this */
$state = $this->getLogState();
// Voci molto lunghe (per esempio un log con una sola intestazione seguita da migliaia di righe JSON):
// si mostrano l'inizio E la fine, perche' le righe piu' recenti sono in fondo.
$maxBodyChars = 20000;
$headChars = 12000;
$tailChars = 8000;
$labelStyle = 'display:block;font-size:.875rem;font-weight:500;margin-bottom:.25rem;';
?>
<x-filament-panels::page>
    <style>
        .log-tree-btn { display:flex; align-items:center; gap:.375rem; width:100%; text-align:left; padding:.25rem .5rem; border:0; border-radius:.375rem; background:transparent; color:inherit; font-size:.875rem; cursor:pointer; }
        .log-tree-btn:hover { background:rgba(128,128,128,.15); }
    </style>

    <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-start;">
        <div style="flex:0 0 20rem;max-width:100%;min-width:0;">
            <x-filament::section>
                <x-slot name="heading">{{ __('activity::log_viewer.tree.heading') }}</x-slot>

                <div style="max-height:32rem;overflow:auto;">
                    @if ($state->files === [])
                        <p style="font-size:.875rem;">{{ __('activity::log_viewer.messages.no_files') }}</p>
                    @else
                        @include('activity::filament.pages.partials.log-tree-node', ['node' => $state->tree, 'expanded' => $this->expanded, 'selected' => $this->file])
                    @endif
                </div>
            </x-filament::section>
        </div>

        <div style="flex:1 1 32rem;min-width:0;display:flex;flex-direction:column;gap:1rem;">
            <x-filament::section>
                <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-end;">
                    <div style="flex:1 1 12rem;min-width:0;">
                        <label style="{{ $labelStyle }}">{{ __('activity::log_viewer.fields.window') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input.select wire:model.live="window">
                                @foreach ($state->windows as $kb)
                                    <option value="{{ $kb }}">{{ __('activity::log_viewer.window_option', ['size' => Number::fileSize($kb * 1024)]) }}</option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    </div>

                    <div style="flex:1 1 10rem;min-width:0;">
                        <label style="{{ $labelStyle }}">{{ __('activity::log_viewer.fields.level') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input.select wire:model.live="level">
                                <option value="">{{ __('activity::log_viewer.placeholders.all_levels') }}</option>
                                @foreach ($state->levels as $levelCase)
                                    <option value="{{ $levelCase->value }}">{{ $levelCase->getLabel() }}</option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    </div>

                    <div style="flex:2 1 14rem;min-width:0;">
                        <label style="{{ $labelStyle }}">{{ __('activity::log_viewer.fields.search') }}</label>
                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="search"
                                wire:model.live.debounce.500ms="search"
                                :placeholder="__('activity::log_viewer.placeholders.search')"
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>
            </x-filament::section>

    <x-filament::section>
        <p style="font-size:.8125rem;opacity:.75;margin-bottom:.75rem;">{{ __('activity::log_viewer.messages.sensitive') }}</p>

        @if ($state->error !== null)
            <p style="color:rgb(var(--danger-600, 220 38 38));">{{ $state->error }}</p>
        @elseif ($state->tail === null)
            <p>{{ __('activity::log_viewer.messages.no_file_selected') }}</p>
        @else
            <p style="font-size:.875rem;">
                {{ __('activity::log_viewer.messages.file_info', [
                    'size' => Number::fileSize($state->tail->size),
                    'date' => Carbon::createFromTimestamp((int) $state->modifiedAt)->format('d/m/Y H:i:s'),
                ]) }}
            </p>

            @if ($state->tail->truncated)
                <p style="font-size:.875rem;margin-top:.25rem;">
                    {{ __('activity::log_viewer.messages.partial_read', [
                        'read' => Number::fileSize($state->tail->bytesRead),
                        'size' => Number::fileSize($state->tail->size),
                    ]) }}
                </p>
            @endif

            @if ($state->entries === [])
                <p style="margin-top:1rem;">{{ __('activity::log_viewer.messages.no_entries') }}</p>
            @else
                <p style="font-size:.875rem;margin:.75rem 0;font-weight:500;">
                    {{ __('activity::log_viewer.messages.summary', ['shown' => count($state->entries), 'total' => $state->total]) }}
                </p>

                <div style="display:flex;flex-direction:column;gap:.5rem;">
                    @foreach ($state->entries as $entry)
                        <details style="border:1px solid rgba(128,128,128,.35);border-radius:.5rem;" @if ($state->total <= 3) open @endif>
                            <summary style="cursor:pointer;padding:.5rem .75rem;display:flex;flex-wrap:wrap;gap:.5rem;align-items:baseline;font-size:.875rem;">
                                <span style="opacity:.7;white-space:nowrap;">{{ $entry->timestamp ?? '—' }}</span>
                                @if ($entry->level !== null)
                                    <x-filament::badge :color="LogLevelEnum::tryFrom($entry->level)?->getColor() ?? 'gray'">{{ $entry->level }}</x-filament::badge>
                                @endif
                                <span style="word-break:break-word;min-width:0;flex:1 1 20rem;">{{ mb_substr($entry->message, 0, 300) }}@if (mb_strlen($entry->message) > 300)…@endif</span>
                            </summary>
                            @php
                                $bodyLength = mb_strlen($entry->body);
                                $shownBody = $bodyLength <= $maxBodyChars
                                    ? $entry->body
                                    : mb_substr($entry->body, 0, $headChars)
                                        ."\n\n".__('activity::log_viewer.messages.entry_omitted', ['count' => number_format($bodyLength - $headChars - $tailChars, 0, ',', '.')])."\n\n"
                                        .mb_substr($entry->body, -$tailChars);
                            @endphp
                            <pre style="margin:0;padding:.75rem;border-top:1px solid rgba(128,128,128,.35);font-size:.75rem;white-space:pre-wrap;word-break:break-word;overflow-x:auto;">{{ $shownBody }}</pre>
                        </details>
                    @endforeach
                </div>
            @endif
        @endif
    </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
