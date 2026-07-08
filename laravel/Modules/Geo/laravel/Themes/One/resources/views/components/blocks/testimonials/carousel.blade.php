{{-- Testimonials Block - Theme Zero (Fallback) --}}
<section style="padding: 40px 20px; background: white;">
    <div style="max-width: 1000px; margin: 0 auto;">
        @if(isset($title))
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 2rem; color: #1f2937;">
                {{ $title }}
            </h2>
        @endif

        @if(isset($testimonials) && is_array($testimonials))
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                @foreach($testimonials as $testimonial)
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid #e5e7eb;">
                        @if(isset($testimonial['rating']))
                            <div style="margin-bottom: 1rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $testimonial['rating'] ? '#fbbf24' : '#d1d5db' }}; font-size: 1.2rem;">★</span>
                                @endfor
                            </div>
                        @endif

                        @if(isset($testimonial['content']))
                            <p style="color: #374151; margin-bottom: 1rem; font-style: italic; line-height: 1.5;">
                                "{{ $testimonial['content'] }}"
                            </p>
                        @endif

                        @if(isset($testimonial['author']))
                            <div style="font-weight: 600; color: #1f2937;">{{ $testimonial['author'] }}</div>
                        @endif
                        
                        @if(isset($testimonial['role']) || isset($testimonial['company']))
                            <div style="font-size: 0.875rem; color: #6b7280;">
                                {{ $testimonial['role'] ?? '' }}{{ isset($testimonial['role']) && isset($testimonial['company']) ? ' - ' : '' }}{{ $testimonial['company'] ?? '' }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
