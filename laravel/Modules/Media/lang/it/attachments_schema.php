<?php

declare(strict_types=1);

return [
    'fields' => [
        'invoice' => [
            'label' => 'Fattura',
            'placeholder' => 'Carica la fattura',
            'helper_text' => 'Carica la fattura in formato PDF o immagine',
            'description' => 'Documento di fatturazione',
            'validation' => [
                'required' => 'Il caricamento della fattura è obbligatorio',
                'mimes' => 'Il file deve essere un documento PDF o un\'immagine',
                'max' => 'La dimensione massima del file è 10MB',
            ],
        ],
        'prescription' => [
            'label' => 'Ricetta Medica',
            'placeholder' => 'Carica la ricetta medica',
            'helper_text' => 'Carica la prescrizione del medico',
            'description' => 'Prescrizione medica per farmaci o esami',
            'validation' => [
                'required' => 'La ricetta medica è obbligatoria',
                'mimes' => 'Formati supportati: PDF, JPG, PNG',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'medical_report' => [
            'label' => 'Referto Medico',
            'placeholder' => 'Carica il referto medico',
            'helper_text' => 'Carica il referto o l\'esito degli esami',
            'description' => 'Documento medico con diagnosi e prescrizioni',
            'validation' => [
                'mimes' => 'Formati supportati: PDF, JPG, PNG',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'certificate' => [
            'label' => 'Certificato1',
            'placeholder' => 'Carica il certificato',
            'helper_text' => 'Formati supportati: PDF, JPG, PNG',
            'description' => 'Certificato medico o documentazione sanitaria',
            'validation' => [
                'mimes' => 'Formati supportati: PDF, JPG, PNG',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'consent_form' => [
            'label' => 'Modulo di Consenso',
            'placeholder' => 'Carica il modulo di consenso',
            'helper_text' => 'Modulo di consenso informato firmato',
            'description' => 'Modulo di consenso informato firmato dal paziente',
            'validation' => [
                'mimes' => 'Formati supportati: PDF, DOC, DOCX',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'xray_image' => [
            'label' => 'Immagine Radiografica',
            'placeholder' => 'Carica l\'immagine radiografica',
            'helper_text' => 'Immagini diagnostiche e radiografie',
            'description' => 'Immagine radiografica o diagnostica',
            'validation' => [
                'mimes' => 'Formati supportati: JPG, PNG, DICOM',
                'max' => 'Dimensione massima: 20MB',
            ],
        ],
        'treatment_plan' => [
            'label' => 'Piano di Trattamento',
            'placeholder' => 'Carica il piano di trattamento',
            'helper_text' => 'Piano terapeutico personalizzato',
            'description' => 'Piano di trattamento personalizzato per il paziente',
            'validation' => [
                'mimes' => 'Formati supportati: PDF, DOC, DOCX',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'medical_history' => [
            'label' => 'Storia Clinica',
            'placeholder' => 'Carica la storia clinica',
            'helper_text' => 'Documentazione sanitaria del paziente',
            'description' => 'Documentazione della storia clinica del paziente',
            'validation' => [
                'mimes' => 'Formati supportati: PDF, DOC, DOCX',
                'max' => 'Dimensione massima: 10MB',
            ],
        ],
        'doctor_certificate' => [
            'description' => 'doctor_certificate',
            'helper_text' => 'doctor_certificate1',
            'label' => 'doctor_certificate',
            'placeholder' => 'doctor_certificate',
        ],
    ],
    'validation' => [
        'file_required' => 'Il file è obbligatorio',
        'file_type_invalid' => 'Tipo di file non supportato',
        'file_size_exceeded' => 'Dimensione del file troppo grande',
        'file_corrupted' => 'Il file sembra essere corrotto',
    ],
    'messages' => [
        'upload_success' => 'File caricato con successo',
        'upload_error' => 'Errore durante il caricamento del file',
        'delete_success' => 'File eliminato con successo',
        'delete_error' => 'Errore durante l\'eliminazione del file',
    ],
];
