<?php

declare(strict_types=1);

?>
@props([
    'title' => 'Prenota un appuntamento',
    'id' => 'booking-form',
    'form_intro' => 'Compila il form per prenotare',
    'steps' => [],
    'submit_text' => 'Conferma',
    'privacy_text' => 'Acconsento al trattamento dei dati personali',
    'success_message' => 'Prenotazione effettuata con successo'
])

<section class="py-16 bg-white" id="{{ $id }}">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">{{ $title }}</h2>
                <p class="text-gray-600">{{ $form_intro }}</p>
            </div>

            <div
                x-data="{
                    currentStep: 0,
                    totalSteps: {{ count($steps) }},
                    formData: {},
                    formComplete: false,
                    nextStep() {
                        if (this.currentStep < this.totalSteps - 1) {
                            this.currentStep++;
                            window.scrollTo({top: document.getElementById('{{ $id }}').offsetTop, behavior: 'smooth'});
                        }
                    },
                    prevStep() {
                        if (this.currentStep > 0) {
                            this.currentStep--;
                            window.scrollTo({top: document.getElementById('{{ $id }}').offsetTop, behavior: 'smooth'});
                        }
                    },
                    submitForm() {
                        // In a real app this would submit the data to the server
                        this.formComplete = true;

                        // Dispatch a custom event that can be caught by other scripts
                        window.dispatchEvent(new CustomEvent('booking-completed', {
                            detail: { formData: this.formData }
                        }));
                    }
                }"
            >
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="overflow-hidden mb-4">
                        <div class="w-full py-1 flex items-center">
                            @foreach($steps as $index => $step)
                                <div
                                    class="flex-1 px-2 text-center flex flex-col items-center"
                                    :class="{'text-primary-600 font-semibold': currentStep >= {{ $index }}}"
                                >
                                    <div
                                        class="w-8 h-8 flex items-center justify-center rounded-full mb-2 transition-colors"
                                        :class="{'bg-primary-500 text-white': currentStep >= {{ $index }}, 'bg-gray-200': currentStep < {{ $index }}}"
                                    >
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="text-sm hidden md:block">{{ $step['title'] }}</span>
                                </div>

                                @if(!$loop->last)
                                    <div
                                        class="w-full h-1 bg-gray-200"
                                        :class="{'bg-primary-500': currentStep > {{ $index }}}"
                                    ></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div x-show="!formComplete" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form @submit.prevent="submitForm">
                        <!-- Form Steps -->
                        @foreach($steps as $index => $step)
                            <div x-show="currentStep === {{ $index }}">
                                <h3 class="text-xl font-bold mb-6">{{ $step['title'] }}</h3>

                                @foreach($step['fields'] as $field)
                                    <div class="mb-6">
                                        <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $field['label'] }}
                                            @if(isset($field['required']) && $field['required'])
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>

                                        @if($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'tel')
                                            <input
                                                type="{{ $field['type'] }}"
                                                id="{{ $field['name'] }}"
                                                name="{{ $field['name'] }}"
                                                x-model="formData.{{ $field['name'] }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                        @elseif($field['type'] === 'textarea')
                                            <textarea
                                                id="{{ $field['name'] }}"
                                                name="{{ $field['name'] }}"
                                                x-model="formData.{{ $field['name'] }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            ></textarea>
                                        @elseif($field['type'] === 'select')
                                            <select
                                                id="{{ $field['name'] }}"
                                                name="{{ $field['name'] }}"
                                                x-model="formData.{{ $field['name'] }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                                <option value="">Seleziona...</option>
                                                @foreach($field['options'] as $option)
                                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($field['type'] === 'date')
                                            <input
                                                type="date"
                                                id="{{ $field['name'] }}"
                                                name="{{ $field['name'] }}"
                                                x-model="formData.{{ $field['name'] }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                            >
                                        @elseif($field['type'] === 'time_slots')
                                            <div class="grid grid-cols-3 gap-2">
                                                <template x-for="time in ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']">
                                                    <label class="border border-gray-200 rounded p-2 cursor-pointer hover:bg-gray-50" :class="{'bg-primary-50 border-primary-500': formData.{{ $field['name'] }} === time}">
                                                        <input
                                                            type="radio"
                                                            name="{{ $field['name'] }}"
                                                            :value="time"
                                                            x-model="formData.{{ $field['name'] }}"
                                                            class="sr-only"
                                                            {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                                                        >
                                                        <span x-text="time" class="block text-center"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- Form Navigation -->
                        <div class="flex justify-between items-center">
                            <button
                                type="button"
                                @click="prevStep"
                                x-show="currentStep > 0"
                                class="px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                            >
                                Indietro
                            </button>

                            <div class="ml-auto">
                                <button
                                    type="button"
                                    @click="nextStep"
                                    x-show="currentStep < totalSteps - 1"
                                    class="px-6 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors"
                                >
                                    Continua
                                </button>

                                <div x-show="currentStep === totalSteps - 1">
                                    <label class="flex items-center mb-4">
                                        <input type="checkbox" name="privacy" required class="mr-2">
                                        <span class="text-sm text-gray-600">{{ $privacy_text }}</span>
                                    </label>

                                    <button
                                        type="submit"
                                        class="w-full px-6 py-3 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors"
                                    >
                                        {{ $submit_text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Success Message -->
                <div
                    x-show="formComplete"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="bg-green-50 border border-green-200 rounded-lg p-6 text-center"
                >
                    <div class="flex justify-center mb-4">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-green-800 mb-2">Prenotazione completata!</h3>
                    <p class="text-green-700">{{ $success_message }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    // Example listener for booking completed event
    window.addEventListener('booking-completed', (event) => {
        console.log('Booking completed:', event.detail.formData);
        // Redirect after a short delay to allow the user to see the success message
        setTimeout(() => {
            // window.location.href = '/thank-you';
        }, 3000);
    });
</script>
@endpush
