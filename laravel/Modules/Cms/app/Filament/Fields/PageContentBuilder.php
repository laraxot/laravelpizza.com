<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Notifications\Notification;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\Xot\Datas\ComponentFileData;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class PageContentBuilder
{
    public static function make(string $name, string $context = 'form'): Builder
    {
        /** @var DataCollection<int, ComponentFileData> $blocks */
        $blocks = app(GetAllBlocksAction::class)->execute();

        $blockList = self::buildBlockList($blocks, $context);

        /* @var list<Block> $blockList */
        return Builder::make($name)
            ->blocks($blockList)
            ->collapsible();
    }

    /**
     * @param DataCollection<int, ComponentFileData> $blocks
     *
     * @return list<Block>
     */
    private static function buildBlockList(DataCollection $blocks, string $context): array
    {
        /** @var list<Block> $blockList */ $blockList = [];

        foreach ($blocks as $block) {
            Assert::isInstanceOf($block, ComponentFileData::class, '['.__LINE__.']['.__FILE__.']');
            $class = $block->class;

            try {
                $blockInstance = $class::make(
                    name: $block->name,
                    context: $context,
                );
            } catch (\Error $e) {
                if (! app()->environment('testing')) {
                    report($e);
                    Notification::make()
                        ->danger()
                        ->title(__('cms::page_content_builder.messages.block_unavailable.title'))
                        ->body(__('cms::page_content_builder.messages.block_unavailable.body', ['block' => $block->name]))
                        ->send();
                }

                continue;
            }

            Assert::isInstanceOf(
                $blockInstance,
                Block::class,
                '['.__LINE__.']['.__FILE__.']'
            );
            $blockList[] = $blockInstance;
        }

        return $blockList;
    }
}
