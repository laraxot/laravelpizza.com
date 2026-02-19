<x-filament::widget>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
            {{ __('seo::social_share.widget_title') }}
        </h3>
        <x-seo::social-share :data="$data" />
    </div>
</x-filament::widget>
