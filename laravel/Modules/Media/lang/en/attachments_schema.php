<?php

declare(strict_types=1);

return [
    'fields' => [
        'invoice' => [
            'label' => 'Invoice',
            'placeholder' => 'Upload invoice',
            'helper_text' => 'Upload your invoice in PDF or image format',
            'description' => 'Billing document',
            'validation' => [
                'required' => 'Invoice upload is required',
                'mimes' => 'File must be a PDF document or image',
                'max' => 'Maximum file size is 10MB',
            ],
        ],
        'prescription' => [
            'label' => 'Medical Prescription',
            'placeholder' => 'Upload prescription',
            'helper_text' => 'Upload your medical prescription',
            'description' => 'Medical prescription for medications or exams',
            'validation' => [
                'required' => 'Medical prescription is required',
                'mimes' => 'Supported formats: PDF, JPG, PNG',
                'max' => 'Maximum size: 10MB',
            ],
        ],
        'medical_report' => [
            'label' => 'Medical Report',
            'placeholder' => 'Upload medical report',
            'helper_text' => 'Upload your test results or medical report',
            'description' => 'Medical document with diagnosis and prescriptions',
            'validation' => [
                'mimes' => 'Supported formats: PDF, JPG, PNG',
                'max' => 'Maximum size: 10MB',
            ],
        ],
        'certificate' => [
            'label' => 'Certificate',
            'placeholder' => 'Upload certificate',
            'helper_text' => 'Supported formats: PDF, JPG, PNG',
            'description' => 'Medical certificate or healthcare documentation',
            'validation' => [
                'mimes' => 'Supported formats: PDF, JPG, PNG',
                'max' => 'Maximum size: 10MB',
            ],
        ],
        'consent_form' => [
            'label' => 'Consent Form',
            'placeholder' => 'Upload consent form',
            'helper_text' => 'Signed informed consent form',
            'description' => 'Informed consent form signed by the patient',
            'validation' => [
                'mimes' => 'Supported formats: PDF, DOC, DOCX',
                'max' => 'Maximum size: 10MB',
            ],
        ],
        'xray_image' => [
            'label' => 'X-Ray Image',
            'placeholder' => 'Upload X-ray image',
            'helper_text' => 'Diagnostic images and X-rays',
            'description' => 'X-ray or diagnostic image',
            'validation' => [
                'mimes' => 'Supported formats: JPG, PNG, DICOM',
                'max' => 'Maximum size: 20MB',
            ],
        ],
        'treatment_plan' => [
            'label' => 'Treatment Plan',
            'placeholder' => 'Upload treatment plan',
            'helper_text' => 'Personalized therapeutic plan',
            'description' => 'Personalized treatment plan for the patient',
            'validation' => [
                'mimes' => 'Supported formats: PDF, DOC, DOCX',
                'max' => 'Maximum size: 10MB',
            ],
        ],
        'medical_history' => [
            'label' => 'Medical History',
            'placeholder' => 'Upload medical history',
            'helper_text' => 'Patient healthcare documentation',
            'description' => 'Patient medical history documentation',
            'validation' => [
                'mimes' => 'Supported formats: PDF, DOC, DOCX',
                'max' => 'Maximum size: 10MB',
            ],
        ],
    ],
    'validation' => [
        'file_required' => 'File is required',
        'file_type_invalid' => 'Unsupported file type',
        'file_size_exceeded' => 'File size too large',
        'file_corrupted' => 'File appears to be corrupted',
    ],
    'messages' => [
        'upload_success' => 'File uploaded successfully',
        'upload_error' => 'Error uploading file',
        'delete_success' => 'File deleted successfully',
        'delete_error' => 'Error deleting file',
    ],
];
