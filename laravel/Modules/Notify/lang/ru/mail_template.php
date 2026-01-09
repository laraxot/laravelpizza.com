<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => [
            'name' => 'Уведомления',
            'description' => 'Управление email уведомлениями и их шаблонами',
        ],
        'label' => 'Email шаблоны',
        'plural' => 'Email шаблоны',
        'singular' => 'Email шаблон',
        'icon' => 'heroicon-o-envelope',
        'sort' => '1',
        'name' => 'Email шаблон',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'helper_text' => 'Уникальный идентификатор шаблона',
        ],
        'mailable' => [
            'label' => 'Класс Mailable',
            'placeholder' => 'Введите имя класса Mailable',
            'help' => 'PHP класс, который обрабатывает отправку email',
            'helper_text' => 'PHP класс, управляющий отправкой email',
            'description' => 'mailable',
        ],
        'subject' => [
            'label' => 'Тема',
            'placeholder' => 'Введите тему письма',
            'help' => 'Тема, которая появится в письме',
            'helper_text' => 'Тема письма',
            'description' => 'subject',
        ],
        'html_template' => [
            'label' => 'HTML содержимое',
            'placeholder' => 'Введите HTML содержимое письма',
            'help' => 'Содержимое письма в формате HTML',
            'helper_text' => 'HTML содержимое email шаблона',
            'description' => 'html_template',
        ],
        'text_template' => [
            'label' => 'Текстовое содержимое',
            'placeholder' => 'Введите текстовое содержимое письма',
            'help' => 'Текстовая версия письма для клиентов, не поддерживающих HTML',
            'helper_text' => 'Текстовая версия email шаблона',
            'description' => 'text_template',
        ],
        'version' => [
            'label' => 'Версия',
            'help' => 'Номер версии шаблона',
        ],
        'created_at' => [
            'label' => 'Создано',
            'helper_text' => 'Дата создания шаблона',
        ],
        'updated_at' => [
            'label' => 'Последнее изменение',
            'helper_text' => 'Дата последнего изменения шаблона',
        ],
        'from_email' => [
            'label' => 'Email отправителя',
            'helper_text' => 'Адрес электронной почты отправителя',
            'placeholder' => 'noreply@example.com',
        ],
        'from_name' => [
            'label' => 'Имя отправителя',
            'helper_text' => 'Отображаемое имя отправителя',
            'placeholder' => 'Название компании',
        ],
        'variables' => [
            'label' => 'Доступные переменные',
            'helper_text' => 'Список переменных, которые можно использовать в шаблоне',
            'placeholder' => 'напр: {{name}}, {{email}}',
        ],
        'is_markdown' => [
            'label' => 'Использовать Markdown',
            'helper_text' => 'Указывает, использует ли шаблон синтаксис Markdown',
        ],
        'status' => [
            'label' => 'Статус',
            'helper_text' => 'Текущий статус шаблона',
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
            'description' => 'Название шаблона',
            'helper_text' => 'Описательное имя для идентификации шаблона',
            'placeholder' => 'Напр: Добро пожаловать, Подтверждение заказа, Сброс пароля',
            'label' => 'Название шаблона',
        ],
        'params' => [
            'label' => 'Параметры',
            'helper_text' => 'Введите параметры, разделенные запятыми, которые можно использовать в шаблоне',
            'placeholder' => 'name, email, date, company',
            'description' => 'Доступные параметры для email шаблона',
        ],
    ],
    'filters' => [
        'search_placeholder' => 'Поиск шаблонов...',
        'version' => [
            'label' => 'Версия',
            'placeholder' => 'Выбрать версию',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Новый шаблон',
            'modal' => [
                'heading' => 'Создать email шаблон',
                'description' => 'Введите данные для нового email шаблона',
                'submit' => 'Создать',
            ],
        ],
        'edit' => [
            'label' => 'Редактировать',
            'modal' => [
                'heading' => 'Редактировать email шаблон',
                'description' => 'Изменить данные email шаблона',
                'submit' => 'Сохранить',
            ],
        ],
        'delete' => [
            'label' => 'Удалить',
            'modal' => [
                'heading' => 'Удалить email шаблон',
                'description' => 'Вы уверены, что хотите удалить этот шаблон? Это действие нельзя отменить.',
                'submit' => 'Удалить',
            ],
        ],
        'restore' => [
            'label' => 'Восстановить',
        ],
        'force_delete' => [
            'label' => 'Полное удаление',
            'modal' => [
                'heading' => 'Полное удаление email шаблона',
                'description' => 'Вы уверены, что хотите полностью удалить этот шаблон? Это действие нельзя отменить.',
                'submit' => 'Полное удаление',
            ],
        ],
        'new_version' => [
            'label' => 'Новая версия',
            'modal' => [
                'heading' => 'Создать новую версию',
                'description' => 'Создать новую версию email шаблона',
                'submit' => 'Создать версию',
            ],
        ],
        'preview' => [
            'label' => 'Предварительный просмотр',
            'tooltip' => 'Посмотреть предварительный просмотр письма',
            'success_message' => 'Предварительный просмотр успешно создан',
            'error_message' => 'Ошибка при создании предварительного просмотра',
        ],
        'test' => [
            'label' => 'Отправить тест',
            'tooltip' => 'Отправить тестовое письмо',
            'success_message' => 'Тестовое письмо успешно отправлено',
            'error_message' => 'Ошибка при отправке тестового письма',
        ],
        'duplicate' => [
            'label' => 'Дублировать',
            'tooltip' => 'Создать копию шаблона',
            'success_message' => 'Шаблон успешно дублирован',
            'error_message' => 'Ошибка при дублировании шаблона',
        ],
        'export' => [
            'label' => 'Экспорт',
            'tooltip' => 'Экспортировать шаблон в формат JSON',
            'success_message' => 'Шаблон успешно экспортирован',
            'error_message' => 'Ошибка при экспорте шаблона',
        ],
        'import' => [
            'label' => 'Импорт',
            'tooltip' => 'Импортировать шаблон из JSON файла',
            'success_message' => 'Шаблон успешно импортирован',
            'error_message' => 'Ошибка при импорте шаблона',
        ],
    ],
    'messages' => [
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
    ],
    'sections' => [
        'template' => [
            'label' => 'Шаблон',
            'description' => 'Основная информация шаблона',
        ],
        'versions' => [
            'label' => 'Версии',
            'description' => 'История версий шаблона',
        ],
        'logs' => [
            'label' => 'Журналы',
            'description' => 'История отправки шаблона',
        ],
        'main' => 'Основная информация',
        'content' => 'Содержимое',
        'styling' => 'Стили',
        'settings' => 'Настройки',
        'variables' => 'Переменные',
    ],
    'status' => [
        'sent' => 'Отправлено',
        'delivered' => 'Доставлено',
        'failed' => 'Неудачно',
        'opened' => 'Открыто',
        'clicked' => 'Кликнуто',
        'bounced' => 'Возвращено',
        'spam' => 'Помечено как спам',
    ],
    'model' => [
        'label' => 'email шаблон',
    ],
];
