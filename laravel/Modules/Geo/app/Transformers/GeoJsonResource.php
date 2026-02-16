<?php

declare(strict_types=1);

namespace Modules\Geo\Transformers;

/* TO FIX
 * 34     Call to an undefined method Modules\Cms\Contracts\PanelContract::imgSrc().
 * 34     Parameter #1 $model of static method Modules\Cms\Services\PanelService::make()->get() expects Illuminate\Database\Eloquent\Model, $this(Modules\Geo\Transformers\GeoJsonResource) given.
 */
/*
 *  GEOJSON e' uno standard
 * https://it.wikipedia.org/wiki/GeoJSON
 */
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as ResCollection;

/**
 * Class GeoJsonResource.
 *
 * @property int $id
 * @property string|null $post_type
 * @property int|null $post_id
 * @property int|null $url
 * @property int|null $title
 * @property int|null $subtitle
 * @property float|null $ratings_avg
 * @property string|null $phone
 * @property string|null $full_address
 * @property string|null $email
 * @property float $latitude
 * @property float $longitude
 */
class GeoJsonResource extends ResCollection
{
    public function toArray(Request $request): array
    {
        app()->getLocale();

        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $this->post_type.'-'.$this->post_id,
                // "index"=> 0,
                'isActive' => true,
                // "logo"=> "http://placehold.it/32x32",
                // 39     Parameter #1 $model of static method Modules\Cms\Services\PanelService::make()->get()
                // expects Illuminate\Database\Eloquent\Model,
                // $this(Modules\Geo\Transformers\GeoJsonResource) given.
                // 'image' => Panel::make()->get($this)->imgSrc(['width' => 200, 'height' => 200]),
                'link' => $this->url,
                'url' => '#',
                'name' => $this->title,
                'category' => $this->post_type,
                'email' => $this->email,
                'stars' => $this->ratings_avg,
                'phone' => $this->phone,
                'address' => $this->full_address,
                'about' => $this->subtitle."\r\n",
                'tags' => [
                    $this->post_type,
                    // "Restaurant",
                    // "Contemporary"
                ],
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [round($this->longitude, 7), round($this->latitude, 7)],
            ],
        ];
    }
}

/*
 * {"type":"Feature","properties":{"p":"vending_machine","id":"node/31605830"},"geometry":{"type":"Point","coordinates":[9.0796524,48.5308688]
 */
