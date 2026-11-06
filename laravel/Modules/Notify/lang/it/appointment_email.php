<?php

declare(strict_types=1);

return [
    'common' => [
        'greeting' => [
            'label' => 'Gentile :name,',
        ],
        'details' => [
            'title' => 'Dettagli dell\'appuntamento',
        ],
        'status' => [
            'description' => 'La informiamo che il Suo appuntamento è stato :status.',
        ],
        'regards' => [
            'label' => 'Cordiali saluti,',
        ],
        'team' => [
            'label' => 'Il Team di il progetto',
        ],
        'auto_generated' => [
            'description' => 'Questa email è stata inviata automaticamente. Si prega di non rispondere a questo messaggio.',
        ],
        'rights_reserved' => [
            'label' => 'Tutti i diritti riservati',
        ],
        'view_button' => [
            'label' => 'Visualizza Appuntamento',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Data',
        ],
        'time' => [
            'label' => 'Orario',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'doctor' => [
            'label' => 'Medico',
        ],
        'location' => [
            'label' => 'Sede',
        ],
        'notes' => [
            'label' => 'Note',
        ],
        'cancellation_reason' => [
            'label' => 'Motivo della cancellazione',
        ],
        'rescheduling_reason' => [
            'label' => 'Motivo della riprogrammazione',
        ],
    ],
    'sections' => [
        'reminder' => [
            'title' => 'Promemoria Appuntamento',
            'description' => 'Le ricordiamo che il Suo appuntamento presso la nostra struttura è previsto per :when.',
        ],
        'confirmed' => [
            'title' => 'Conferma Appuntamento',
            'description' => 'Con la presente confermiamo il Suo appuntamento presso la nostra struttura.',
        ],
        'cancelled' => [
            'title' => 'Cancellazione Appuntamento',
        ],
        'rescheduled' => [
            'title' => 'Modifica Appuntamento',
        ],
        'generic' => [
            'title' => 'Notifica Appuntamento',
        ],
    ],
    'reminder' => [
        'tomorrow' => [
            'label' => 'domani',
        ],
        'countdown' => [
            'description' => 'Manca solo 1 giorno al Suo appuntamento!',
        ],
        'arrive_early' => [
            'description' => 'Si prega di presentarsi 15 minuti prima dell\'orario fissato e di portare con sé:',
        ],
        'bring' => [
            'id' => 'Documento d\'identità valido',
            'health_card' => 'Tessera sanitaria',
            'reports' => 'Eventuali referti o esami precedenti',
            'medications' => 'Lista dei farmaci che sta assumendo',
        ],
        'cancel_notice' => [
            'description' => 'Se non dovesse essere in grado di partecipare all\'appuntamento, La preghiamo di contattarci il prima possibile per riprogrammarlo.',
        ],
        'manage_button' => [
            'label' => 'Gestisci Appuntamento',
        ],
    ],
    'confirmed' => [
        'arrive_early' => [
            'description' => 'La preghiamo di presentarsi 15 minuti prima dell\'orario fissato per completare eventuali procedure amministrative.',
        ],
        'cancel_notice' => [
            'description' => 'Se non dovesse essere in grado di partecipare all\'appuntamento, La preghiamo di contattarci con almeno 24 ore di anticipo per riprogrammarlo.',
        ],
        'questions' => [
            'description' => 'Per eventuali domande o chiarimenti, non esiti a contattarci.',
        ],
    ],
    'cancelled' => [
        'status' => [
            'label' => 'cancellato',
        ],
        'details' => [
            'title' => 'Dettagli dell\'appuntamento cancellato',
        ],
        'rebook' => [
            'description' => 'Se desidera prenotare un nuovo appuntamento, può farlo tramite il nostro sistema di prenotazione online o contattando direttamente la nostra segreteria.',
        ],
        'new_button' => [
            'label' => 'Prenota Nuovo Appuntamento',
        ],
    ],
    'rescheduled' => [
        'status' => [
            'label' => 'riprogrammato',
        ],
        'previous_details' => [
            'title' => 'Dettagli precedenti',
        ],
        'new_details' => [
            'title' => 'Nuovi dettagli dell\'appuntamento',
        ],
        'incompatible_notice' => [
            'description' => 'Se il nuovo orario non fosse compatibile con i Suoi impegni, La preghiamo di contattarci al più presto per trovare un\'alternativa.',
        ],
    ],
    'generic' => [
        'default' => [
            'message' => 'Desideriamo informarLa riguardo al Suo appuntamento presso la nostra struttura.',
        ],
        'contact_notice' => [
            'description' => 'Per qualsiasi informazione o necessità, non esiti a contattarci.',
        ],
    ],
];
