<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Sts\StsClient;
use Spatie\QueueableAction\QueueableAction;

class CreateFilesystemStsClientAction
{
    use QueueableAction;

    private const string DEFAULT_REGION = 'eu-west-1';

    public function execute(): StsClient
    {
        return new StsClient([
            'region' => config('filesystems.disks.s3.region', self::DEFAULT_REGION),
            'version' => 'latest',
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);
    }
}
