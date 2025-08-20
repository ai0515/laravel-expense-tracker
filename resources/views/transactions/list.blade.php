@extends('layouts.transactions')

@section('title', '収支一覧')

@section('content')
    <div class="list_container">
        <h1>収支一覧</h1>
        <div class="create_button">
            <button type="button" onclick="location.href='/transactions/create'">収支登録</button>
        </div>

        @livewire('transaction-table')
    </div>
@endsection