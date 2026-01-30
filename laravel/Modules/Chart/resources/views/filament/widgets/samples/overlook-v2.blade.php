<x-filament-widgets::widget id="overlook-widget" @class(['hidden' => ! $data])>
    <div class="grid gap-6 grid-cols-{{ $grid['default'] ?? 1 }} {{ isset($grid['sm']) ? 'sm:grid-cols-' . $grid['sm'] : '' }} {{ isset($grid['md']) ? 'md:grid-cols-' . $grid['md'] : '' }} {{ isset($grid['lg']) ? 'lg:grid-cols-' . $grid['lg'] : '' }} {{ isset($grid['xl']) ? 'xl:grid-cols-' . $grid['xl'] : '' }}">
        @foreach ($data as $resource)
            <div>
                <a
                    href="{{ $resource['url'] }}"
                    @if ($this->shouldShowTooltips($resource['raw_count']))
                        x-data x-tooltip="'{{ $resource['raw_count'] }}'"
                    @endif
                >
                    <x-filament::section class="relative overflow-hidden overlook-card bg-gradient-to-tr group">
                        <div class="relative z-10">
                            <div class="text-center overlook-name ">{{ $resource['name'] }}</div>
                            {{-- <div class="absolute text-3xl font-bold leading-none text-gray-600 overlook-count dark:text-gray-300 bottom-3 right-4">{{ $resource['count'] }}</div> --}}
                            <div class="grid items-center sm:gap-6 sm:grid-cols-2">
                                <div class="py-4">
                                    <h3 class="text-lg font-bold">2,318,589</h3>
                                    <div class="flex items-center space-x-1 text-gray-400">
                                        <x-heroicon-o-eye class="size-4" />
                                        <span class="text-sm">Post views</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between text-gray-400">
                                        <div class="flex items-center space-x-1">
                                            <x-heroicon-o-chat-bubble-left class="size-4" />
                                            <h4 class="text-gray-700 dark:text-white">412</h4>
                                        </div>
                                        <span class="text-sm">SMS</span>
                                    </div>
                                    <div class="flex items-center justify-between text-gray-400">
                                        <div class="flex items-center space-x-1">
                                            <x-heroicon-o-envelope class="size-4" />
                                            <h4 class="text-gray-700 dark:text-white">1,241</h4>
                                        </div>
                                        <span class="text-sm">Email</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($resource['icon'])
                            <x-filament::icon
                                :icon="$resource['icon']"
                                class="absolute w-auto transition left-2 text-primary-500 h-36 z-1 overlook-icon -bottom-12 opacity-10 dark:opacity-10 group-hover:scale-110 group-hover:-rotate-12 group-hover:opacity-30"
                            />
                        @endif
                    </x-filament::section>
                </a>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>