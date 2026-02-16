<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Активность',
    'plural' => 'Активности',
    'group' => 
    array (
      'name' => 'Мониторинг',
      'description' => 'Мониторинг активности системы',
    ),
    'label' => 'Активность',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Пользователь',
      'placeholder' => 'Выберите пользователя',
      'help' => 'Пользователь, который выполнил действие',
      'name' => 
      array (
        'label' => 'Имя',
        'placeholder' => 'Введите имя',
        'help' => 'Полное имя пользователя',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Введите email',
        'help' => 'Адрес электронной почты пользователя',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => 'Роль',
        'placeholder' => 'Выберите роль',
        'help' => 'Роль пользователя в системе',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => 'Действие',
      'placeholder' => 'Выберите действие',
      'help' => 'Тип выполненного действия',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => 'Создано',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => 'Обновлено',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => 'Удалено',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => 'Просмотрено',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => 'Загружено',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => 'Загружено',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => 'Вошел',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => 'Вышел',
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
      'label' => 'Объект',
      'placeholder' => 'Выберите объект',
      'help' => 'Объект, на который повлияло действие',
      'type' => 
      array (
        'label' => 'Тип',
        'placeholder' => 'Тип объекта',
        'help' => 'Класс или тип объекта',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'ID',
        'placeholder' => 'ID объекта',
        'help' => 'Уникальный идентификатор объекта',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => 'Имя',
        'placeholder' => 'Имя объекта',
        'help' => 'Описательное имя объекта',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Описание',
      'placeholder' => 'Введите описание',
      'help' => 'Подробное описание активности',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'IP-адрес',
      'placeholder' => 'Например, 192.168.1.1',
      'help' => 'IP-адрес, с которого было выполнено действие',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'User Agent',
      'placeholder' => 'Браузер и операционная система',
      'help' => 'Информация о браузере и системе пользователя',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Дата',
      'placeholder' => 'Выберите дату и время',
      'help' => 'Дата и время создания активности',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'Свойства',
      'placeholder' => 'Дополнительные свойства',
      'help' => 'Дополнительные данные активности',
      'old' => 
      array (
        'label' => 'Старое значение',
        'placeholder' => 'Предыдущее значение',
        'help' => 'Значение до изменения',
      ),
      'new' => 
      array (
        'label' => 'Новое значение',
        'placeholder' => 'Текущее значение',
        'help' => 'Значение после изменения',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Показать/Скрыть столбцы',
      'help' => 'Настроить видимость столбцов',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Переупорядочить записи',
      'help' => 'Переупорядочить записи в таблице',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Сбросить фильтры',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Применить фильтры',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => 'Пользователь',
      'placeholder' => 'Фильтр по пользователю',
      'help' => 'Фильтровать активности по пользователю',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => 'Действие',
      'placeholder' => 'Фильтр по действию',
      'help' => 'Фильтровать активности по типу действия',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => 'Тип объекта',
      'placeholder' => 'Фильтр по типу объекта',
      'help' => 'Фильтровать активности по типу объекта',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => 'Диапазон дат',
      'placeholder' => 'Выберите диапазон',
      'help' => 'Фильтровать активности по диапазону дат',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => 'Сегодня',
        'yesterday' => 'Вчера',
        'last_7_days' => 'Последние 7 дней',
        'last_30_days' => 'Последние 30 дней',
        'this_month' => 'Этот месяц',
        'last_month' => 'Прошлый месяц',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'IP-адрес',
      'placeholder' => 'Фильтр по IP',
      'help' => 'Фильтровать активности по IP-адресу',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => 'Просмотреть детали',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => 'Детали успешно загружены',
      'error' => 'Ошибка загрузки деталей',
      'confirmation' => 'Вы хотите просмотреть детали этой активности?',
    ),
    'export' => 
    array (
      'label' => 'Экспорт',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => 'Экспорт успешно завершен',
      'error' => 'Ошибка при экспорте',
      'confirmation' => 'Вы хотите экспортировать выбранные активности?',
    ),
    'clear_old' => 
    array (
      'label' => 'Очистить старые',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Старые активности успешно удалены',
      'error' => 'Ошибка очистки активностей',
      'confirmation' => 'Вы уверены, что хотите удалить старые активности? Это действие нельзя отменить.',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Удалить выбранные',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Выбранные активности успешно удалены',
      'error' => 'Ошибка удаления активностей',
      'confirmation' => 'Вы уверены, что хотите удалить выбранные активности?',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'Для выбранных фильтров не найдено активностей',
    'cleared' => 'Старые активности успешно удалены',
    'exported' => 'Активности успешно экспортированы',
    'loading' => 'Загрузка активностей...',
    'error_loading' => 'Ошибка загрузки активностей',
    'empty_state' => 
    array (
      'title' => 'Нет записанных активностей',
      'description' => 'Пока нет активностей для отображения. Активности появятся здесь, когда пользователи начнут взаимодействовать с системой.',
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
        'label' => 'Дата',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => 'Пользователь',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => 'Действие',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => 'Объект',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => 'Описание',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => 'активность_{date}_{time}',
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
