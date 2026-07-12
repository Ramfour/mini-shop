<?php 
// данные
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



require 'receipt.php';