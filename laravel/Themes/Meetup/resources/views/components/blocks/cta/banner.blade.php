{{-- CTA Section --}}
<section id="community" class="py-20 bg-gradient-to-r from-red-600 to-red-700">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">{{ $title ?? 'Ready to Join?' }}</h2>
            <p class="text-xl text-red-100 mb-10">
                {{ $description ?? 'Connect with Laravel developers in your area. Share knowledge, make friends, and enjoy great pizza together.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(isset($cta_primary))
                    <a href="{{ $cta_primary['url'] ?? '#' }}" class="bg-white text-red-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg transition-colors">
                        {{ $cta_primary['label'] ?? 'Create Free Account' }}
                    </a>
                @endif
                @if(isset($cta_secondary))
                    <a href="{{ $cta_secondary['url'] ?? '#' }}" class="border-2 border-white text-white hover:bg-white/10 px-8 py-4 rounded-lg font-semibold text-lg transition-colors">
                        {{ $cta_secondary['label'] ?? 'Browse Events' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>