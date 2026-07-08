@if ($showIcon)
    <div class="flex items-center space-x-2">
        <div class="flex-shrink-0">
            @if ($animate)
                <div class="animate-pulse">
                    <span class="text-lg">{{ $icon }}</span>
                </div>
            @else
                <span class="text-lg">{{ $icon }}</span>
            @endif
        </div>
        <div class="flex-1">
            <div class="{{ $bgColor }} rounded-lg px-3 py-2 border-l-4 
                @if ($status === 'loading') border-blue-400 dark:border-blue-500
                @elseif ($status === 'validating') border-yellow-400 dark:border-yellow-500
                @elseif ($status === 'completed') border-green-400 dark:border-green-500
                @elseif ($status === 'error') border-red-400 dark:border-red-500
                @else border-gray-400 dark:border-gray-500
                @endif">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium {{ $textColor }}">
                        {{ $step }}
                    </span>
                    @if ($animate)
                        <div class="flex space-x-1">
                            <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 0ms;"></div>
                            <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 150ms;"></div>
                            <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 300ms;"></div>
                        </div>
                    @endif
                </div>
                <div class="text-xs {{ $textColor }} opacity-80 mt-1">
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="{{ $bgColor }} rounded-lg px-3 py-2 border-l-4
        @if ($status === 'loading') border-blue-400 dark:border-blue-500
        @elseif ($status === 'validating') border-yellow-400 dark:border-yellow-500
        @elseif ($status === 'completed') border-green-400 dark:border-green-500
        @elseif ($status === 'error') border-red-400 dark:border-red-500
        @else border-gray-400 dark:border-gray-500
        @endif">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium {{ $textColor }}">
                {{ $step }}
            </span>
            @if ($animate)
                <div class="flex space-x-1">
                    <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 0ms;"></div>
                    <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 150ms;"></div>
                    <div class="w-1 h-1 {{ $textColor }} rounded-full animate-bounce" style="animation-delay: 300ms;"></div>
                </div>
            @endif
        </div>
        <div class="text-xs {{ $textColor }} opacity-80 mt-1">
            {{ $message }}
        </div>
    </div>
@endif