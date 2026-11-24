<?php

declare(strict_types=1);

return [
    'sections' => [
        'cancelled' => [
            'title' => 'Cancelación de la cita',
        ],
        'confirmed' => [
            'title' => 'Confirmación de la cita',
            'description' => 'Nos complace confirmar su cita en nuestras instalaciones.',
        ],
        'generic' => [
            'title' => 'Notificación de la cita',
        ],
        'reminder' => [
            'title' => 'Recordatorio de la cita',
            'description' => 'Le recordamos que su cita en nuestras instalaciones está prevista para :when.',
        ],
        'rescheduled' => [
            'title' => 'Modificación de la cita',
        ],
    ],
    'cancelled' => [
        'status' => [
            'label' => 'cancelada',
        ],
        'details' => [
            'title' => 'Detalles de la cita cancelada',
        ],
        'rebook' => [
            'description' => 'Si desea reservar una nueva cita, puede hacerlo a través de nuestro sistema de reservas en línea o poniéndose en contacto directamente con nuestra secretaría.',
        ],
        'new_button' => [
            'label' => 'Reservar nueva cita',
        ],
    ],
    'common' => [
        'greeting' => [
            'label' => 'Estimado/a :name,',
        ],
        'status' => [
            'description' => 'Le informamos de que su cita ha sido :status.',
        ],
        'regards' => [
            'label' => 'Atentamente,',
        ],
        'team' => [
            'label' => 'El equipo del proyecto',
        ],
        'auto_generated' => [
            'description' => 'Este correo electrónico se ha enviado automáticamente. Por favor, no responda a este mensaje.',
        ],
        'rights_reserved' => [
            'label' => 'Todos los derechos reservados',
        ],
        'details' => [
            'title' => 'Detalles de la cita',
        ],
        'view_button' => [
            'label' => 'Ver cita',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Fecha',
        ],
        'time' => [
            'label' => 'Hora',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'doctor' => [
            'label' => 'Médico',
        ],
        'cancellation_reason' => [
            'label' => 'Motivo de la cancelación',
        ],
        'location' => [
            'label' => 'Sede',
        ],
        'notes' => [
            'label' => 'Notas',
        ],
        'rescheduling_reason' => [
            'label' => 'Motivo de la reprogramación',
        ],
    ],
    'confirmed' => [
        'arrive_early' => [
            'description' => 'Le rogamos que se presente 15 minutos antes de la hora fijada para completar los trámites administrativos necesarios.',
        ],
        'cancel_notice' => [
            'description' => 'Si no puede asistir a la cita, le rogamos que se ponga en contacto con nosotros con al menos 24 horas de antelación para reprogramarla.',
        ],
        'questions' => [
            'description' => 'Si tiene alguna pregunta o necesita alguna aclaración, no dude en ponerse en contacto con nosotros.',
        ],
    ],
    'generic' => [
        'default' => [
            'message' => 'Deseamos informarle sobre su cita en nuestras instalaciones.',
        ],
        'contact_notice' => [
            'description' => 'Para cualquier información o necesidad, no dude en ponerse en contacto con nosotros.',
        ],
    ],
    'reminder' => [
        'tomorrow' => [
            'label' => 'mañana',
        ],
        'countdown' => [
            'description' => '¡Solo falta 1 día para su cita!',
        ],
        'arrive_early' => [
            'description' => 'Se ruega presentarse 15 minutos antes de la hora fijada y traer consigo:',
        ],
        'bring' => [
            'id' => 'Un documento de identidad válido',
            'health_card' => 'Tarjeta sanitaria',
            'reports' => 'Informes o resultados de pruebas anteriores, si los hay',
            'medications' => 'Una lista de los medicamentos que está tomando',
        ],
        'cancel_notice' => [
            'description' => 'Si no puede asistir a la cita, le rogamos que se ponga en contacto con nosotros lo antes posible para reprogramarla.',
        ],
        'manage_button' => [
            'label' => 'Gestionar cita',
        ],
    ],
    'rescheduled' => [
        'status' => [
            'label' => 'reprogramada',
        ],
        'previous_details' => [
            'title' => 'Detalles anteriores',
        ],
        'new_details' => [
            'title' => 'Nuevos detalles de la cita',
        ],
        'incompatible_notice' => [
            'description' => 'Si la nueva hora no se ajusta a su agenda, le rogamos que se ponga en contacto con nosotros lo antes posible para encontrar una alternativa.',
        ],
    ],
];
