@props([
    'title' => 'Trova l\'Articolo Perfetto',
    'subtitle' => '',
    'placeholder' => 'Cerca per argomento, normativa o parola chiave...',
    'show_advanced' => true,
    'show_suggestions' => true,
])

@php
    $searchQuery = request()->get('q', '');
@endphp

<section class="py-12 bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600 mb-8">{{ $subtitle }}</p>
            @endif
            
            {{-- Search Form --}}
            <form action="{{ request()->path() }}" method="GET" class="relative">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $searchQuery }}"
                            placeholder="{{ $placeholder }}"
                            class="w-full px-6 py-4 pl-14 text-lg border-2 border-gray-200 rounded-xl focus:border-[#1E5A96] focus:ring-4 focus:ring-[#1E5A96]/20 outline-none transition-all"
                            autocomplete="off"
                        >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor" 
                            stroke-width="2"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </div>
                    <button 
                        type="submit" 
                        class="bg-[#1E5A96] hover:bg-[#164575] text-white px-8 py-4 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl"
                    >
                        Cerca
                    </button>
                </div>
            </form>
            
            {{-- Quick Suggestions --}}
            @if($show_suggestions && empty($searchQuery))
                <div class="mt-8">
                    <p class="text-sm text-gray-500 mb-3">Ricerche popolari:</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <a href="{{ request()->path() }}?q=D.Lgs+101%2F2020" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm text-gray-700 hover:border-[#1E5A96] hover:text-[#1E5A96] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            D.Lgs 101/2020
                        </a>
                        <a href="{{ request()->path() }}?q=radioprotezione" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm text-gray-700 hover:border-[#1E5A96] hover:text-[#1E5A96] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Radioprotezione
                        </a>
                        <a href="{{ request()->path() }}?q=elettromedicali" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm text-gray-700 hover:border-[#1E5A96] hover:text-[#1E5A96] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Elettromedicali
                        </a>
                        <a href="{{ request()->path() }}?q=controlli" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm text-gray-700 hover:border-[#1E5A96] hover:text-[#1E5A96] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Controlli
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>