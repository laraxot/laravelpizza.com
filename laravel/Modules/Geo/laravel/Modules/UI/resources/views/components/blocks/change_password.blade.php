<?php

declare(strict_types=1);

?>
@props(['title' => 'Cambia Password'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Attuale</label>
                <input type="password" 
                       name="current_password" 
                       id="current_password"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nuova Password</label>
                <input type="password" 
                       name="password" 
                       id="password"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Conferma Nuova Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Requisiti Password -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-900 mb-2">Requisiti Password</h3>
            <ul class="text-sm text-gray-600 space-y-1">
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Almeno 8 caratteri
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Almeno una lettera maiuscola
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Almeno un numero
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Almeno un carattere speciale
                </li>
            </ul>
        </div>
        
        <!-- Azioni -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('profile.show') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Annulla
            </a>
            
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                Cambia Password
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const requirements = document.querySelectorAll('.bg-gray-50 ul li');
    
    function checkPassword() {
        const value = password.value;
        
        // Almeno 8 caratteri
        requirements[0].querySelector('svg').className = 
            value.length >= 8 ? 'h-4 w-4 text-green-500 mr-2' : 'h-4 w-4 text-gray-400 mr-2';
        
        // Almeno una lettera maiuscola
        requirements[1].querySelector('svg').className = 
            /[A-Z]/.test(value) ? 'h-4 w-4 text-green-500 mr-2' : 'h-4 w-4 text-gray-400 mr-2';
        
        // Almeno un numero
        requirements[2].querySelector('svg').className = 
            /[0-9]/.test(value) ? 'h-4 w-4 text-green-500 mr-2' : 'h-4 w-4 text-gray-400 mr-2';
        
        // Almeno un carattere speciale
        requirements[3].querySelector('svg').className = 
            /[^A-Za-z0-9]/.test(value) ? 'h-4 w-4 text-green-500 mr-2' : 'h-4 w-4 text-gray-400 mr-2';
    }
    
    password.addEventListener('input', checkPassword);
});
</script>
@endpush
