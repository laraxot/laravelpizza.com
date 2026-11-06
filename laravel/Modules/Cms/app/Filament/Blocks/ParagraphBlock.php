<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\RichEditor;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class ParagraphBlock extends XotBaseBlock
{
    public static function getBlockSchema(): array
    {
        return [
            RichEditor::make('content')
                ->label('Contenuto')
                ->required()
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'underline',
                    'strike',
                    'link',
                    'orderedList',
                    'unorderedList',
                    'h2',
                    'h3',
                    'h4',
                    'blockquote',
                    'undo',
                    'redo',
                ])
                ->disableToolbarButtons([
                    'attachFiles',
                    'codeBlock',
                ]),
        ];
    }
}
