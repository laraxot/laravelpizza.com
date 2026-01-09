<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\Xot\Datas\ComponentFileData;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class PageContent
{
    public static function make(string $name, string $context = 'form'): Builder
    {
        /** @var DataCollection<int, ComponentFileData> $blocks */
        $blocks = app(GetAllBlocksAction::class)->execute();

        /** @var list<Block> $blockList */ $blockList = [];

        foreach ($blocks as $block) {
            Assert::isInstanceOf($block, ComponentFileData::class, '['.__LINE__.']['.__FILE__.']');
            $class = $block->class;
            $blockInstance = $class::make(context: $context);
            Assert::isInstanceOf(
                $blockInstance,
                Block::class,
                '['.__LINE__.']['.__FILE__.']'
            );
            $blockList[] = $blockInstance;
        }

        /* @var list<Block> $blockList */
        return Builder::make($name)
            ->blocks($blockList)
            ->collapsible();
    }
}
