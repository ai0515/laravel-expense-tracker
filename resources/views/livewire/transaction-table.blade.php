<div>
    <div class="filter_area">
        <form wire:submit="updateList"> 
            <p>検索条件：</p>
            <div class="condition">
                    <label for="period">期間</label>
                    <select name="period" wire:model="period">
                        @foreach ($period_options as $option)
                            <option value="{{$option}}" @selected($period == $option)>{{$option}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="condition"> 
                ＞ 
            </div>
            <div class="condition">
                <label for="categories">カテゴリー<br><span>(Ctrl+クリックで複数選択)</span></label>
                <select name="categories" wire:model="categories" multiple>
                    @foreach ($category_options as $category)
                        <option value="{{$category->id}}" 
                            {{ in_array($category->id, $categories) ? 'selected' : ''}} >{{$category->category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="condition"> 
                ＞ 
            </div>            
            <div class="condition">
                <button type="submit">一覧更新</button>
            </div>
        </form>
    </div>

    <table class="total_table">
        <tr><th>支出合計</th><td>{{number_format($payment_total)}} 円</td></tr>
        <tr><th>収入合計</th><td>{{number_format($income_total)}} 円</td></tr>
        <tr><th>収支</th><td>{{number_format($income_total-$payment_total)}} 円</td></tr>
    </table>

    <table class="list_table">
        <tr>
            <th class="note_field">メモ</th>
            <th>金額</th>
            <th>日付</th>
            <th>入金/出金</th>
            <th>支払い方法</th>
            <th>カテゴリー</th>
            <th class="edit_field">編集</th>
        </tr>
        @foreach($transactions as $item)
            <tr>
                <td class="note_field">{{$item->note}}</td>
                <td>{{number_format($item->amount)}}</td>
                <td>{{$item->transaction_date}}</td>
                <td>{{$item->transaction_type->getLabel()}}</td>
                <td>{{$item->paymentMethod->payment_method}}</td>
                <td>{{$item->categories->pluck('category')->join(', ')}}</td>
                <td class="edit_field"><a href="{{route('transactions.edit', $item->id)}}"><img class="edit_icon" src="{{asset('img/edit.png')}}"></a></td>
            </tr>   
        @endforeach
    </table> 

</div>
