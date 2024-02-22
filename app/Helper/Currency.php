<?php

namespace App\Helper;

use NumberFormatter;

class Currency {
    public static function format($amount, $currency = null) {
        $formatter = new NumberFormatter('en', NumberFormatter::CURRENCY);
        if ($currency == null) {
            $currency = config('app.currency', 'USD');
        }
        return $formatter->formatCurrency($amount, $currency);
    }
}