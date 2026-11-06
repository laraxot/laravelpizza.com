<?php

declare(strict_types=1);
?>
@props(['title' => __('ui::blocks_patient_dashboard.header.title.title')])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Prossimo Appuntamento -->
        <div class="bg-indigo-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-indigo-900 mb-2">{{ __('ui::blocks_patient_dashboard.next_appointment.heading.title') }}</h3>
            @if($nextAppointment)
                <div class="space-y-2">
                    <p class="text-indigo-700">
                        <span class="font-medium">{{ __('ui::blocks_patient_dashboard.next_appointment.date.label') }}</span> 
                        {{ $nextAppointment->date->format('d/m/Y') }}
                    </p>
                    <p class="text-indigo-700">
                        <span class="font-medium">{{ __('ui::blocks_patient_dashboard.next_appointment.time.label') }}</span> 
                        {{ $nextAppointment->time }}
                    </p>
                    <p class="text-indigo-700">
                        <span class="font-medium">{{ __('ui::blocks_patient_dashboard.next_appointment.type.label') }}</span> 
                        {{ $nextAppointment->type }}
                    </p>
                </div>
                <a href="{{ route('appointments.show', $nextAppointment->id) }}" 
                   class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                    {{ __('ui::blocks_patient_dashboard.next_appointment.details.label') }} →
                </a>
            @else
                <p class="text-indigo-700">{{ __('ui::blocks_patient_dashboard.next_appointment.none.message') }}</p>
                <a href="{{ route('appointments.create') }}" 
                   class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                    {{ __('ui::blocks_patient_dashboard.next_appointment.book.label') }} →
                </a>
            @endif
        </div>
        
        <!-- Documenti Recenti -->
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-green-900 mb-2">{{ __('ui::blocks_patient_dashboard.recent_documents.heading.title') }}</h3>
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
                    {{ __('ui::blocks_patient_dashboard.recent_documents.all.label') }} →
                </a>
            @else
                <p class="text-green-700">{{ __('ui::blocks_patient_dashboard.recent_documents.none.message') }}</p>
            @endif
        </div>
        
        <!-- Notifiche -->
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-yellow-900 mb-2">{{ __('ui::blocks_patient_dashboard.recent_notifications.heading.title') }}</h3>
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
                    {{ __('ui::blocks_patient_dashboard.recent_notifications.all.label') }} →
                </a>
            @else
                <p class="text-yellow-700">{{ __('ui::blocks_patient_dashboard.recent_notifications.none.message') }}</p>
            @endif
        </div>
    </div>
    
    <!-- Azioni Rapide -->
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">{{ __('ui::blocks_patient_dashboard.quick_actions.profile.label') }}</span>
        </a>
        <a href="{{ route('appointments.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">{{ __('ui::blocks_patient_dashboard.quick_actions.appointments.label') }}</span>
        </a>
        <a href="{{ route('documents.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">{{ __('ui::blocks_patient_dashboard.quick_actions.documents.label') }}</span>
        </a>
        <a href="{{ route('notifications.index') }}" 
           class="flex items-center justify-center p-4 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            <span class="text-gray-700">{{ __('ui::blocks_patient_dashboard.quick_actions.notifications.label') }}</span>
        </a>
    </div>
</div>
