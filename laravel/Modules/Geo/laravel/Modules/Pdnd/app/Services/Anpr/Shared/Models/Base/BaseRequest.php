<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Models\Base;

use App\Services\Anpr\Shared\Traits\HasArrayConversion;
use App\Services\Anpr\Shared\Traits\HasValidation;
use Modules\Pdnd\Services\Anpr\Contracts\AnprRequestInterface;
use Override;

abstract class BaseRequest implements AnprRequestInterface
{
    // use HasArrayConversion, HasValidation;

    public function __construct(
        public readonly string $idOperazioneClient
    ) {}

    #[Override]
    public function getIdOperazione(): string
    {
        return $this->idOperazioneClient;
    }

    protected function generateOperationId(): string
    {
        return 'ANPR_'.now()->format('YmdHis').'_'.uniqid();
    }
}
