<?php

use App\Enums\TransactionType;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

test('Guest: can view the page', function ($url) {
    $this->get($url)->assertOk();
})->with([
    '/transactions/login',
    '/transactions/register'
]);


test('Guest: redirected to login page', function ($url) {
    $r = $this->get($url);
    $r->assertRedirect('/transactions/login');
    $r->assertStatus(302);
})->with([
    '/transactions',
    '/transactions/index',
    '/transactions/logout',
    '/transactions/create'
]);


test('Authenticated: can view the page', function ($url) {

    // ユーザーと収支データを登録
    $user = User::factory()->create();
    $t = Transaction::factory()
        ->for($user, 'user')
        ->for(PaymentMethod::factory()->create(), 'paymentMethod')
        ->has(
            Category::factory()->count(3),
            'categories'
    )->create();
        
    $this->actingAs($user);
    $this->get($url)->assertOk();
})->with([
    '/transactions',
    '/transactions/login',
    '/transactions/register',
    '/transactions/create',
]);


test('User: registration and search', function () {

    // ユーザーを登録
    $user = User::factory()->create();
    expect($user)->not->toBeNull();

    // 登録データの検索、家計簿アプリで使用するカラム値のみテスト（user_id, name, password）
    $response = User::where('name', $user->name)->first();
    expect($response->id)->toEqual($user->id);
    expect($response->name)->toEqual($user->name);
    expect($response->password)->toEqual($user->password);
});


test('Payment method: create and search', function () {

    // 支払い方法を登録
    $paymentMethod = PaymentMethod::factory()->create();
    expect($paymentMethod)->not->toBeNull();

    // 登録データの検索、カラム値のテスト
    $response = PaymentMethod::where('payment_method', $paymentMethod->payment_method)->first();
    expect($response->id)->toEqual($paymentMethod->id);
    expect($response->payment_method)->toEqual($paymentMethod->payment_method);
});


test('Category: create and search', function () {

    // 収支カテゴリーを登録
    $category = Category::factory()->create();
    expect($category)->not->toBeNull();

    // 登録データの検索、カラム値のテスト
    $res = Category::where('category', $category->category)->first();
    expect($res->id)->toEqual($category->id);
    expect($res->category)->toEqual($category->category);
});


test('Authenticated: create transaction data', function () {

    // ユーザーと収支データを登録
    $user = User::factory()->create();
    $category = Category::factory()->count(2)->create();
    $paymentMethod = PaymentMethod::factory()->create();

    $this->actingAs($user);

    // 登録データの作成
    $payload = [
        'amount' => 12345,
        'transaction_date' => date('Y-m-d'),
        'category_ids' => $category->pluck('id')->all(),
        'income' => false,
        'payment_method_id' => $paymentMethod->id,
        'note' => 'test',
    ];

    // データ登録→収支一覧に遷移
    $this->post(route('transactions.store'), $payload)->assertRedirect('/transactions');                

    // DBに登録されていることを確認
    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'amount' => 12345,
        'transaction_date' => date('Y-m-d'),
        'transaction_type' => TransactionType::PAYMENT->value,
        'payment_method_id' => $paymentMethod->id,
        'note' => 'test',
    ]);
});


test('Authenticated: view transaction edit page', function () {

    // ユーザーと収支データを登録
    $user = User::factory()->create();
    $t = Transaction::factory()
        ->for($user, 'user')
        ->for(PaymentMethod::factory()->create(), 'paymentMethod')
        ->has(
            Category::factory()->count(3),
            'categories'
    )->create();
        
    $this->actingAs($user);
    $this->get(route('transactions.edit', $t))->assertOk();
});


test('Authenticated: delete transaction data', function () {

    // ユーザーと収支データを登録
    $user = User::factory()->create();
    $transaction = Transaction::factory()
        ->for($user, 'user')
        ->for(PaymentMethod::factory()->create(), 'paymentMethod')
        ->has(
            Category::factory()->count(3),
            'categories'
    )->create();
        
    $this->actingAs($user);

    // データ削除→収支一覧に遷移
    $this->delete(route('transactions.destroy', $transaction))->assertRedirect('/transactions');

    // DBから削除されていることを確認
    $this->assertDatabaseMissing('transactions', [
        'id' => $transaction->id
    ]);
});


test('Authenticated: logout', function () {

    // ユーザーを登録
    $user = User::factory()->create();
    $this->actingAs($user);

    // ログアウト→ログイン画面に遷移
    $response = $this->get('/transactions/logout');
    $response->assertRedirect('/transactions/login');
    $response->assertStatus(302);
});