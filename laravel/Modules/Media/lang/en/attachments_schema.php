<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'invoice' => 
    array (
      'label' => 'Invoice',
      'placeholder' => 'Upload invoice',
      'helper_text' => 'Upload your invoice in PDF or image format',
      'description' => 'Billing document',
      'validation' => 
      array (
        'required' => 'Invoice upload is required',
        'mimes' => 'File must be a PDF document or image',
        'max' => 'Maximum file size is 10MB',
      ),
      'tooltip' => '',
    ),
    'prescription' => 
    array (
      'label' => 'Medical Prescription',
      'placeholder' => 'Upload prescription',
      'helper_text' => 'Upload your medical prescription',
      'description' => 'Medical prescription for medications or exams',
      'validation' => 
      array (
        'required' => 'Medical prescription is required',
        'mimes' => 'Supported formats: PDF, JPG, PNG',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
    'medical_report' => 
    array (
      'label' => 'Medical Report',
      'placeholder' => 'Upload medical report',
      'helper_text' => 'Upload your test results or medical report',
      'description' => 'Medical document with diagnosis and prescriptions',
      'validation' => 
      array (
        'mimes' => 'Supported formats: PDF, JPG, PNG',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
    'certificate' => 
    array (
      'label' => 'Certificate',
      'placeholder' => 'Upload certificate',
      'helper_text' => 'Supported formats: PDF, JPG, PNG',
      'description' => 'Medical certificate or healthcare documentation',
      'validation' => 
      array (
        'mimes' => 'Supported formats: PDF, JPG, PNG',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
    'consent_form' => 
    array (
      'label' => 'Consent Form',
      'placeholder' => 'Upload consent form',
      'helper_text' => 'Signed informed consent form',
      'description' => 'Informed consent form signed by the patient',
      'validation' => 
      array (
        'mimes' => 'Supported formats: PDF, DOC, DOCX',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
    'xray_image' => 
    array (
      'label' => 'X-Ray Image',
      'placeholder' => 'Upload X-ray image',
      'helper_text' => 'Diagnostic images and X-rays',
      'description' => 'X-ray or diagnostic image',
      'validation' => 
      array (
        'mimes' => 'Supported formats: JPG, PNG, DICOM',
        'max' => 'Maximum size: 20MB',
      ),
      'tooltip' => '',
    ),
    'treatment_plan' => 
    array (
      'label' => 'Treatment Plan',
      'placeholder' => 'Upload treatment plan',
      'helper_text' => 'Personalized therapeutic plan',
      'description' => 'Personalized treatment plan for the patient',
      'validation' => 
      array (
        'mimes' => 'Supported formats: PDF, DOC, DOCX',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
    'medical_history' => 
    array (
      'label' => 'Medical History',
      'placeholder' => 'Upload medical history',
      'helper_text' => 'Patient healthcare documentation',
      'description' => 'Patient medical history documentation',
      'validation' => 
      array (
        'mimes' => 'Supported formats: PDF, DOC, DOCX',
        'max' => 'Maximum size: 10MB',
      ),
      'tooltip' => '',
    ),
  ),
  'validation' => 
  array (
    'file_required' => 'File is required',
    'file_type_invalid' => 'Unsupported file type',
    'file_size_exceeded' => 'File size too large',
    'file_corrupted' => 'File appears to be corrupted',
  ),
  'messages' => 
  array (
    'upload_success' => 'File uploaded successfully',
    'upload_error' => 'Error uploading file',
    'delete_success' => 'File deleted successfully',
    'delete_error' => 'Error deleting file',
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);
