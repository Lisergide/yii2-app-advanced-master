<?php
// Подготовка - создать и указать в тестовом конфиге БД для тестирования, запустить yii_test migrate.
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost:3306;dbname=yii2-adv_test',
        ],
    ],
];
