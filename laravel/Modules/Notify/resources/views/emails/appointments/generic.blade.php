<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('notify::appointment_email.sections.generic.title') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4A90E2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .appointment-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #4A90E2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('notify::appointment_email.sections.generic.title') }}</h1>
    </div>
    
    <div class="content">
        <p>{{ __('notify::appointment_email.common.greeting.label', ['name' => $patient->full_name]) }}</p>
        
        @if(isset($additionalData['message']))
            <p>{{ $additionalData['message'] }}</p>
        @else
            <p>{{ __('notify::appointment_email.generic.default.message') }}</p>
        @endif
        
        <div class="appointment-details">
            <h3>{{ __('notify::appointment_email.common.details.title') }}:</h3>
            <p><strong>{{ __('notify::appointment_email.fields.date.label') }}:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.time.label') }}:</strong> {{ $appointment->starts_at->format('H:i') }} - {{ $appointment->ends_at->format('H:i') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.type.label') }}:</strong> {{ $appointment->getTypeText() }}</p>
            @if ($appointment->dentist)
                <p><strong>{{ __('notify::appointment_email.fields.doctor.label') }}:</strong> {{ $appointment->dentist->title }} {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}</p>
            @endif
            @if ($appointment->location)
                <p><strong>{{ __('notify::appointment_email.fields.location.label') }}:</strong> {{ $appointment->location }}</p>
            @endif
            @if ($appointment->notes)
                <p><strong>{{ __('notify::appointment_email.fields.notes.label') }}:</strong> {{ $appointment->notes }}</p>
            @endif
        </div>
        
        @if(isset($additionalData['additional_message']))
            <p>{{ $additionalData['additional_message'] }}</p>
        @endif
        
        <p>{{ __('notify::appointment_email.generic.contact_notice.description') }}</p>
        
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">{{ __('notify::appointment_email.common.view_button.label') }}</a>
        
        <p>{{ __('notify::appointment_email.common.regards.label') }}<br>
        {{ __('notify::appointment_email.common.team.label') }}</p>
    </div>
    
    <div class="footer">
        <p>{{ __('notify::appointment_email.common.auto_generated.description') }}</p>
        <p>© {{ date('Y') }} - {{ __('notify::appointment_email.common.rights_reserved.label') }}</p>
    </div>
</body>
</html>
