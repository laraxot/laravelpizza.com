<div>
    <svg class="icon icon-primary" wire:click="update()">
        @if ($fav)
            <use xlink:href="{{ Theme::asset('pub_theme::dist/svg/sprite.svg') }}#it-star-full">
            @else
                <use xlink:href="{{ Theme::asset('pub_theme::dist/svg/sprite.svg') }}#it-star-outline">
        @endif
    </svg>
</div>
