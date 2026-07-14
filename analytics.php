<?php

/**
 * @file analytics.php
 * @brief Вспомогательные функции для аналитики
 * @see shop.php константы VAT_RATE, DISCOUNT_THRESHOLD, DISCOUNT_RATE используются в shop.php
 */
// Вспомогательные функции для аналитики

// Форматировать копейки в рубли
function formatMoney(int $kopecks): string
{
    $rubles = intdiv($kopecks, 100);
    $remainingKopecks = $kopecks % 100;
    return sprintf("%d руб. %02d коп.", $rubles, $remainingKopecks);
}

// Рассчет суммы, наличия скидки, НДС и количества товаров
function calculateTotals(array $products): array
{
    /** @var int $itemSum Сумма заказа в копейках */
    $itemSum = 0;
    /** @var int $itemNds Сумма НДС в копейках */
    $itemNds = 0;
    /** @var int $itemCount Количество товаров */
    $itemCount = 0;
    /** @var bool $hasDiscount Флаг наличия скидки */
    $hasDiscount = false;

    foreach ($products as $product) {
        $itemSum += $product['price'] * $product['count'];
        $itemNds += floor(($product['price'] * $product['count']) * VAT_RATE); // НДС
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
