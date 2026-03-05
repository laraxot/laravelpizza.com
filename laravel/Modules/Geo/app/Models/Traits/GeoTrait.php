<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
// --- models ---
use Modules\Geo\Datas\GeoData;
// ---- services --
use Modules\Geo\Services\GeoService;

/**
 * Modules\Geo\Models\Traits\GeoTrait.
 *
 * @property float  $latitude
 * @property float  $longitude
 * @property string $country.
 * @property string $country.
 * @property string $administrative_area_level_2.
 * @property string $country.
 * @property string $locality.
 * @property string $route.
 * @property string $street_number.
 * @property string $country.
 * @property string $country.
 * @property string $administrative_area_level_2.
 * @property string $country.
 * @property string $locality.
 * @property string $route.
 * @property string $street_number.
 * @property string $route.
 * @property string $street_number.
 * @property string $postal_code.
 * @property string $administrative_area_level_3.
 * @property string $administrative_area_level_2_short.
 */
trait GeoTrait
{
    /*
     * @return array
     *
     * public function getFillable() {
     * $shorts = collect(Place::$address_components)->map(
     * function ($item) {
     * return $item.'_short';
     * }
     * )->all();
     * $fillable = array_merge($this->fillable, Place::$address_components, $shorts, ['latitude', 'longitude']);
     *
     * return $fillable;
     * }*/

    // --- functions ----

    public function distance(?float $lat = null, ?float $lng = null): ?float
    {
        return (float) GeoService::distance((float) $this->latitude, (float) $this->longitude, $lat, $lng, '');
    }

    public function distanceCustomField(
        string $lat_field,
        string $lng_field,
        ?float $lat = null,
        ?float $lng = null,
        ?string $unit = '',
    ): ?float {
        return (float) GeoService::distance(
            (float) $this->{$lat_field},
            (float) $this->{$lng_field},
            $lat,
            $lng,
            $unit,
        );
    }

    // ---- Scopes ----
    public function scopeWithDistance(Builder $query, float $lat, float $lng): Builder
    {
        $q = $query;
        if ($lat > 0 && $lng > 0) {
            $haversine = GeoService::haversine($lat, $lng);

            return $query->selectRaw("*,{$haversine} AS distance")->orderBy('distance');
        }

        return $q;
    }

    public function scopeWithDistanceCustomField(
        Builder $query,
        string $lat_field,
        string $lng_field,
        float $lat,
        float $lng,
    ): Builder {
        $q = $query;
        if ($lat > 0 && $lng > 0) {
            $haversine = GeoService::setLatitudeLongitudeField('lat', 'lng')->haversine($lat, $lng);

            return $query->selectRaw("*,{$haversine} AS distance")->orderBy('distance');
        }

        return $q;
    }

    public function scopeOfInPolygon(Builder $query, string $polygon_field, float $lat, float $lng): Builder
    {
        // (concat('POLYGON(',replace(replace(replace(replace(Replace(REPLACE(zone_polygon,'"lat":',''),',"lng":',' '),'{',''),'}',''),'[','('),']',')'),')'))
        // errore poligono non chiuso
        /*
         *
         * SELECT ID,zone_polygon
         * ,(ST_GeomFromText(
         * concat('POLYGON((',
         * REPLACE(
         * REPLACE(
         * REPLACE(
         * REPLACE(
         * replace(CONCAT(
         * replace(replace(JSON_extract(zone_polygon,'$'),']',''),'[',''),
         * ',',JSON_extract(zone_polygon,'$[0]'))
         * ,'"lat":','')
         * ,',"lng":',' ')
         * ,'{',' ')
         * ,', "lng":',' ')
         * ,'}','')
         * ,'))')
         * )
         * )
         * AS test
         *
         * from vo_activities
         * where zone_polygon IS NOT NULL
         */

        $sql = "ST_Contains(
        ST_GeomFromText(
       concat('POLYGON((',
       REPLACE(
       REPLACE(
       REPLACE(
       REPLACE(
       replace(CONCAT(
       replace(replace(JSON_extract(zone_polygon,'$'),']',''),'[',''),
       ',',JSON_extract(zone_polygon,'$[0]'))
       ,'\"lat\":','')
       ,',\"lng\":',' ')
       ,'{',' ')
       ,', \"lng\":',' ')
       ,'}','')
       ,'))')
       ), ST_GeomFromText('POINT(".$lat.' '.$lng.")')
       )";

        // dddx($query->whereNotNull($polygon_field)->whereRaw($sql)->toSql());

        return $query->whereNotNull($polygon_field)->whereRaw($sql);
    }

    // ---- mutators ----

    public function getAddress(): string
    {
        if ('' === $this->country) {
            $this->country = 'Italia';
        }

        return $this->route.
            ', '.
            $this->street_number.
            ', '.
            $this->locality.
            ', '.
            $this->administrative_area_level_2.
            ', '.
            $this->country;
    }

    /**
     * Get latitude attribute.
     */
    public function getLatitudeAttribute(mixed $value): ?float
    {
        if (is_float($value) || is_int($value)) {
            return (float) $value;
        }
        $address = $this->address;
        if (null === $address) {
            return null;
        }
        if (is_string($address) && isJson($address)) {
            $geo = GeoData::from(json_decode($address, true, 512, JSON_THROW_ON_ERROR));
            $latlng = $geo->latlng;
            $lat = is_float($latlng['lat'] ?? null) || is_int($latlng['lat'] ?? null) ? (float) ($latlng['lat']) : null;
            $lng = is_float($latlng['lng'] ?? null) || is_int($latlng['lng'] ?? null) ? (float) ($latlng['lng']) : null;
            if (null !== $lat && null !== $lng) {
                $this->update([
                    'latitude' => $lat,
                    'longitude' => $lng,
                ]);
                $this->save();
            }

            return $lat;
        }
        // call to function is_object() with string will always evaluate to false
        // if (\is_object($address)) {
        //    dddx($address);
        // }
        // Call to function is_array() with string will always evaluate to false
        /*
         * if (\is_array($address)) {
         * $lat = $address['latlng']['lat'];
         * $lng = $address['latlng']['lng'];
         * $this->update([
         * 'latitude' => $lat,
         * 'longitude' => $lng,
         * ]);
         * $this->save();
         *
         * return $lat;
         * }
         */

        return null;
    }

    /**
     * Set address attribute with proper type handling.
     */
    public function setAddressAttribute(mixed $value): void
    {
        // *

        if (is_string($value) && isJson((string) $value)) {
            /*
             * @var array<string, mixed>
             */
            // $json = json_decode($value, true);
            // $json['latitude'] = $json['latlng']['lat'];
            // $json['longitude'] = $json['latlng']['lng'];

            $geo = GeoData::from(json_decode((string) $value, true, 512, JSON_THROW_ON_ERROR));
            $latlng = $geo->latlng;
            $lat = $latlng['lat'];
            $lng = $latlng['lng'];

            // unset($json['latlng'], $json['value']);
            // $this->attributes = array_merge($this->attributes, $json);
            $this->attributes['latitude'] = $lat;
            $this->attributes['longitude'] = $lng;
            if (! isset($this->attributes['full_address'])) {
                $this->attributes['full_address'] = ',,';
            }

            $fullAddress = (string) ($this->attributes['full_address'] ?? '');
            if (strlen($fullAddress) < 10) {
                $tmp = [];
                $tmp[] = $geo->route ?? '';
                $tmp[] = $geo->street_number ?? '';
                $tmp[] = $geo->postal_code ?? '';
                $tmp[] = $geo->administrative_area_level_3 ?? '';
                $tmp[] = $geo->administrative_area_level_2_short ?? '';
                $this->attributes['full_address'] = implode(', ', $tmp);
            }
        }

        if (\is_array($value)) {
            $value = json_encode($value, JSON_THROW_ON_ERROR);
        }
        $this->attributes['address'] = $value;

        // dddx(['isJson'=>\isJson($value),'value'=>$value]);
    }

    /**
     * @param mixed $value
     *
     * @return bool|mixed|string
     */
    /*
     * public function getAddressAttribute($value) {
     * if (null !== $value) {
     * return json_decode($value);
     * }
     *
     * if ('' == $this->country) {
     * $this->country = 'Italia';
     * }
     * $val1 = (object) [
     * 'value' => $this->route.', '.$this->street_number.', '.$this->locality.', '.$this->administrative_area_level_2.', '.$this->country,
     * ];
     * $val1->latlng = (object) [
     * 'lat' => $this->latitude,
     * 'lng' => $this->longitude,
     * ];
     * foreach (Place::$address_components as $v) {
     * $val1->$v = $this->$v;
     * $val1->{$v.'_short'} = $this->{$v.'_short'};
     * }
     *
     * return json_encode($val1, 1);
     * //return response()->json($val1);
     * }
     */

    /**
     * ---.
     */
    public function getFullAddressAttribute(?string $value): ?string
    {
        if (null === $this->address) {
            return null;
        }
        if (is_string($this->address) && isJson($this->address)) {
            /*
             * $addr = json_decode($this->address);
             * if (\is_object($addr)) {
             * $addr = get_object_vars($addr);
             * }
             *
             * extract($addr);
             */
            $geo = GeoData::from(json_decode((string) $this->address, true, 512, JSON_THROW_ON_ERROR));

            $value = str_ireplace(', Italia', '', $geo->value);
            // Call to function is_array() with string will always evaluate to false.
            // if (\is_array($value)) {
            //    $value = implode(' ', $value);
            // }
            if (isset($geo->street_number)) {
                $str = $geo->street_number.', ';
                $before = Str::before($geo->value, $str);
                $after = Str::after($geo->value, $str);

                return $before.$str.''.($geo->postal_code ?? '').', '.$after;
            }
            if (isset($geo->administrative_area_level_3)) {
                $str = ', '.$geo->administrative_area_level_3;
                $before = Str::before($geo->value, $str);
                $after = Str::after($geo->value, $str);

                return $before.', '.($geo->postal_code ?? '').''.$str.''.$after;
            }
        }
        // Call to function is_object() with string|null will always evaluate to false.
        /*
         * if (\is_object($this->address)) {
         * $address = collect($this->address)->except(['value', 'latlng']);
         * $up = false;
         * foreach ($address->all() as $k => $v) {
         * if ($this->$k !== $v) {
         * $up = true;
         * break;
         * }
         * }
         * if ($up) {
         * $this->update($address->all());
         * }
         *
         * $tmp = [];
         * $tmp[] = $address->get('route');
         * $tmp[] = $address->get('street_number');
         * $tmp[] = $address->get('postal_code');
         * $tmp[] = $address->get('administrative_area_level_3');
         * $tmp[] = $address->get('administrative_area_level_2_short');
         * $value = implode(', ', $tmp);
         *
         * return $value;
         * }
         */
        $tmp = [];
        $tmp[] = $this->route;
        $tmp[] = $this->street_number;
        $tmp[] = $this->postal_code;
        $tmp[] = $this->administrative_area_level_3;
        $tmp[] = $this->administrative_area_level_2_short;

        return implode(', ', $tmp);
    }
}
