<?php

namespace App\Enums;

enum TransactionType: string
{
    case PAYMENT = 'payment';
    case INCOME = 'income';

    public static function boolToEnum(bool $transaction_type) :self
    {
        return $transaction_type ? self::INCOME : self::PAYMENT;
    }

    // 収支一覧の表示ラベルを返す
    public function getLabel() :string
    {
        return match($this) {
            self::PAYMENT => '出金',
            self::INCOME => '入金'
        };
    }
}