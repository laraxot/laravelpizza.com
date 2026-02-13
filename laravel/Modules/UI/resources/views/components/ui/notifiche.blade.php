@props([
    'notifications' => [],
    'maxCount' => 5,
    'showUnread' => true,
])

<div class="ui-notifiche relative">
    <!-- Notification Bell -->
    <button 
        type="button"
        class="relative p-2 text-gray-600 hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-lg"
        aria-label="{{ __('Notifiche') }}"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        
        <!-- Unread Badge -->
        @if($showUnread && !empty($notifications))
            @php
                $unreadCount = collect($notifications)->where('read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute top-0 right-0 -mt-1 -mr-1 flex items-center justify-center w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        @endif
    </button>
    
    <!-- Notification Dropdown -->
    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 hidden z-50">
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900">
                {{ __('Notifiche') }}
            </h3>
        </div>
        
        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @if(!empty($notifications))
                @foreach(collect($notifications)->take($maxCount) as $notification)
                    <div 
                        class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors
                            {{ !$notification['read'] ? 'bg-blue-50' : '' }}"
                    >
                        <div class="flex items-start space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                @if(isset($notification['type']))
                                    @switch($notification['type'])
                                        @case('success')
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            @break
                                        
                                        @case('warning')
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                            </div>
                                            @break
                                        
                                        @case('error')
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </div>
                                            @break
                                        
                                        @default
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                    @endswitch
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $notification['title'] ?? '' }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $notification['message'] ?? '' }}
                                </p>
                                @if(isset($notification['time']))
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification['time'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-4 py-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-sm text-gray-500">
                        {{ __('Nessuna notifica') }}
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        @if(!empty($notifications))
            <div class="px-4 py-3 border-t border-gray-200">
                <a href="#" class="block text-sm text-center text-primary-600 hover:text-primary-700 font-medium">
                    {{ __('Visualizza tutte le notifiche') }}
                </a>
            </div>
        @endif
    </div>
</div>