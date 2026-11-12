<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Редактировать профиль',
    'sections' => [
        'data' => ['title' => 'Ваши данные', 'description' => 'Имя и рассказ о себе видны в публичном профиле и в списках участников.'],
        'photo' => ['title' => 'Фото', 'description' => 'Необязательно. Без фото мы показываем ваши инициалы.'],
        'password' => ['title' => 'Пароль', 'description' => 'Сначала введите текущий пароль. Другие открытые сеансы будут завершены.'],
    ],
    'fields' => [
        'first_name' => 'Имя',
        'last_name' => 'Фамилия',
        'email' => 'Email',
        'bio' => 'О себе',
        'locale' => 'Предпочитаемый язык',
        'photo' => 'Новое фото',
        'current_password' => 'Текущий пароль',
        'password' => 'Новый пароль',
        'password_confirmation' => 'Повторите новый пароль',
    ],
    'help' => [
        'email' => 'Email здесь изменить нельзя: напишите нам со страницы «Контакты».',
        'bio' => 'Не более 500 символов. Видно всем.',
        'locale' => 'Язык писем, которые мы вам отправляем.',
        'photo' => 'JPG, PNG или WebP, не более 2 МБ.',
    ],
    'placeholders' => [
        'bio' => 'Пара строк о себе: чем занимаетесь, с чем работаете, чему хотите научиться.',
    ],
    'actions' => [
        'save_profile' => 'Сохранить',
        'view_public' => 'Открыть публичный профиль',
        'save_photo' => 'Загрузить фото',
        'remove_photo' => 'Удалить фото',
        'change_password' => 'Сменить пароль',
    ],
    'saved' => [
        'profile' => 'Данные сохранены.',
        'photo' => 'Фото обновлено.',
        'password' => 'Пароль изменён.',
    ],
    'photo' => [
        'uploading' => 'Загрузка…',
        'preview_alt' => 'Предпросмотр нового фото',
        'current_alt' => 'Ваше текущее фото',
    ],
];
