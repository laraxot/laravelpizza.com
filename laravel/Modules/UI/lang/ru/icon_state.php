<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Имя',
            'placeholder' => 'Введите имя',
            'help' => 'Идентифицирующее имя элемента',
            'description' => 'Имя объекта',
            'helper_text' => '',
        ],
        'edit-name' => [
            'label' => 'Редактировать имя',
            'placeholder' => 'Новое имя',
            'help' => 'Изменить существующее имя',
            'description' => 'Действие для изменения имени',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Изменить состояние',
            'placeholder' => 'Выбрать новое состояние',
            'help' => 'Изменить текущее состояние',
            'description' => 'Действие для изменения состояния',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Состояние',
            'placeholder' => 'Выбрать состояние',
            'help' => 'Текущее состояние элемента',
            'description' => 'Текущее состояние системы',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Сообщение',
            'placeholder' => 'Введите сообщение',
            'help' => 'Информационное сообщение',
            'description' => 'Текст сообщения',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Недействительный экземпляр состояния',
        'record_not_found' => 'Запись не найдена',
        'transition_completed' => [
            'title' => 'Переход завершен',
            'body' => 'Переход состояния успешно завершен',
        ],
        'transition_error' => [
            'title' => 'Ошибка перехода',
        ],
    ],
];
