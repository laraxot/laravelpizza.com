<?php

declare(strict_types=1);

?>
<x-filament::page>
    @php
        // Ensure $results is defined with a default value
        $results = $results ?? null;
    @endphp
    
    @if ($results)
        <div
            class="p-4 rounded-lg border mb-4 
    @if ($results['status'] === 'success') bg-success-50 border-success-200 @endif
    @if ($results['status'] === 'error') bg-danger-50 border-danger-200 @endif">
            <h3 class="font-bold mb-2">{{ $results['message'] }}</h3>

            @if (isset($results['details']))
                <div class="space-y-1">
                    @foreach ($results['details'] as $key => $value)
                        <div class="grid grid-cols-3">
                            <span class="text-gray-600">{{ $key }}:</span>
                            <span class="col-span-2">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <div class="p-4 text-gray-500 text-center">
            {{ __('ui::aws_test.no_results') }}
        </div>
    @endif
</x-filament::page>
