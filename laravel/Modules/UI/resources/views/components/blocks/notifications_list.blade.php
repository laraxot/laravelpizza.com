<?php

declare(strict_types=1);

?>
@props(['title' => 'Notifiche'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <!-- Filtri -->
    <div class="mb-6 flex flex-wrap gap-4">
        <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
            Tutte
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Non lette
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Appuntamenti
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Documenti
        </button>
    </div>
    
    <!-- Lista Notifiche -->
    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="flex items-start p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0">
                    @if($notification->type === 'appointment')
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @elseif($notification->type === 'document')
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    @else
                        <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    @endif
                </div>
                
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-900">
                            {{ $notification->title }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $notification->message }}
                    </p>
                    
                    @if($notification->action_url)
                        <div class="mt-2">
                            <a href="{{ $notification->action_url }}" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                {{ $notification->action_text ?? 'Leggi di più' }} →
                            </a>
                        </div>
                    @endif
                </div>
                
                @if(!$notification->read_at)
                    <div class="ml-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Nuova
                        </span>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nessuna notifica</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Non hai ricevuto ancora nessuna notifica.
                </p>
            </div>
        @endforelse
    </div>
    
    <!-- Paginazione -->
    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
