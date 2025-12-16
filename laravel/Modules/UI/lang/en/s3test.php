<?php

declare(strict_types=1);

return [
    'page' => [
        'title' => 'S3 and CloudFront Test',
        'heading' => 'AWS Configuration Test',
        'description' => 'Page to test S3 and CloudFront configuration',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'Test File',
            'placeholder' => 'Upload a file to test S3',
            'helper_text' => 'File will be uploaded to S3 to test configuration',
        ],
        'debug_output' => [
            'label' => 'Debug Results',
            'placeholder' => 'Test results will appear here',
            'helper_text' => 'Detailed output of AWS configuration tests',
        ],
    ],
    'actions' => [
        'testS3Connection' => [
            'label' => '🔍 Test S3 Connection',
            'tooltip' => 'Test connection to S3 bucket',
            'success' => 'S3 connection tested successfully',
            'error' => 'Error testing S3 connection',
        ],
        'testPermissions' => [
            'label' => '🔒 Test Permissions',
            'tooltip' => 'Test S3 permissions (ListBucket, PutObject, GetObject, DeleteObject)',
            'success' => 'S3 permissions tested successfully',
            'error' => 'Error testing S3 permissions',
        ],
        'testCloudFront' => [
            'label' => '☁️ Test CloudFront',
            'tooltip' => 'Test CloudFront configuration and signed URL generation',
            'success' => 'CloudFront tested successfully',
            'error' => 'Error testing CloudFront',
        ],
        'runAllTests' => [
            'label' => '🚀 Run All Tests',
            'tooltip' => 'Run all AWS configuration tests',
            'success' => 'All tests completed successfully',
            'error' => 'Error running tests',
        ],
        'sendEmail' => [
            'label' => '📧 Send Email',
            'tooltip' => 'Test email sending with S3 attachment',
            'success' => 'Email sent successfully',
            'error' => 'Error sending email',
        ],
    ],
    'notifications' => [
        's3_test_successful' => '✅ S3 and CloudFront test completed successfully!',
        'test_failed' => '❌ Test failed',
        'operations_completed' => 'All operations completed successfully',
        's3_connection_tested' => 'S3 Connection Tested',
        's3_permissions_tested' => 'S3 Permissions Tested',
        'cloudfront_tested' => 'CloudFront Tested',
        'credentials_tested' => 'AWS Credentials Tested',
        'bucket_policy_tested' => 'Bucket Policy Tested',
        'file_operations_tested' => 'File Operations Tested',
        'config_debugged' => 'Configuration Debugged',
        'results_cleared' => 'Results Cleared',
        'all_tests_completed' => 'All Tests Completed',
        'email_sent_successfully' => 'Email Sent Successfully',
        'email_send_failed' => 'Email Send Failed',
    ],
    'debug' => [
        'run_tests_message' => 'Run tests to see results...',
        'configuration_title' => '📋 Configuration',
        'credentials_title' => '🔐 AWS Credentials',
        's3_connection_title' => '☁️ S3 Connection',
        'permissions_title' => '🔒 S3 Permissions',
        'bucket_policy_title' => '📜 Bucket Policy',
        'cloudfront_title' => '☁️ CloudFront',
        'status_success' => 'success',
        'status_error' => 'error',
        'status_info' => 'info',
        'present' => '✅ Present',
        'missing' => '❌ Missing',
        'yes' => '✅ Yes',
        'no' => '❌ No',
        'ok' => '✅ OK',
        'complete' => '✅ Complete',
        'incomplete' => '❌ Incomplete',
    ],
];
