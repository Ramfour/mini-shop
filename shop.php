<?php

/** @const float VAT_RATE Ставка НДС */
define('VAT_RATE', 0.2);

/** @const int DISCOUNT_THRESHOLD Порог скидки в копейках */
define('DISCOUNT_THRESHOLD', 300000);

/** @const float DISCOUNT_RATE Ставка скидки */
define('DISCOUNT_RATE', 0.1);

// Функции рассчета суммы, наличия скидки, НДС и количества товаров
require 'analytics.php';


// Массив продуктов
$products = [
    [
        'name'     => 'Кофе',
        'price'    => 19999,
        'count'    => 2,
        'category' => 'drink',
    ],
    [
        'name'     => 'Чай',
        'price'    => 9999,
        'count'    => 1,
        'category' => 'drink',
    ],
    [
        'name'     => 'Печенье',
        'price'    => 4999,
        'count'    => 3,
        'category' => 'food',
    ],
    [
        'name'     => 'Сок',
        'price'    => 2999,
        'count'    => 5,
        'category' => 'drink',
    ],
    [
        'name'     => 'Торт',
        'price'    => 59999,
        'count'    => 1,
        'category' => 'food',
    ],
];

// Массив категорий
$categories = [
    'drink' => 'Напитки',
    'food'  => 'Еда',
    'other' => 'Другое',
];


// Вывод чека
require 'receipt.php';
