@php
    use \Illuminate\Support\Js;
@endphp
<x-filament-panels::page>
    <div class="space-y-6">
        @foreach(// @var mixed getActivities(

            @php
                /* @var \Spatie\Activitylog\Models\Activity $activityItem */
                $changes = $activityItem->getChangesAttribute();
                
            @endphp

            <div @class([
                'p-2 space-y-2 bg-white rounded-xl shadow',
                'dark:border-gray-600 dark:bg-gray-800',
            ])>
                <div class="p-2">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-4">
                            @if ($activityItem->causer)
                                <x-filament-panels::avatar.user :user="$activityItem->causer" class="!w-7 !h-7"/>
                            @endif
                            <div class="flex flex-col text-start">
                                <span class="font-bold">{{ $activityItem->causer?->name }}</span>
                                <span class="text-xs text-gray-500">
                                    @if($activityItem->event != null)
                                    {{ __('activity::activities.events.' . $activityItem->event) }} 
                                    @endif
                                    {{ $activityItem->created_at->format(__('activity::activities.default_datetime_format')) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col text-xs text-gray-500 justify-end">
                            @if (// @var mixed canRestoreActivity(
                                <x-filament::button
                                    tag="button"
                                    icon="heroicon-o-arrow-path-rounded-square"
                                    labeled-from="sm"
                                    color="gray"
                                    class="right"
                                    wire:click="restoreActivity({{ Js::from($activityItem->getKey()) }})"
                                >
                                    @lang('activity::activities.table.restore')
                                </x-filament::button>
                            @endif
                        </div>
                    </div>

                    {{-- Description Field (CRITICAL!) --}}
                    @if ($activityItem->description)
                        <div class="mt-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-start gap-2">
                                <x-filament::icon icon="heroicon-o-information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                                <p class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                    {{ $activityItem->description }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Metadata Badges --}}
                    <div class="flex flex-wrap gap-2 px-4 mt-3">
                        @if ($activityItem->log_name)
                            <x-filament::badge color="gray" icon="heroicon-o-tag" size="sm">
                                {{ $activityItem->log_name }}
                            </x-filament::badge>
                        @endif

                        @if ($activityItem->subject_type)
                            <x-filament::badge color="info" icon="heroicon-o-cube" size="sm">
                                {{ class_basename($activityItem->subject_type) }}
                            </x-filament::badge>
                        @endif

                        @if ($activityItem->batch_uuid)
                            <x-filament::badge color="warning" icon="heroicon-o-queue-list" size="sm">
                                Batch: {{ Str::limit($activityItem->batch_uuid, 8, '...') }}
                            </x-filament::badge>
                        @endif
                    </div>
                </div>

                @if ($changes->isNotEmpty())
                    <div class="px-4 pb-4">
                        <table class="fi-ta-table w-full overflow-hidden text-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="fi-ta-header-cell px-4 py-3 text-left">
                                        <div class="flex items-center gap-2">
                                            <x-filament::icon icon="heroicon-o-pencil-square" class="w-4 h-4" />
                                            <span>{{ __('activity::activities.table.field') }}</span>
                                        </div>
                                    </th>
                                    <th class="fi-ta-header-cell px-4 py-3 text-left">
                                        <div class="flex items-center gap-2">
                                            <x-filament::icon icon="heroicon-o-arrow-left" class="w-4 h-4" />
                                            <span>{{ __('activity::activities.table.old') }}</span>
                                        </div>
                                    </th>
                                    <th class="fi-ta-header-cell px-4 py-3 text-left">
                                        <div class="flex items-center gap-2">
                                            <x-filament::icon icon="heroicon-o-arrow-right" class="w-4 h-4" />
                                            <span>{{ __('activity::activities.table.new') }}</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                        <tbody>
                            @foreach (data_get($changes, 'attributes', []) as $field => $change)
                                @php
                                    $oldValue = isset($changes['old'][$field]) ? $changes['old'][$field] : '';
                                    $newValue = isset($changes['attributes'][$field]) ? $changes['attributes'][$field] : '';
                                @endphp
                            <tr
                                @class([
                                    'fi-ta-row',
                                    'bg-gray-100/30' => $loop->even
                                ])
                            >
                                <td class="fi-ta-cell px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6" width="20%">
                                    {{ // @var mixed getFieldLabel($field
                                </td>
                                <td width="40%" class="fi-ta-cell px-4 py-3 align-top break-all whitespace-normal">
                                    @if($oldValue === '' || $oldValue === null)
                                        <span class="text-xs italic text-gray-400 dark:text-gray-600">—</span>
                                    @elseif(is_array($oldValue))
                                        <pre class="text-xs text-gray-600 dark:text-gray-400 p-2 bg-gray-50 dark:bg-gray-900 rounded">{{ json_encode($oldValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @elseif(is_bool($oldValue))
                                        <x-filament::badge :color="$oldValue ? 'success' : 'danger'" size="sm">
                                            {{ $oldValue ? 'true' : 'false' }}
                                        </x-filament::badge>
                                    @else
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $oldValue }}</span>
                                    @endif
                                </td>
                                <td width="40%" class="fi-ta-cell px-4 py-3 align-top break-all whitespace-normal">
                                    @if($newValue === '' || $newValue === null)
                                        <span class="text-xs italic text-gray-400 dark:text-gray-600">—</span>
                                    @elseif(is_bool($newValue))
                                        <x-filament::badge :color="$newValue ? 'success' : 'danger'" size="sm">
                                            {{ $newValue ? 'true' : 'false' }}
                                        </x-filament::badge>
                                    @elseif(is_array($newValue))
                                        <pre class="text-xs text-gray-600 dark:text-gray-400 p-2 bg-gray-50 dark:bg-gray-900 rounded">{{ json_encode($newValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $newValue }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach

        <x-filament::pagination
            currentPageOptionProperty="recordsPerPage"
            :page-options="// @var mixed getRecordsPerPageSelectOptions(
            :paginator="// @var mixed getActivities(
        />
    </div>
</x-filament-panels::page>