<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <x-heroicon-o-building-storefront class="h-8 w-8 text-blue-600" />
                    <span class="ml-2 text-xl font-bold text-gray-900">Laravel Pizza Meetups</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    @foreach($items as $item)
                        <a href="{{ $item['url'] }}"
                           class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition duration-150 ease-in-out">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open main menu</span>
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                </button>
            </div>
        </div>
    </div>
</nav>