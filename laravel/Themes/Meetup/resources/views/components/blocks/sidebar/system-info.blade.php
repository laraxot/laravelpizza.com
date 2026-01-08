{{--
/**
 * System Info Sidebar Block - Theme Sixteen
 *
 * Informazioni di sistema nella sidebar.
 *
 * @var string $title Titolo della sezione
 * @var array $info Array di informazioni di sistema
 */
--}}

<div class="bg-gray-50 rounded-lg p-6 mb-6">
    {{-- Title --}}
    @if(isset($title) && $title)
        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-300">
            {{ $title }}
        </h3>
    @endif

    {{-- System Info List --}}
    @if(isset($info) && is_array($info))
        <dl class="space-y-3">
            @foreach($info as $item)
                <div class="flex justify-between items-center">
                    {{-- Label --}}
                    @if(isset($item['label']))
                        <dt class="text-sm font-medium text-gray-600">
                            {{ $item['label'] }}:
                        </dt>
                    @endif

                    {{-- Value --}}
                    @if(isset($item['value']))
                        <dd class="text-sm text-gray-900 font-mono bg-white px-2 py-1 rounded">
                            @if(str_contains($item['value'], '{{') && str_contains($item['value'], '}}'))
                                {{-- Renderizza espressioni Blade --}}
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

    {{-- System Status Indicator --}}
    <div class="mt-4 pt-4 border-t border-gray-300">
        <div class="flex items-center text-sm">
            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
            <span class="text-gray-600">Sistema Operativo</span>
        </div>
    </div>
</div>
