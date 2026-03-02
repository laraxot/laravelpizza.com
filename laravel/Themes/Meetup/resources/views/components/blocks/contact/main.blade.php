@php
    $contacts = [];
    foreach (($contact_info ?? []) as $item) {
        $contacts[] = [
            'icon' => $item['icon'] ?? null,
            'title' => $item['title'] ?? null,
            'value' => $item['value'] ?? null,
            'url' => $item['link'] ?? null,
            'description' => $item['description'] ?? null,
        ];
    }

    $submitLabel = $submit_button_label ?? 'Send Message';
@endphp

<x-pub_theme::components.blocks.contact.info
    :title="$title ?? null"
    :description="$description ?? null"
    :contacts="$contacts"
/>

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="#" method="post" class="bg-gray-50 rounded-xl p-8 shadow-lg">
            @csrf

            @if(isset($form_fields) && is_array($form_fields))
                <div class="space-y-6">
                    @foreach($form_fields as $field)
                        <div>
                            @if(isset($field['label']))
                                <label for="{{ $field['name'] ?? '' }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $field['label'] }}
                                    @if(!empty($field['required']))
                                        <span class="text-red-600">*</span>
                                    @endif
                                </label>
                            @endif

                            @if(($field['type'] ?? 'text') === 'textarea')
                                <textarea
                                    id="{{ $field['name'] ?? '' }}"
                                    name="{{ $field['name'] ?? '' }}"
                                    rows="{{ $field['rows'] ?? 4 }}"
                                    @if(!empty($field['required'])) required @endif
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                >{{ old($field['name'] ?? '') }}</textarea>
                            @else
                                <input
                                    id="{{ $field['name'] ?? '' }}"
                                    name="{{ $field['name'] ?? '' }}"
                                    type="{{ $field['type'] ?? 'text' }}"
                                    value="{{ old($field['name'] ?? '') }}"
                                    @if(!empty($field['required'])) required @endif
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                >
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-8">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</section>
