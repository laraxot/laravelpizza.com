@php
    $user = auth()->user();
    $locale = app()->getLocale();
    $profileUrl = url($locale . '/profile');
    $dashboardUrl = Route::has('filament.pages.dashboard') ? route('filament.pages.dashboard') : null;
@endphp

@auth
    <div class="it-header-slim-right-zone">
        <div class="nav-item dropdown">
            <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" id="user-dropdown-trigger">
                <span class="rounded-icon" aria-hidden="true">
                    <x-filament::icon icon="heroicon-o-user" class="icon icon-primary" />
                </span>
                <span class="d-none d-lg-block">{{ $user->name ?? $user->email }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown-trigger">
                <div class="link-list-wrapper">
                    <ul class="link-list">
                        <li>
                            <a class="dropdown-item list-item" href="{{ $profileUrl }}">
                                <span>{{ __('user::auth.auth_button.profile') }}</span>
                            </a>
                        </li>
                        @if($dashboardUrl && auth()->user()->can('access-admin'))
                        <li>
                            <a class="dropdown-item list-item" href="{{ $dashboardUrl }}">
                                <span>{{ __('user::auth.auth_button.dashboard') }}</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item list-item">
                                    <span>{{ __('user::auth.auth_button.logout') }}</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@else
    <a class="btn btn-primary btn-icon btn-full" href="{{ route('login') }}" data-element="personal-area-login">
        <span class="rounded-icon" aria-hidden="true">
            <x-filament::icon icon="heroicon-o-user" class="icon icon-primary" />
        </span>
        <span class="d-none d-lg-block">{{ __('user::auth.auth_button.personal_area') }}</span>
    </a>
@endauth
