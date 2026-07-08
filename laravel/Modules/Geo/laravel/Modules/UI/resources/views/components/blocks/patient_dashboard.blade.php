<?php

declare(strict_types=1);

?>
@props(['title' => 'Area Personale'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Prossimo Appuntamento -->
        <div class="bg-indigo-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-indigo-900 mb-2">Prossimo Appuntamento</h3>
            @if($nextAppointment)
                <div class="space-y-2">
                    <p class="text-indigo-700">
                        <span class="font-medium">Data:</span> 
                        {{ $nextAppointment->date->format('d/m/Y') }}
                    </p>
                    <p class="text-indigo-700">
                        <span class="font-medium">Orario:</span> 
                        {{ $nextAppointment->time }}
                    </p>
                    <p class="text-indigo-700">
                        <span class="font-medium">Tipo:</span> 
                        {{ $nextAppointment->type }}
                    </p>
                </div>
                <a href="{{ route('appointments.show', $nextAppointment->id) }}" 
                   class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                    Dettagli →
                </a>
            @else
                <p class="text-indigo-700">Nessun appuntamento programmato</p>
                <a href="{{ route('appointments.create') }}" 
                   class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                    Prenota un appuntamento →
                </a>
            @endif
        </div>
        
        <!-- Documenti Recenti -->
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-green-900 mb-2">Documenti Recenti</h3>
            @if($recentDocuments->count() > 0)
                <ul class="space-y-2">
                    @foreach($recentDocuments as $document)
                        <li class="text-green-700">
                            <a href="{{ route('documents.show', $document->id) }}" 
                               class="hover:text-green-900">
                                {{ $document->title }}
                            </a>
                            <span class="text-sm text-green-600">
                                ({{ $document->created_at->format('d/m/Y') }})
                            </span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('documents.index') }}" 
                   class="mt-4 inline-block text-green-600 hover:text-green-800">
                    Tutti i documenti →
                </a>
            @else
                <p class="text-green-700">Nessun documento disponibile</p>
            @endif
        </div>
        
        <!-- Notifiche -->
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-yellow-900 mb-2">Notifiche Recenti</h3>
            @if($recentNotifications->count() > 0)
                <ul class="space-y-2">
                    @foreach($recentNotifications as $notification)
                        <li class="text-yellow-700">
                            <span class="font-medium">{{ $notification->title }}</span>
                            <p class="text-sm">{{ $notification->message }}</p>
                            <span class="text-xs text-yellow-600">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('notifications.index') }}" 
                   class="mt-4 inline-block text-yellow-600 hover:text-yellow-800">
                    Tutte le notifiche →
                </a>
            @else
                <p class="text-yellow-700">Nessuna notifica recente</p>
            @endif
        </div>
    </div>
    
    <!-- Azioni Rapide -->
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">Profilo</span>
        </a>
        <a href="{{ route('appointments.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">Appuntamenti</span>
        </a>
        <a href="{{ route('documents.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">Documenti</span>
        </a>
        <a href="{{ route('notifications.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">Notifiche</span>
        </a>
    </div>
</div>
