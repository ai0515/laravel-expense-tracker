<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Category;
use App\Enums\TransactionType;

class TransactionService
{
    public function getAllCategories()
    {
        return Category::all();
    }

    // $period の選択肢を日付に変換
    public function getPeriodDate($period)
    {
        switch ($period) {
            case '今月':
                $date_from = date('Y-m-01');
                $date_to = date('Y-m-t');
                break;
            case '今週':
                $date_from = date('Y-m-d',strtotime('last Monday'));
                $date_to = date('Y-m-d',strtotime('this Sunday'));
                break;
            case '今日':
                $date_from = date('Y-m-d');
                $date_to = date('Y-m-d');                
                break;
            case '先月':
                $date_from = date('Y-m-d',strtotime('first day of last month'));
                $date_to =  date('Y-m-d',strtotime('last day of last month'));
                break;                                
        }

        return compact('date_from', 'date_to');
    }

    public function getTransactions($period, $categories)
    {
        $date = $this->getPeriodDate($period);
        $date_from = $date['date_from'];
        $date_to = $date['date_to'];

        $query = Transaction::with(['categories', 'paymentMethod'])
            ->whereDate('transaction_date', '>=', $date_from)
            ->whereDate('transaction_date', '<=', $date_to)
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('category_id', $categories);
            });

        $payment_total = $query->clone()->where('transaction_type', TransactionType::PAYMENT)->sum('amount');
        $income_total = $query->clone()->where('transaction_type', TransactionType::INCOME)->sum('amount');
        $transactions = $query->get();

        return compact('transactions', 'payment_total', 'income_total');
    }
}