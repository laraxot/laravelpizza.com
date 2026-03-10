<?php

declare(strict_types=1);

?>
@props(['title' => 'Profilo Utente'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

    <!-- Informazioni Personali -->
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informazioni Personali</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cognome</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->last_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Telefono</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->phone }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data di Nascita</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->birth_date->format('d/m/Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Codice Fiscale</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->fiscal_code }}</p>
            </div>
        </div>
    </div>

    <!-- Indirizzo -->
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Indirizzo</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Via</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->address->street }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Città</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->address->city }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Provincia</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->address->province }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">CAP</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->address->postal_code }}</p>
            </div>
        </div>
    </div>

    <!-- Informazioni Mediche -->
    <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informazioni Mediche</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Medico di Base</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->medical_info->primary_doctor }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gruppo Sanguigno</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->medical_info->blood_type }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Allergie</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->medical_info->allergies ?? 'Nessuna' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Patologie Croniche</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->medical_info->chronic_conditions ?? 'Nessuna' }}</p>
            </div>
        </div>
    </div>

    <!-- Azioni -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('profile.edit') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
            Modifica Profilo
        </a>

        <a href="{{ route('profile.password') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Cambia Password
        </a>
    </div>
</div>
