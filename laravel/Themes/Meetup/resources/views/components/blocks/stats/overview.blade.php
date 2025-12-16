{{-- Stats Section - Laravel Pizza Meetups Style --}}
<section class="{{ $background_color ?? 'bg-slate-800' }} py-16 sm:py-24 border-y border-slate-700">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center mb-16">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                {{ $title ?? 'In Numbers' }}
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats ?? [] as $stat)
            <div class="text-center group">
                <p class="text-5xl font-bold text-red-500 group-hover:text-red-400 transition-colors">
                    {{ $stat['number'] ?? '0' }}
                </p>
                <p class="mt-2 text-xl font-semibold text-white">
                    {{ $stat['label'] ?? 'Label' }}
                </p>
                <p class="mt-1 text-sm text-gray-400">
                    {{ $stat['description'] ?? 'Description' }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
