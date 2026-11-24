{{--
    Blocco "Modifica il profilo" (pages/profile/edit.json -> /{lingua}/profile/edit, solo utenti autenticati).
    Titolo e descrizione arrivano dal JSON; il form è il componente Livewire del modulo Meetup.
--}}
@php($title ??= null)
@php($description ??= null)

<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-900 to-red-950 px-4 py-12 sm:py-16">
    <div class="pointer-events-none absolute -top-32 right-0 h-72 w-72 rounded-full bg-red-500/10 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-3xl">
        <header class="mb-8">
            <h1 class="text-3xl font-extrabold text-white sm:text-4xl">{{ $title }}</h1>
            @if($description)
                <p class="mt-2 text-slate-300">{{ $description }}</p>
            @endif
        </header>

        @livewire(\Modules\Meetup\Http\Livewire\ProfileEditForm::class)
    </div>
</section>
