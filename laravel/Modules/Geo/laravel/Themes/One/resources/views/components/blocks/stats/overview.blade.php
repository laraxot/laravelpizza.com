{{-- Stats Overview Block - Theme Zero (Fallback) --}}
<section style="padding: 40px 20px; background: #f9fafb;">
    <div style="max-width: 1000px; margin: 0 auto;">
        @if(isset($title))
            <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 2rem; color: #1f2937;">
                {{ $title }}
            </h2>
        @endif

        @if(isset($stats) && is_array($stats))
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
                @foreach($stats as $stat)
                    <div>
                        @if(isset($stat['number']))
                            <div style="font-size: 2.5rem; font-weight: bold; color: #3b82f6; margin-bottom: 0.5rem;">
                                {{ $stat['number'] }}
                            </div>
                        @endif
                        @if(isset($stat['label']))
                            <div style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem;">
                                {{ $stat['label'] }}
                            </div>
                        @endif
                        @if(isset($stat['description']))
                            <div style="font-size: 0.875rem; color: #6b7280;">
                                {{ $stat['description'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
