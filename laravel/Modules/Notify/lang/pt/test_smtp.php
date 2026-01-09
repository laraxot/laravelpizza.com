<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Teste SMTP',
        'group' => 'Notificações',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'Teste SMTP',
    'plural_label' => 'Testes SMTP',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'host' => [
            'label' => 'Host',
        ],
        'port' => [
            'label' => 'Porta',
        ],
        'username' => [
            'label' => 'Nome de Usuário',
        ],
        'password' => [
            'label' => 'Senha',
        ],
        'encryption' => [
            'label' => 'Criptografia',
        ],
        'from_address' => [
            'label' => 'Endereço Remetente',
        ],
        'from_name' => [
            'label' => 'Nome Remetente',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'last_tested_at' => [
            'label' => 'Último Teste Em',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
        'body_html' => [
            'description' => 'Corpo HTML',
            'helper_text' => 'Conteúdo HTML do email',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Sair',
            'icon' => 'logout',
            'label' => 'Sair',
        ],
        'emailFormActions' => [
            'tooltip' => 'Ações do Formulário de Email',
            'icon' => 'emailFormActions',
            'label' => 'Ações do Formulário de Email',
        ],
        'profile' => [
            'tooltip' => 'Perfil',
            'icon' => 'profile',
        ],
        'send_test_email' => [
            'label' => 'Enviar Email de Teste',
        ],
        'test_connection' => [
            'label' => 'Testar Conexão',
        ],
    ],
];
