@props([
    'currentStep' => 1,
    'totalSteps' => 4,
    'steps' => [],
])

@php
$stepTitles = $steps ?: [
    1 => __('ui::stepper.step_1'),
    2 => __('ui::stepper.step_2'),
    3 => __('ui::stepper.step_3'),
    4 => __('ui::stepper.step_4'),
];
@endphp

<div 
    x-data="{
        currentStep: @js($currentStep),
        totalSteps: @js($totalSteps),
        canGoNext() {
            return this.currentStep < this.totalSteps;
        },
        canGoPrev() {
            return this.currentStep > 1;
        },
        goToStep(step) {
            if (step >= 1 && step <= this.totalSteps) {
                this.currentStep = step;
                this.$dispatch('step-changed', { step: step });
            }
        },
        next() {
            if (this.canGoNext()) {
                this.currentStep++;
                this.$dispatch('step-next', { step: this.currentStep });
            }
        },
        prev() {
            if (this.canGoPrev()) {
                this.currentStep--;
                this.$dispatch('step-prev', { step: this.currentStep });
            }
        }
    }"
    class="it-stepper"
    role="group"
    aria-label="{{ __('ui::stepper.aria_label') }}"
    {{ $attributes->merge(['class' => '']) }}
>
    {{-- Progress Header --}}
    <div class="stepper-header" role="tablist">
        <ul class="stepper-header-group">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <li 
                    class="stepper-step"
                    :class="{
                        'active': currentStep === {{ $i }},
                        'completed': currentStep > {{ $i }},
                        'disabled': currentStep < {{ $i }}
                    }"
                    role="tab"
                    :aria-selected="currentStep === {{ $i }}"
                    :aria-current="currentStep === {{ $i }} ? 'step' : null"
                    :tabindex="currentStep === {{ $i }} ? 0 : -1"
                >
                    <button 
                        type="button"
                        class="stepper-number"
                        @click="goToStep({{ $i }})"
                        :disabled="currentStep < {{ $i }}"
                        :aria-label="'{{ __('ui::stepper.step') }} ' + {{ $i }} + ': ' + '{{ $stepTitles[$i] ?? "Step $i" }}'"
                    >
                        <span class="step-dot">
                            <span x-show="currentStep > {{ $i }}" class="sr-only">
                                {{ __('ui::stepper.completed') }}
                            </span>
                            <svg x-show="currentStep > {{ $i }}" class="icon icon-sm" aria-hidden="true">
                                <use href="#it-check"></use>
                            </svg>
                            <span x-show="currentStep <= {{ $i }}">{{ $i }}</span>
                        </span>
                        <span class="step-label">{{ $stepTitles[$i] ?? "Step $i" }}</span>
                    </button>
                </li>
            @endfor
        </ul>
        
        {{-- Progress Bar --}}
        <div class="stepper-progress" role="progressbar" :aria-valuenow="currentStep" aria-valuemin="1" :aria-valuemax="totalSteps">
            <div class="stepper-progress-bar" :style="'width: ' + ((currentStep - 1) / (totalSteps - 1) * 100) + '%'"></div>
        </div>
    </div>

    {{-- Step Content --}}
    <div class="stepper-content">
        {{ $slot }}
    </div>

    {{-- Navigation Buttons --}}
    <nav class="stepper-nav" aria-label="{{ __('ui::stepper.navigation') }}">
        <button 
            type="button" 
            class="btn btn-outline-primary"
            @click="prev"
            x-show="canGoPrev()"
            :disabled="!canGoPrev()"
        >
            <svg class="icon icon-primary icon-sm" aria-hidden="true">
                <use href="#it-chevron-left"></use>
            </svg>
            <span>{{ __('ui::stepper.previous') }}</span>
        </button>
        
        <button 
            type="button" 
            class="btn btn-primary ms-auto"
            @click="next"
            x-show="canGoNext()"
            :disabled="!canGoNext()"
        >
            <span>{{ __('ui::stepper.next') }}</span>
            <svg class="icon icon-white icon-sm" aria-hidden="true">
                <use href="#it-chevron-right"></use>
            </svg>
        </button>
        
        <button 
            type="submit" 
            class="btn btn-success ms-auto"
            x-show="!canGoNext()"
        >
            <span>{{ __('ui::stepper.confirm') }}</span>
            <svg class="icon icon-white icon-sm" aria-hidden="true">
                <use href="#it-check"></use>
            </svg>
        </button>
    </nav>
</div>

<style>
.it-stepper {
    --stepper-primary: #0066cc;
    --stepper-success: #008758;
    --stepper-gray: #5b6f82;
    --stepper-light-gray: #e3e7eb;
}

.stepper-header {
    position: relative;
    margin-bottom: 2rem;
}

.stepper-header-group {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    list-style: none;
    padding: 0;
    margin: 0 0 1rem 0;
    position: relative;
    z-index: 1;
}

.stepper-step {
    flex: 1;
    text-align: center;
    position: relative;
}

.stepper-number {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0;
    color: var(--stepper-gray);
    transition: all 0.3s ease;
}

.stepper-number:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.step-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--stepper-light-gray);
    color: var(--stepper-gray);
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.stepper-step.active .step-dot {
    background-color: var(--stepper-primary);
    color: white;
    box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.2);
}

.stepper-step.completed .step-dot {
    background-color: var(--stepper-success);
    color: white;
}

.step-label {
    font-size: 0.875rem;
    font-weight: 600;
}

.stepper-step.active .step-label {
    color: var(--stepper-primary);
}

.stepper-step.completed .step-label {
    color: var(--stepper-success);
}

.stepper-progress {
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 4px;
    background-color: var(--stepper-light-gray);
    z-index: 0;
    border-radius: 2px;
}

.stepper-progress-bar {
    height: 100%;
    background-color: var(--stepper-primary);
    transition: width 0.3s ease;
    border-radius: 2px;
}

.stepper-content {
    min-height: 300px;
    margin-bottom: 2rem;
}

.stepper-nav {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--stepper-light-gray);
}

/* Responsive */
@media (max-width: 768px) {
    .step-label {
        font-size: 0.75rem;
    }
    
    .step-dot {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }
    
    .stepper-header-group {
        gap: 0;
    }
}

@media (max-width: 576px) {
    .step-label {
        display: none;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .it-stepper {
        --stepper-gray: #a0aec0;
        --stepper-light-gray: #2d3748;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .step-dot {
        border: 2px solid currentColor;
    }
    
    .stepper-step.active .step-dot {
        border-color: var(--stepper-primary);
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .step-dot,
    .stepper-number,
    .stepper-progress-bar {
        transition: none;
    }
}
</style>
