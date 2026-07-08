{{-- Hero Section Block - Theme Zero (Fallback) --}}
<section style="background: linear-gradient(135deg, #1e293b 0%, #475569 100%); color: white; padding: 60px 20px; text-align: center;">
    @if(isset($title))
        <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem; line-height: 1.2;">
            {{ $title }}
        </h1>
    @endif

    @if(isset($subtitle))
        <h2 style="font-size: 1.25rem; margin-bottom: 1rem; opacity: 0.9;">
            {{ $subtitle }}
        </h2>
    @endif

    @if(isset($description))
        <p style="font-size: 1.1rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            {{ $description }}
        </p>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
        @if(isset($cta_primary))
            <a href="{{ $cta_primary['url'] ?? '#' }}" 
               style="background: white; color: #1e293b; padding: 12px 24px; border-radius: 4px; font-weight: 600; text-decoration: none; display: inline-block;">
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
</section>
