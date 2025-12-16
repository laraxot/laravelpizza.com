<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'title' => 'Gerenciamento de Usuários',
            'roles' => [
                'all' => 'Todos os Papéis',
                'create' => 'Criar Papel',
                'edit' => 'Editar Papel',
                'management' => 'Gerenciamento de Papéis',
                'main' => 'Papéis',
            ],
            'users' => [
                'all' => 'Todos os Usuários',
                'change-password' => 'Alterar Senha',
                'create' => 'Criar Usuário',
                'deactivated' => 'Desativar Usuários',
                'deleted' => 'Excluir Usuários',
                'edit' => 'Editar Usuário',
                'main' => 'Usuários',
                'view' => 'Visualizar Usuário',
            ],
        ],
        'log-viewer' => [
            'main' => 'Visualizador de Log',
            'dashboard' => 'Painel de Controle',
            'logs' => 'Logs',
        ],
        'sidebar' => [
            'dashboard' => 'Painel de Controle',
            'general' => 'Geral',
            'system' => 'Sistema',
        ],
    ],
    'language-picker' => [
        'language' => 'Idioma',
        'langs' => [
            'ar' => 'العربية (Arabic)',
            'da' => 'Dinamarquês (Danish)',
            'de' => 'Alemão (German)',
            'el' => '(Greek)',
            'en' => 'Inglês (English)',
            'es' => 'Espanhol (Spanish)',
            'fr' => 'Francês (French)',
            'it' => 'Italiano (Italian)',
            'nl' => 'Holandês (Dutch)',
            'pt_BR' => 'Português do Brasil (Brazilian Portuguese)',
            'sv' => 'Sueco (Swedish)',
            'th' => 'Thai',
        ],
    ],
];
