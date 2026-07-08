{{-- CTA Banner Block - Theme Zero (Fallback) --}}
<section style="padding: 40px 20px; background: #1e40af; color: white; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        @if(isset($title))
            <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">
                {{ $title }}
            </h2>
        @endif

        @if(isset($description))
            <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.9; line-height: 1.5;">
                {{ $description }}
            </p>
        @endif

        <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
            @if(isset($cta_primary))
                <a href="{{ $cta_primary['url'] ?? '#' }}" 
                   style="background: white; color: #1e40af; padding: 12px 24px; border-radius: 4px; font-weight: 600; text-decoration: none; display: inline-block;">
                    {{ $cta_primary['label'] ?? 'Inizia' }}
                </a>
            @endif

            @if(isset($cta_secondary))
                <a href="{{ $cta_secondary['url'] ?? '#' }}" 
                   style="border: 2px solid white; color: white; padding: 10px 24px; border-radius: 4px; font-weight: 600; text-decoration: none; display: inline-block;">
                    {{ $cta_secondary['label'] ?? 'Scopri' }}
                </a>
            @endif
        </div>
    </div>
</section>
