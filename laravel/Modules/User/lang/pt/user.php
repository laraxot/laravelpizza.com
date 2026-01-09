<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'Anexar Usuário',
        'associate_user' => 'Associar Usuário',
        'user_actions' => 'Ações do Usuário',
        'view' => 'Visualizar',
        'edit' => 'Editar',
        'detach' => 'Desvincular',
        'row_actions' => 'Ações',
        'delete_selected' => 'Excluir Selecionados',
        'confirm_detach' => 'Tem certeza de que deseja desvincular este usuário?',
        'confirm_delete' => 'Tem certeza de que deseja excluir os usuários selecionados?',
        'success_attached' => 'Usuário anexado com sucesso',
        'success_detached' => 'Usuário desvinculado com sucesso',
        'success_deleted' => 'Usuários excluídos com sucesso',
        'toggle_layout' => 'Alternar Layout',
        'create' => 'Criar Usuário',
        'delete' => 'Excluir Usuário',
        'associate' => 'Associar Usuário',
        'bulk_delete' => 'Excluir Selecionados',
        'bulk_detach' => 'Desvincular Selecionados',
        'impersonate' => 'Personificar Usuário',
        'stop_impersonating' => 'Parar Personificação',
        'block' => 'Bloquear',
        'unblock' => 'Desbloquear',
        'send_reset_link' => 'Enviar Link de Redefinição',
        'verify_email' => 'Verificar Email',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Insira o nome',
            'description' => 'nome',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Insira o email',
            'description' => 'email',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Data de Criação',
        ],
        'updated_at' => [
            'label' => 'Última Modificação',
        ],
        'role' => [
            'label' => 'Função',
        ],
        'active' => 'Ativo',
        'id' => [
            'label' => 'ID',
        ],
        'password' => [
            'label' => 'Senha',
            'placeholder' => 'Insira a senha',
            'description' => 'senha',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirmar Senha',
            'placeholder' => 'Confirme a senha',
        ],
        'email_verified_at' => [
            'label' => 'Email Verificado em',
        ],
        'current_password' => [
            'label' => 'Senha Atual',
            'placeholder' => 'Insira a senha atual',
        ],
        'roles' => [
            'label' => 'Funções',
        ],
        'permissions' => [
            'label' => 'Permissões',
        ],
        'status' => [
            'label' => 'Status',
            'options' => [
                'active' => 'Ativo',
                'inactive' => 'Inativo',
                'blocked' => 'Bloqueado',
            ],
        ],
        'last_login' => [
            'label' => 'Último Login',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'language' => [
            'label' => 'Idioma',
        ],
        'timezone' => [
            'label' => 'Fuso Horário',
        ],
        'password_expires_at' => [
            'label' => 'Expiração da Senha',
        ],
        'verified' => [
            'label' => 'Verificado',
        ],
        'unverified' => [
            'label' => 'Não Verificado',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'isActive' => [
            'label' => 'isActive',
        ],
        'deactivate' => [
            'label' => 'deactivate',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'changePassword' => [
            'label' => 'changePassword',
        ],
    ],
    'filters' => [
        'active_users' => 'Usuários Ativos',
        'creation_date' => 'Data de Criação',
        'date_from' => 'De',
        'date_to' => 'Até',
        'verified' => 'Usuários Verificados',
        'unverified' => 'Usuários Não Verificados',
    ],
    'messages' => [
        'no_records' => 'Nenhum usuário encontrado',
        'loading' => 'Carregando usuários...',
        'search' => 'Buscar usuários...',
        'credentials_incorrect' => 'As credenciais fornecidas estão incorretas.',
        'created' => 'Usuário criado com sucesso',
        'updated' => 'Usuário atualizado com sucesso',
        'deleted' => 'Usuário excluído com sucesso',
        'blocked' => 'Usuário bloqueado com sucesso',
        'unblocked' => 'Usuário desbloqueado com sucesso',
        'reset_link_sent' => 'Link de redefinição enviado',
        'email_verified' => 'Email verificado com sucesso',
        'impersonating' => 'Você está personificando o usuário :name',
        'login_success' => 'Login bem-sucedido',
        'validation_error' => 'Erro de validação',
        'login_error' => 'Ocorreu um erro durante o login. Por favor, tente novamente mais tarde.',
    ],
    'modals' => [
        'create' => [
            'heading' => 'Criar Usuário',
            'description' => 'Criar um novo registro de usuário',
            'actions' => [
                'submit' => 'Criar',
                'cancel' => 'Cancelar',
            ],
        ],
        'edit' => [
            'heading' => 'Editar Usuário',
            'description' => 'Modificar informações do usuário',
            'actions' => [
                'submit' => 'Salvar Alterações',
                'cancel' => 'Cancelar',
            ],
        ],
        'delete' => [
            'heading' => 'Excluir Usuário',
            'description' => 'Tem certeza de que deseja excluir este usuário?',
            'actions' => [
                'submit' => 'Excluir',
                'cancel' => 'Cancelar',
            ],
        ],
        'associate' => [
            'heading' => 'Associar Usuário',
            'description' => 'Selecione um usuário para associar',
            'actions' => [
                'submit' => 'Associar',
                'cancel' => 'Cancelar',
            ],
        ],
        'detach' => [
            'heading' => 'Desvincular Usuário',
            'description' => 'Tem certeza de que deseja desvincular este usuário?',
            'actions' => [
                'submit' => 'Desvincular',
                'cancel' => 'Cancelar',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'Excluir Usuários Selecionados',
            'description' => 'Tem certeza de que deseja excluir os usuários selecionados?',
            'actions' => [
                'submit' => 'Excluir Selecionados',
                'cancel' => 'Cancelar',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'Desvincular Usuários Selecionados',
            'description' => 'Tem certeza de que deseja desvincular os usuários selecionados?',
            'actions' => [
                'submit' => 'Desvincular Selecionados',
                'cancel' => 'Cancelar',
            ],
        ],
    ],
    'navigation' => [
        'name' => 'Usuários',
        'plural' => 'Usuários',
        'group' => [
            'name' => 'Gestão de Usuários',
            'description' => 'Gestão de usuários e suas permissões',
        ],
        'label' => 'Usuários',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'validation' => [
        'email_unique' => 'Este email já está em uso',
        'password_min' => 'A senha deve ter pelo menos :min caracteres',
        'password_confirmed' => 'As senhas não coincidem',
        'current_password' => 'A senha atual está incorreta',
    ],
    'permissions' => [
        'view_users' => 'Visualizar usuários',
        'create_users' => 'Criar usuários',
        'edit_users' => 'Editar usuários',
        'delete_users' => 'Excluir usuários',
        'impersonate_users' => 'Personificar usuários',
        'manage_roles' => 'Gerenciar funções',
    ],
    'model' => [
        'label' => 'Usuário',
    ],
];
