<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

/**
 * Bridge legacy per mantenere compatibilita' col naming alternativo.
 *
 * La business logic reale vive in `UpdatepercParttimepondDalal`, che resta la
 * classe canonica usata dalla pipeline di `OrganizzativaMoney`.
 */
class UpdatePercParttimepondDalalAction extends UpdatepercParttimepondDalal {}
