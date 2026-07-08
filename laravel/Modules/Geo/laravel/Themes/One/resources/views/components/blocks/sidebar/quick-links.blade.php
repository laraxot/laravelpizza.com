{{-- Quick Links Sidebar - Theme Zero (Fallback) --}}
<div style="background: white; border: 1px solid #e5e7eb; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
    @if(isset($title))
        <h3 style="font-weight: 600; color: #1f2937; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;">
            {{ $title }}
        </h3>
    @endif

    @if(isset($links) && is_array($links))
        <ul style="list-style: none; margin: 0; padding: 0;">
            @foreach($links as $link)
                <li style="margin-bottom: 0.5rem;">
                    <a href="{{ $link['url'] ?? '#' }}" 
                       style="display: block; padding: 0.5rem; color: #374151; text-decoration: none; border-radius: 4px; transition: background-color 0.2s;"
                       onmouseover="this.style.backgroundColor='#f3f4f6'"
                       onmouseout="this.style.backgroundColor='transparent'">
                        {{ $link['label'] ?? 'Link' }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
