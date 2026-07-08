<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'progressione',
        'plural' => 'progressioni',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
    ],
    'actions' => [
        'import' => [
            'name' => 'Importa da file',
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'name' => 'Esporta dati',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'list_log_activities' => [
            'label' => 'list_log_activities',
            'icon' => 'list_log_activities',
            'tooltip' => 'list_log_activities',
        ],
        'send-mail' => [
            'label' => 'send-mail',
            'icon' => 'send-mail',
            'tooltip' => 'send-mail',
        ],
        'zip-schede' => [
            'label' => 'zip-schede',
            'icon' => 'zip-schede',
            'tooltip' => 'zip-schede',
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
        ],
        'merge_double_row_cateco_year' => [
            'label' => 'merge_double_row_cateco_year',
            'icon' => 'merge_double_row_cateco_year',
            'tooltip' => 'merge_double_row_cateco_year',
        ],
        'export_xls' => [
            'label' => 'export_xls',
            'icon' => 'export_xls',
            'tooltip' => 'export_xls',
        ],
        'ricalcola' => [
            'label' => 'ricalcola',
            'icon' => 'ricalcola',
            'tooltip' => 'ricalcola',
        ],
    ],
    'fields' => [
        'name' => 'Nome',
        'parent' => 'Padre',
        'parent.name' => 'Padre',
        'parent_name' => 'Padre',
        'assets' => 'assets',
        'id' => [
            'label' => 'id',
        ],
        'id_placeholder' => ' ',
        'cognome' => [
            'label' => 'cognome',
        ],
        'cognome_placeholder' => ' ',
        'nome' => 'Nome',
        'nome_placeholder' => ' ',
        'ente' => 'ente',
        'matr' => [
            'label' => 'matr',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
            'placeholder' => 'ha_diritto',
            'helper_text' => 'ha_diritto',
            'description' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'motivo_placeholder' => ' ',
        'stabi' => 'stabi',
        'stabi_txt' => 'stabi_txt',
        'repar' => 'repar',
        'repar_txt' => 'repar_txt',
        'rep2kd' => 'rep2kd',
        'rep2ka' => 'rep2ka',
        'propro' => 'propro',
        'posfun' => 'posfun',
        'qua2kd' => 'qua2kd',
        'qua2ka' => 'qua2ka',
        'categoria_eco' => 'categoria_eco',
        'anno' => [
            'label' => 'anno',
            'placeholder' => 'anno',
            'helper_text' => 'anno',
            'description' => 'anno',
        ],
        'criteri' => [
            'label' => 'criteri',
        ],
        'gg' => [
            'label' => 'gg',
        ],
        'gg_no_asz' => [
            'label' => 'gg_no_asz',
        ],
        'gg_asz' => [
            'label' => 'gg_asz',
        ],
        'gg_cateco_no_posfun_no_asz' => [
            'label' => 'gg_cateco_no_posfun_no_asz',
        ],
        'eta' => [
            'label' => 'eta',
        ],
        'periodo' => [
            'label' => 'periodo',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'al' => [
            'label' => 'al',
        ],
        'anno/valutatore' => [
            'label' => 'anno/valutatore',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'description' => 'valutatore_id',
        ],
    ],
    'schede' => [
        'field' => [
            'stabi' => 'stabi',
            'valutatore_id' => 'Valutatore',
            'valutatore_id_placeholder' => '---',
            'year' => 'Anno',
            'year_placeholder' => 'anno es 2019',
            'sort_by_placeholder' => '  ',
            'sort_order_placeholder' => '  ',
        ],
    ],
    'tab' => [
        'index' => 'lista',
        'create' => 'Aggiungi.',
    ],
];
