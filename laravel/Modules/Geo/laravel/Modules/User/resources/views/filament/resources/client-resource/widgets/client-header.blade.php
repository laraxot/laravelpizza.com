<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Basic Information Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->id }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->name }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Client ID</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">{{ $getRecord()->id }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Client Secret</dt>
                <dd class="mt-1 text-sm text-gray-900 break-all">
                    @if($getRecord()->secret)
                        <span class="font-mono">••••••••</span>
                        <button 
                            x-data="{ show: false }"
                            @click="show = !show"
                            class="ml-2 text-sm text-blue-600 hover:text-blue-800"
                        >
                            <span x-show="!show">Show</span>
                            <span x-show="show" x-cloak>{{ $getRecord()->secret }}</span>
                        </button>
                    @else
                        <span class="text-gray-400">No secret</span>
                    @endif
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Provider</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->provider ?? 'Default' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->created_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Updated</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->updated_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Configuration Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Configuration</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Confidential</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->confidential() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->confidential() ? 'Yes' : 'No' }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">First Party</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->firstParty() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->firstParty() ? 'Yes' : 'No' }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Personal Access</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->personal_access_client ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->personal_access_client ? 'Yes' : 'No' }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Password Client</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->password_client ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $getRecord()->password_client ? 'Yes' : 'No' }}
                    </span>
                </dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Revoked</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $getRecord()->revoked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $getRecord()->revoked ? 'Yes' : 'No' }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Grant Types Section -->
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Grant Types</h3>
        <div class="flex flex-wrap gap-2">
            @if($getRecord()->hasGrantType('authorization_code'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Authorization Code
                </span>
            @endif
            @if($getRecord()->hasGrantType('client_credentials'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Client Credentials
                </span>
            @endif
            @if($getRecord()->hasGrantType('password'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Password
                </span>
            @endif
            @if($getRecord()->hasGrantType('refresh_token'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Refresh Token
                </span>
            @endif
            @if($getRecord()->hasGrantType('implicit'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Implicit
                </span>
            @endif
            @if($getRecord()->hasGrantType('personal_access'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Personal Access
                </span>
            @endif
            @if(!$getRecord()->grant_types)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    No grant types configured
                </span>
            @endif
        </div>
    </div>

    <!-- Redirect URIs Section -->
    @if($getRecord()->redirect_uris || $getRecord()->redirect)
    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Redirect URIs</h3>
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
        <h3 class="text-lg font-medium text-gray-900 mb-4">Scopes</h3>
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
        <h3 class="text-lg font-medium text-gray-900 mb-4">Owner Information</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Owner ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner->id ?? 'N/A' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Owner Type</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner_type ?? 'N/A' }}</dd>
            </div>
            @if($getRecord()->owner->name ?? null)
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Owner Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $getRecord()->owner->name }}</dd>
            </div>
            @endif
        </dl>
    </div>
    @endif
</div>