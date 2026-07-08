<?php

declare(strict_types=1);

?>
@props(['title' => 'Materiale Educativo'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <!-- Filtri -->
    <div class="mb-6 flex flex-wrap gap-4">
        <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
            Tutti
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Articoli
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Video
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Infografiche
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Checklist
        </button>
    </div>
    
    <!-- Griglia Materiali -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($materials as $material)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                @if($material->type === 'video')
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                        <img src="{{ $material->thumbnail }}" alt="{{ $material->title }}" class="object-cover">
                    </div>
                @elseif($material->type === 'infographic')
                    <div class="aspect-w-4 aspect-h-3 bg-gray-100">
                        <img src="{{ $material->image }}" alt="{{ $material->title }}" class="object-cover">
                    </div>
                @endif
                
                <div class="p-4">
                    <div class="flex items-center mb-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            @if($material->type === 'article') bg-blue-100 text-blue-700
                            @elseif($material->type === 'video') bg-purple-100 text-purple-700
                            @elseif($material->type === 'infographic') bg-green-100 text-green-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($material->type) }}
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ $material->title }}
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4">
                        {{ $material->description }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            {{ $material->duration ?? $material->created_at->format('d/m/Y') }}
                        </span>
                        
                        <a href="{{ route('materials.show', $material->id) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            Leggi di più →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Paginazione -->
    @if($materials->hasPages())
        <div class="mt-6">
            {{ $materials->links() }}
        </div>
    @endif
</div>
