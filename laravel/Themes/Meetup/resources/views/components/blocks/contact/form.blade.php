{{--
/**
 * Contact Form Block - Laravel Pizza Theme
 *
 * Form di contatto con validazione.
 *
 * @var string $title Titolo della sezione
 * @var string $description Descrizione della sezione
 * @var array $form_fields Array di campi del form
 * @var string $submit_label Label del pulsante submit
 * @var string $submit_style Stile del pulsante submit
 */
--}}

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            @if(isset($title) && $title)
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $title }}
                </h2>
            @endif
            
            @if(isset($description) && $description)
                <p class="text-xl text-gray-600">
                    {{ $description }}
                </p>
            @endif
        </div>

        {{-- Contact Form --}}
        <form 
            action="{{ route('contact.submit') }}" 
            method="POST" 
            class="bg-gray-50 rounded-xl p-8 shadow-lg"
            x-data="{ 
                submitting: false,
                submitForm() {
                    this.submitting = true;
                    this.$el.submit();
                }
            }"
        >
            @csrf

            @if(isset($form_fields) && is_array($form_fields))
                <div class="space-y-6">
                    @foreach($form_fields as $field)
                        <div>
                            {{-- Label --}}
                            @if(isset($field['label']))
                                <label 
                                    for="{{ $field['name'] ?? '' }}" 
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    {{ $field['label'] }}
                                    @if(isset($field['required']) && $field['required'])
                                        <span class="text-red-600">*</span>
                                    @endif
                                </label>
                            @endif

                            {{-- Input Field --}}
                            @if(isset($field['type']))
                                @if($field['type'] === 'textarea')
                                    <textarea
                                        name="{{ $field['name'] ?? '' }}"
                                        id="{{ $field['name'] ?? '' }}"
                                        rows="{{ $field['rows'] ?? 3 }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        @if(isset($field['required']) && $field['required']) required @endif
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                    ></textarea>
                                @else
                                    <input
                                        type="{{ $field['type'] }}"
                                        name="{{ $field['name'] ?? '' }}"
                                        id="{{ $field['name'] ?? '' }}"
                                        value="{{ old($field['name'] ?? '') }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        @if(isset($field['required']) && $field['required']) required @endif
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                    >
                                @endif
                            @endif

                            {{-- Error Message --}}
                            @error($field['name'] ?? '')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Submit Button --}}
            <div class="mt-8">
                <button
                    type="submit"
                    @click.prevent="submitForm()"
                    :disabled="submitting"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span x-show="!submitting">{{ $submit_label ?? 'Send Message' }}</span>
                    <span x-show="submitting" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    </div>
</section>
