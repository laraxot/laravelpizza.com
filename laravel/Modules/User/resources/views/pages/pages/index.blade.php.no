<?php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\render;

render(function (View $view) {
    // Recuperiamo la locale corrente
    $locale = app()->getLocale();

    // Verifichiamo se esiste la colonna category nel modello Page
    $hasCategory = \Schema::hasColumn('pages', 'category');

    // Recupero le pagine con paginazione (12 per pagina)
    $pages = Page::when(request()->has('q'), function($query) {
        return $query->where('title', 'like', '%' . request()->get('q') . '%');
    });

    // Applichiamo il filtro per categoria solo se la colonna esiste
    if ($hasCategory) {
        $pages = $pages->when(request()->has('category'), function($query) {
            return $query->where('category', request()->get('category'));
        });
    }

    $pages = $pages->orderBy('created_at', 'desc')
        ->paginate(12)
        ->withQueryString();

    // Recuperiamo le categorie solo se la colonna esiste
    $categories = collect();
    if ($hasCategory) {
        $categories = Page::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');
    }

    return $view->with([
        'pages' => $pages,
        'categories' => $categories,
        'hasCategory' => $hasCategory,
        'locale' => $locale,
    ]);
});
?>

<x-layouts.marketing>
    <div class="max-w-[calc(100%-30px)] sm:max-w-[calc(100%-80px)] lg:max-w-[996px] mx-auto pb-12 font-roboto">
        <nav class="flex py-3 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/{{ $locale }}" class="inline-flex items-center hover:text-primary-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 font-medium text-gray-500 md:ml-2">Pagine</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="py-6 sm:py-10">
            <h1 class="text-[2rem] mb-4 font-roboto font-semibold text-neutral-5">
                Archivio Pagine
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Esplora tutte le pagine informative disponibili in il progetto
            </p>

            <div class="flex flex-col md:flex-row justify-between gap-4 mb-8">
                <!-- Barra di ricerca -->
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <form method="GET" action="{{ url()->current() }}" class="flex">
                        <div class="relative w-full">
                            <input
                                type="search"
                                name="q"
                                value="{{ request()->get('q') }}"
                                placeholder="Cerca pagine..."
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                            <button type="submit" class="absolute right-3 top-2.5">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filtri categoria (solo se disponibili) -->
                @if($hasCategory && $categories->count() > 0)
                <div class="w-full md:w-1/2 lg:w-1/3 md:ml-auto">
                    <form method="GET" action="{{ url()->current() }}" id="categoryForm">
                        <select
                            name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            onchange="document.getElementById('categoryForm').submit();"
                        >
                            <option value="">Tutte le categorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @if(request()->get('category') === $category) selected @endif>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endif
            </div>
        </div>

        @if(request()->has('q') || (request()->has('category') && $hasCategory))
        <div class="mb-6 flex items-center gap-2">
            <div class="text-sm text-gray-600">
                Filtri attivi:
            </div>
            <div class="flex flex-wrap gap-2">
                @if(request()->has('q'))
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except('q')) }}" class="inline-flex items-center text-xs bg-primary-100 text-primary-700 rounded-full px-3 py-1">
                    Ricerca: {{ request()->get('q') }}
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                @endif

                @if(request()->has('category') && $hasCategory)
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except('category')) }}" class="inline-flex items-center text-xs bg-primary-100 text-primary-700 rounded-full px-3 py-1">
                    Categoria: {{ ucfirst(request()->get('category')) }}
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
                @endif

                <a href="{{ url()->current() }}" class="text-xs text-primary-600 hover:underline">
                    Rimuovi tutti i filtri
                </a>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pages as $page)
                <a
                    href="{{ url('/' . $locale . '/pages/' . $page->slug) }}"
                    class="group flex flex-col h-full overflow-hidden bg-white rounded-lg shadow hover:shadow-md transition duration-300"
                >
                    @if(isset($page->featured_image) && $page->featured_image)
                    <div class="aspect-video overflow-hidden">
                        <img
                            src="{{ $page->featured_image }}"
                            alt="{{ $page->title }}"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300"
                        >
                    </div>
                    @endif

                    <div class="p-6 flex flex-col flex-grow">
                        @if($hasCategory && isset($page->category) && $page->category)
                        <span class="text-xs text-primary-600 font-medium mb-2">{{ ucfirst($page->category) }}</span>
                        @endif

                        <h2 class="text-xl font-semibold mb-3 text-neutral-5 group-hover:text-primary-600 transition-colors">
                            {{ $page->title }}
                        </h2>

                        @if(isset($page->excerpt) && $page->excerpt)
                        <p class="text-sm text-gray-600 mb-4 flex-grow">
                            {{ Str::limit($page->excerpt, 100) }}
                        </p>
                        @endif

                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ $page->created_at->format('d/m/Y') }}
                            </span>
                            <span class="inline-flex items-center text-sm text-primary-600 font-medium group-hover:translate-x-1 transition-transform duration-200">
                                Leggi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full p-10 bg-gray-50 rounded-lg text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-gray-600 mb-4 font-medium text-lg">Nessuna pagina disponibile.</p>

                    @if(request()->has('q') || (request()->has('category') && $hasCategory))
                        <p class="text-sm text-gray-500 mb-4">Prova a modificare i tuoi filtri di ricerca.</p>
                        <a href="{{ url()->current() }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300">
                            Mostra tutte le pagine
                        </a>
                    @else
                        <p class="text-sm text-gray-500">Le pagine verranno aggiunte presto.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Paginazione -->
        @if($pages->hasPages())
            <div class="mt-10 flex justify-center">
                <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
                    @if($pages->onFirstPage())
                        <span class="px-3 py-1 text-sm border rounded opacity-50 cursor-not-allowed">
                            &laquo; Precedente
                        </span>
                    @else
                        <a href="{{ $pages->previousPageUrl() }}" class="px-3 py-1 text-sm border rounded hover:bg-gray-50 transition">
                            &laquo; Precedente
                        </a>
                    @endif

                    <div class="flex items-center gap-1 mx-2">
                        @for($i = 1; $i <= $pages->lastPage(); $i++)
                            @if($i == $pages->currentPage())
                                <span class="px-3 py-1 text-sm border rounded bg-primary-600 text-white">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="{{ $pages->url($i) }}" class="px-3 py-1 text-sm border rounded hover:bg-gray-50 transition">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                    </div>

                    @if($pages->hasMorePages())
                        <a href="{{ $pages->nextPageUrl() }}" class="px-3 py-1 text-sm border rounded hover:bg-gray-50 transition">
                            Successiva &raquo;
                        </a>
                    @else
                        <span class="px-3 py-1 text-sm border rounded opacity-50 cursor-not-allowed">
                            Successiva &raquo;
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</x-layouts.marketing>
