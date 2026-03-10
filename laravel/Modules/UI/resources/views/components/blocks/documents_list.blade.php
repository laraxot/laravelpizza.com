<?php

declare(strict_types=1);

?>
@props(['title' => 'Documenti'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <!-- Filtri -->
    <div class="mb-6 flex flex-wrap gap-4">
        <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
            Tutti
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Referti
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Prescrizioni
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Consensi
        </button>
    </div>
    
    <!-- Lista Documenti -->
    <div class="space-y-4">
        @forelse($documents as $document)
            <div class="flex items-start p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex-shrink-0">
                    @if($document->type === 'report')
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    @elseif($document->type === 'prescription')
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    @else
                        <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    @endif
                </div>
                
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-900">
                            {{ $document->title }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $document->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $document->description }}
                    </p>
                    
                    <div class="mt-2 flex items-center space-x-4">
                        <a href="{{ $document->download_url }}" 
                           class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Scarica →
                        </a>
                        
                        @if($document->preview_url)
                            <a href="{{ $document->preview_url }}" 
                               class="text-sm font-medium text-gray-600 hover:text-gray-800">
                                Anteprima →
                            </a>
                        @endif
                    </div>
                </div>
                
                @if($document->is_confidential)
                    <div class="ml-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Riservato
                        </span>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun documento</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Non hai ancora nessun documento disponibile.
                </p>
            </div>
        @endforelse
    </div>
    
    <!-- Paginazione -->
    @if($documents->hasPages())
        <div class="mt-6">
            {{ $documents->links() }}
        </div>
    @endif
</div>
