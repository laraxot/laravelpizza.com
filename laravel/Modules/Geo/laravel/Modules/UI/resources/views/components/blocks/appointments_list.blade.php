<?php

declare(strict_types=1);

?>
@props(['title' => 'Appuntamenti'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <!-- Filtri -->
    <div class="mb-6 flex flex-wrap gap-4">
        <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
            Tutti
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Prossimi
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Passati
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Cancellati
        </button>
    </div>
    
    <!-- Lista Appuntamenti -->
    <div class="space-y-4">
        @forelse($appointments as $appointment)
            <div class="flex items-start p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0">
                    @if($appointment->status === 'confirmed')
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @elseif($appointment->status === 'pending')
                        <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>
                
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-900">
                            {{ $appointment->type }}
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                    
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Data:</span> 
                            {{ $appointment->starts_at->format('d/m/Y') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Orario:</span> 
                            {{ $appointment->time }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Dottore:</span> 
                            {{ $appointment->doctor_name }}
                        </p>
                    </div>
                    
                    <div class="mt-4 flex items-center space-x-4">
                        <a href="{{ route('appointments.show', $appointment->id) }}" 
                           class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Dettagli →
                        </a>
                        
                        @if($appointment->status === 'confirmed')
                            <button type="button" 
                                    class="text-sm font-medium text-red-600 hover:text-red-800"
                                    onclick="confirmCancel({{ $appointment->id }})">
                                Cancella →
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun appuntamento</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Non hai ancora nessun appuntamento programmato.
                </p>
                <div class="mt-4">
                    <a href="{{ route('appointments.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        Prenota un appuntamento
                    </a>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Paginazione -->
    @if($appointments->hasPages())
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
function confirmCancel(appointmentId) {
    if (confirm('Sei sicuro di voler cancellare questo appuntamento?')) {
        // Implementa la logica di cancellazione
        window.location.href = `/appointments/${appointmentId}/cancel`;
    }
}
</script>
@endpush
