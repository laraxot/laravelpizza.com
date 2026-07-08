{{-- Links Grid Block - Theme Zero --}}
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

        @if(isset($links) && is_array($links))
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                @foreach($links as $link)
                    <a href="{{ $link['url'] ?? '#' }}"
                       style="display: block; padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; transition: all 0.3s ease; background: white; color: #1f2937;"
                       onmouseover="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)';"
                       onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        @if(isset($link['title']))
                            <h3 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">
                                {{ $link['title'] }}
                            </h3>
                        @endif

                        @if(isset($link['description']))
                            <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">
                                {{ $link['description'] }}
                            </p>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
