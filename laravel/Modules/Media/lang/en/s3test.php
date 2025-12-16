<?php

declare(strict_types=1);

return [
    'actions' => [
        'testCredentials' => [
            'label' => 'Test AWS Credentials',
            'tooltip' => 'Verify configured AWS credentials',
        ],
        'testS3Connection' => [
            'label' => 'Test S3 Connection',
            'tooltip' => 'Verify S3 bucket connection',
        ],
        'testPermissions' => [
            'label' => 'Test S3 Permissions',
            'tooltip' => 'Verify S3 operation permissions',
        ],
        'testBucketPolicy' => [
            'label' => 'Test Bucket Policy',
            'tooltip' => 'Verify S3 bucket policy',
        ],
        'testCloudFront' => [
            'label' => 'Test CloudFront',
            'tooltip' => 'Verify CloudFront configuration',
        ],
        'testFileOperations' => [
            'label' => 'Test File Operations',
            'tooltip' => 'Test file upload, download and deletion',
        ],
        'debugConfig' => [
            'label' => 'Debug Configuration',
            'tooltip' => 'Show current AWS configuration',
        ],
        'clearResults' => [
            'label' => 'Clear Results',
            'tooltip' => 'Clear all test results',
        ],
        'sendEmail' => [
            'label' => 'Send Test Email',
            'tooltip' => 'Send email with attachment for testing',
        ],
    ],
    'notifications' => [
        'credentials_tested' => 'AWS credentials tested',
        'bucket_policy_tested' => 'Bucket policy tested',
        'file_operations_tested' => 'File operations tested',
        'config_debugged' => 'Configuration analyzed',
        'results_cleared' => 'Results cleared',
        's3_test_successful' => 'S3 test completed successfully',
        'operations_completed' => 'All operations completed',
        'test_failed' => 'Test failed',
        'no_attachment' => 'No attachment selected',
        'upload_file_first' => 'Upload a file first to test',
        'email_sent' => 'Test email sent',
        'email_with_attachment' => 'Email with attachment sent successfully',
        'email_failed' => 'Email sending failed',
    ],
    'debug' => [
        'run_tests_message' => 'Run tests to see results here...',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'Attachment',
            'placeholder' => 'Select a file to attach',
            'helper_text' => 'Test file to verify S3 operations',
        ],
        'debug_output' => [
            'label' => 'Debug Output',
            'placeholder' => 'Test results will appear here',
            'helper_text' => 'Detailed output of executed tests',
        ],
    ],
    'messages' => [
        'test_successful' => 'Test completed successfully',
        'test_failed' => 'Test failed',
        'configuration_valid' => 'Valid configuration',
        'configuration_invalid' => 'Invalid configuration',
        'permissions_ok' => 'Permissions verified',
        'permissions_failed' => 'Insufficient permissions',
        'connection_ok' => 'Connection established',
        'connection_failed' => 'Connection failed',
    ],
    'errors' => [
        'aws_credentials_invalid' => 'Invalid AWS credentials',
        's3_bucket_inaccessible' => 'S3 bucket not accessible',
        'cloudfront_config_incomplete' => 'Incomplete CloudFront configuration',
        'file_operations_failed' => 'File operations failed',
        'permissions_insufficient' => 'Insufficient permissions',
        'unknown_error' => 'Unknown error',
    ],
    'solutions' => [
        'check_credentials' => 'Check AWS credentials in .env',
        'check_bucket_name' => 'Check S3 bucket name',
        'check_region' => 'Check configured AWS region',
        'check_permissions' => 'Check IAM permissions for S3',
        'check_cloudfront_config' => 'Check CloudFront configuration',
        'contact_admin' => 'Contact system administrator',
    ],
];
