{{--
/**
 * Stats Overview Block - Theme Sixteen
 *
 * Sezione statistiche con numeri e metriche.
 *
 * @var string $title Titolo della sezione
 * @var string $background_color Colore di sfondo
 * @var array $stats Array di statistiche
 */
--}}

<section class="py-16 {{ $background_color ?? 'bg-gray-50' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Title --}}
        @if(isset($title) && $title)
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $title }}
                </h2>
            </div>
        @endif

        {{-- Stats Grid --}}
        @if(isset($stats) && is_array($stats))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center">
                        {{-- Number --}}
                        @if(isset($stat['number']))
                            <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">
                                {{ $stat['number'] }}
                            </div>
                        @endif

                        {{-- Label --}}
                        @if(isset($stat['label']))
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $stat['label'] }}
                            </h3>
                        @endif

                        {{-- Description --}}
                        @if(isset($stat['description']))
                            <p class="text-gray-600">
                                {{ $stat['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
