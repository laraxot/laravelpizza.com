<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Dummy;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetProductsArrayDummyAction
{
    use QueueableAction;

    /**
     * Execute the function with the given model class.
     *
     * @throws \Exception Generating Factory [factory_class] press [F5] to refresh page [__LINE__][__FILE__]
     */
    public function execute(): array
    {
        // API
        $response = Http::get('https://dummyjson.com/products');

        Assert::isArray($products = $response->json());
        Assert::isArray($products['products']);

        // filtering some attributes
        return Arr::map($products['products'], static function ($item) {
            // Verifichiamo che $item sia un array prima di usare Arr::only
            if (! \is_array($item)) {
                return []; // Restituiamo un array vuoto se $item non è un array
            }

            return Arr::only($item, [
                'id',
                'title',
                'description',
                'price',
                'rating',
                'brand',
                'category',
                'thumbnail',
            ]);
        });
    }
}
