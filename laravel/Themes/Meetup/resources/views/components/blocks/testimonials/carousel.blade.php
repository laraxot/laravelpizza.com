{{--
/**
 * Testimonials Carousel Block - Theme Sixteen
 *
 * Carosello di testimonianze clienti.
 *
 * @var string $title Titolo della sezione
 * @var array $testimonials Array di testimonianze
 */
--}}

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Title --}}
        @if(isset($title) && $title)
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $title }}
                </h2>
            </div>
        @endif

        {{-- Testimonials Grid --}}
        @if(isset($testimonials) && is_array($testimonials))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-gray-50 rounded-xl p-8 relative">
                        {{-- Quote Icon --}}
                        <div class="absolute top-6 right-6 text-blue-200">
                            <x-heroicon-o-chat-bubble-left-ellipsis class="w-8 h-8" />
                        </div>

                        {{-- Rating --}}
                        @if(isset($testimonial['rating']))
                            <div class="flex mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-heroicon-s-star class="w-5 h-5 {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" />
                                @endfor
                            </div>
                        @endif

                        {{-- Content --}}
                        @if(isset($testimonial['content']))
                            <blockquote class="text-gray-700 mb-6 italic leading-relaxed">
                                "{{ $testimonial['content'] }}"
                            </blockquote>
                        @endif

                        {{-- Author Info --}}
                        <div class="flex items-center">
                            @if(isset($testimonial['avatar']))
                                <img 
                                    src="{{ $testimonial['avatar'] }}" 
                                    alt="{{ $testimonial['author'] ?? 'Cliente' }}"
                                    class="w-12 h-12 rounded-full mr-4 object-cover"
                                >
                            @else
                                <div class="w-12 h-12 bg-blue-600 rounded-full mr-4 flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">
                                        {{ substr($testimonial['author'] ?? 'C', 0, 1) }}
                                    </span>
                                </div>
                            @endif

                            <div>
                                @if(isset($testimonial['author']))
                                    <div class="font-semibold text-gray-900">
                                        {{ $testimonial['author'] }}
                                    </div>
                                @endif
                                
                                @if(isset($testimonial['role']) || isset($testimonial['company']))
                                    <div class="text-sm text-gray-600">
                                        @if(isset($testimonial['role']))
                                            {{ $testimonial['role'] }}
                                        @endif
                                        @if(isset($testimonial['role']) && isset($testimonial['company']))
                                            {{ ' - ' }}
                                        @endif
                                        @if(isset($testimonial['company']))
                                            {{ $testimonial['company'] }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
