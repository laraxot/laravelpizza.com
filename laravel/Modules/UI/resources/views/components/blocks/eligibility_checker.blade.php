<?php

declare(strict_types=1);

?>
@props(['title' => 'Verifica Idoneità'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <form action="{{ route('eligibility.check') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- ISEE -->
        <div>
            <label for="isee" class="block text-sm font-medium text-gray-700">ISEE (€)</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">€</span>
                </div>
                <input type="number" 
                       name="isee" 
                       id="isee"
                       required
                       min="0"
                       step="0.01"
                       value="{{ old('isee') }}"
                       class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                @error('isee')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Stato Gravidanza -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Stato Gravidanza</label>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="radio" 
                           name="pregnancy_status" 
                           id="pregnant" 
                           value="pregnant"
                           {{ old('pregnancy_status') === 'pregnant' ? 'checked' : '' }}
                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                    <label for="pregnant" class="ml-3 block text-sm font-medium text-gray-700">
                        Sono in gravidanza
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="radio" 
                           name="pregnancy_status" 
                           id="not_pregnant" 
                           value="not_pregnant"
                           {{ old('pregnancy_status') === 'not_pregnant' ? 'checked' : '' }}
                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                    <label for="not_pregnant" class="ml-3 block text-sm font-medium text-gray-700">
                        Non sono in gravidanza
                    </label>
                </div>
            </div>
            @error('pregnancy_status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Residenza -->
        <div>
            <label for="residence" class="block text-sm font-medium text-gray-700">Comune di Residenza</label>
            <select name="residence" 
                    id="residence"
                    required
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value="">Seleziona comune</option>
                @foreach($municipalities as $municipality)
                    <option value="{{ $municipality->id }}" 
                            {{ old('residence') == $municipality->id ? 'selected' : '' }}>
                        {{ $municipality->name }}
                    </option>
                @endforeach
            </select>
            @error('residence')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Informazioni -->
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-blue-800 mb-2">Informazioni Importanti</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Il programma è rivolto a donne in gravidanza</li>
                <li>• L'ISEE deve essere inferiore a € 20.000</li>
                <li>• È necessario essere residenti in uno dei comuni aderenti</li>
                <li>• Il servizio è gratuito per le persone idonee</li>
            </ul>
        </div>
        
        <!-- Azioni -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                Verifica Idoneità
            </button>
        </div>
    </form>
</div>

@if(session('eligibility_result'))
    <div class="mt-6">
        @if(session('eligibility_result')['eligible'])
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Congratulazioni! Sei idonea al programma.
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>{{ session('eligibility_result')['message'] }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('appointments.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Prenota un appuntamento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Mi dispiace, non sei idonea al programma.
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ session('eligibility_result')['message'] }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('contact') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                Contatta il supporto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif
