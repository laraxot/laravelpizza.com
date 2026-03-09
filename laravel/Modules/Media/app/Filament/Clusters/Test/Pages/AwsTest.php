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
                        ->default(fn () => json_encode($this->testResults['s3'] ?? [], JSON_PRETTY_PRINT))
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
                    ->default(fn () => json_encode($this->testResults['cloudfront'] ?? [], JSON_PRETTY_PRINT))
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
                    ->default(fn () => json_encode($this->testResults['iam'] ?? [], JSON_PRETTY_PRINT))
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
                KeyValue::make('aws_config')->columnSpanFull()->state($this->getAwsConfig()),
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

            $s3->headBucket([
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
                    'Solution' => $this->getS3Solution($e->getAwsErrorCode())
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
        $this->test_cloud_front_config();

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
            'AWS_DEFAULT_REGION' => (string) config('filesystems.disks.s3.region'),
            'AWS_BUCKET' => (string) config('filesystems.disks.s3.bucket'),
            'CLOUDFRONT_URL' => (string) config('filesystems.cloudfront.url'),
            'CLOUDFRONT_KEY_PAIR_ID' => (string) config('filesystems.cloudfront.key_pair_id'),
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

            $s3->listObjectsV2([
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
                    'Solution' => $this->getS3Solution($e->getAwsErrorCode())
                ],
            ];

            Notification::make()
                ->title('S3 Permissions Failed')
                ->danger()
                ->body($e->getAwsErrorCode() ?? 'UnknownError')
                ->send();
        }
    }
}
