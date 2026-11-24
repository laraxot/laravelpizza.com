<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('notify::appointment_email.sections.reminder.title') }}</title>
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
            background-color: #F2A94A;
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
            background-color: #F2A94A;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .important {
            font-weight: bold;
            color: #E24A4A;
        }
        .countdown {
            font-size: 18px;
            font-weight: bold;
            color: #F2A94A;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('notify::appointment_email.sections.reminder.title') }}</h1>
    </div>
    
    <div class="content">
        <p>{{ __('notify::appointment_email.common.greeting.label', ['name' => $patient->full_name]) }}</p>
        
        <p>{!! __('notify::appointment_email.sections.reminder.description', ['when' => '<strong>'.e(__('notify::appointment_email.reminder.tomorrow.label')).'</strong>']) !!}</p>
        
        <div class="countdown">
            {{ __('notify::appointment_email.reminder.countdown.description') }}
        </div>
        
        <div class="appointment-details">
            <h3>{{ __('notify::appointment_email.common.details.title') }}:</h3>
            <p><strong>{{ __('notify::appointment_email.fields.date.label') }}:</strong> {{ $appointment->starts_at->format('d/m/Y') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.time.label') }}:</strong> {{ $appointment->starts_at->format('H:i') }} - {{ $appointment->ends_at->format('H:i') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.type.label') }}:</strong> {{ $appointment->getTypeText() }}</p>
            @if ($appointment->dentist)
                <p><strong>{{ __('notify::appointment_email.fields.doctor.label') }}:</strong> {{ $appointment->dentist->title }} {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}</p>
            @endif
            @if ($appointment->location)
                <p><strong>{{ __('notify::appointment_email.fields.location.label') }}:</strong> {{ $appointment->location }}</p>
            @endif
        </div>
        
        <p>{{ __('notify::appointment_email.reminder.arrive_early.description') }}</p>
        <ul>
            <li>{{ __('notify::appointment_email.reminder.bring.id') }}</li>
            <li>{{ __('notify::appointment_email.reminder.bring.health_card') }}</li>
            <li>{{ __('notify::appointment_email.reminder.bring.reports') }}</li>
            <li>{{ __('notify::appointment_email.reminder.bring.medications') }}</li>
        </ul>
        
        <p class="important">{{ __('notify::appointment_email.reminder.cancel_notice.description') }}</p>
        
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">{{ __('notify::appointment_email.reminder.manage_button.label') }}</a>
        
        <p>{{ __('notify::appointment_email.common.regards.label') }}<br>
        {{ __('notify::appointment_email.common.team.label') }}</p>
    </div>
    
    <div class="footer">
        <p>{{ __('notify::appointment_email.common.auto_generated.description') }}</p>
        <p>© {{ date('Y') }} - {{ __('notify::appointment_email.common.rights_reserved.label') }}</p>
    </div>
</body>
</html>
