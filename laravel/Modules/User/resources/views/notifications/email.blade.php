<?php

declare(strict_types=1);

?>
@props([
    'level' => 'success',
])
<x-mail::message>
    {{-- Greeting --}}
    @if (!empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level === 'error')
            # @lang('Whoops!')
        @else
            # @lang('Hello!')
        @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
        {{ $line }}
    @endforeach

    {{-- Action Button --}}
    @isset($actionText)
        <?php

        // @phpstan-ignore variable.undefined
        $color = match ($level) {
            'success', 'error' => $level,
            default => 'primary',
        };
        ?>
        <x-mail::button :url="$actionUrl" :color="$color">
            {{ $actionText }}
        </x-mail::button>
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
        {{ $line }}
    @endforeach

    {{-- Salutation --}}
    @if (!empty($salutation))
        {{ $salutation }}
    @else
        @lang('Regards'),<br>
        {{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
        <x-slot:subcopy>
            @lang('user::email.trouble_clicking_button', [
                'actionText' => $actionText,
                'action_text' => $actionText,
            ]) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
        </x-slot:subcopy>
    @endisset
</x-mail::message>
