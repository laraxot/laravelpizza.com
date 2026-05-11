{{--
  Scroll reveal: anima il contenuto quando entra in viewport.
  Rispetta prefers-reduced-motion (nessuna animazione se ridotta).
  Usa IntersectionObserver, nessun plugin Alpine richiesto.
  Checklist: docs/project/website-checklist.md sezione 3 Animazioni.
--}}
@props([
    'animation' => 'fade-in-up',
    'delay' => 0,
    'threshold' => 0.1,
])
@php
    $delayClass = match((int) $delay) {
        100 => 'delay-100',
        200 => 'delay-200',
        300 => 'delay-300',
        400 => 'delay-400',
        500 => 'delay-500',
        default => '',
    };
    $animClass = match($animation) {
        'fade-in' => 'animate-fade-in',
        'slide-in-right' => 'animate-slide-in-right',
        'slide-in-left' => 'animate-slide-in-left',
        'scale-in' => 'animate-scale-in',
        default => 'animate-fade-in-up',
    };
@endphp
<div
    x-data="{
        visible: false,
        reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        init() {
            if (this.reducedMotion) {
                this.visible = true;
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) this.visible = true;
                });
            }, { threshold: {{ $threshold }}, rootMargin: '0px 0px -50px 0px' });
            observer.observe(this.$el);
        }
    }"
    x-bind:class="visible ? (reducedMotion ? 'opacity-100' : '{{ $animClass }} {{ $delayClass }}') : 'opacity-0'"
    {{ $attributes->merge(['class' => 'transition-opacity duration-300']) }}
>
    {{ $slot }}
</div>
