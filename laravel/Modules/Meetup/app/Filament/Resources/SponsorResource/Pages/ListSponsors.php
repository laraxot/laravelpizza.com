<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\SponsorResource\Pages;

use Modules\Meetup\Filament\Resources\SponsorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListSponsors extends XotBaseListRecords
{
    protected static string $resource = SponsorResource::class;
}
