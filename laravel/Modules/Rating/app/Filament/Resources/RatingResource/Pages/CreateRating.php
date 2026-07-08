<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Pages;

use Modules\Rating\Filament\Resources\RatingResource;

class CreateRating extends BaseCreateRating
{
    protected static string $resource = RatingResource::class;

    // public static function getResource(): string {

    // dddx($this->getModel());
    // dddx(static::class);//Modules\Rating\Filament\Resources\RatingResource\Pages\CreateRating
    // dddx(parent::class); // Filament\Resources\Pages\CreateRecord
    // dddx(get_called_class()); // Modules\Rating\Filament\Resources\RatingResource\Pages\CreateRating
    // dddx(get_parent_class());//Filament\Resources\Pages\CreateRecord
    // }
}
