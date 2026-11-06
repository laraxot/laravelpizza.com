<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

/**
 * Compatibilità per i riferimenti legacy: la risorsa Passport vive nel cluster.
 */
class OauthRefreshTokenResource extends \Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource {}
