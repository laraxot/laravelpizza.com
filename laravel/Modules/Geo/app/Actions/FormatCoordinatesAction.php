<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

class FormatCoordinatesAction
{
    public function execute(float $latitude, float $longitude, string $format = 'decimal'): string
    {
        return match ($format) {
            'dms' => // @var mixed toDMS($latitude, $longitude
            'decimal' => // @var mixed toDecimal($latitude, $longitude
            'google' => // @var mixed toGoogleMapsUrl($latitude, $longitude
            default => throw new \InvalidArgumentException('Formato non supportato'),
        };
    }

    private function toDMS(float $latitude, float $longitude): string
    {
        $latDir = $latitude >= 0 ? 'N' : 'S';
        $lonDir = $longitude >= 0 ? 'E' : 'W';

        $latDMS = // @var mixed decimalToDMS(abs($latitude;
        $lonDMS = // @var mixed decimalToDMS(abs($longitude;

        return "{$latDMS}{$latDir} {$lonDMS}{$lonDir}";
    }

    private function decimalToDMS(float $decimal): string
    {
        $degrees = floor($decimal);
        $minutes = floor(($decimal - $degrees) * 60);
        $seconds = round(((($decimal - $degrees) * 60) - $minutes) * 60);

        return sprintf("%d°%d'%d\"", $degrees, $minutes, $seconds);
    }

    private function toDecimal(float $latitude, float $longitude): string
    {
        return sprintf('%.6f, %.6f', $latitude, $longitude);
    }

    private function toGoogleMapsUrl(float $latitude, float $longitude): string
    {
        return "https://www.google.com/maps?q={$latitude},{$longitude}";
    }
}
