@props([
    'title' => 'Esplora per Tag',
    'subtitle' => '',
    'style' => 'cloud',
    'max_tags' => 20,
    'show_count' => true,
    'tags' => [],
])

@php
    $tagColors = [
        'blue' => 'bg-blue-100 text-blue-700 hover:bg-blue-200',
        'green' => 'bg-green-100 text-green-700 hover:bg-green-200',
        'orange' => 'bg-orange-100 text-orange-700 hover:bg-orange-200',
        'purple' => 'bg-purple-100 text-purple-700 hover:bg-purple-200',
        'teal' => 'bg-teal-100 text-teal-700 hover:bg-teal-200',
        'red' => 'bg-red-100 text-red-700 hover:bg-red-200',
        'indigo' => 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200',
        'pink' => 'bg-pink-100 text-pink-700 hover:bg-pink-200',
        'gray' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
        'yellow' => 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200',
        'cyan' => 'bg-cyan-100 text-cyan-700 hover:bg-cyan-200',
        'emerald' => 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200',
        'lime' => 'bg-lime-100 text-lime-700 hover:bg-lime-200',
        'amber' => 'bg-amber-100 text-amber-700 hover:bg-amber-200',
        'rose' => 'bg-rose-100 text-rose-700 hover:bg-rose-200',
    ];
@endphp

<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="text-lg text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
        
        <div class="flex flex-wrap justify-center gap-3">
            @foreach(array_slice($tags, 0, $max_tags) as $tag)
                @php
                    $color = $tagColors[$tag['color']] ?? $tagColors['blue'];
                @endphp
                <a 
                    href="{{ request()->path() }}?tag={{ urlencode($tag['name']) }}" 
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $color }} transition-all"
                >
                    <span>{{ $tag['name'] }}</span>
                    @if($show_count)
                        <span class="ml-2 opacity-75">{{ $tag['count'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>