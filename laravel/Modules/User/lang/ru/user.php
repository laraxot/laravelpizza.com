<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'Прикрепить пользователя',
        'associate_user' => 'Связать пользователя',
        'user_actions' => 'Действия пользователя',
        'view' => 'Просмотр',
        'edit' => 'Редактировать',
        'detach' => 'Отсоединить',
        'row_actions' => 'Действия',
        'delete_selected' => 'Удалить выбранные',
        'confirm_detach' => 'Вы уверены, что хотите отсоединить этого пользователя?',
        'confirm_delete' => 'Вы уверены, что хотите удалить выбранных пользователей?',
        'success_attached' => 'Пользователь успешно прикреплен',
        'success_detached' => 'Пользователь успешно отсоединен',
        'success_deleted' => 'Пользователи успешно удалены',
        'toggle_layout' => 'Переключить макет',
        'create' => 'Создать пользователя',
        'delete' => 'Удалить пользователя',
        'associate' => 'Связать пользователя',
        'bulk_delete' => 'Удалить выбранные',
        'bulk_detach' => 'Отсоединить выбранные',
        'impersonate' => 'Войти как пользователь',
        'stop_impersonating' => 'Выйти из режима имитации',
        'block' => 'Заблокировать',
        'unblock' => 'Разблокировать',
        'send_reset_link' => 'Отправить ссылку на сброс',
        'verify_email' => 'Подтвердить email',
    ],
    'fields' => [
        'name' => [
            'label' => 'Имя',
            'placeholder' => 'Введите имя',
            'description' => 'имя',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Введите email',
            'description' => 'email',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Дата создания',
        ],
        'updated_at' => [
            'label' => 'Последнее изменение',
        ],
        'role' => [
            'label' => 'Роль',
        ],
        'active' => 'Активный',
        'id' => [
            'label' => 'ID',
        ],
        'password' => [
            'label' => 'Пароль',
            'placeholder' => 'Введите пароль',
            'description' => 'пароль',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => 'Подтверждение пароля',
            'placeholder' => 'Подтвердите пароль',
        ],
        'email_verified_at' => [
            'label' => 'Email подтвержден',
        ],
        'current_password' => [
            'label' => 'Текущий пароль',
            'placeholder' => 'Введите текущий пароль',
        ],
        'roles' => [
            'label' => 'Роли',
        ],
        'permissions' => [
            'label' => 'Разрешения',
        ],
        'status' => [
            'label' => 'Статус',
            'options' => [
                'active' => 'Активный',
                'inactive' => 'Неактивный',
                'blocked' => 'Заблокирован',
            ],
        ],
        'last_login' => [
            'label' => 'Последний вход',
        ],
        'avatar' => [
            'label' => 'Аватар',
        ],
        'language' => [
            'label' => 'Язык',
        ],
        'timezone' => [
            'label' => 'Часовой пояс',
        ],
        'password_expires_at' => [
            'label' => 'Истечение пароля',
        ],
        'verified' => [
            'label' => 'Подтвержден',
        ],
        'unverified' => [
            'label' => 'Не подтвержден',
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
        'active_users' => 'Активные пользователи',
        'creation_date' => 'Дата создания',
        'date_from' => 'С',
        'date_to' => 'По',
        'verified' => 'Подтвержденные пользователи',
        'unverified' => 'Неподтвержденные пользователи',
    ],
    'messages' => [
        'no_records' => 'Пользователи не найдены',
        'loading' => 'Загрузка пользователей...',
        'search' => 'Поиск пользователей...',
        'credentials_incorrect' => 'Предоставленные учетные данные некорректны.',
        'created' => 'Пользователь успешно создан',
        'updated' => 'Пользователь успешно обновлен',
        'deleted' => 'Пользователь успешно удален',
        'blocked' => 'Пользователь успешно заблокирован',
        'unblocked' => 'Пользователь успешно разблокирован',
        'reset_link_sent' => 'Ссылка на сброс отправлена',
        'email_verified' => 'Email успешно подтвержден',
        'impersonating' => 'Вы вошли как пользователь :name',
        'login_success' => 'Успешный вход',
        'validation_error' => 'Ошибка проверки',
        'login_error' => 'Произошла ошибка при входе. Пожалуйста, попробуйте позже.',
    ],
    'modals' => [
        'create' => [
            'heading' => 'Создать пользователя',
            'description' => 'Создать новую запись пользователя',
            'actions' => [
                'submit' => 'Создать',
                'cancel' => 'Отмена',
            ],
        ],
        'edit' => [
            'heading' => 'Редактировать пользователя',
            'description' => 'Изменить информацию пользователя',
            'actions' => [
                'submit' => 'Сохранить изменения',
                'cancel' => 'Отмена',
            ],
        ],
        'delete' => [
            'heading' => 'Удалить пользователя',
            'description' => 'Вы уверены, что хотите удалить этого пользователя?',
            'actions' => [
                'submit' => 'Удалить',
                'cancel' => 'Отмена',
            ],
        ],
        'associate' => [
            'heading' => 'Связать пользователя',
            'description' => 'Выберите пользователя для связи',
            'actions' => [
                'submit' => 'Связать',
                'cancel' => 'Отмена',
            ],
        ],
        'detach' => [
            'heading' => 'Отсоединить пользователя',
            'description' => 'Вы уверены, что хотите отсоединить этого пользователя?',
            'actions' => [
                'submit' => 'Отсоединить',
                'cancel' => 'Отмена',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'Удалить выбранных пользователей',
            'description' => 'Вы уверены, что хотите удалить выбранных пользователей?',
            'actions' => [
                'submit' => 'Удалить выбранные',
                'cancel' => 'Отмена',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'Отсоединить выбранных пользователей',
            'description' => 'Вы уверены, что хотите отсоединить выбранных пользователей?',
            'actions' => [
                'submit' => 'Отсоединить выбранные',
                'cancel' => 'Отмена',
            ],
        ],
    ],
    'navigation' => [
        'name' => 'Пользователи',
        'plural' => 'Пользователи',
        'group' => [
            'name' => 'Управление пользователями',
            'description' => 'Управление пользователями и их разрешениями',
        ],
        'label' => 'Пользователи',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'validation' => [
        'email_unique' => 'Этот email уже используется',
        'password_min' => 'Пароль должен быть не менее :min символов',
        'password_confirmed' => 'Пароли не совпадают',
        'current_password' => 'Текущий пароль неверен',
    ],
    'permissions' => [
        'view_users' => 'Просмотр пользователей',
        'create_users' => 'Создание пользователей',
        'edit_users' => 'Редактирование пользователей',
        'delete_users' => 'Удаление пользователей',
        'impersonate_users' => 'Вход как пользователь',
        'manage_roles' => 'Управление ролями',
    ],
    'model' => [
        'label' => 'Пользователь',
    ],
];
