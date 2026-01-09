<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => [
            'name' => 'Notificações',
            'description' => 'Gestão de notificações por e-mail e seus modelos',
        ],
        'label' => 'Modelos de E-mail',
        'plural' => 'Modelos de E-mail',
        'singular' => 'Modelo de E-mail',
        'icon' => 'heroicon-o-envelope',
        'sort' => '1',
        'name' => 'Modelo de E-mail',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'helper_text' => 'Identificador único do modelo',
        ],
        'mailable' => [
            'label' => 'Classe Mailable',
            'placeholder' => 'Insira o nome da classe Mailable',
            'help' => 'A classe PHP que lida com o envio de e-mails',
            'helper_text' => 'Classe PHP que gerencia o envio de e-mails',
            'description' => 'mailable',
        ],
        'subject' => [
            'label' => 'Assunto',
            'placeholder' => 'Insira o assunto do e-mail',
            'help' => 'O assunto que aparecerá no e-mail',
            'helper_text' => 'Assunto do e-mail',
            'description' => 'subject',
        ],
        'html_template' => [
            'label' => 'Conteúdo HTML',
            'placeholder' => 'Insira o conteúdo HTML do e-mail',
            'help' => 'O conteúdo do e-mail em formato HTML',
            'helper_text' => 'Conteúdo HTML do modelo de e-mail',
            'description' => 'html_template',
        ],
        'text_template' => [
            'label' => 'Conteúdo de Texto',
            'placeholder' => 'Insira o conteúdo de texto do e-mail',
            'help' => 'Versão de texto do e-mail para clientes que não suportam HTML',
            'helper_text' => 'Versão de texto do modelo de e-mail',
            'description' => 'text_template',
        ],
        'version' => [
            'label' => 'Versão',
            'help' => 'Número da versão do modelo',
        ],
        'created_at' => [
            'label' => 'Criado em',
            'helper_text' => 'Data de criação do modelo',
        ],
        'updated_at' => [
            'label' => 'Última Modificação',
            'helper_text' => 'Data da última modificação do modelo',
        ],
        'from_email' => [
            'label' => 'E-mail do remetente',
            'helper_text' => 'Endereço de e-mail do remetente',
            'placeholder' => 'noreply@exemplo.com',
        ],
        'from_name' => [
            'label' => 'Nome do remetente',
            'helper_text' => 'Nome exibido do remetente',
            'placeholder' => 'Nome da Empresa',
        ],
        'variables' => [
            'label' => 'Variáveis disponíveis',
            'helper_text' => 'Lista de variáveis que podem ser usadas no modelo',
            'placeholder' => 'ex: {{name}}, {{email}}',
        ],
        'is_markdown' => [
            'label' => 'Usar Markdown',
            'helper_text' => 'Indica se o modelo usa sintaxe Markdown',
        ],
        'status' => [
            'label' => 'Status',
            'helper_text' => 'Status atual do modelo',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'slug' => [
            'label' => 'slug',
            'description' => 'slug',
            'helper_text' => 'slug',
            'placeholder' => 'slug',
        ],
        'name' => [
            'description' => 'Nome do modelo',
            'helper_text' => 'Nome descritivo para identificar o modelo',
            'placeholder' => 'Ex: Bem-vindo, Confirmação de pedido, Redefinição de senha',
            'label' => 'Nome do Modelo',
        ],
        'params' => [
            'label' => 'Parâmetros',
            'helper_text' => 'Insira os parâmetros separados por vírgula que podem ser usados no modelo',
            'placeholder' => 'name, email, date, company',
            'description' => 'Parâmetros disponíveis para o modelo de e-mail',
        ],
    ],
    'filters' => [
        'search_placeholder' => 'Procurar modelos...',
        'version' => [
            'label' => 'Versão',
            'placeholder' => 'Selecionar versão',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Novo Modelo',
            'modal' => [
                'heading' => 'Criar Modelo de E-mail',
                'description' => 'Insira os detalhes para o novo modelo de e-mail',
                'submit' => 'Criar',
            ],
        ],
        'edit' => [
            'label' => 'Editar',
            'modal' => [
                'heading' => 'Editar Modelo de E-mail',
                'description' => 'Modificar os detalhes do modelo de e-mail',
                'submit' => 'Salvar',
            ],
        ],
        'delete' => [
            'label' => 'Excluir',
            'modal' => [
                'heading' => 'Excluir Modelo de E-mail',
                'description' => 'Tem certeza de que deseja excluir este modelo? Esta ação não pode ser desfeita.',
                'submit' => 'Excluir',
            ],
        ],
        'restore' => [
            'label' => 'Restaurar',
        ],
        'force_delete' => [
            'label' => 'Excluir Permanentemente',
            'modal' => [
                'heading' => 'Excluir Permanentemente Modelo de E-mail',
                'description' => 'Tem certeza de que deseja excluir permanentemente este modelo? Esta ação não pode ser desfeita.',
                'submit' => 'Excluir Permanentemente',
            ],
        ],
        'new_version' => [
            'label' => 'Nova Versão',
            'modal' => [
                'heading' => 'Criar Nova Versão',
                'description' => 'Criar uma nova versão do modelo de e-mail',
                'submit' => 'Criar Versão',
            ],
        ],
        'preview' => [
            'label' => 'Pré-visualizar',
            'tooltip' => 'Visualizar prévia do e-mail',
            'success_message' => 'Pré-visualização gerada com sucesso',
            'error_message' => 'Erro ao gerar pré-visualização',
        ],
        'test' => [
            'label' => 'Enviar teste',
            'tooltip' => 'Enviar um e-mail de teste',
            'success_message' => 'E-mail de teste enviado com sucesso',
            'error_message' => 'Erro ao enviar e-mail de teste',
        ],
        'duplicate' => [
            'label' => 'Duplicar',
            'tooltip' => 'Criar uma cópia do modelo',
            'success_message' => 'Modelo duplicado com sucesso',
            'error_message' => 'Erro ao duplicar modelo',
        ],
        'export' => [
            'label' => 'Exportar',
            'tooltip' => 'Exportar modelo em formato JSON',
            'success_message' => 'Modelo exportado com sucesso',
            'error_message' => 'Erro ao exportar modelo',
        ],
        'import' => [
            'label' => 'Importar',
            'tooltip' => 'Importar modelo de um arquivo JSON',
            'success_message' => 'Modelo importado com sucesso',
            'error_message' => 'Erro ao importar modelo',
        ],
    ],
    'messages' => [
        'created' => 'Modelo de e-mail criado com sucesso.',
        'updated' => 'Modelo de e-mail atualizado com sucesso.',
        'deleted' => 'Modelo de e-mail excluído com sucesso.',
        'restored' => 'Modelo de e-mail restaurado com sucesso.',
        'force_deleted' => 'Modelo de e-mail excluído permanentemente.',
        'version_created' => 'Nova versão do modelo criada com sucesso.',
        'success' => 'Operação concluída com sucesso',
        'error' => 'Ocorreu um erro durante a operação',
        'confirmation' => 'Tem certeza de que deseja prosseguir com esta operação?',
        'template_created' => 'O modelo de e-mail foi criado com sucesso',
        'template_updated' => 'O modelo de e-mail foi atualizado com sucesso',
        'template_deleted' => 'O modelo de e-mail foi excluído com sucesso',
    ],
    'sections' => [
        'template' => [
            'label' => 'Modelo',
            'description' => 'Informações principais do modelo',
        ],
        'versions' => [
            'label' => 'Versões',
            'description' => 'Histórico de versões do modelo',
        ],
        'logs' => [
            'label' => 'Registros',
            'description' => 'Histórico de envio do modelo',
        ],
        'main' => 'Informações Principais',
        'content' => 'Conteúdo',
        'styling' => 'Estilo',
        'settings' => 'Configurações',
        'variables' => 'Variáveis',
    ],
    'status' => [
        'sent' => 'Enviado',
        'delivered' => 'Entregue',
        'failed' => 'Falhou',
        'opened' => 'Aberto',
        'clicked' => 'Clicado',
        'bounced' => 'Devolvido',
        'spam' => 'Marcado como spam',
    ],
    'model' => [
        'label' => 'modelo de e-mail',
    ],
];
