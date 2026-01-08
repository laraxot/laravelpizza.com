{{--
/**
 * Stats Overview Block - Laravel Pizza Theme
 *
 * Sezione statistiche con numeri e metriche.
 *
 * @var string $title Titolo della sezione
 * @var string $background_color Colore di sfondo
 * @var array $stats Array di statistiche
 */
--}}

<section class="py-16 {{ $background_color ?? 'bg-slate-900' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Title --}}
        @if(isset($title) && $title)
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    {{ $title }}
                </h2>
            </div>
        @endif

        {{-- Stats Grid --}}
        @if(isset($stats) && is_array($stats))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center group">
                        {{-- Number --}}
                        @if(isset($stat['number']))
                            <div class="text-4xl md:text-5xl font-bold text-red-500 mb-2 group-hover:text-red-400 transition-colors">
                                {{ $stat['number'] }}
                            </div>
                        @endif

                        {{-- Label --}}
                        @if(isset($stat['label']))
                            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-red-400 transition-colors">
                                {{ $stat['label'] }}
                            </h3>
                        @endif

                        {{-- Description --}}
                        @if(isset($stat['description']))
                            <p class="text-slate-400 group-hover:text-slate-300 transition-colors">
                                {{ $stat['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
