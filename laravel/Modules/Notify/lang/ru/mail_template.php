<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 
    array (
      'name' => 'Уведомления',
      'description' => 'Управление email уведомлениями и их шаблонами',
    ),
    'label' => 'Email шаблоны',
    'plural' => 'Email шаблоны',
    'singular' => 'Email шаблон',
    'icon' => 'heroicon-o-envelope',
    'sort' => '1',
    'name' => 'Email шаблон',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'helper_text' => 'Уникальный идентификатор шаблона',
      'tooltip' => '',
      'description' => '',
    ),
    'mailable' => 
    array (
      'label' => 'Класс Mailable',
      'placeholder' => 'Введите имя класса Mailable',
      'help' => 'PHP класс, который обрабатывает отправку email',
      'helper_text' => 'PHP класс, управляющий отправкой email',
      'description' => 'mailable',
      'tooltip' => '',
    ),
    'subject' => 
    array (
      'label' => 'Тема',
      'placeholder' => 'Введите тему письма',
      'help' => 'Тема, которая появится в письме',
      'helper_text' => 'Тема письма',
      'description' => 'subject',
      'tooltip' => '',
    ),
    'html_template' => 
    array (
      'label' => 'HTML содержимое',
      'placeholder' => 'Введите HTML содержимое письма',
      'help' => 'Содержимое письма в формате HTML',
      'helper_text' => 'HTML содержимое email шаблона',
      'description' => 'html_template',
      'tooltip' => '',
    ),
    'text_template' => 
    array (
      'label' => 'Текстовое содержимое',
      'placeholder' => 'Введите текстовое содержимое письма',
      'help' => 'Текстовая версия письма для клиентов, не поддерживающих HTML',
      'helper_text' => 'Текстовая версия email шаблона',
      'description' => 'text_template',
      'tooltip' => '',
    ),
    'version' => 
    array (
      'label' => 'Версия',
      'help' => 'Номер версии шаблона',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Создано',
      'helper_text' => 'Дата создания шаблона',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Последнее изменение',
      'helper_text' => 'Дата последнего изменения шаблона',
      'tooltip' => '',
      'description' => '',
    ),
    'from_email' => 
    array (
      'label' => 'Email отправителя',
      'helper_text' => 'Адрес электронной почты отправителя',
      'placeholder' => 'noreply@example.com',
      'tooltip' => '',
      'description' => '',
    ),
    'from_name' => 
    array (
      'label' => 'Имя отправителя',
      'helper_text' => 'Отображаемое имя отправителя',
      'placeholder' => 'Название компании',
      'tooltip' => '',
      'description' => '',
    ),
    'variables' => 
    array (
      'label' => 'Доступные переменные',
      'helper_text' => 'Список переменных, которые можно использовать в шаблоне',
      'placeholder' => 'напр: {{name}}, {{email}}',
      'tooltip' => '',
      'description' => '',
    ),
    'is_markdown' => 
    array (
      'label' => 'Использовать Markdown',
      'helper_text' => 'Указывает, использует ли шаблон синтаксис Markdown',
      'tooltip' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Статус',
      'helper_text' => 'Текущий статус шаблона',
      'tooltip' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'layout',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'slug',
      'description' => 'slug',
      'helper_text' => 'slug',
      'placeholder' => 'slug',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'description' => 'Название шаблона',
      'helper_text' => 'Описательное имя для идентификации шаблона',
      'placeholder' => 'Напр: Добро пожаловать, Подтверждение заказа, Сброс пароля',
      'label' => 'Название шаблона',
      'tooltip' => '',
    ),
    'params' => 
    array (
      'label' => 'Параметры',
      'helper_text' => 'Введите параметры, разделенные запятыми, которые можно использовать в шаблоне',
      'placeholder' => 'name, email, date, company',
      'description' => 'Доступные параметры для email шаблона',
      'tooltip' => '',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Поиск шаблонов...',
    'version' => 
    array (
      'label' => 'Версия',
      'placeholder' => 'Выбрать версию',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Новый шаблон',
      'modal' => 
      array (
        'heading' => 'Создать email шаблон',
        'description' => 'Введите данные для нового email шаблона',
        'submit' => 'Создать',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Редактировать',
      'modal' => 
      array (
        'heading' => 'Редактировать email шаблон',
        'description' => 'Изменить данные email шаблона',
        'submit' => 'Сохранить',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Удалить',
      'modal' => 
      array (
        'heading' => 'Удалить email шаблон',
        'description' => 'Вы уверены, что хотите удалить этот шаблон? Это действие нельзя отменить.',
        'submit' => 'Удалить',
      ),
    ),
    'restore' => 
    array (
      'label' => 'Восстановить',
    ),
    'force_delete' => 
    array (
      'label' => 'Полное удаление',
      'modal' => 
      array (
        'heading' => 'Полное удаление email шаблона',
        'description' => 'Вы уверены, что хотите полностью удалить этот шаблон? Это действие нельзя отменить.',
        'submit' => 'Полное удаление',
      ),
    ),
    'new_version' => 
    array (
      'label' => 'Новая версия',
      'modal' => 
      array (
        'heading' => 'Создать новую версию',
        'description' => 'Создать новую версию email шаблона',
        'submit' => 'Создать версию',
      ),
    ),
    'preview' => 
    array (
      'label' => 'Предварительный просмотр',
      'tooltip' => 'Посмотреть предварительный просмотр письма',
      'success_message' => 'Предварительный просмотр успешно создан',
      'error_message' => 'Ошибка при создании предварительного просмотра',
    ),
    'test' => 
    array (
      'label' => 'Отправить тест',
      'tooltip' => 'Отправить тестовое письмо',
      'success_message' => 'Тестовое письмо успешно отправлено',
      'error_message' => 'Ошибка при отправке тестового письма',
    ),
    'duplicate' => 
    array (
      'label' => 'Дублировать',
      'tooltip' => 'Создать копию шаблона',
      'success_message' => 'Шаблон успешно дублирован',
      'error_message' => 'Ошибка при дублировании шаблона',
    ),
    'export' => 
    array (
      'label' => 'Экспорт',
      'tooltip' => 'Экспортировать шаблон в формат JSON',
      'success_message' => 'Шаблон успешно экспортирован',
      'error_message' => 'Ошибка при экспорте шаблона',
    ),
    'import' => 
    array (
      'label' => 'Импорт',
      'tooltip' => 'Импортировать шаблон из JSON файла',
      'success_message' => 'Шаблон успешно импортирован',
      'error_message' => 'Ошибка при импорте шаблона',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Email шаблон успешно создан.',
    'updated' => 'Email шаблон успешно обновлен.',
    'deleted' => 'Email шаблон успешно удален.',
    'restored' => 'Email шаблон успешно восстановлен.',
    'force_deleted' => 'Email шаблон полностью удален.',
    'version_created' => 'Новая версия шаблона успешно создана.',
    'success' => 'Операция успешно выполнена',
    'error' => 'Произошла ошибка во время операции',
    'confirmation' => 'Вы уверены, что хотите продолжить эту операцию?',
    'template_created' => 'Email шаблон был успешно создан',
    'template_updated' => 'Email шаблон был успешно обновлен',
    'template_deleted' => 'Email шаблон был успешно удален',
  ),
  'sections' => 
  array (
    'template' => 
    array (
      'label' => 'Шаблон',
      'description' => 'Основная информация шаблона',
    ),
    'versions' => 
    array (
      'label' => 'Версии',
      'description' => 'История версий шаблона',
    ),
    'logs' => 
    array (
      'label' => 'Журналы',
      'description' => 'История отправки шаблона',
    ),
    'main' => 'Основная информация',
    'content' => 'Содержимое',
    'styling' => 'Стили',
    'settings' => 'Настройки',
    'variables' => 'Переменные',
  ),
  'status' => 
  array (
    'sent' => 'Отправлено',
    'delivered' => 'Доставлено',
    'failed' => 'Неудачно',
    'opened' => 'Открыто',
    'clicked' => 'Кликнуто',
    'bounced' => 'Возвращено',
    'spam' => 'Помечено как спам',
  ),
  'model' => 
  array (
    'label' => 'email шаблон',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
