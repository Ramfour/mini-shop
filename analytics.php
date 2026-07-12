<?php 
// Вспомогательные функции для аналитики

// Форматировать копейки в рубли
function formatMoney(int $kopecks): string {
    $rubles = intdiv($kopecks, 100);
    $remainingKopecks = $kopecks % 100;
    return sprintf("%d руб. %02d коп.", $rubles, $remainingKopecks);
}

// Рассчет суммы, наличия скидки, НДС и количества товаров
function calculateTotals(array $products): array {
    $itemSum = 0;
    $itemNds = 0;
    $itemCount = 0;
    $hasDiscount = false;
    foreach ($products as $product) {
        $itemSum += $product['price'] * $product['count'];
        $itemNds += ($product['price'] * $product['count']) * 0.2; // 20% НДС
        $itemCount += $product['count'];
    }
    $hasDiscount = $itemSum > 300000;
    if ($hasDiscount) {
    $discountAmount = intval($itemSum * 0.1);
    $itemSum = $itemSum - $discountAmount;
    }
    return [
        'discount' => $hasDiscount,
        'sum' => $itemSum,
        'nds' => $itemNds,
        'count' => $itemCount
    ];
}


