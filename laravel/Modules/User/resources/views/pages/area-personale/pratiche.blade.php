<?php

declare(strict_types=1);

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Fixcity\Actions\BuildAuthenticatedUserTicketsQueryAction;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('area-personale.pratiche');
middleware(PageSlugMiddleware::class);

new class extends Component {
    /** @var LengthAwarePaginator<int, \Modules\Fixcity\Models\Ticket> */
    public LengthAwarePaginator $tickets;

    public function mount(): void
    {
        if (! auth()->check()) {
            $this->redirect(LaravelLocalization::localizeURL('/auth/login'));

            return;
        }

        $this->tickets = class_exists(BuildAuthenticatedUserTicketsQueryAction::class)
            ? app(BuildAuthenticatedUserTicketsQueryAction::class)
                ->execute()
                ->paginate(15)
            : new LengthAwarePaginator([], 0, 15);
    }
};
?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('pub_theme::ui.header_area_personale.my_practices.label') }}
    </x-slot>

    <main id="main-container" class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <header class="mb-8 max-w-3xl">
            <h1 class="text-3xl font-bold tracking-tight text-slate-950">{{ __('pub_theme::ui.header_area_personale.my_practices.label') }}</h1>
            <p class="mt-2 text-lg text-slate-700">{{ __('pub_theme::ui.header_area_personale.my_practices.description', ['default' => 'Elenco delle pratiche in corso']) }}</p>
        </header>
        @volt('area-personale.pratiche')
            @if ($tickets->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                    <p class="text-slate-700">{{ __('pub_theme::ui.header_area_personale.my_practices.empty', ['default' => 'Non hai ancora inviato nessuna segnalazione.']) }}</p>
                    <a href="{{ LaravelLocalization::localizeURL('/tickets/create') }}" class="mt-5 inline-flex min-h-11 items-center rounded-lg bg-sky-900 px-5 py-3 font-semibold text-white hover:bg-sky-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-800 focus-visible:ring-offset-2">{{ __('pub_theme::ui.header_area_personale.my_practices.new_report', ['default' => 'Invia una nuova segnalazione']) }}</a>
                </div>
            @else
                <div class="divide-y divide-slate-200 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" role="list">
                    @foreach ($tickets as $ticket)
                        <article class="p-5 sm:p-6" role="listitem">
                            <h2 class="text-lg font-semibold text-slate-950">{{ $ticket->name }}</h2>
                            @if ($ticket->content)<p class="mt-1 text-slate-700">{{ \Illuminate\Support\Str::limit(strip_tags((string) $ticket->content), 140) }}</p>@endif
                            <p class="mt-2 text-sm text-slate-600">{{ __('user::area_personale.practices.submitted_on.label', ['date' => $ticket->created_at?->translatedFormat('d F Y')]) }}</p>
                        </article>
                    @endforeach
                </div>
                <div class="mt-6">{{ $tickets->links() }}</div>
            @endif
        @endvolt
    </main>
</x-layouts.app>
