<?php

declare(strict_types=1);

?>
@props(['title' => 'Prenota Appuntamento'])

<div class="bg-white p-6 rounded-lg shadow-md" id="booking-form">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <form wire:submit="bookAppointment" class="space-y-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
            <input type="date" 
                   id="date" 
                   wire:model="date" 
                   min="{{ date('Y-m-d') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
            @error('date') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <label for="time" class="block text-sm font-medium text-gray-700">Orario</label>
            <select id="time" 
                    wire:model="time" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                <option value="">Seleziona un orario</option>
                @foreach($availableSlots as $slot)
                    <option value="{{ $slot }}">{{ $slot }}</option>
                @endforeach
            </select>
            @error('time') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo di visita</label>
            <select id="type" 
                    wire:model="type" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                <option value="">Seleziona il tipo di visita</option>
                <option value="checkup">Check-up generale</option>
                <option value="emergency">Emergenza</option>
                <option value="followup">Controllo</option>
            </select>
            @error('type') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Note (opzionale)</label>
            <textarea id="notes" 
                      wire:model="notes" 
                      rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('notes') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Prenota Appuntamento
            </button>
        </div>
    </form>
    
    @if ($bookingSuccess)
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
            <p class="font-medium">Appuntamento prenotato con successo!</p>
            <p class="mt-1">Riceverai una conferma via email e SMS.</p>
            <a href="{{ route('appointments.index') }}" 
               class="mt-2 inline-block text-indigo-600 underline">
                Visualizza i tuoi appuntamenti
            </a>
        </div>
    @endif
</div>
