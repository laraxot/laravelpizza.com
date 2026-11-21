@props([
    'user' => null,
    'item' => null,
    'slug0' => null,
])

@php
    $userModel = $user instanceof \Modules\User\Models\User
        ? $user
        : ($item instanceof \Modules\User\Models\User ? $item : null);

    if (! $userModel && $item instanceof \Modules\User\Models\Profile) {
        $candidateUser = $item->user;
        if ($candidateUser instanceof \Modules\User\Models\User) {
            $userModel = $candidateUser;
        }
    }

    if (! $userModel && is_string($slug0) && $slug0 !== '') {
        $userModel = \Modules\User\Models\User::query()
            ->with('profile')
            ->find($slug0);
    }

    $profileModel = $userModel?->profile;
    $displayName = trim((string) ($userModel?->name ?? ''));
    if ($displayName === '') {
        $displayName = trim((string) (($userModel?->first_name ?? $profileModel?->first_name ?? '').' '.($userModel?->last_name ?? $profileModel?->last_name ?? '')));
    }
    if ($displayName === '') {
        $displayName = (string) __('pub_theme::profile.messages.anonymous_user.label');
    }

    $bio = trim((string) ($profileModel?->bio ?? ''));
    $email = trim((string) ($userModel?->email ?? $profileModel?->email ?? ''));
    $locale = trim((string) ($profileModel?->locale ?? $userModel?->lang ?? app()->getLocale()));
    $memberSince = $userModel?->created_at?->translatedFormat('F Y');
    $avatarUrl = $profileModel?->getAvatarUrl() ?? ($userModel?->profile_photo_url ?? null);
    $eventsUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/events');
    $location = trim((string) ($profileModel?->address ?? ''));
@endphp

<section class="relative overflow-hidden bg-slate-950 text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(251,113,133,0.24),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.18),_transparent_28%)]"></div>

    <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,1.6fr)_minmax(320px,1fr)] lg:items-start">
            <div class="space-y-6">
                <div class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-1 text-sm font-medium text-white/85 backdrop-blur">
                    {{ __('pub_theme::profile.badges.public_profile.label') }}
                </div>

                <div class="flex items-start gap-5">
                    <div class="h-24 w-24 shrink-0 overflow-hidden rounded-3xl border border-white/15 bg-white/10 shadow-2xl shadow-black/20">
                        @if(is_string($avatarUrl) && $avatarUrl !== '')
                            <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-white/80">
                                {{ \Illuminate\Support\Str::of($displayName)->trim()->substr(0, 1)->upper() }}
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <h1 class="text-4xl font-black tracking-tight text-white sm:text-5xl">
                            {{ $displayName }}
                        </h1>

                        <p class="max-w-2xl text-lg leading-8 text-slate-200">
                            {{ $bio !== '' ? $bio : __('pub_theme::profile.messages.short_bio_fallback.label') }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ $eventsUrl }}"
                        class="inline-flex items-center rounded-2xl bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-300"
                    >
                        {{ __('pub_theme::profile.actions.browse_events.label') }}
                    </a>

                    @if($email !== '')
                        <a
                            href="mailto:{{ $email }}"
                            class="inline-flex items-center rounded-2xl border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/40"
                        >
                            {{ __('pub_theme::profile.actions.contact.label') }}
                        </a>
                    @endif
                </div>
            </div>

            <aside class="rounded-[2rem] border border-white/10 bg-white/8 p-6 shadow-2xl shadow-black/20 backdrop-blur">
                <h2 class="text-lg font-semibold text-white">
                    {{ __('pub_theme::profile.sections.profile_details.label') }}
                </h2>

                <dl class="mt-6 space-y-5">
                    @if($memberSince)
                        <div>
                            <dt class="text-sm uppercase tracking-[0.2em] text-slate-400">
                                {{ __('pub_theme::profile.fields.member_since.label') }}
                            </dt>
                            <dd class="mt-1 text-base font-medium text-white">
                                {{ $memberSince }}
                            </dd>
                        </div>
                    @endif

                    @if($email !== '')
                        <div>
                            <dt class="text-sm uppercase tracking-[0.2em] text-slate-400">
                                {{ __('pub_theme::profile.fields.email.label') }}
                            </dt>
                            <dd class="mt-1 break-all text-base font-medium text-white">
                                {{ $email }}
                            </dd>
                        </div>
                    @endif

                    @if($locale !== '')
                        <div>
                            <dt class="text-sm uppercase tracking-[0.2em] text-slate-400">
                                {{ __('pub_theme::profile.fields.locale.label') }}
                            </dt>
                            <dd class="mt-1 text-base font-medium text-white">
                                {{ strtoupper($locale) }}
                            </dd>
                        </div>
                    @endif

                    @if($location !== '')
                        <div>
                            <dt class="text-sm uppercase tracking-[0.2em] text-slate-400">
                                {{ __('pub_theme::profile.fields.location.label') }}
                            </dt>
                            <dd class="mt-1 whitespace-pre-line text-base font-medium text-white">
                                {{ $location }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </aside>
        </div>
    </div>
</section>
