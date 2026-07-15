<?php

/**
 * @file analytics.php
 * @brief Вспомогательные функции для аналитики
 * @const VAT_RATE Ставка НДС {@see shop.php}
 * @const DISCOUNT_THRESHOLD Порог скидки в копейках {@see shop.php}
 * @const DISCOUNT_RATE Ставка скидки {@see shop.php}
 */
// Вспомогательные функции для аналитики

// Форматировать копейки в рубли
function formatMoney(int $kopecks): string
{
    $rubles = intdiv($kopecks, 100);
    $remainingKopecks = $kopecks % 100;
    return sprintf("%d руб. %02d коп.", $rubles, $remainingKopecks);
}

/**
 * Рассчет суммы, наличия скидки, НДС и количества товаров
 * @param array $products Массив товаров {@see shop.php}
 * @return array Массив с ключами 'discount', 'sum', 'nds', 'count'
 */
function calculateTotals(array $products): array
{
    $itemSum = 0;
    $itemNds = 0;
    $itemCount = 0;
    $hasDiscount = false;

    foreach ($products as $product) {
        $itemSum += $product['price'] * $product['count'];
        $itemNds += intval(($product['price'] * $product['count']) * VAT_RATE); // НДС
        $itemCount += $product['count'];
    }
    $hasDiscount = $itemSum > DISCOUNT_THRESHOLD;
    if ($hasDiscount) {
        $discountAmount = intval($itemSum * DISCOUNT_RATE);
        $itemSum = $itemSum - $discountAmount;
    }
    return [
        'discount' => $hasDiscount,
        'sum' => $itemSum,
        'nds' => $itemNds,
        'count' => $itemCount
    ];
}

/**
 * Форматировать дату
 * @param string $date Дата в формате YYYY-MM-DD
 * @return string Дата в формате DD.MM.YYYY
 */
function formatDate(string $date): string
{
    $resultDate = explode('-', $date);
    return sprintf("%s.%s.%s", $resultDate[2], $resultDate[1], $resultDate[0]);
}

/**
 * Вывести сводку по заказу
 * @param array $order Массив заказа с ключами 'date', 'items', 'total' {@see shop.php}
 * @return string Строка формата "Заказ от DD.MM.YYYY: item1, item2, ... - total"
 */
function getOrderSummary(array $order): string
{
    $dateFormatted = formatDate($order['date']);
    $totalFormatted = formatMoney($order['total']);
    return sprintf("Заказ от %s: %s - %s",  $dateFormatted, implode(', ', $order['items']), $totalFormatted);
}

/**
 * Вывести заказы, сумма которых превышает порог скидки
 * @param array $orders Массив заказов {@see shop.php}
 * @param int $threshold Порог скидки в копейках, по умолчанию константа DISCOUNT_THRESHOLD {@see shop.php}
 * @return array Массив заказов, сумма которых превышает порог скидки
 */
function getOrdersWithDiscount(array $orders, int $threshold = DISCOUNT_THRESHOLD): array
{
    $sortedOrders = array_filter($orders, fn($order) => $order['total'] > $threshold);
    return $sortedOrders;
}

/**
 * Сортировать заказы по общей сумме
 * @param array $orders Массив заказов {@see shop.php}
 * @param string $direction Направление сортировки ('asc' или 'desc'), по умолчанию 'asc'
 * @return array Отсортированный массив заказов
 */
function sortOrdersByTotal(array $orders, string $direction = 'asc'): array
{
    /* $compare - функция сравнения для usort, использует оператор spaceship (<=>) и
     тернарный оператор + стрелочные функции*/
    $compare = $direction === 'asc' ?
        (fn($a, $b) => $a['total'] <=> $b['total']) : (fn($a, $b) => $b['total'] <=> $a['total']);
    usort($orders, $compare);
    return $orders;
}

