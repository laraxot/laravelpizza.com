@props([
    'number' => 1,
    'title' => '',
])

<div 
    x-show="currentStep === {{ $number }}"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-4"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform -translate-x-4"
    class="stepper-pane"
    role="tabpanel"
    :aria-labelledby="'step-{{ $number }}-tab'"
    :id="'step-{{ $number }}-panel'"
    {{ $attributes->merge(['class' => '']) }}
>
    @if($title)
        <h2 class="stepper-pane-title">{{ $title }}</h2>
    @endif
    
    <div class="stepper-pane-content">
        {{ $slot }}
    </div>
</div>

<style>
.stepper-pane-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #17324d;
}

.stepper-pane-content {
    padding: 1rem 0;
}

@media (prefers-color-scheme: dark) {
    .stepper-pane-title {
        color: #f0f4f8;
    }
}
</style>
