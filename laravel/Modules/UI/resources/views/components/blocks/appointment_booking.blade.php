<?php

declare(strict_types=1);
?>
@props(['title' => __('ui::blocks_appointments.booking.prenota_appuntamento.label')])

<div class="bg-white p-6 rounded-lg shadow-md" id="booking-form">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <form wire:submit="bookAppointment" class="space-y-4">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">{{ __('ui::blocks_appointments.booking.data.label') }}</label>
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
            <label for="time" class="block text-sm font-medium text-gray-700">{{ __('ui::blocks_appointments.booking.orario.label') }}</label>
            <select id="time" 
                    wire:model="time" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                <option value="">{{ __('ui::blocks_appointments.booking.seleziona_un_orario.label') }}</option>
                @foreach($availableSlots as $slot)
                    <option value="{{ $slot }}">{{ $slot }}</option>
                @endforeach
            </select>
            @error('time') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('ui::blocks_appointments.booking.tipo_di_visita.label') }}</label>
            <select id="type" 
                    wire:model="type" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                <option value="">{{ __('ui::blocks_appointments.booking.text_1.label') }}</option>
                <option value="checkup">{{ __('ui::blocks_appointments.booking.check_up_generale.label') }}</option>
                <option value="emergency">{{ __('ui::blocks_appointments.booking.emergenza.label') }}</option>
                <option value="followup">{{ __('ui::blocks_appointments.booking.controllo.label') }}</option>
            </select>
            @error('type') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>
        
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('ui::blocks_appointments.booking.note_opzionale.label') }}</label>
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
                {{ __('ui::blocks_appointments.booking.prenota_appuntamento.label') }}
            </button>
        </div>
    </form>
    
    @if ($bookingSuccess)
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
            <p class="font-medium">{{ __('ui::blocks_appointments.booking.appuntamento_prenotato_con_successo.label') }}</p>
            <p class="mt-1">{{ __('ui::blocks_appointments.booking.paragraph_1.description') }}</p>
            <a href="{{ route('appointments.index') }}" 
               class="mt-2 inline-block text-indigo-600 underline">
                {{ __('ui::blocks_appointments.booking.visualizza_i_tuoi_appuntamenti.label') }}
            </a>
        </div>
    @endif
</div>
