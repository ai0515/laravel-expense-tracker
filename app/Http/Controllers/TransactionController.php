<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    // 収支一覧画面を表示
    public function index(Request $request)
    {
        return view('transactions.list');
    }

    // 収支データ登録画面表示
    public function create(Request $request)
    {
        $category_options = Category::all();
        $paymentMethods = PaymentMethod::all();

        return view('transactions.create', compact('category_options', 'paymentMethods'));
    }

    // 収支データ登録
    public function store(TransactionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['transaction_type'] = TransactionType::boolToEnum($request->boolean('income'));

        $transaction = $request->user()->transactions()->create($data);            
        $transaction->categories()->attach($request->category_ids);
        $transaction->save();

        return redirect('/transactions')->with('success', '登録しました。');
    }

    // 収支データ編集画面表示
    public function edit($id)
    {
        $transaction = Transaction::with('categories')->findOrFail($id);
        $transaction['income'] = ($transaction->transaction_type == TransactionType::INCOME ? true : false);
        $category_options = Category::all();
        $paymentMethods = PaymentMethod::all();

        return view('transactions.edit', compact('transaction', 'category_options', 'paymentMethods'));
    }

    // 収支データ更新
    public function update(TransactionRequest $request, $id)
    {
        $data = $request->validated();
        $data['transaction_type'] = TransactionType::boolToEnum($request->boolean('income'));

        $transaction = Transaction::with('categories')->findOrFail($id);
        $transaction->update($data);
        $transaction->categories()->sync($request->category_ids);

        return redirect('/transactions')->with('success', '保存しました。');
    }

    // 収支データ削除
    public function destroy(Request $request, $id)
    {
        Transaction::with('categories')->findOrFail($id)->delete();
        return redirect('/transactions')->with('success', '削除しました。');
    }
}