<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Arr;
use Modules\Lang\Datas\TranslationData;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;

class PublishTranslationAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(TranslationData $translationData): void
    {
        /*
         * $hints=app('translator')->getLoader()->namespaces();
         * $path=collect($hints)->get($row->namespace);
         * if($path==null){
         * throw new Exception('['.__LINE__.']['.class_basename($this).']');
         * }
         * $filename=app(\Modules\Xot\Actions\File\FixPathAction::class)->execute($path.'/'.$row->lang.'/'.$row->group.'.php');
         */
        $filename = $translationData->getFilename();
        /*
         * $data=[];
         * if(File::exists($filename)){
         * $data=File::getRequire($filename);
         * }
         */
        $data = $translationData->getData();
        $updatedData = $data;
        Arr::set($updatedData, $translationData->item, $translationData->value);
        if ($data !== $updatedData) {
            app(SaveArrayAction::class)->execute(
                data: $updatedData,
                filename: $filename,
            );
        }
    }
}
