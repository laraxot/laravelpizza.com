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
        Assert::isArray($products = Http::get('https://dummyjson.com/products')->json());
        Assert::isArray($products['products']);
        // filtering some attributes
        $products = Arr::map($products['products'], function ($item) {
            return Arr::only(
                $item,
                [
                    'id',
                    'title',
                    'description',
                    'price',
                    'rating',
                    'brand',
                    'category',
                    'thumbnail',
                ]
            );
        });

        return $products;
    }
}
