{{-- Features Grid Block - Theme Zero (Fallback) --}}
<section style="padding: 40px 20px; background: white;">
    <div style="max-width: 1000px; margin: 0 auto;">
        @if(isset($title))
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 1rem; color: #1f2937;">
                {{ $title }}
            </h2>
        @endif
        
        @if(isset($description))
            <p style="font-size: 1.1rem; text-align: center; color: #6b7280; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                {{ $description }}
            </p>
        @endif

        @if(isset($features) && is_array($features))
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                @foreach($features as $feature)
                    <div style="text-align: center; padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                        @if(isset($feature['title']))
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 0.75rem;">
                                {{ $feature['title'] }}
                            </h3>
                        @endif

                        @if(isset($feature['description']))
                            <p style="color: #6b7280; margin-bottom: 1rem; line-height: 1.5;">
                                {{ $feature['description'] }}
                            </p>
                        @endif

                        @if(isset($feature['url']))
                            <a href="{{ $feature['url'] }}" 
                               style="color: #3b82f6; text-decoration: none; font-weight: 500;">
                                Scopri di più →
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
