<div class="bg-gray-50 rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        {{ $title ?? 'Informazioni Sistema' }}
    </h3>
    <dl class="space-y-3">
        @foreach($info ?? [] as $item)
        <div class="flex justify-between text-sm">
            <dt class="font-medium text-gray-600">{{ $item['label'] ?? 'Label' }}</dt>
            <dd class="text-gray-900">
                @if(str_contains($item['value'] ?? '', '{{'))
                    @php
                        $value = $item['value'] ?? '';
                        // Evaluate simple Blade expressions
                        if (str_contains($value, "app()->version()")) {
                            echo app()->version();
                        } elseif (str_contains($value, "app()->environment()")) {
                            echo app()->environment();
                        } elseif (str_contains($value, "app()->getLocale()")) {
                            echo app()->getLocale();
                        } else {
                            echo strip_tags($value);
                        }
                    @endphp
                @else
                    {{ $item['value'] ?? 'Value' }}
                @endif
            </dd>
        </div>
        @endforeach
    </dl>
</div>
