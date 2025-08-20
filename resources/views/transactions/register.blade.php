@extends('layouts.transactions')

@section('title', 'ユーザー登録')

@section('content')
    <div class="register_container">
        <h1>ユーザー登録</h1>
        <p>メールアドレスとパスワードを入力してください。</p>
        <form action="/transactions/register" method="post">
            @csrf      
            <div class="form_input">
                <label for="email">メールアドレス</label>
                <input type="text" name="email" value="{{old('email', '')}}" required>
                @error('email')
                    <p class="errors">{{ $errors->first('email') }}</p>
                @enderror
            </div>            
            <div class="form_input">
                <label for="password">パスワード</label>
                <input type="password" name="password" required>
                @error('password')
                    <p class="errors">{{ $errors->first('password') }}</p>
                @enderror
            </div>
            <div class="form_input">
                <label for="password">パスワード（再入力）</label>
                <input type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <p class="errors">{{ $errors->first('password_confirmation') }}</p>
                @enderror                
            </div>
            
            <div class="form_buttons">
                <input class="register_button" type="submit" value="ユーザー登録">
            </div>

        </form>
    </div>
@endsection