<x-filament::widget>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('seo::generate_sitemap_widget.sections.main.title') }}</h3>
        <p class="text-xs text-gray-600 dark:text-gray-300 mb-3">{!! __('seo::generate_sitemap_widget.messages.description.message', ['file' => '<code>sitemap.xml</code>']) !!}</p>
        {{ $this->getActions() }}
    </div>
</x-filament::widget>