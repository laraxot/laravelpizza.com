<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Testimonianze',
    'testimonials' => []
])

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-6">{{ $title }}</h2>
        </div>

        <div
            class="relative max-w-4xl mx-auto"
            x-data="{
                activeSlide: 0,
                slides: {{ count($testimonials) }},
                autoplay: 5000,
                init() {
                    if (this.autoplay) {
                        setInterval(() => { this.nextSlide() }, this.autoplay);
                    }
                },
                nextSlide() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides;
                },
                prevSlide() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides;
                }
            }"
        >
            <!-- Testimonials -->
            <div class="relative py-10">
                @foreach($testimonials as $index => $testimonial)
                    <div
                        x-show="activeSlide === {{ $index }}"
                        x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                        class="p-6 bg-white rounded-xl shadow-lg"
                    >
                        <div class="flex flex-col items-center md:flex-row md:items-start">
                            @if(isset($testimonial['image']))
                                <div class="w-24 h-24 mb-4 md:mb-0 md:mr-6 flex-shrink-0">
                                    <img
                                        class="w-full h-full object-cover rounded-full"
                                        src="{{ $testimonial['image'] }}"
                                        alt="{{ $testimonial['author'] }}"
                                    >
                                </div>
                            @endif

                            <div>
                                <div class="text-gray-600 mb-4">
                                    <svg class="w-8 h-8 text-primary-400 mb-4" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                    </svg>
                                    <p class="text-lg">{{ $testimonial['quote'] }}</p>
                                </div>

                                <div>
                                    <p class="font-bold text-lg">{{ $testimonial['author'] }}</p>
                                    @if(isset($testimonial['role']))
                                        <p class="text-gray-500">{{ $testimonial['role'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <div class="flex justify-center mt-8 space-x-3">
                <button
                    @click="prevSlide"
                    class="p-2 rounded-full bg-white shadow hover:bg-gray-100"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <div class="flex space-x-2">
                    @foreach($testimonials as $index => $testimonial)
                        <button
                            @click="activeSlide = {{ $index }}"
                            :class="{'bg-primary-500': activeSlide === {{ $index }}, 'bg-gray-300': activeSlide !== {{ $index }}}"
                            class="w-3 h-3 rounded-full"
                        ></button>
                    @endforeach
                </div>

                <button
                    @click="nextSlide"
                    class="p-2 rounded-full bg-white shadow hover:bg-gray-100"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
