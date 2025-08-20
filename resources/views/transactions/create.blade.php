@extends('layouts.transactions')

@section('title', '収支登録')

@section('content')
    <div class="transaction_container">
        <h1>収支登録</h1>
        <form action="/transactions" method="post">
            @csrf      
            <div class="transaction_form">
                <label for="amount">金額</label>
                <div class="amount_container">
                    <input type="number" class="amount" name="amount" value="{{old('amount', 0)}}" required>

                    <input type="hidden" name="income" value="false">
                    <input type="checkbox" class="income" name="income" value="true" @checked(old('income', false))>
                    <label for="income">入金</label>
                </div>

                <label for="transaction_date">日付</label>
                <input type="date" name="transaction_date" value="{{old('transaction_date', date('Y-m-d'))}}" required>                

                <label for="category_ids">カテゴリー (Ctrl+クリックで複数選択)</label>
                <select name="category_ids[]" multiple>
                    @foreach ($category_options as $category)
                        <option value="{{$category->id}}" {{in_array($category->id, old('category_ids', [1])) ? 'selected' : ''}}>{{$category->category}}</option>
                    @endforeach
                </select>

                <label for="payment_method_id">支払い方法</label>
                <select name="payment_method_id">
                    @foreach ($paymentMethods as $method)
                        <option value="{{$method->id}}" {{old('payment_method_id') == $method->id ? 'selected' : ''}}>{{$method->payment_method}}</option>
                    @endforeach
                </select>

                <label for="note">メモ</label>
                <input type="text" name="note" value="{{old('note', '')}}">

                @if($errors->any())
                    <div class="error_message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form_buttons">
                    <input type="submit" class="create_button" name="create_button" value="登録">
                    <button type="button" class="cancel_button" onclick="location.href='/transactions'">キャンセル</button>
                </div>
            </div>
        </form>
    </div>
@endsection