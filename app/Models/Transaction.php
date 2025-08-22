<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TransactionType;

class Transaction extends Model
{
   use HasFactory;
   public $timestamps = false;

   protected $casts = [
      'transaction_type' => TransactionType::class
   ];

   protected $fillable = [
      'amount',
      'transaction_date',
      'transaction_type',
      'payment_method_id',
      'note'
   ];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
       return $this->belongsTo(PaymentMethod::class);
    }

    public function categories()
    {
       return $this->belongsToMany(Category::class, 'category_transaction', 'transaction_id', 'category_id');
    }

   protected static function boot()
    {
        parent::boot();

        // ログイン中のユーザーのレコードのみが検索対象
        static::addGlobalScope('by_user', 
            function (Builder $builder) {
               if (Auth::check()) {
                  $builder->where('user_id', Auth::id());
               }
            }
        );
    }

}
