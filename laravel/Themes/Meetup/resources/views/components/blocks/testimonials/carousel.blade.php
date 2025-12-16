<section class="py-16 sm:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ $title ?? 'Testimonianze' }}
            </h2>
        </div>
        <div class="mt-16 space-y-8">
            @foreach($testimonials ?? [] as $testimonial)
            <div class="mx-auto max-w-3xl">
                <figure class="rounded-2xl bg-gray-50 p-8 shadow-sm">
                    <blockquote class="text-lg leading-8 text-gray-900">
                        <p>"{{ $testimonial['content'] ?? 'Contenuto testimonianza' }}"</p>
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-x-4">
                        @if(isset($testimonial['avatar']))
                        <img
                            class="h-12 w-12 rounded-full bg-gray-200"
                            src="{{ $testimonial['avatar'] }}"
                            alt="{{ $testimonial['author'] ?? 'Avatar' }}"
                        >
                        @else
                        <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ substr($testimonial['author'] ?? 'U', 0, 1) }}
                        </div>
                        @endif
                        <div>
                            <div class="font-semibold text-gray-900">{{ $testimonial['author'] ?? 'Nome Autore' }}</div>
                            <div class="text-sm text-gray-600">
                                {{ $testimonial['role'] ?? 'Ruolo' }}{{ isset($testimonial['company']) ? ' - ' . $testimonial['company'] : '' }}
                            </div>
                        </div>
                        @if(isset($testimonial['rating']))
                        <div class="ml-auto flex gap-x-1 text-yellow-400">
                            @for($i = 0; $i < ($testimonial['rating'] ?? 5); $i++)
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        @endif
                    </figcaption>
                </figure>
            </div>
            @endforeach
        </div>
    </div>
</section>
