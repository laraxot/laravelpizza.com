<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Clusters\Test\Pages;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Modules\Media\Actions\Diagnostic\S3\TestBucketPermissionsAction;
use Modules\Media\Actions\Storage\GetFilesystemAdapterAction;
use Modules\Media\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Override;
use Webmozart\Assert\Assert;

use function Safe\file_put_contents;
use function Safe\json_decode;
use function Safe\json_encode;
use function Safe\unlink;

/**
 * S3Test Page for AWS S3 testing and diagnostics.
 *
 * @property array<string, mixed> $debugResults
 * @property Schema $form
 */
class S3Test extends XotBasePage
{
    protected static ?string $cluster = Test::class;

    /** @var array<string, mixed> */
    public array $debugResults = [];

    private const string DEFAULT_REGION = 'eu-west-1';

    private const string TEST_FILE_PREFIX = 'test-upload-';

    private const string PERMISSION_TEST_PREFIX = 'test-permissions-';

    private const string CLOUDFRONT_TEST_FILE = 'test-file.txt';

    private const int DEBUG_OUTPUT_ROWS = 15;

    private const int URL_PREVIEW_LENGTH = 100;

    public function mount(): void
    {
        $this->fillForms();
    }

    /**
     * Get the forms for this page.
     *
     * @return array<string>
     */
    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    /**
     * Get the form actions for this page.
     *
     * @return array<Action>
     */
    #[Override]
    protected function getFormActions(): array
    {
        return [
            Action::make('testCredentials')->color('secondary')->action('testCredentials'),
            Action::make('testS3Connection')->color('info')->action('testS3Connection'),
            Action::make('testPermissions')->color('warning')->action('testPermissions'),
            Action::make('testBucketPolicy')->color('danger')->action('testBucketPolicy'),
            Action::make('testCloudFront')->color('success')->action('testCloudFront'),
            Action::make('testFileOperations')->color('primary')->action('testFileOperations'),
            Action::make('debugConfig')->color('gray')->action('debugConfig'),
            Action::make('clearResults')->color('warning')->action('clearResults'),
            Action::make('test01')->submit('test01'),
        ];
    }

    /**
     * Get the form schema for this page.
     *
     * @return array<int, Component>
     */
    protected function getFormSchema(): array
    {
        $prefix = Config::string('media-library.prefix');

        $attachmentDir = 'form-attachments';
        if ($prefix !== '') {
            $attachmentDir = $prefix.'/'.$attachmentDir;
        }

        return [
            Grid::make(2)->schema([
                FileUpload::make('attachment')
                    ->disk('s3')
                    ->directory($attachmentDir)
                    ->visibility('private')
                    ->columnSpan(1),
                Textarea::make('debug_output')
                    ->rows(self::DEBUG_OUTPUT_ROWS)
                    ->default($this->getDebugOutput())
                    ->disabled()
                    ->columnSpan(1),
            ]),
        ];
    }

    /**
     * Fill the forms with initial data.
     */
    protected function fillForms(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput(),
        ]);
    }

    /**
     * Test S3 connection.
     */
    public function test_s3_connection(): void
    {
        $this->debugResults['s3_connection'] = $this->test_s3_connection_details();
        $this->updateDebugOutput();
    }

    /**
     * Test S3 permissions.
     */
    public function test_permissions(): void
    {
        $this->debugResults['permissions'] = $this->test_s3_permissions();
        $this->updateDebugOutput();
    }

    /**
     * Test CloudFront connection.
     */
    public function test_cloud_front(): void
    {
        $this->debugResults['cloudfront'] = $this->test_cloud_front_connection();
        $this->updateDebugOutput();
    }

    /**
     * Test AWS credentials.
     */
    public function test_credentials(): void
    {
        $this->debugResults['credentials'] = $this->performCredentialsTest();
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.credentials_tested'))
            ->success()
            ->send();
    }

    /**
     * Test bucket policy.
     */
    public function test_bucket_policy(): void
    {
        $this->debugResults['bucket_policy'] = $this->checkBucketPolicy();
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.bucket_policy_tested'))
            ->success()
            ->send();
    }

    /**
     * Test file operations.
     */
    public function test_file_operations(): void
    {
        $this->debugResults['file_operations'] = $this->test_file_upload_download();
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.file_operations_tested'))
            ->success()
            ->send();
    }

    /**
     * Debug configuration.
     */
    public function debugConfig(): void
    {
        $this->debugResults['config'] = $this->buildConfigDebugData();
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.config_debugged'))
            ->success()
            ->send();
    }

    /**
     * Clear test results.
     */
    public function clearResults(): void
    {
        $this->debugResults = [];
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.results_cleared'))
            ->success()
            ->send();
    }

    public function test01(): void
    {
        $formState = $this->form->getState();
        Assert::isArray($formState, 'Form state must be array');
        $data = $formState;
        $filePath = $data['attachment'] ?? null;

        if (! is_string($filePath) || '' === $filePath) {
            Notification::make()
                ->warning()
                ->title(Lang::string('media::s3test.notifications.no_attachment'))
                ->body(Lang::string('media::s3test.notifications.upload_file_first'))
                ->send();

            return;
        }

        // Generate CloudFront signed URL for attachment
        $signedUrl = app(GetCloudFrontSignedUrlAction::class)->execute($filePath, 60);
        $this->debugResults['signed_url'] = [
            'title' => 'CloudFront signed URL',
            'status' => 'info',
            'data' => [
                'signedurl' => $signedUrl,
                'filePath' => $filePath,
                'url2' => app(GetFilesystemAdapterAction::class)->execute('s3')->url($filePath),
                'url3' => app(GetFilesystemAdapterAction::class)->execute('s3')->temporaryUrl($filePath, now()->addMinutes(5)),
            ],
        ];
        $this->updateDebugOutput();

        Notification::make()
            ->title(Lang::string('media::s3test.notifications.s3_test_successful'))
            ->success()
            ->send();
    }

    /**
     * Build configuration debug data.
     *
     * @return array<string, mixed>
     */
    private function buildConfigDebugData(): array
    {
        return [
            'title' => '📋 Configuration',
            'status' => 'info',
            'data' => [
                'AWS_ACCESS_KEY_ID' => substr(Config::string('filesystems.disks.s3.key', ''), 0, 8).'...',
                'AWS_SECRET_ACCESS_KEY' => config('filesystems.disks.s3.secret') ? '✅ Present' : '❌ Missing',
                'AWS_DEFAULT_REGION' => config('filesystems.disks.s3.region'),
                'AWS_BUCKET' => Config::string('filesystems.disks.s3.bucket'),
                'AWS_USE_PATH_STYLE_ENDPOINT' => config('filesystems.disks.s3.use_path_style_endpoint', 'false'),
                'CLOUDFRONT_BASE_URL' => config('services.cloudfront.base_url'),
                'CLOUDFRONT_KEYPAIR_ID' => config('services.cloudfront.key_pair_id'),
                'CLOUDFRONT_PRIVATE_KEY' => config('services.cloudfront.private_key')
                    ? '✅ Present'
                    : '❌ Missing',
            ],
        ];
    }

    /**
     * Perform credentials test.
     *
     * @return array<string, mixed>
     */
    private function performCredentialsTest(): array
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

            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'success',
                'data' => [
                    'Valid' => '✅ Yes',
                    'Account ID' => $result['Account'],
                    'User ARN' => $result['Arn'],
                ],
            ];
        } catch (AwsException $e) {
            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'error',
                'data' => [
                    'Valid' => '❌ No',
                    'Error' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Test S3 connection details.
     *
     * @return array<string, mixed>
     */
    private function test_s3_connection_details(): array
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

            // Test bucket accessibility
            $s3->headBucket(['Bucket' => Config::string('filesystems.disks.s3.bucket')]);

            // Get bucket region
            $location = $s3->getBucketLocation(['Bucket' => Config::string('filesystems.disks.s3.bucket')]);
            $bucketRegion = $location['LocationConstraint'] ?: 'us-east-1';

            $regionMatch = $bucketRegion === config('filesystems.disks.s3.region');

            return [
                'title' => '☁️ S3 Connection',
                'status' => 'success',
                'data' => [
                    'Bucket Accessible' => '✅ Yes',
                    'Bucket Region' => $bucketRegion,
                    'Config Region' => config('filesystems.disks.s3.region'),
                    'Region Match' => $regionMatch ? '✅ Yes' : '⚠️ No - This might cause issues',
                ],
            ];
        } catch (AwsException $e) {
            return [
                'title' => '☁️ S3 Connection',
                'status' => 'error',
                'data' => [
                    'Bucket Accessible' => '❌ No',
                    'Error Code' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                    'Solution' => $this->getSolutionForError($e->getAwsErrorCode()),
                ],
            ];
        }
    }

    /**
     * Test S3 permissions.
     *
     * @return array<string, mixed>
     */
    private function test_s3_permissions(): array
    {
        return app(TestBucketPermissionsAction::class)->execute(self::PERMISSION_TEST_PREFIX);
    }

    /**
     * Check bucket policy.
     *
     * @return array<string, mixed>
     */
    private function checkBucketPolicy(): array
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

            $policy = $s3->getBucketPolicy(['Bucket' => Config::string('filesystems.disks.s3.bucket')]);
            $policyDocument = $policy['Policy'] ?? null;
            $formattedPolicy = is_string($policyDocument)
                ? json_encode(json_decode($policyDocument), JSON_PRETTY_PRINT)
                : 'Policy document unavailable';

            return [
                'title' => '📜 Bucket Policy',
                'status' => 'info',
                'data' => [
                    'Policy Exists' => '✅ Yes',
                    'Policy' => $formattedPolicy,
                ],
            ];
        } catch (AwsException $e) {
            if (($e->getAwsErrorCode() ?? '') === 'NoSuchBucketPolicy') {
                return [
                    'title' => '📜 Bucket Policy',
                    'status' => 'info',
                    'data' => [
                        'Policy Exists' => 'ℹ️ No (This is usually OK)',
                    ],
                ];
            }

            return [
                'title' => '📜 Bucket Policy',
                'status' => 'error',
                'data' => [
                    'Error' => $e->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Test CloudFront connection.
     *
     * @return array<string, mixed>
     */
    private function test_cloud_front_connection(): array
    {
        try {
            // Test CloudFront configuration
            $baseUrl = config('services.cloudfront.base_url');
            $keyPairId = config('services.cloudfront.key_pair_id');
            $privateKey = config('services.cloudfront.private_key');

            if (! $baseUrl || ! $keyPairId || ! $privateKey) {
                return [
                    'title' => '☁️ CloudFront',
                    'status' => 'error',
                    'data' => [
                        'Configuration' => '❌ Incomplete',
                        'Missing' => collect([
                            'Base URL' => ! $baseUrl,
                            'Key Pair ID' => ! $keyPairId,
                            'Private Key' => ! $privateKey,
                        ])
                            ->filter()
                            ->keys()
                            ->implode(', '),
                    ],
                ];
            }

            // Test signed URL generation
            $testUrl = app(GetCloudFrontSignedUrlAction::class)->execute(self::CLOUDFRONT_TEST_FILE, 5);

            return [
                'title' => '☁️ CloudFront',
                'status' => 'success',
                'data' => [
                    'Configuration' => '✅ Complete',
                    'Base URL' => $baseUrl,
                    'Key Pair ID' => $keyPairId,
                    'Signed URL Test' => '✅ Success',
                    'Sample URL' => substr((string) $testUrl, 0, self::URL_PREVIEW_LENGTH).'...',
                ],
            ];
        } catch (Exception $e) {
            return [
                'title' => '☁️ CloudFront',
                'status' => 'error',
                'data' => [
                    'Error' => $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Get solution for AWS error.
     */
    private function getSolutionForError(?string $errorCode): string
    {
        if ($errorCode === null) {
            return 'Unknown error - check AWS credentials and configuration';
        }

        $solutions = [
            'AccessDenied' => 'Check IAM permissions for your AWS user',
            'SignatureDoesNotMatch' => 'Verify AWS_SECRET_ACCESS_KEY in .env',
            'InvalidAccessKeyId' => 'Check AWS_ACCESS_KEY_ID in .env',
            'NoSuchBucket' => 'Verify bucket name and region',
            'BucketRegionError' => 'Update AWS_DEFAULT_REGION to match bucket region',
        ];

        return $solutions[$errorCode] ?? ('Check AWS documentation for error: '.$errorCode);
    }

    /**
     * Get debug output.
     */
    private function getDebugOutput(): string
    {
        if (empty($this->debugResults)) {
            return Lang::string('media::s3test.debug.run_tests_message');
        }

        $output = [];
        foreach ($this->debugResults as $result) {
            if (! is_array($result) || ! isset($result['title'], $result['status'], $result['data'])
                || ! is_string($result['title']) || ! is_string($result['status'])) {
                continue;
            }

            $title = $result['title'];
            $status = $result['status'];
            $data = $result['data'];

            $output[] = "=== {$title} ===";
            $output[] = "Status: {$status}";
            $output[] = '';

            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $keyStr = (string) $key;
                    if (is_array($value)) {
                        $output[] = "{$keyStr}: ".json_encode($value, JSON_PRETTY_PRINT);
                    } else {
                        $valueStr = \Modules\Xot\Actions\Cast\SafeStringCastAction::cast($value);
                        $output[] = "{$keyStr}: {$valueStr}";
                    }
                }
            }

            $output[] = '';
            $output[] = str_repeat('-', 50);
            $output[] = '';
        }

        return implode("\n", $output);
    }

    /**
     * Send email with attachment.
     */
    public function sendEmail(): void
    {
        try {
            $formState = $this->form->getState();
            Assert::isArray($formState, 'Form state must be array');
            $data = $formState;
            $filePath = $data['attachment'] ?? null;

            if (! is_string($filePath) || '' === $filePath) {
                Notification::make()
                    ->warning()
                    ->title(Lang::string('media::s3test.notifications.no_attachment'))
                    ->body(Lang::string('media::s3test.notifications.upload_file_first'))
                    ->send();

                return;
            }

            // Generate CloudFront signed URL for attachment
            $signedUrl = app(GetCloudFrontSignedUrlAction::class)->execute($filePath, 60);

            // Log the email data for testing purposes (no actual email sent)
            Log::debug('S3 Test Email Data', [
                'attachment_path' => $filePath,
                'signed_url' => $signedUrl,
                'timestamp' => now()->toISOString(),
            ]);

            Notification::make()
                ->success()
                ->title(Lang::string('media::s3test.notifications.email_sent'))
                ->body(Lang::string('media::s3test.notifications.email_with_attachment'))
                ->send();
        } catch (Exception $e) {
            Log::error('S3 Test Email Failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            Notification::make()
                ->danger()
                ->title(Lang::string('media::s3test.notifications.email_failed'))
                ->body($e->getMessage())
                ->send();
        }
    }

    /**
     * Test file upload and download operations.
     *
     * @return array<string, mixed>
     */
    private function test_file_upload_download(): array
    {
        try {
            $testData = 'This is a test file content for S3 upload/download test.';
            $testFileName = 'test-file-'.time().'.txt';
            $localTestPath = sys_get_temp_dir().'/'.$testFileName;

            // Create test file
            file_put_contents($localTestPath, $testData);

            // Test upload
            $uploadResult = Storage::disk('s3')->put($testFileName, $testData);

            if (! $uploadResult) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to upload test file to S3',
                    'details' => ['file' => $testFileName],
                ];
            }

            // Test download
            $downloadedContent = Storage::disk('s3')->get($testFileName);

            if ($downloadedContent !== $testData) {
                return [
                    'status' => 'error',
                    'message' => 'Downloaded content does not match uploaded content',
                    'details' => [
                        'expected_length' => strlen($testData),
                        'actual_length' => strlen($downloadedContent ?? ''),
                    ],
                ];
            }

            // Test file info
            $exists = Storage::disk('s3')->exists($testFileName);
            $size = Storage::disk('s3')->size($testFileName);

            // Cleanup
            Storage::disk('s3')->delete($testFileName);
            unlink($localTestPath);

            return [
                'status' => 'success',
                'message' => 'File upload/download test completed successfully',
                'details' => [
                    'file_uploaded' => true,
                    'file_downloaded' => true,
                    'content_verified' => true,
                    'file_exists_check' => $exists,
                    'file_size' => $size,
                    'cleanup_completed' => true,
                    'test_file' => $testFileName,
                ],
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'File operations test failed: '.$e->getMessage(),
                'details' => [
                    'error_class' => get_class($e),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                ],
            ];
        }
    }

    /**
     * Update debug output.
     */
    private function updateDebugOutput(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput(),
        ]);
    }

    /**
     * Save and test S3 operations.
     */
    public function save(): void
    {
        try {
            // Test basic S3 operation
            $filename = self::TEST_FILE_PREFIX.time().'.txt';
            Storage::disk('s3')->put($filename, 'Hello World from Filament Test');

            // Test CloudFront signed URL
            $cloudFrontUrl = app(GetCloudFrontSignedUrlAction::class)->execute($filename, 5);

            // Test Laravel temporary URL
            /** @var FilesystemAdapter $s3Disk */
            $s3Disk = Storage::disk('s3');
            $temporaryUrl = $s3Disk->temporaryUrl($filename, now()->addMinutes(5));

            $formState = $this->form->getState();
            Assert::isArray($formState, 'Form state must be array');
            $data = $formState;
            $filePath = $data['attachment'] ?? null;

            $uploadedFile = is_string($filePath) && '' !== $filePath
                ? [
                    'path' => $filePath,
                    'cloudfront_url' => app(GetCloudFrontSignedUrlAction::class)->execute($filePath, 30),
                    'temporary_url' => $s3Disk->temporaryUrl($filePath, now()->addMinutes(30)),
                ]
                : null;

            $results = [
                'test_file' => [
                    'path' => $filename,
                    'cloudfront_url' => $cloudFrontUrl,
                    'temporary_url' => $temporaryUrl,
                ],
                'uploaded_file' => $uploadedFile,
            ];

            // Clean up test file
            Storage::disk('s3')->delete($filename);

            Notification::make()
                ->success()
                ->title(Lang::string('media::s3test.notifications.s3_test_successful'))
                ->body(Lang::string('media::s3test.notifications.operations_completed'))
                ->send();

            // Log results for debugging
            Log::debug('S3 Test Results', $results);
        } catch (Exception $e) {
            Notification::make()
                ->danger()
                ->title(Lang::string('media::s3test.notifications.test_failed'))
                ->body($e->getMessage())
                ->send();

            // Log error for debugging
            Log::error('S3 Test Failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
