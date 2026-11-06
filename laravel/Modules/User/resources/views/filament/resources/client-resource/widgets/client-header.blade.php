<?php

declare(strict_types=1);

?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Basic Information Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.basic.title') }}</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->id }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.name.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->name }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.client_id.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->id }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.client_secret.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">
                    @if($getRecord()->secret)
                        <span class="font-mono">••••••••</span>
                        <button 
                            x-data="{ show: false }"
                            @click="show = !show"
                            class="ml-2 text-sm text-blue-600 hover:text-blue-800"
                        >
                            <span x-show="!show">{{ __('user::client_header.basic.show.label') }}</span>
                            <span x-show="show" x-cloak>{{ $getRecord()->secret }}</span>
                        </button>
                    @else
                        <span class="text-gray-400">{{ __('user::client_header.basic.no_secret.message') }}</span>
                    @endif
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.provider.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->provider ?? __('user::client_header.basic.default_provider.label') }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.created.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->created_at?->format('Y-m-d H:i:s') ?? __('user::client_header.messages.not_available.message') }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.basic.updated.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->updated_at?->format('Y-m-d H:i:s') ?? __('user::client_header.messages.not_available.message') }}</dd>
            </div>
        </dl>
    </div>

    <!-- Configuration Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.configuration.title') }}</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.configuration.confidential.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->confidential() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->confidential() ? __('user::client_header.sections.yes.label') : __('user::client_header.messages.no.message') }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.configuration.first_party.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->firstParty() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->firstParty() ? __('user::client_header.sections.yes.label') : __('user::client_header.messages.no.message') }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.sections.personal_access.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->personal_access_client ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->personal_access_client ? __('user::client_header.sections.yes.label') : __('user::client_header.messages.no.message') }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.configuration.password_client.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->password_client ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->password_client ? __('user::client_header.sections.yes.label') : __('user::client_header.messages.no.message') }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.configuration.revoked.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->revoked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $getRecord()->revoked ? __('user::client_header.sections.yes.label') : __('user::client_header.messages.no.message') }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Grant Types Section -->
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.grant_types.title') }}</h3>
        <div class="flex flex-wrap gap-2">
            @if($getRecord()->hasGrantType('authorization_code'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::client_header.grant_types.authorization_code.label') }}
                </span>
            @endif
            @if($getRecord()->hasGrantType('client_credentials'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::client_header.grant_types.client_credentials.label') }}
                </span>
            @endif
            @if($getRecord()->hasGrantType('password'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::login.fields.password.label') }}
                </span>
            @endif
            @if($getRecord()->hasGrantType('refresh_token'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::client_header.grant_types.refresh_token.label') }}
                </span>
            @endif
            @if($getRecord()->hasGrantType('implicit'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::client_header.grant_types.implicit.label') }}
                </span>
            @endif
            @if($getRecord()->hasGrantType('personal_access'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __('user::client_header.sections.personal_access.label') }}
                </span>
            @endif
            @if(!$getRecord()->grant_types)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ __('user::client_header.grant_types.none.message') }}
                </span>
            @endif
        </div>
    </div>

    <!-- Redirect URIs Section -->
    @if($getRecord()->redirect_uris || $getRecord()->redirect)
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.redirect_uris.title') }}</h3>
        <div class="border rounded-lg overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @if($getRecord()->redirect_uris && is_array($getRecord()->redirect_uris))
                    @foreach($getRecord()->redirect_uris as $uri)
                        <li class="px-4 py-3 text-sm text-gray-900 font-mono bg-gray-50">{{ $uri }}</li>
                    @endforeach
                @elseif($getRecord()->redirect)
                    <li class="px-4 py-3 text-sm text-gray-900 font-mono bg-gray-50">{{ $getRecord()->redirect }}</li>
                @endif
            </ul>
        </div>
    </div>
    @endif

    <!-- Scopes Section -->
    @if($getRecord()->scopes && is_array($getRecord()->scopes) && count($getRecord()->scopes) > 0)
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.scopes.title') }}</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($getRecord()->scopes as $scope)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ $scope }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Owner Information -->
    @if($getRecord()->owner)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('user::client_header.sections.owner.title') }}</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.owner.id.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner->id ?? __('user::client_header.messages.not_available.message') }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.owner.type.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner_type ?? __('user::client_header.messages.not_available.message') }}</dd>
            </div>
            @if($getRecord()->owner->name ?? null)
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">{{ __('user::client_header.owner.name.label') }}</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner->name }}</dd>
            </div>
            @endif
        </dl>
    </div>
    @endif
</div>