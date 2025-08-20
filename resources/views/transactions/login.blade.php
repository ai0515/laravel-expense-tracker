@extends('layouts.transactions')

@section('title', 'ログイン')

@section('content')
    <div class="login_container">
        <h1>ログイン</h1>
        <form action="/transactions/login" method="post">
            @csrf      
            <div class="form_input">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" value="{{old('email', '')}}" required>
            </div>
            <div class="form_input">
                <label for="password">パスワード</label>
                <input type="password" name="password" required>
            </div>

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
                <input class="login_button" type="submit" value="ログイン">
            </div>
        </form>

        <a href="/transactions/register">ユーザ―登録はこちら</a>
    </div>
@endsection