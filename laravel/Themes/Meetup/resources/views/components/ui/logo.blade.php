{{--
/**
 * Logo Laravel Pizza — single source: meetup-logo (Modules/Meetup/resources/svg/logo.svg).
 * NO SVG inline: vedi .cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc
 */
--}}

<div class="relative {{ $class ?? '' }}">
    <x-filament::icon
        icon="meetup-logo"
        class="h-20 w-20 text-red-500 group-hover:rotate-6 transition-transform duration-300"
    />
    @if($withShadow ?? true)
        <div class="absolute -bottom-2 left-0 right-0 h-3 bg-black/10 dark:bg-black/30 blur-md transform scale-95 group-hover:scale-100 transition-transform duration-300"></div>
    @endif
</div>
