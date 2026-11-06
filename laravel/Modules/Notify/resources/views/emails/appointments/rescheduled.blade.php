<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('notify::appointment_email.sections.rescheduled.title') }}</title>
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
            background-color: #9C27B0;
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
        .previous-details {
            background-color: #fff1f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 3px solid #E24A4A;
        }
        .new-details {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 3px solid #4A90E2;
        }
        .button {
            display: inline-block;
            background-color: #9C27B0;
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
        .change {
            font-weight: bold;
            color: #4A90E2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('notify::appointment_email.sections.rescheduled.title') }}</h1>
    </div>
    
    <div class="content">
        <p>{{ __('notify::appointment_email.common.greeting.label', ['name' => $patient->full_name]) }}</p>
        
        <p>{!! __('notify::appointment_email.common.status.description', ['status' => '<span class="change">'.e(__('notify::appointment_email.rescheduled.status.label')).'</span>']) !!}</p>
        
        @if(isset($additionalData['previous_appointment']))
            <div class="previous-details">
                <h3>{{ __('notify::appointment_email.rescheduled.previous_details.title') }}:</h3>
                <p><strong>{{ __('notify::appointment_email.fields.date.label') }}:</strong> {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['date'])->format('d/m/Y') }}</p>
                <p><strong>{{ __('notify::appointment_email.fields.time.label') }}:</strong> {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['starts_at'])->format('H:i') }} - {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['ends_at'])->format('H:i') }}</p>
                @if(isset($additionalData['previous_appointment']['dentist']))
                    <p><strong>{{ __('notify::appointment_email.fields.doctor.label') }}:</strong> {{ $additionalData['previous_appointment']['dentist'] }}</p>
                @endif
            </div>
        @endif
        
        <div class="new-details">
            <h3>{{ __('notify::appointment_email.rescheduled.new_details.title') }}:</h3>
            <p><strong>{{ __('notify::appointment_email.fields.date.label') }}:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.time.label') }}:</strong> {{ $appointment->starts_at->format('H:i') }} - {{ $appointment->ends_at->format('H:i') }}</p>
            <p><strong>{{ __('notify::appointment_email.fields.type.label') }}:</strong> {{ $appointment->getTypeText() }}</p>
            @if ($appointment->dentist)
                <p><strong>{{ __('notify::appointment_email.fields.doctor.label') }}:</strong> {{ $appointment->dentist->title }} {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}</p>
            @endif
            @if ($appointment->location)
                <p><strong>{{ __('notify::appointment_email.fields.location.label') }}:</strong> {{ $appointment->location }}</p>
            @endif
        </div>
        
        @if(isset($additionalData['rescheduling_reason']) && $additionalData['rescheduling_reason'])
            <p><strong>{{ __('notify::appointment_email.fields.rescheduling_reason.label') }}:</strong> {{ $additionalData['rescheduling_reason'] }}</p>
        @endif
        
        <p class="important">{{ __('notify::appointment_email.rescheduled.incompatible_notice.description') }}</p>
        
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
