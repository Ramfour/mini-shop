<?php

/** 
 * @file receipt.php
 * @brief Вывод чека
 * @var array $products Массив товаров
 * @see analytics.php функции formatMoney(), calculateTotals()
 * @see shop.php константы VAT_RATE, DISCOUNT_THRESHOLD, DISCOUNT_RATE используются в shop.php
 * @var int $itemSum Сумма заказа в копейках
 * @var int $itemNds Сумма НДС в копейках
 * @var int $itemCount Количество товаров
 * @var bool $hasDiscount Флаг наличия скидки
 * @var array $categories Массив категорий
 */

// Вывод чека
echo '<pre>';
$title      = 'чек заказа';
$titleUpper = mb_strtoupper($title, 'UTF-8');   // mb_strtoupper
$titleLength = mb_strlen($titleUpper, 'UTF-8'); // mb_strlen
$doubleLine = str_repeat('=', 40); // str_repeat
$line = str_repeat('-', 40); // str_repeat

echo $doubleLine . PHP_EOL;
echo $titleUpper . PHP_EOL;
echo $doubleLine . PHP_EOL;

foreach ($products as $product) {
    echo 'Товар: ' . $product['name'] . PHP_EOL;
    echo 'Цена за единицу: ' . formatMoney($product['price']) . PHP_EOL;
    echo 'Количество: ' . $product['count'] . PHP_EOL;
    echo "Категория:  {$categories[$product['category']]}" . PHP_EOL;
    echo PHP_EOL;
}

echo $line . PHP_EOL;
$result = calculateTotals($products);
echo 'Итого: ' . formatMoney($result['sum']) . PHP_EOL;
echo 'НДС 20%: ' . formatMoney($result['nds']) . PHP_EOL;
echo 'Скидка: ' . ($result['discount'] ? 'Да' : 'Нет') . PHP_EOL;

echo '</pre>';
