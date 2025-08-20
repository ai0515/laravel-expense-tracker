<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransactionService;

class TransactionTable extends Component
{
    public $period;
    public $period_options = ['今月', '今週', '今日', '先月'];
    public $categories = [];
    public $category_options;

    public $transactions;
    public $payment_total = 0;
    public $income_total = 0;

    public function mount(TransactionService $ts)
    {
        $this->period = '今月';
        $this->category_options = $ts->getAllCategories();
        // 一覧表示のカテゴリーのデフォルト表示：全選択
        $this->categories = $this->category_options->pluck('id')->toArray();

        $this->updateList($ts);      
    }

    public function updateList(TransactionService $ts)
    {
        $results = $ts->getTransactions($this->period, $this->categories);
        $this->transactions = $results['transactions'];
        $this->payment_total = $results['payment_total'];
        $this->income_total = $results['income_total']; 
    }

    public function render()
    {
        return view('livewire.transaction-table');
    }
}
