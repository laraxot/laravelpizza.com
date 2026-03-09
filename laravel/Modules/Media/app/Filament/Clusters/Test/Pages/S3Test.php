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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Modules\Media\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

class S3Test extends XotBasePage
{
    protected static ?string $cluster = Test::class;

    public array $debugResults = [];

    private const DEFAULT_REGION = 'eu-west-1';
    private const DEBUG_OUTPUT_ROWS = 15;

    public function mount(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput()
        ]);
    }

    protected function getFormSchema(): array
    {
        $prefix = Config::string('media-library.prefix', '');
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

    protected function getFormActions(): array
    {
        return [
            Action::make('testS3Connection')->color('info')->action('testS3Connection'),
            Action::make('clearResults')->color('warning')->action('clearResults'),
        ];
    }

    public function testS3Connection(): void
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

            $s3->headBucket(['Bucket' => config('filesystems.disks.s3.bucket')]);

            $this->debugResults['s3'] = [
                'title' => 'S3 Connection',
                'status' => 'success',
                'data' => ['Accessible' => 'Yes'],
            ];

            Notification::make()->title('S3 Connected')->success()->send();
        } catch (Exception $e) {
            $this->debugResults['s3'] = [
                'title' => 'S3 Connection',
                'status' => 'error',
                'data' => ['Error' => $e->getMessage()],
            ];
            Notification::make()->title('S3 Failed')->danger()->send();
        }

        $this->updateDebugOutput();
    }

    public function clearResults(): void
    {
        $this->debugResults = [];
        $this->updateDebugOutput();
    }

    private function getDebugOutput(): string
    {
        if (empty($this->debugResults)) {
            return 'No tests run yet.';
        }

        return json_encode($this->debugResults, JSON_PRETTY_PRINT);
    }

    private function updateDebugOutput(): void
    {
        $this->form->fill([
            'debug_output' => $this->getDebugOutput()
        ]);
    }
}
