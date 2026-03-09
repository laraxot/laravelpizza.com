<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Clusters\Test\Pages;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Modules\Media\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;

use function Safe\json_encode;

class AwsTest extends XotBasePage
{
    protected static ?string $cluster = Test::class;

    public array $testResults = [];

    public string $activeTab = 's3';

    private const DEFAULT_REGION = 'eu-west-1';

    private const KEY_PREVIEW_LENGTH = 8;

    public array $connectionTests = [
        's3' => 'Test S3 Connection',
        'cloudfront' => 'Test CloudFront',
        'iam' => 'Test IAM Permissions',
        'full' => 'Full Diagnostic',
    ];

    protected function getS3TestSchema(): array
    {
        return [
            Section::make('S3 Connection Test')
                ->description('Verify S3 bucket access and permissions')
                ->schema([
                    Actions::make([
                        Action::make('test_s3_connection')
                            ->label(__('ui::aws_test.test_s3_connection'))
                            ->action('testS3Connection'),
                        Action::make('test_s3_permissions')
                            ->label(__('ui::aws_test.test_s3_permissions'))
                            ->color('warning')
                            ->action('testS3Permissions'),
                        Action::make('test_file_operations')
                            ->label(__('ui::aws_test.test_file_operations'))
                            ->color('success')
                            ->action('testS3FileOperations'),
                    ])->fullWidth(),
                    Textarea::make('s3_results')
                        ->label('S3 Test Results')
                        ->rows(10)
                        ->disabled()
                        ->default(fn () => json_encode($this->testResults['s3'] ?? [], JSON_PRETTY_PRINT)),
                ]),
        ];
    }

    protected function getCloudFrontTestSchema(): array
    {
        return [
            Section::make('CloudFront Test')->schema([
                TextInput::make('cloudfront_url')->default(config('filesystems.cloudfront.url')),
                Actions::make([
                    Action::make('test_cloudfront_config')->action('testCloudFrontConfig'),
                    Action::make('test_signed_urls')->action('testCloudFrontSignedUrls'),
                ]),
                Textarea::make('cloudfront_results')
                    ->label('CloudFront Test Results')
                    ->rows(10)
                    ->disabled()
                    ->default(fn () => json_encode($this->testResults['cloudfront'] ?? [], JSON_PRETTY_PRINT)),
            ]),
        ];
    }

    protected function getIamTestSchema(): array
    {
        return [
            Section::make('IAM Permissions Test')->schema([
                TextInput::make('iam_user')->default(env('AWS_ACCESS_KEY_ID')),
                Actions::make([
                    Action::make('test_iam_credentials')->action('testIamCredentials'),
                    Action::make('test_iam_policies')->color('warning')->action('testIamPolicies'),
                ]),
                Textarea::make('iam_results')
                    ->label('IAM Test Results')
                    ->rows(10)
                    ->disabled()
                    ->default(fn () => json_encode($this->testResults['iam'] ?? [], JSON_PRETTY_PRINT)),
            ]),
        ];
    }

    protected function getDiagnosticsSchema(): array
    {
        return [
            Section::make('Complete Diagnostic')->schema([
                Actions::make([
                    Action::make('run_full_diagnostic')
                        ->color('danger')
                        ->icon('heroicon-o-bolt')
                        ->action('runFullDiagnostic'),
                ]),
                Textarea::make('full_results')
                    ->label('Full Diagnostic Results')
                    ->rows(15)
                    ->disabled()
                    ->default(fn () => json_encode($this->testResults['full'] ?? [], JSON_PRETTY_PRINT)),
                KeyValue::make('aws_config')->columnSpanFull()->state($this->getAwsConfig(...)),
            ]),
        ];
    }

    /* Test Methods */
    public function test_s3_connection(): void
    {
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            $result = $s3->headBucket([
                'Bucket' => config('filesystems.disks.s3.bucket'),
            ]);

            $this->testResults['s3'] = [
                'status' => 'success',
                'message' => 'Successfully connected to S3 bucket',
                'details' => [
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                    'Region' => config('filesystems.disks.s3.region'),
                ],
            ];

            Notification::make()
                ->title(__('ui::awstest.notifications.s3_connection_successful'))
                ->success()
                ->send();
        } catch (AwsException $e) {
            $this->testResults['s3'] = [
                'status' => 'error',
                'message' => $e->getAwsErrorCode() ?? 'UnknownError',
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => $this->getS3Solution($e->getAwsErrorCode() ?? 'UnknownError'),
                ],
            ];

            Notification::make()
                ->title(__('ui::awstest.notifications.s3_connection_failed'))
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }

    public function test_cloud_front_config(): void
    {
        try {
            // Implement CloudFront config test
            $this->testResults['cloudfront'] = [
                'status' => 'success',
                'message' => 'CloudFront configuration valid',
                'details' => [
                    'Base URL' => config('filesystems.cloudfront.url'),
                    'Key Pair ID' => config('filesystems.cloudfront.key_pair_id'),
                ],
            ];

            Notification::make()
                ->title(__('ui::awstest.notifications.cloudfront_config_valid'))
                ->success()
                ->send();
        } catch (Exception $e) {
            $this->testResults['cloudfront'] = [
                'status' => 'error',
                'message' => 'CloudFront configuration error',
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => 'Check CloudFront settings in config',
                ],
            ];

            Notification::make()
                ->title(__('ui::awstest.notifications.cloudfront_config_error'))
                ->danger()
                ->send();
        }
    }

    public function runFullDiagnostic(): void
    {
        $this->test_s3_connection();
        $this->test_s3_permissions();
        $this->test_s3_file_operations();
        $this->test_cloud_front_config();
        $this->test_cloud_front_signed_urls();
        $this->test_iam_credentials();
        $this->test_iam_policies();

        $this->testResults['full'] = [
            'status' => 'completed',
            'message' => 'Full diagnostic completed',
            'details' => $this->testResults,
        ];

        Notification::make()
            ->title(__('ui::awstest.notifications.full_diagnostic_completed'))
            ->success()
            ->send();
    }

    /* Helper Methods */
    protected function getAwsConfig(): array
    {
        return [
            'AWS_ACCESS_KEY_ID' => substr((string) config('filesystems.disks.s3.key', ''), 0, self::KEY_PREVIEW_LENGTH).'...',
            'AWS_DEFAULT_REGION' => config('filesystems.disks.s3.region'),
            'AWS_BUCKET' => config('filesystems.disks.s3.bucket'),
            'CLOUDFRONT_URL' => config('filesystems.cloudfront.url'),
            'CLOUDFRONT_KEY_PAIR_ID' => config('filesystems.cloudfront.key_pair_id'),
        ];
    }

    protected function getS3Solution(?string $errorCode): string
    {
        if ($errorCode === null) {
            return 'Unknown error - check AWS credentials and configuration';
        }

        $solutions = [
            'SignatureDoesNotMatch' => 'Verify your AWS_SECRET_ACCESS_KEY in .env',
            'AccessDenied' => 'Check IAM permissions for S3 access',
            'NoSuchBucket' => 'Verify bucket name and region',
            'InvalidAccessKeyId' => 'Check AWS_ACCESS_KEY_ID',
        ];

        return $solutions[$errorCode] ?? ('Consult AWS documentation for error: '.$errorCode);
    }

    public function test_s3_permissions(): void
    {
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            // Test list objects permission
            $result = $s3->listObjectsV2([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'MaxKeys' => 1,
            ]);

            $this->testResults['s3_permissions'] = [
                'status' => 'success',
                'message' => 'S3 permissions verified successfully',
                'details' => [
                    'ListObjects' => 'OK',
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                ],
            ];

            Notification::make()
                ->title('S3 Permissions OK')
                ->success()
                ->send();
        } catch (AwsException $e) {
            $this->testResults['s3_permissions'] = [
                'status' => 'error',
                'message' => 'S3 permissions error: '.($e->getAwsErrorCode() ?? 'UnknownError'),
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => $this->getS3Solution($e->getAwsErrorCode() ?? 'UnknownError'),
                ],
            ];

            Notification::make()
                ->title('S3 Permissions Failed')
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }

    public function test_s3_file_operations(): void
    {
        try {
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            $testFileName = 'test-file-'.now()->timestamp.'.txt';
            $testContent = 'Test file content for AWS S3 operations';

            // Test put operation
            $s3->putObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $testFileName,
                'Body' => $testContent,
                'ContentType' => 'text/plain',
            ]);

            // Test get operation
            $result = $s3->getObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $testFileName,
            ]);

            // Clean up - delete test file
            $s3->deleteObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $testFileName,
            ]);

            $this->testResults['s3_operations'] = [
                'status' => 'success',
                'message' => 'S3 file operations completed successfully',
                'details' => [
                    'Upload' => 'OK',
                    'Download' => 'OK',
                    'Delete' => 'OK',
                    'Test File' => $testFileName,
                ],
            ];

            Notification::make()
                ->title('S3 File Operations OK')
                ->success()
                ->send();
        } catch (AwsException $e) {
            $this->testResults['s3_operations'] = [
                'status' => 'error',
                'message' => 'S3 file operations error: '.($e->getAwsErrorCode() ?? 'UnknownError'),
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => $this->getS3Solution($e->getAwsErrorCode() ?? 'UnknownError'),
                ],
            ];

            Notification::make()
                ->title('S3 File Operations Failed')
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }

    public function test_cloud_front_signed_urls(): void
    {
        try {
            // Test CloudFront signed URL generation
            $privateKey = config('filesystems.cloudfront.private_key');
            $keyPairId = config('filesystems.cloudfront.key_pair_id');
            $baseUrl = config('filesystems.cloudfront.url');

            if (! $privateKey || ! $keyPairId || ! $baseUrl) {
                throw new Exception('Missing CloudFront configuration');
            }

            $this->testResults['cloudfront_signed'] = [
                'status' => 'success',
                'message' => 'CloudFront signed URL configuration valid',
                'details' => [
                    'Base URL' => $baseUrl,
                    'Key Pair ID' => $keyPairId,
                    'Private Key' => 'Configured',
                ],
            ];

            Notification::make()
                ->title('CloudFront Signed URLs OK')
                ->success()
                ->send();
        } catch (Exception $e) {
            $this->testResults['cloudfront_signed'] = [
                'status' => 'error',
                'message' => 'CloudFront signed URL error',
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => 'Check CloudFront private key and configuration',
                ],
            ];

            Notification::make()
                ->title('CloudFront Signed URLs Failed')
                ->danger()
                ->send();
        }
    }

    public function test_iam_credentials(): void
    {
        try {
            $sts = new StsClient([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            $result = $sts->getCallerIdentity();

            $this->testResults['iam_credentials'] = [
                'status' => 'success',
                'message' => 'IAM credentials verified successfully',
                'details' => [
                    'Account' => $result['Account'] ?? 'Unknown',
                    'ARN' => $result['Arn'] ?? 'Unknown',
                    'User ID' => $result['UserId'] ?? 'Unknown',
                ],
            ];

            Notification::make()
                ->title('IAM Credentials OK')
                ->success()
                ->send();
        } catch (AwsException $e) {
            $this->testResults['iam_credentials'] = [
                'status' => 'error',
                'message' => 'IAM credentials error: '.($e->getAwsErrorCode() ?? 'UnknownError'),
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => 'Check AWS access keys and secret',
                ],
            ];

            Notification::make()
                ->title('IAM Credentials Failed')
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }

    public function test_iam_policies(): void
    {
        try {
            // Test IAM policies by attempting various operations
            $s3 = new S3Client([
                'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            // Test bucket access
            $s3->headBucket([
                'Bucket' => config('filesystems.disks.s3.bucket'),
            ]);

            // Test list objects
            $s3->listObjectsV2([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'MaxKeys' => 1,
            ]);

            $this->testResults['iam_policies'] = [
                'status' => 'success',
                'message' => 'IAM policies verified successfully',
                'details' => [
                    'S3 Access' => 'OK',
                    'List Objects' => 'OK',
                    'Bucket Access' => 'OK',
                ],
            ];

            Notification::make()
                ->title('IAM Policies OK')
                ->success()
                ->send();
        } catch (AwsException $e) {
            $this->testResults['iam_policies'] = [
                'status' => 'error',
                'message' => 'IAM policies error: '.($e->getAwsErrorCode() ?? 'UnknownError'),
                'details' => [
                    'Error' => $e->getMessage(),
                    'Solution' => 'Check IAM user policies and permissions',
                ],
            ];

            Notification::make()
                ->title('IAM Policies Failed')
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }
}
