<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Prediction;

use Spatie\QueueableAction\QueueableAction;

final class GetPredictionFallbackTemplatesAction
{
    use QueueableAction;

    /** @return array<int, array<string, mixed>> */
    public function execute(): array
    {
        return [
            [
                'category' => 'Sport',
                'title' => 'La squadra italiana vincera una coppa europea entro la fine della stagione?',
                'subtitle' => 'Calcio europeo',
                'description' => 'Mercato su una possibile vittoria internazionale di un club italiano nella stagione corrente.',
                'analysis' => 'Il mercato combina forma recente, profondita della rosa e calendario residuo. La domanda e risolvibile con un esito pubblico e chiaro.',
                'tags' => ['sport', 'calcio', 'europa'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Crypto',
                'title' => 'Bitcoin chiudera il trimestre sopra i 120000 dollari?',
                'subtitle' => 'Mercati crypto',
                'description' => 'Predizione sul prezzo di chiusura trimestrale di Bitcoin rispetto a una soglia chiara.',
                'analysis' => 'La domanda e verificabile su fonti di mercato pubbliche e ha una soglia netta. E utile per utenti che seguono momentum e volatilita.',
                'tags' => ['crypto', 'bitcoin', 'mercati'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Politica',
                'title' => 'Il governo approvera una riforma fiscale strutturale entro sei mesi?',
                'subtitle' => 'Politica italiana',
                'description' => 'Mercato politico su approvazione formale di una riforma fiscale entro una finestra temporale definita.',
                'analysis' => 'La risoluzione puo essere legata a fonti istituzionali. La domanda resta concreta e non dipende da interpretazioni troppo elastiche.',
                'tags' => ['politica', 'italia', 'riforme'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Tecnologia',
                'title' => 'Un nuovo modello AI open source superera il benchmark di riferimento entro 90 giorni?',
                'subtitle' => 'AI e benchmark',
                'description' => 'Predizione su rilascio e performance di un modello AI open source rispetto a un benchmark noto.',
                'analysis' => 'La metrica deve essere definita prima della pubblicazione del mercato. Questo rende la risoluzione trasparente e difendibile.',
                'tags' => ['ai', 'open-source', 'benchmark'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Economia',
                'title' => 'La BCE tagliera i tassi almeno due volte entro l anno?',
                'subtitle' => 'Politica monetaria',
                'description' => 'Mercato macroeconomico legato alle decisioni ufficiali sui tassi nell anno in corso.',
                'analysis' => 'La domanda ha una fonte di risoluzione ufficiale e facilita una lettura probabilistica chiara da parte degli utenti.',
                'tags' => ['economia', 'bce', 'tassi'],
                'options' => ['0.25%', '0.50%', 'Mantenimento', 'Altro'],
            ],
            [
                'category' => 'Intrattenimento',
                'title' => 'Un film italiano entrera nella top 10 box office europea entro l estate?',
                'subtitle' => 'Cinema europeo',
                'description' => 'Mercato entertainment basato su ranking di box office europei in una finestra temporale definita.',
                'analysis' => 'La domanda usa una metrica pubblica e permette una risoluzione semplice. Il copy puo attirare anche utenti non specialisti.',
                'tags' => ['cinema', 'box-office', 'europa'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Scienza',
                'title' => 'Una terapia innovativa otterra un via libera regolatorio entro 12 mesi?',
                'subtitle' => 'Ricerca e salute',
                'description' => 'Predizione su un evento regolatorio chiaro relativo a una terapia innovativa.',
                'analysis' => 'La risoluzione e ancorata a una decisione pubblica. Il mercato e utile per utenti interessati a scienza applicata e health innovation.',
                'tags' => ['scienza', 'salute', 'regolatorio'],
                'options' => ['Sì', 'No'],
            ],
        ];
    }
}
