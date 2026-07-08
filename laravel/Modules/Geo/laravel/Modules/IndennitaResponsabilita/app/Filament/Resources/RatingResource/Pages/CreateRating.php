<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\IndennitaResponsabilita\Filament\Resources\RatingResource;

class CreateRating extends CreateRecord
{
    protected static string $resource = RatingResource::class;

    // public static function getResource(): string {

    // dddx($this->getModel());
    // dddx(static::class);//Modules\Ptv\Filament\Resources\RatingResource\Pages\CreateRating
    // dddx(parent::class); // Filament\Resources\Pages\CreateRecord
    // dddx(get_called_class()); // Modules\Ptv\Filament\Resources\RatingResource\Pages\CreateRating
    // dddx(get_parent_class());//Filament\Resources\Pages\CreateRecord
    // }
}
