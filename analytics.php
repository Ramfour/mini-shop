<?php 
// Вспомогательные функции для аналитики

// Форматировать копейки в рубли
function formatMoney(int $kopecks): string {
    $rubles = floor($kopecks / 100);
    $remainingKopecks = $kopecks % 100;
    return sprintf("%d руб. %02d коп.", $rubles, $remainingKopecks);
}