<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Atividade',
    'plural' => 'Atividades',
    'group' => 
    array (
      'name' => 'Monitoramento',
      'description' => 'Monitoramento de atividade do sistema',
    ),
    'label' => 'Atividade',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Usuário',
      'placeholder' => 'Selecione um usuário',
      'help' => 'O usuário que realizou a ação',
      'name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Insira o nome',
        'help' => 'Nome completo do usuário',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Insira o email',
        'help' => 'Endereço de email do usuário',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => 'Função',
        'placeholder' => 'Selecione uma função',
        'help' => 'Função do usuário no sistema',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => 'Ação',
      'placeholder' => 'Selecione uma ação',
      'help' => 'Tipo de ação realizada',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => 'Criado',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => 'Atualizado',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => 'Excluído',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => 'Visualizado',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => 'Baixado',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => 'Enviado',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => 'Conectado',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => 'Desconectado',
          'icon' => 'heroicon-o-arrow-left-on-rectangle',
          'color' => 'gray',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Assunto',
      'placeholder' => 'Selecione um assunto',
      'help' => 'O objeto afetado pela ação',
      'type' => 
      array (
        'label' => 'Tipo',
        'placeholder' => 'Tipo de objeto',
        'help' => 'Classe ou tipo do objeto',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'ID',
        'placeholder' => 'ID do objeto',
        'help' => 'Identificador único do objeto',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Nome do objeto',
        'help' => 'Nome descritivo do objeto',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrição',
      'placeholder' => 'Insira uma descrição',
      'help' => 'Descrição detalhada da atividade',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'Endereço IP',
      'placeholder' => 'Ex. 192.168.1.1',
      'help' => 'Endereço IP de onde a ação foi realizada',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'Agente de Usuário',
      'placeholder' => 'Navegador e sistema operacional',
      'help' => 'Informações sobre o navegador e sistema do usuário',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data',
      'placeholder' => 'Selecione data e hora',
      'help' => 'Data e hora em que a atividade foi criada',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'Propriedades',
      'placeholder' => 'Propriedades adicionais',
      'help' => 'Dados adicionais da atividade',
      'old' => 
      array (
        'label' => 'Valor Antigo',
        'placeholder' => 'Valor anterior',
        'help' => 'Valor antes da alteração',
      ),
      'new' => 
      array (
        'label' => 'Novo Valor',
        'placeholder' => 'Valor atual',
        'help' => 'Valor após a alteração',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostrar/Ocultar Colunas',
      'help' => 'Configurar visibilidade das colunas',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Reordenar Registros',
      'help' => 'Reordenar registros na tabela',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Redefinir Filtros',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Aplicar Filtros',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => 'Usuário',
      'placeholder' => 'Filtrar por usuário',
      'help' => 'Filtrar atividades por usuário',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => 'Ação',
      'placeholder' => 'Filtrar por ação',
      'help' => 'Filtrar atividades por tipo de ação',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => 'Tipo de Assunto',
      'placeholder' => 'Filtrar por tipo de assunto',
      'help' => 'Filtrar atividades por tipo de assunto',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => 'Intervalo de Data',
      'placeholder' => 'Selecionar intervalo',
      'help' => 'Filtrar atividades por intervalo de data',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => 'Hoje',
        'yesterday' => 'Ontem',
        'last_7_days' => 'Últimos 7 Dias',
        'last_30_days' => 'Últimos 30 Dias',
        'this_month' => 'Este Mês',
        'last_month' => 'Mês Passado',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'Endereço IP',
      'placeholder' => 'Filtrar por IP',
      'help' => 'Filtrar atividades por endereço IP',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => 'Ver Detalhes',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => 'Detalhes carregados com sucesso',
      'error' => 'Erro ao carregar detalhes',
      'confirmation' => 'Deseja ver os detalhes desta atividade?',
    ),
    'export' => 
    array (
      'label' => 'Exportar',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => 'Exportação concluída com sucesso',
      'error' => 'Erro durante exportação',
      'confirmation' => 'Deseja exportar as atividades selecionadas?',
    ),
    'clear_old' => 
    array (
      'label' => 'Limpar Antigas',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Atividades antigas excluídas com sucesso',
      'error' => 'Erro ao limpar atividades',
      'confirmation' => 'Tem certeza de que deseja excluir as atividades antigas? Esta ação não pode ser desfeita.',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Excluir Selecionadas',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Atividades selecionadas excluídas com sucesso',
      'error' => 'Erro ao excluir atividades',
      'confirmation' => 'Tem certeza de que deseja excluir as atividades selecionadas?',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'Nenhuma atividade encontrada para os filtros selecionados',
    'cleared' => 'Atividades antigas excluídas com sucesso',
    'exported' => 'Atividades exportadas com sucesso',
    'loading' => 'Carregando atividades...',
    'error_loading' => 'Erro ao carregar atividades',
    'empty_state' => 
    array (
      'title' => 'Nenhuma atividade registrada',
      'description' => 'Ainda não há atividades para exibir. As atividades aparecerão aqui quando os usuários começarem a interagir com o sistema.',
    ),
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 
      array (
        'label' => 'CSV',
        'mime_type' => 'text/csv',
        'extension' => 'csv',
        'icon' => 'heroicon-o-document-text',
      ),
      'excel' => 
      array (
        'label' => 'Excel',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'extension' => 'xlsx',
        'icon' => 'heroicon-o-table-cells',
      ),
      'pdf' => 
      array (
        'label' => 'PDF',
        'mime_type' => 'application/pdf',
        'extension' => 'pdf',
        'icon' => 'heroicon-o-document',
      ),
    ),
    'columns' => 
    array (
      'date' => 
      array (
        'label' => 'Data',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => 'Usuário',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => 'Ação',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => 'Assunto',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => 'Descrição',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => 'atividade_{date}_{time}',
    'max_records' => '10000',
  ),
  'permissions' => 
  array (
    'view' => 'activities.view',
    'create' => 'activities.create',
    'update' => 'activities.update',
    'delete' => 'activities.delete',
    'export' => 'activities.export',
    'clear_old' => 'activities.clear_old',
  ),
  'pagination' => 
  array (
    'per_page' => '25',
    'options' => 
    array (
      0 => '10',
      1 => '25',
      2 => '50',
      3 => '100',
    ),
  ),
  'cache' => 
  array (
    'ttl' => '300',
    'tags' => 
    array (
      0 => 'activities',
      1 => 'monitoring',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
