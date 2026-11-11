@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    $contacts = [];
    foreach (($contact_info ?? []) as $item) {
        $url = $item['link'] ?? null;
        // Percorsi interni nella lingua corrente (/events => /it/events); mailto: e URL esterni restano come sono.
        if (is_string($url) && str_starts_with($url, '/')) {
            $url = LaravelLocalization::localizeUrl($url);
        }
        $icon = is_string($item['icon'] ?? null) ? $item['icon'] : null;
        $contacts[] = [
            'icon' => $icon !== null && ! str_starts_with($icon, 'heroicon-') && ! str_starts_with($icon, 'meetup-') ? 'heroicon-o-'.$icon : $icon,
            'title' => $item['title'] ?? null,
            'value' => $item['value'] ?? null,
            'url' => $url,
            'description' => $item['description'] ?? null,
        ];
    }
@endphp

<x-blocks.contact.info
    :title="$title ?? null"
    :description="$description ?? null"
    :contacts="$contacts"
/>

{{-- Modulo contatti funzionante (Livewire): prima era un <form action="#"> che non inviava nulla --}}
<section class="py-16 bg-white dark:bg-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(! empty($form_title))
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">{{ $form_title }}</h2>
        @endif
        <div class="rounded-xl bg-slate-50 p-8 shadow-lg dark:bg-slate-900">
            @livewire(\Modules\Meetup\Http\Livewire\ContactForm::class)
        </div>
    </div>
</section>
