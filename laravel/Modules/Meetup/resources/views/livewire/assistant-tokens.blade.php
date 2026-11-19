{{--
    "Collega un assistente AI" (Modules\Meetup\Http\Livewire\AssistantTokens).
    Indirizzo del server MCP, creazione di un token (mostrato una volta sola), elenco dei token attivi con revoca.
--}}
@php
    $input = 'block w-full rounded-xl border border-slate-600 bg-slate-900/60 px-4 py-3 text-white placeholder-slate-500 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/40';
    $label = 'mb-1.5 block text-sm font-medium text-slate-200';
    $card = 'rounded-2xl border border-slate-700/60 bg-slate-800/70 p-6 shadow-xl sm:p-8';
    $primary = 'inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60';
    $secondary = 'inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-5 py-3 font-semibold text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50 disabled:opacity-60';
    $code = 'block w-full overflow-x-auto rounded-xl border border-slate-600 bg-slate-950 px-4 py-3 font-mono text-sm text-slate-100';
@endphp

<div class="space-y-8">
    <p class="text-slate-300">{{ __('meetup::assistant_tokens.intro') }}</p>

    {{-- Indirizzo del server MCP --}}
    <section class="{{ $card }}" aria-labelledby="assistant-server-heading">
        <h2 id="assistant-server-heading" class="text-xl font-bold text-white">{{ __('meetup::assistant_tokens.server.title') }}</h2>
        <code class="{{ $code }} mt-4" data-mcp-url>{{ $mcpUrl }}</code>
        <p class="mt-3 text-sm text-slate-400">{{ __('meetup::assistant_tokens.server.help') }}</p>
    </section>

    {{-- Token appena creato: una volta sola --}}
    @if($plainToken !== '')
        @php($config = json_encode(['mcpServers' => ['laravelpizza' => ['type' => 'http', 'url' => $mcpUrl, 'headers' => ['Authorization' => 'Bearer '.$plainToken]]]], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
        <section class="rounded-2xl border border-amber-400/60 bg-amber-950/40 p-6 shadow-xl sm:p-8" aria-labelledby="assistant-created-heading" role="status"
                 x-data="{ copied: false, copy() { navigator.clipboard?.writeText(this.$refs.token.value).then(() => { this.copied = true; setTimeout(() => this.copied = false, 2000); }); } }">
            <h2 id="assistant-created-heading" class="text-xl font-bold text-amber-100">{{ __('meetup::assistant_tokens.created.title') }}</h2>
            <p class="mt-1 text-sm text-amber-100/90">{{ __('meetup::assistant_tokens.created.warning') }}</p>

            <label for="assistant-new-token" class="{{ $label }} mt-5">{{ __('meetup::assistant_tokens.created.label', ['name' => $createdName]) }}</label>
            <div class="flex flex-col gap-3 sm:flex-row">
                <input id="assistant-new-token" x-ref="token" type="text" readonly value="{{ $plainToken }}" class="{{ $input }} font-mono text-sm" x-on:focus="$el.select()">
                <button type="button" x-on:click="copy()" class="{{ str_replace(['bg-red-600', 'hover:bg-red-500'], ['bg-red-700', 'hover:bg-red-600'], $primary) }} shrink-0">
                    <span x-show="!copied">{{ __('meetup::assistant_tokens.created.copy') }}</span>
                    <span x-show="copied" x-cloak>{{ __('meetup::assistant_tokens.created.copied') }}</span>
                </button>
            </div>

            <p class="{{ $label }} mt-5">{{ __('meetup::assistant_tokens.created.config') }}</p>
            <pre class="{{ $code }} max-h-56 whitespace-pre focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-300" tabindex="0" aria-label="{{ __('meetup::assistant_tokens.created.config') }}">{{ $config }}</pre>

            <button type="button" wire:click="dismiss" class="{{ $secondary }} mt-5">{{ __('meetup::assistant_tokens.created.done') }}</button>
        </section>
    @endif

    {{-- Nuovo token --}}
    <section class="{{ $card }}" aria-labelledby="assistant-create-heading">
        <h2 id="assistant-create-heading" class="text-xl font-bold text-white">{{ __('meetup::assistant_tokens.create.title') }}</h2>
        <p class="mt-1 text-sm text-slate-300">{{ __('meetup::assistant_tokens.create.description') }}</p>

        <form wire:submit="create" class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-end" novalidate>
            <div class="flex-1">
                <label for="assistant-token-name" class="{{ $label }}">{{ __('meetup::assistant_tokens.fields.name') }}</label>
                <input id="assistant-token-name" type="text" wire:model="name" maxlength="60" required class="{{ $input }}"
                       placeholder="{{ __('meetup::assistant_tokens.placeholders.name') }}"
                       @error('name') aria-invalid="true" aria-describedby="assistant-token-name-error" @enderror>
                @error('name') <p id="assistant-token-name-error" class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled" wire:target="create" class="{{ $primary }}">{{ __('meetup::assistant_tokens.create.submit') }}</button>
        </form>
    </section>

    {{-- Token attivi --}}
    <section class="{{ $card }}" aria-labelledby="assistant-list-heading">
        <h2 id="assistant-list-heading" class="text-xl font-bold text-white">{{ __('meetup::assistant_tokens.list.title') }}</h2>

        @if($revoked !== '')
            <p class="mt-3 text-sm font-medium text-green-300" role="status">{{ __('meetup::assistant_tokens.list.revoked') }}</p>
        @endif

        @if($tokens === [])
            <p class="mt-4 text-sm text-slate-300">{{ __('meetup::assistant_tokens.list.empty') }}</p>
        @else
            <ul class="mt-4 divide-y divide-slate-700/60" role="list">
                @foreach($tokens as $token)
                    <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between" wire:key="token-{{ $token['id'] }}">
                        <div>
                            <p class="font-semibold text-white">{{ $token['name'] }}</p>
                            <p class="text-sm text-slate-400">
                                {{ __('meetup::assistant_tokens.list.created_at', ['date' => $token['created_at']?->translatedFormat('j F Y') ?? '—']) }}@if($token['expires_at']), {{ __('meetup::assistant_tokens.list.expires_at', ['date' => $token['expires_at']->translatedFormat('j F Y')]) }}@endif
                            </p>
                        </div>
                        <button type="button" wire:click="revoke('{{ $token['id'] }}')" wire:confirm="{{ __('meetup::assistant_tokens.list.revoke_confirm') }}"
                                class="{{ $secondary }} border-red-400/50 text-red-200 hover:bg-red-500/10"
                                aria-label="{{ __('meetup::assistant_tokens.list.revoke') }}: {{ $token['name'] }}">
                            {{ __('meetup::assistant_tokens.list.revoke') }}
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <p class="text-sm text-slate-400">{{ __('meetup::assistant_tokens.safety') }}</p>
</div>
