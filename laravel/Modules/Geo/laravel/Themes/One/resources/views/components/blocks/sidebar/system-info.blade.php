{{-- System Info Sidebar - Theme Zero (Fallback) --}}
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
    @if(isset($title))
        <h3 style="font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
            {{ $title }}
        </h3>
    @endif

    @if(isset($info) && is_array($info))
        <dl style="margin: 0; padding: 0;">
            @foreach($info as $item)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.875rem;">
                    @if(isset($item['label']))
                        <dt style="color: #6b7280; font-weight: 500;">{{ $item['label'] }}:</dt>
                    @endif
                    @if(isset($item['value']))
                        <dd style="color: #1f2937; font-family: monospace; background: white; padding: 2px 4px; border-radius: 2px; margin: 0;">
                            @if(str_contains($item['value'], '{{') && str_contains($item['value'], '}}'))
                                {!! \Illuminate\Support\Facades\Blade::render($item['value']) !!}
                            @else
                                {{ $item['value'] }}
                            @endif
                        </dd>
                    @endif
                </div>
            @endforeach
        </dl>
    @endif

    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #d1d5db;">
        <div style="display: flex; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 0.5rem;"></div>
            Sistema Operativo
        </div>
    </div>
</div>
