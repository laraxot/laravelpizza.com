<?php

declare(strict_types=1);

return array (
  'page' => 
  array (
    'title' => 'AWS Diagnostic Test',
    'heading' => 'AWS Configuration Diagnostics',
    'description' => 'Page to test and diagnose complete AWS configuration',
  ),
  'fields' => 
  array (
    'cloudfront_url' => 
    array (
      'label' => 'CloudFront Distribution URL',
      'placeholder' => 'Enter CloudFront URL',
      'helper_text' => 'URL of the configured CloudFront distribution',
      'tooltip' => '',
      'description' => '',
    ),
    'iam_user' => 
    array (
      'label' => 'IAM User/Role',
      'placeholder' => 'Enter IAM user',
      'helper_text' => 'IAM user or role used for AWS access',
      'tooltip' => '',
      'description' => '',
    ),
    'aws_config' => 
    array (
      'label' => 'AWS Configuration',
      'placeholder' => 'Current AWS configuration',
      'helper_text' => 'Overview of current AWS configuration',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'test_s3_connection' => 
    array (
      'label' => 'Test Basic Connection',
      'tooltip' => 'Test basic connection to S3 bucket',
      'success' => 'S3 connection tested successfully',
      'error' => 'Error testing S3 connection',
    ),
    'test_s3_permissions' => 
    array (
      'label' => 'Test Permissions',
      'tooltip' => 'Test S3 permissions (ListBucket, PutObject, GetObject, DeleteObject)',
      'success' => 'S3 permissions tested successfully',
      'error' => 'Error testing S3 permissions',
    ),
    'test_file_operations' => 
    array (
      'label' => 'Test File Operations',
      'tooltip' => 'Test S3 file operations (upload, download, delete)',
      'success' => 'File operations tested successfully',
      'error' => 'Error testing file operations',
    ),
    'test_cloudfront_config' => 
    array (
      'label' => 'Test Configuration',
      'tooltip' => 'Test CloudFront configuration',
      'success' => 'CloudFront configuration tested successfully',
      'error' => 'Error testing CloudFront configuration',
    ),
    'test_signed_urls' => 
    array (
      'label' => 'Test Signed URLs',
      'tooltip' => 'Test CloudFront signed URL generation',
      'success' => 'Signed URLs tested successfully',
      'error' => 'Error testing signed URLs',
    ),
    'test_iam_credentials' => 
    array (
      'label' => 'Test Credentials',
      'tooltip' => 'Test IAM credentials',
      'success' => 'IAM credentials tested successfully',
      'error' => 'Error testing IAM credentials',
    ),
    'test_iam_policies' => 
    array (
      'label' => 'Test Policies',
      'tooltip' => 'Test IAM policies',
      'success' => 'IAM policies tested successfully',
      'error' => 'Error testing IAM policies',
    ),
    'run_full_diagnostic' => 
    array (
      'label' => 'Run Full Diagnostic',
      'tooltip' => 'Run all AWS diagnostic tests',
      'success' => 'Full diagnostic completed successfully',
      'error' => 'Error during full diagnostic',
    ),
  ),
  'sections' => 
  array (
    's3_connection_test' => 
    array (
      'label' => 'S3 Connection Test',
      'description' => 'Verify S3 bucket access and permissions',
    ),
    'cloudfront_test' => 
    array (
      'label' => 'CloudFront Test',
      'description' => 'Verify CloudFront configuration and signed URLs',
    ),
    'iam_permissions_test' => 
    array (
      'label' => 'IAM Permissions Test',
      'description' => 'Verify IAM credentials and policies',
    ),
    'complete_diagnostic' => 
    array (
      'label' => 'Complete Diagnostic',
      'description' => 'Run all AWS diagnostic tests',
    ),
  ),
  'tabs' => 
  array (
    'tests' => 
    array (
      'label' => 'Tests',
    ),
    's3' => 
    array (
      'label' => 'S3',
    ),
    'cloudfront' => 
    array (
      'label' => 'CloudFront',
    ),
    'iam' => 
    array (
      'label' => 'IAM',
    ),
    'diagnostics' => 
    array (
      'label' => 'Diagnostics',
    ),
  ),
  'notifications' => 
  array (
    's3_connection_successful' => 'S3 Connection Successful',
    's3_connection_failed' => 'S3 Connection Failed',
    'cloudfront_config_valid' => 'CloudFront Config Valid',
    'cloudfront_config_error' => 'CloudFront Config Error',
    'full_diagnostic_completed' => 'Full Diagnostic Completed',
  ),
  'test_results' => 
  array (
    'status_success' => 'success',
    'status_error' => 'error',
    'status_completed' => 'completed',
    'successfully_connected' => 'Successfully connected to S3 bucket',
    'cloudfront_config_valid' => 'CloudFront configuration valid',
    'cloudfront_config_error' => 'CloudFront configuration error',
    'full_diagnostic_completed' => 'Full diagnostic completed',
    'check_cloudfront_settings' => 'Check CloudFront settings in config',
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
);
