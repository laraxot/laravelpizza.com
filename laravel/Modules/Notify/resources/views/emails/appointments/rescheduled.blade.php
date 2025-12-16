<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Appuntamento</title>
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
        <h1>Modifica Appuntamento</h1>
    </div>
    
    <div class="content">
        <p>Gentile {{ $patient->full_name }},</p>
        
        <p>La informiamo che il Suo appuntamento è stato <span class="change">riprogrammato</span>.</p>
        
        @if(isset($additionalData['previous_appointment']))
            <div class="previous-details">
                <h3>Dettagli precedenti:</h3>
                <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['date'])->format('d/m/Y') }}</p>
                <p><strong>Orario:</strong> {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['starts_at'])->format('H:i') }} - {{ \Carbon\Carbon::parse($additionalData['previous_appointment']['ends_at'])->format('H:i') }}</p>
                @if(isset($additionalData['previous_appointment']['dentist']))
                    <p><strong>Medico:</strong> {{ $additionalData['previous_appointment']['dentist'] }}</p>
                @endif
            </div>
        @endif
        
        <div class="new-details">
            <h3>Nuovi dettagli dell'appuntamento:</h3>
            <p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
            <p><strong>Orario:</strong> {{ $appointment->starts_at->format('H:i') }} - {{ $appointment->ends_at->format('H:i') }}</p>
            <p><strong>Tipo:</strong> {{ $appointment->getTypeText() }}</p>
            @if ($appointment->dentist)
                <p><strong>Medico:</strong> {{ $appointment->dentist->title }} {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}</p>
            @endif
            @if ($appointment->location)
                <p><strong>Sede:</strong> {{ $appointment->location }}</p>
            @endif
        </div>
        
        @if(isset($additionalData['rescheduling_reason']) && $additionalData['rescheduling_reason'])
            <p><strong>Motivo della riprogrammazione:</strong> {{ $additionalData['rescheduling_reason'] }}</p>
        @endif
        
        <p class="important">Se il nuovo orario non fosse compatibile con i Suoi impegni, La preghiamo di contattarci al più presto per trovare un'alternativa.</p>
        
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">Visualizza Appuntamento</a>
        
        <p>Cordiali saluti,<br>
        Il Team di il progetto</p>
    </div>
    
    <div class="footer">
        <p>Questa email è stata inviata automaticamente. Si prega di non rispondere a questo messaggio.</p>
        <p>© {{ date('Y') }} - Tutti i diritti riservati</p>
    </div>
</body>
</html>
