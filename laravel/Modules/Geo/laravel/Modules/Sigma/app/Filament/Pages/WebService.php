<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Pages;

use Illuminate\Support\Str;
use Modules\Sigma\Actions\WebService\DownloadAction;
use Modules\Sigma\Actions\WebService\ImportJsonAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class WebService extends XotBasePage
{
    protected string $view = 'sigma::filament.pages.web-service';

    public string $msg = '...';

    /** @var list<string> */
    public array $formats = ['file', 'xml', 'json'];

    /** @var list<string> */
    public array $tbls = [
        // ----------------------------------

        'ANA02F', // si 32544
        'ANA03F', // si 12053
        'ANA10F', // si 746
        'FUN00F', // 218
        'MOV01F_anno', // si 10
        'QUA00F', // si 23142    //209 SECONDI ?
        'QUA03F', // si 3245
        'REPART', // si 980
        'REP00F', // si 19857
        'TQU00F', // si 4120
        'TURN01F', // NO          ---------------------- (devo creare tabella se non esiste)
        'VOC00F', // si 3093
        'STO00F',
        'WGIU03F_anno', // si 54196
        'WMEN00F_anno', // si 20601
        'WORAR01F', // si 2066
        'WSTR01F_anno', // NO    ----------------------
        'WSTR02F_anno', // si 26407
        'ASZ00F_anno',
        'ASZ00K1_anno',
        // 'ASZ00F_oggi', // Si 42
        // 'MOV01F_oggi', // si 0
        // 'WGIU03F_oggi', // si 0
        // 'WMEN00F_oggi', // si 0
        // 'WSTR01F_oggi', // si 4
        // 'WSTR02F_oggi', // si 0
        'IntegParam',
    ];

    #[\Override]
    protected function getViewData(): array
    {
        return ['a' => 'b'];
    }

    public function import(string $tbl): void
    {
        /** @var string $format */
        $format = $this->formats[2] ?? 'json';

        $res = app(DownloadAction::class)->execute($tbl, $format);
        $this->msg = $res->message.'<br/>'.$this->msg;
        // dddx($res);
        /** @var class-string<ImportJsonAction> $importClass */
        $importClass = '\Modules\Sigma\Actions\WebService\Import'.Str::studly($format).'Action';

        if (! class_exists($importClass)) {
            $this->msg = '<h2 style="color:red;">Classe non trovata: '.$importClass.'</h2>'.$this->msg;

            return;
        }

        /** @var ImportJsonAction $importAction */
        $importAction = app($importClass);
        /** @var string $result */
        $result = $importAction->execute($res->filename, $res->disk, $tbl);
        $this->msg = $result.'<br/>'.$this->msg;
    }
}
