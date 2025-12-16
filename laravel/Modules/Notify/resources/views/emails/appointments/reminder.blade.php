<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promemoria Appuntamento</title>
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
        <h1>Promemoria Appuntamento</h1>
    </div>
    
    <div class="content">
        <p>Gentile {{ $patient->full_name }},</p>
        
        <p>Le ricordiamo che il Suo appuntamento presso la nostra struttura è previsto per <strong>domani</strong>.</p>
        
        <div class="countdown">
            Manca solo 1 giorno al Suo appuntamento!
        </div>
        
        <div class="appointment-details">
            <h3>Dettagli dell'appuntamento:</h3>
            <p><strong>Data:</strong> {{ $appointment->starts_at->format('d/m/Y') }}</p>
            <p><strong>Orario:</strong> {{ $appointment->starts_at->format('H:i') }} - {{ $appointment->ends_at->format('H:i') }}</p>
            <p><strong>Tipo:</strong> {{ $appointment->getTypeText() }}</p>
            @if ($appointment->dentist)
                <p><strong>Medico:</strong> {{ $appointment->dentist->title }} {{ $appointment->dentist->first_name }} {{ $appointment->dentist->last_name }}</p>
            @endif
            @if ($appointment->location)
                <p><strong>Sede:</strong> {{ $appointment->location }}</p>
            @endif
        </div>
        
        <p>Si prega di presentarsi 15 minuti prima dell'orario fissato e di portare con sé:</p>
        <ul>
            <li>Documento d'identità valido</li>
            <li>Tessera sanitaria</li>
            <li>Eventuali referti o esami precedenti</li>
            <li>Lista dei farmaci che sta assumendo</li>
        </ul>
        
        <p class="important">Se non dovesse essere in grado di partecipare all'appuntamento, La preghiamo di contattarci il prima possibile per riprogrammarlo.</p>
        
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">Gestisci Appuntamento</a>
        
        <p>Cordiali saluti,<br>
        Il Team di il progetto</p>
    </div>
    
    <div class="footer">
        <p>Questa email è stata inviata automaticamente. Si prega di non rispondere a questo messaggio.</p>
        <p>© {{ date('Y') }} - Tutti i diritti riservati</p>
    </div>
</body>
</html>
