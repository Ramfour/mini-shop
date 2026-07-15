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

// Рассчет суммы, наличия скидки, НДС и количества товаров
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
