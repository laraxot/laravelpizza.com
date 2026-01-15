<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Digite o nome',
            'help' => 'Nome identificador do elemento',
            'description' => 'Nome do objeto',
            'helper_text' => '',
        ],
        'edit-name' => [
            'label' => 'Editar nome',
            'placeholder' => 'Novo nome',
            'help' => 'Modificar o nome existente',
            'description' => 'Ação para modificar o nome',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Alterar estado',
            'placeholder' => 'Selecionar novo estado',
            'help' => 'Modificar o estado atual',
            'description' => 'Ação para alterar o estado',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Estado',
            'placeholder' => 'Selecionar um estado',
            'help' => 'Estado atual do elemento',
            'description' => 'Condição atual do sistema',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Mensagem',
            'placeholder' => 'Digite uma mensagem',
            'help' => 'Mensagem informativa',
            'description' => 'Texto da mensagem',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Instância de estado inválida',
        'record_not_found' => 'Registo não encontrado',
        'transition_completed' => [
            'title' => 'Transição concluída',
            'body' => 'A transição de estado foi concluída com sucesso',
        ],
        'transition_error' => [
            'title' => 'Erro na transição',
        ],
    ],
];
